<?php
/**
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @author Roan Kattouw
 * @author Trevor Parscal
 */

namespace MediaWiki\ResourceLoader;

use FormatJson;
use MediaWiki\MediaWikiServices;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use WANObjectCache;
use Wikimedia\Rdbms\Database;

/**
 * PHP 7.2 hack to work around the issue described at https://phabricator.wikimedia.org/T166010#5962098
 * Load the ResourceLoader class when MessageBlobStore is loaded.
 * phpcs:disable Generic.Files.OneObjectStructurePerFile.MultipleFound
 * phpcs:disable MediaWiki.Files.ClassMatchesFilename.NotMatch
 */
class ResourceLoader72Hack extends ResourceLoader
{
}

/**
 * This class generates message blobs for use by ResourceLoader.
 *
 * A message blob is a JSON object containing the interface messages for a
 * certain module in a certain language.
 *
 * @ingroup ResourceLoader
 * @since 1.17
 */
class MessageBlobStore implements LoggerAwareInterface
{
    /** @var ResourceLoader */
    private $resourceloader;

    /** @var LoggerInterface */
    protected $logger;

    /** @var WANObjectCache */
    protected $wanCache;

    /**
     * @param ResourceLoader $rl
     * @param LoggerInterface|null $logger
     * @param WANObjectCache|null $wanObjectCache
     */
    public function __construct(
        ResourceLoader $rl,
        ?LoggerInterface $logger,
        ?WANObjectCache $wanObjectCache
    )
    {
        $this->resourceloader = $rl;
        $this->logger = $logger ?: new NullLogger();

        // NOTE: when changing this assignment, make sure the code in the instantiator for
        // LocalisationCache which calls MessageBlobStore::clearGlobalCacheEntry() uses the
        // same cache object.
        $this->wanCache = $wanObjectCache ?: MediaWikiServices::getInstance()
            ->getMainWANObjectCache();
    }

    /**
     * @param LoggerInterface $logger
     * @since 1.27
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Get the message blob for a module
     *
     * @param Module $module
     * @param string $lang Language code
     * @return string JSON
     * @since 1.27
     */
    public function getBlob(Module $module, $lang)
    {
        $blobs = $this->getBlobs([$module->getName() => $module], $lang);

        return $blobs[$module->getName()];
    }

    /**
     * Get the message blobs for a set of modules
     *
     * @param Module[] $modules Array of module objects keyed by name
     * @param string $lang Language code
     * @return string[] An array mapping module names to message blobs
     * @since 1.27
     */
    public function getBlobs(array $modules, $lang)
    {
        // Each cache key for a message blob by module name and language code also has a generic
        // check key without language code. This is used to invalidate any and all language subkeys
        // that exist for a module from the updateMessage() method.
        $cache = $this->wanCache;
        $checkKeys = [
            // Global check key, see clear()
            $cache->makeGlobalKey(__CLASS__)
        ];
        $cacheKeys = [];
        foreach ($modules as $name => $module) {
            $cacheKey = $this->makeCacheKey($module, $lang);
            $cacheKeys[$name] = $cacheKey;
            // Per-module check key, see updateMessage()
            $checkKeys[$cacheKey][] = $cache->makeKey(__CLASS__, $name);
        }
        $curTTLs = [];
        $result = $cache->getMulti(array_values($cacheKeys), $curTTLs, $checkKeys);

        $blobs = [];
        foreach ($modules as $name => $module) {
            $key = $cacheKeys[$name];
            if (!isset($result[$key]) || $curTTLs[$key] === null || $curTTLs[$key] < 0) {
                $blobs[$name] = $this->recacheMessageBlob($key, $module, $lang);
            } else {
                // Use unexpired cache
                $blobs[$name] = $result[$key];
            }
        }

        return $blobs;
    }

    /**
     * @param Module $module
     * @param string $lang
     * @return string Cache key
     * @since 1.27
     */
    private function makeCacheKey(Module $module, $lang)
    {
        $messages = array_values(array_unique($module->getMessages()));
        sort($messages);

        return $this->wanCache->makeKey(__CLASS__, $module->getName(), $lang,
            md5(json_encode($messages))
        );
    }

    /**
     * @param string $cacheKey
     * @param Module $module
     * @param string $lang
     * @return string JSON blob
     * @since 1.27
     */
    protected function recacheMessageBlob($cacheKey, Module $module, $lang)
    {
        $blob = $this->generateMessageBlob($module, $lang);
        $cache = $this->wanCache;
        $cache->set($cacheKey, $blob,
            // Add part of a day to TTL to avoid all modules expiring at once
            $cache::TTL_WEEK + mt_rand(0, $cache::TTL_DAY),
            Database::getCacheSetOptions(wfGetDB(DB_REPLICA))
        );

        return $blob;
    }

    /**
     * Invalidate cache keys for modules using this message key.
     * Called by MessageCache when a message has changed.
     *
     * @param string $key Message key
     */
    public function updateMessage($key): void
    {
        $moduleNames = $this->resourceloader->getModulesByMessage($key);
        foreach ($moduleNames as $moduleName) {
            // Uses a holdoff to account for database replica DB lag (for MessageCache)
            $this->wanCache->touchCheckKey($this->wanCache->makeKey(__CLASS__, $moduleName));
        }
    }

    /**
     * Invalidate cache keys for all known modules.
     */
    public function clear()
    {
        self::clearGlobalCacheEntry($this->wanCache);
    }

    /**
     * Invalidate cache keys for all known modules.
     *
     * Called by LocalisationCache after cache is regenerated.
     *
     * @param WANObjectCache $cache
     */
    public static function clearGlobalCacheEntry(WANObjectCache $cache)
    {
        // Disable hold-off because:
        // - LocalisationCache is populated by messages on-disk and don't have DB lag,
        //   thus there is no need for hold off. We only clear it after new localisation
        //   updates are known to be deployed to all servers.
        // - This global check key invalidates message blobs for all modules for all wikis
        //   in cache contexts (e.g. languages, skins). Setting a hold-off on this key could
        //   cause a cache stampede since no values would be stored for several seconds.
        $cache->touchCheckKey($cache->makeGlobalKey(__CLASS__), $cache::HOLDOFF_TTL_NONE);
    }

    /**
     * @param string $key Message key
     * @param string $lang Language code
     * @return string|null
     * @since 1.27
     */
    protected function fetchMessage($key, $lang)
    {
        $message = wfMessage($key)->inLanguage($lang);
        if (!$message->exists()) {
            $this->logger->warning('Failed to find {messageKey} ({lang})', [
                'messageKey' => $key,
                'lang'       => $lang,
            ]);
            $value = null;
        } else {
            $value = $message->plain();
        }

        return $value;
    }

    /**
     * Generate the message blob for a given module in a given language.
     *
     * @param Module $module
     * @param string $lang Language code
     * @return string JSON blob
     */
    private function generateMessageBlob(Module $module, $lang)
    {
        $messages = [];
        foreach ($module->getMessages() as $key) {
            $value = $this->fetchMessage($key, $lang);
            // If the message does not exist, omit it from the blob so that
            // client-side mw.message may do its own existence handling.
            if ($value !== null) {
                $messages[$key] = $value;
            }
        }

        $json = FormatJson::encode((object)$messages, false, FormatJson::UTF8_OK);
        // @codeCoverageIgnoreStart
        if ($json === false) {
            $this->logger->warning('Failed to encode message blob for {module} ({lang})', [
                'module' => $module->getName(),
                'lang'   => $lang,
            ]);
            $json = '{}';
        }

        // codeCoverageIgnoreEnd
        return $json;
    }
}

/** @deprecated since 1.39 */
class_alias(MessageBlobStore::class, 'MessageBlobStore');
