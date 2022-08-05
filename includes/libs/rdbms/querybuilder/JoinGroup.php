<?php

namespace Wikimedia\Rdbms;

/**
 * An object representing a parenthesized group of tables and their join
 * types and conditions.
 */
class JoinGroup extends JoinGroupBase
{
    /** @var string */
    private $alias;

    /** @var int */
    private $nextAutoAlias = 0;

    /**
     * Use SelectQueryBuilder::newJoinGroup() to create a join group
     *
     * @param string $alias
     * @internal
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get a table alias which is unique to the parent SelectQueryBuilder
     *
     * @return string
     */
    protected function getAutoAlias()
    {
        return $this->alias . '_' . ($this->nextAutoAlias++);
    }

    /**
     * @return array
     * @internal
     */
    public function getRawTables()
    {
        return $this->tables;
    }

    /**
     * @return array
     * @internal
     */
    public function getRawJoinConds()
    {
        return $this->joinConds;
    }

    /**
     * @return string
     * @internal
     */
    public function getAlias()
    {
        return $this->alias;
    }
}
