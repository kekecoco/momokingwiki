<?php

use Wikimedia\Rdbms\ILoadBalancer;

/**
 * A service class for fetching the wiki's current read-only mode.
 * To obtain an instance, use MediaWikiServices::getInstance()->getReadOnlyMode().
 *
 * @since 1.29
 */
class ReadOnlyMode
{
    /** @var ConfiguredReadOnlyMode */
    private $configuredReadOnly;

    /** @var ILoadBalancer */
    private $loadBalancer;

    public function __construct(ConfiguredReadOnlyMode $cro, ILoadBalancer $loadBalancer)
    {
        $this->configuredReadOnly = $cro;
        $this->loadBalancer = $loadBalancer;
    }

    /**
     * Check whether the wiki is in read-only mode.
     *
     * @return bool
     */
    public function isReadOnly(): bool
    {
        return $this->getReason() !== false;
    }

    /**
     * Check if the site is in read-only mode and return the message if so
     *
     * This checks the configuration and registered DB load balancers for
     * read-only mode. This may result in DB connection being made.
     *
     * @return string|false String when in read-only mode; false otherwise
     */
    public function getReason()
    {
        $reason = $this->configuredReadOnly->getReason();
        if ($reason !== false) {
            return $reason;
        }
        $reason = $this->loadBalancer->getReadOnlyReason();

        return $reason ?? false;
    }

    /**
     * Set the read-only mode, which will apply for the remainder of the
     * request or until a service reset.
     *
     * @param string|false|null $msg
     */
    public function setReason($msg): void
    {
        $this->configuredReadOnly->setReason($msg);
    }
}
