<?php
/**
 * MediaWiki page data importer.
 *
 * Copyright © 2003,2005 Brion Vibber <brion@pobox.com>
 * https://www.mediawiki.org/
 *
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
 * @ingroup SpecialPage
 */

use MediaWiki\Logger\LoggerFactory;
use MediaWiki\MainConfigNames;
use MediaWiki\MediaWikiServices;
use MediaWiki\Revision\MutableRevisionSlots;
use MediaWiki\Revision\SlotRecord;

/**
 * Represents a revision, log entry or upload during the import process.
 * This class sticks closely to the structure of the XML dump.
 *
 * @since 1.2
 *
 * @ingroup SpecialPage
 */
class WikiRevision implements ImportableUploadRevision, ImportableOldRevision
{
    use DeprecationHelper;

    /**
     * @since 1.2
     * @var Title
     */
    public $title = null;

    /**
     * @since 1.6.4
     * @var int
     */
    public $id = 0;

    /**
     * @since 1.2
     * @var string
     */
    public $timestamp = "20010115000000";

    /**
     * @since 1.2
     * @var string
     */
    public $user_text = "";

    /**
     * @deprecated since 1.39, use {@see $user_text} instead
     * @since 1.27
     * @var User|null
     */
    public $userObj = null;

    /**
     * @since 1.21
     * @deprecated since 1.35, use getContent
     * @var string
     */
    public $model = null;

    /**
     * @since 1.21
     * @deprecated since 1.35, use getContent
     * @var string
     */
    public $format = null;

    /**
     * @since 1.2
     * @deprecated since 1.35, use getContent
     * @var string
     */
    public $text = "";

    /**
     * @since 1.12.2
     * @var int
     */
    protected $size;

    /**
     * @since 1.21
     * @deprecated since 1.35, use getContent
     * @var Content
     */
    public $content = null;

    /**
     * @since 1.24
     * @var ContentHandler
     */
    protected $contentHandler = null;

    /**
     * @since 1.2.6
     * @var string
     */
    public $comment = "";

    /**
     * @var MutableRevisionSlots
     */
    private $slots;

    /**
     * @since 1.5.7
     * @var bool
     */
    public $minor = false;

    /**
     * @since 1.12.2
     * @var string
     */
    public $type = "";

    /**
     * @since 1.12.2
     * @var string
     */
    public $action = "";

    /**
     * @since 1.12.2
     * @var string
     */
    public $params = "";

    /**
     * @since 1.17
     * @var string
     */
    public $fileSrc = '';

    /**
     * @since 1.17
     * @var bool|string
     */
    public $sha1base36 = false;

    /**
     * @since 1.34
     * @var string[]
     */
    protected $tags = [];

    /**
     * @since 1.17
     * @var string
     */
    public $archiveName = '';

    /**
     * @since 1.12.2
     * @var string|null
     */
    protected $filename;

    /**
     * @since 1.12.2
     * @var string|null
     */
    protected $src = null;

    /**
     * @since 1.18
     * @var bool
     * @todo Unused?
     */
    public $isTemp = false;

    /**
     * @since 1.18
     * @deprecated since 1.29 use WikiRevision::isTempSrc()
     * First written to in 43d5d3b682cc1733ad01a837d11af4a402d57e6a
     * Actually introduced in 52cd34acf590e5be946b7885ffdc13a157c1c6cf
     */
    private $fileIsTemp;

    /** @var bool */
    private $mNoUpdates = false;

    /**
     * @deprecated since 1.31, along with self::downloadSource()
     * @var Config
     */
    private $config;

    /**
     * @param Config $config Deprecated since 1.31, along with self::downloadSource(). Just pass an
     *  empty HashConfig.
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->slots = new MutableRevisionSlots();

        $this->deprecatePublicProperty('fileIsTemp', '1.29');
    }

    /**
     * @param Title $title
     * @throws MWException
     * @since 1.7 taking a Title object (string before)
     */
    public function setTitle($title)
    {
        if (is_object($title)) {
            $this->title = $title;
        } elseif ($title === null) {
            throw new MWException("WikiRevision given a null title in import. "
                . "You may need to adjust \$wgLegalTitleChars.");
        } else {
            throw new MWException("WikiRevision given non-object title in import.");
        }
    }

    /**
     * @param int $id
     * @since 1.6.4
     */
    public function setID($id)
    {
        $this->id = $id;
    }

    /**
     * @param string $ts
     * @since 1.2
     */
    public function setTimestamp($ts)
    {
        # 2003-08-05T18:30:02Z
        $this->timestamp = wfTimestamp(TS_MW, $ts);
    }

    /**
     * @param string $user
     * @since 1.2
     */
    public function setUsername($user)
    {
        $this->user_text = $user;
    }

    /**
     * @param User $user
     * @since 1.27
     * @deprecated since 1.39, use {@see setUsername} instead
     */
    public function setUserObj($user)
    {
        // Not officially supported, but some callers pass false from e.g. User::newFromName()
        $this->userObj = $user ?: null;
        if ($this->user_text === '' && $user) {
            $this->user_text = $user->getName();
        }
    }

    /**
     * @param string $ip
     * @since 1.2
     * @deprecated since 1.39, use {@see setUsername} instead, it does the same anyway
     */
    public function setUserIP($ip)
    {
        $this->user_text = $ip;
    }

    /**
     * @param string $model
     * @deprecated since 1.35, use setContent instead.
     * @since 1.21
     */
    public function setModel($model)
    {
        $this->model = $model;
    }

    /**
     * @param string $format
     * @deprecated since 1.35, use setContent instead.
     * @since 1.21
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @param string $text
     * @deprecated since 1.35, use setContent instead.
     * @since 1.2
     */
    public function setText($text)
    {
        $handler = ContentHandler::getForModelID($this->getModel());
        $content = $handler->unserializeContent($text);
        $this->setContent(SlotRecord::MAIN, $content);
    }

    /**
     * @param string $role
     * @param Content $content
     * @since 1.35
     */
    public function setContent($role, $content)
    {
        $this->slots->setContent($role, $content);

        // backwards compat
        if ($role === SlotRecord::MAIN) {
            $this->content = $content;
            $this->model = $content->getModel();
            $this->format = $content->getDefaultFormat();
            $this->text = $content->serialize();
        }
    }

    /**
     * @param string $text
     * @since 1.2.6
     */
    public function setComment(string $text)
    {
        $this->comment = $text;
    }

    /**
     * @param bool $minor
     * @since 1.5.7
     */
    public function setMinor($minor)
    {
        $this->minor = (bool)$minor;
    }

    /**
     * @param string|null $src
     * @since 1.12.2
     */
    public function setSrc($src)
    {
        $this->src = $src;
    }

    /**
     * @param string $src
     * @param bool $isTemp
     * @since 1.17
     */
    public function setFileSrc($src, $isTemp)
    {
        $this->fileSrc = $src;
        $this->fileIsTemp = $isTemp;
        $this->isTemp = $isTemp;
    }

    /**
     * @param string $sha1base36
     * @since 1.17
     */
    public function setSha1Base36($sha1base36)
    {
        $this->sha1base36 = $sha1base36;
    }

    /**
     * @param string[] $tags
     * @since 1.34
     */
    public function setTags(array $tags)
    {
        $this->tags = $tags;
    }

    /**
     * @param string $filename
     * @since 1.12.2
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }

    /**
     * @param string $archiveName
     * @since 1.17
     */
    public function setArchiveName($archiveName)
    {
        $this->archiveName = $archiveName;
    }

    /**
     * @param int $size
     * @since 1.12.2
     */
    public function setSize($size)
    {
        $this->size = intval($size);
    }

    /**
     * @param string $type
     * @since 1.12.2
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @param string $action
     * @since 1.12.2
     */
    public function setAction($action)
    {
        $this->action = $action;
    }

    /**
     * @param string $params
     * @since 1.12.2
     */
    public function setParams($params)
    {
        $this->params = $params;
    }

    /**
     * @param bool $noupdates
     * @since 1.18
     */
    public function setNoUpdates($noupdates)
    {
        $this->mNoUpdates = $noupdates;
    }

    /**
     * @return Title
     * @since 1.2
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return int
     * @since 1.6.4
     */
    public function getID()
    {
        return $this->id;
    }

    /**
     * @return string
     * @since 1.2
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @return string
     * @since 1.2
     */
    public function getUser()
    {
        return $this->user_text;
    }

    /**
     * @return User|null Typically null, use {@see getUser} instead
     * @since 1.27
     * @deprecated since 1.39, use {@see getUser} instead; this is almost always null anyway
     */
    public function getUserObj()
    {
        return $this->userObj;
    }

    /**
     * @return string
     * @since 1.2
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return ContentHandler
     * @throws MWUnknownContentModelException
     * @since 1.24
     * @deprecated since 1.35, use getContent
     */
    public function getContentHandler()
    {
        if ($this->contentHandler === null) {
            $this->contentHandler = MediaWikiServices::getInstance()
                ->getContentHandlerFactory()
                ->getContentHandler($this->getModel());
        }

        return $this->contentHandler;
    }

    /**
     * @param string $role added in 1.35
     * @return Content
     * @since 1.21
     */
    public function getContent($role = SlotRecord::MAIN)
    {
        return $this->slots->getContent($role);
    }

    /**
     * @param string $role
     * @return SlotRecord
     * @since 1.35
     */
    public function getSlot($role)
    {
        return $this->slots->getSlot($role);
    }

    /**
     * @return string[]
     * @since 1.35
     */
    public function getSlotRoles()
    {
        return $this->slots->getSlotRoles();
    }

    /**
     * @return string
     * @deprecated since 1.35, use getContent
     * @since 1.21
     */
    public function getModel()
    {
        if ($this->model === null) {
            $this->model = $this->getTitle()->getContentModel();
        }

        return $this->model;
    }

    /**
     * @return string
     * @deprecated since 1.35, use getContent
     * @since 1.21
     */
    public function getFormat()
    {
        if ($this->format === null) {
            $this->format = $this->getContentHandler()->getDefaultFormat();
        }

        return $this->format;
    }

    /**
     * @return string
     * @since 1.2.6
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @return bool
     * @since 1.5.7
     */
    public function getMinor()
    {
        return $this->minor;
    }

    /**
     * @return string|null
     * @since 1.12.2
     */
    public function getSrc()
    {
        return $this->src;
    }

    /**
     * @return bool|string
     * @since 1.17
     */
    public function getSha1()
    {
        if ($this->sha1base36) {
            return Wikimedia\base_convert($this->sha1base36, 36, 16);
        }

        return false;
    }

    /**
     * @return bool|string
     * @since 1.31
     */
    public function getSha1Base36()
    {
        if ($this->sha1base36) {
            return $this->sha1base36;
        }

        return false;
    }

    /**
     * @return string[]
     * @since 1.34
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @return string
     * @since 1.17
     */
    public function getFileSrc()
    {
        return $this->fileSrc;
    }

    /**
     * @return bool
     * @since 1.17
     */
    public function isTempSrc()
    {
        return $this->isTemp;
    }

    /**
     * @return mixed
     * @since 1.12.2
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * @return string
     * @since 1.17
     */
    public function getArchiveName()
    {
        return $this->archiveName;
    }

    /**
     * @return mixed
     * @since 1.12.2
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @return string
     * @since 1.12.2
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return string
     * @since 1.12.2
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @return string
     * @since 1.12.2
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return bool
     * @deprecated in 1.31. Use OldRevisionImporter::import
     * @since 1.4.1
     */
    public function importOldRevision()
    {
        if ($this->mNoUpdates) {
            $importer = MediaWikiServices::getInstance()->getWikiRevisionOldRevisionImporterNoUpdates();
        } else {
            $importer = MediaWikiServices::getInstance()->getWikiRevisionOldRevisionImporter();
        }

        return $importer->import($this);
    }

    /**
     * @return bool
     * @since 1.12.2
     */
    public function importLogItem()
    {
        $dbw = wfGetDB(DB_PRIMARY);

        $user = $this->getUserObj() ?: User::newFromName($this->getUser(), false);

        # @todo FIXME: This will not record autoblocks
        if (!$this->getTitle()) {
            wfDebug(__METHOD__ . ": skipping invalid {$this->type}/{$this->action} log time, timestamp " .
                $this->timestamp);

            return false;
        }
        # Check if it exists already
        // @todo FIXME: Use original log ID (better for backups)
        $prior = (bool)$dbw->selectField('logging', '1',
            ['log_type'      => $this->getType(),
             'log_action'    => $this->getAction(),
             'log_timestamp' => $dbw->timestamp($this->timestamp),
             'log_namespace' => $this->getTitle()->getNamespace(),
             'log_title'     => $this->getTitle()->getDBkey(),
             'log_params'    => $this->params],
            __METHOD__
        );
        // @todo FIXME: This could fail slightly for multiple matches :P
        if ($prior) {
            wfDebug(__METHOD__
                . ": skipping existing item for Log:{$this->type}/{$this->action}, timestamp "
                . $this->timestamp);

            return false;
        }
        $actorId = MediaWikiServices::getInstance()->getActorNormalization()
            ->acquireActorId($user, $dbw);
        $data = [
                'log_type'      => $this->type,
                'log_action'    => $this->action,
                'log_timestamp' => $dbw->timestamp($this->timestamp),
                'log_actor'     => $actorId,
                'log_namespace' => $this->getTitle()->getNamespace(),
                'log_title'     => $this->getTitle()->getDBkey(),
                'log_params'    => $this->params
            ] + CommentStore::getStore()->insert($dbw, 'log_comment', $this->getComment());
        $dbw->insert('logging', $data, __METHOD__);

        return true;
    }

    /**
     * @return bool
     * @deprecated in 1.31. Use UploadRevisionImporter::import
     * @since 1.12.2
     */
    public function importUpload()
    {
        wfDeprecated(__METHOD__, '1.31');

        $importer = MediaWikiServices::getInstance()->getWikiRevisionUploadImporter();
        $statusValue = $importer->import($this);

        return $statusValue->isGood();
    }

    /**
     * @return bool|string
     * @deprecated in 1.31. No replacement. Hard deprecated in 1.39.
     * @since 1.12.2
     */
    public function downloadSource()
    {
        wfDeprecated(__METHOD__, '1.31');
        $importer = new ImportableUploadRevisionImporter(
            $this->config->get(MainConfigNames::EnableUploads),
            LoggerFactory::getInstance('UploadRevisionImporter')
        );

        return $importer->downloadSource($this);
    }

}
