<?php
/**
 * Copyright © 2007 Yuri Astrakhan "<Firstname><Lastname>@gmail.com"
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
 */

use MediaWiki\Block\DatabaseBlock;
use MediaWiki\MainConfigNames;
use MediaWiki\Permissions\GroupPermissionsLookup;
use MediaWiki\User\UserFactory;
use MediaWiki\User\UserGroupManager;
use Wikimedia\ParamValidator\ParamValidator;
use Wikimedia\ParamValidator\TypeDef\IntegerDef;

/**
 * Query module to enumerate all registered users.
 *
 * @ingroup API
 */
class ApiQueryAllUsers extends ApiQueryBase
{
    use ApiQueryBlockInfoTrait;

    /** @var UserFactory */
    private $userFactory;

    /** @var UserGroupManager */
    private $userGroupManager;

    /** @var GroupPermissionsLookup */
    private $groupPermissionsLookup;

    /** @var Language */
    private $contentLanguage;

    /**
     * @param ApiQuery $query
     * @param string $moduleName
     * @param UserFactory $userFactory
     * @param UserGroupManager $userGroupManager
     * @param GroupPermissionsLookup $groupPermissionsLookup
     * @param Language $contentLanguage
     */
    public function __construct(
        ApiQuery $query,
        $moduleName,
        UserFactory $userFactory,
        UserGroupManager $userGroupManager,
        GroupPermissionsLookup $groupPermissionsLookup,
        Language $contentLanguage
    )
    {
        parent::__construct($query, $moduleName, 'au');
        $this->userFactory = $userFactory;
        $this->userGroupManager = $userGroupManager;
        $this->groupPermissionsLookup = $groupPermissionsLookup;
        $this->contentLanguage = $contentLanguage;
    }

    /**
     * This function converts the user name to a canonical form
     * which is stored in the database.
     * @param string $name
     * @return string
     */
    private function getCanonicalUserName($name)
    {
        $name = $this->contentLanguage->ucfirst($name);

        return strtr($name, '_', ' ');
    }

    public function execute()
    {
        $params = $this->extractRequestParams();
        $activeUserDays = $this->getConfig()->get(MainConfigNames::ActiveUserDays);

        $db = $this->getDB();

        $prop = $params['prop'];
        if ($prop !== null) {
            $prop = array_fill_keys($prop, true);
            $fld_blockinfo = isset($prop['blockinfo']);
            $fld_editcount = isset($prop['editcount']);
            $fld_groups = isset($prop['groups']);
            $fld_rights = isset($prop['rights']);
            $fld_registration = isset($prop['registration']);
            $fld_implicitgroups = isset($prop['implicitgroups']);
            $fld_centralids = isset($prop['centralids']);
        } else {
            $fld_blockinfo = $fld_editcount = $fld_groups = $fld_registration =
            $fld_rights = $fld_implicitgroups = $fld_centralids = false;
        }

        $limit = $params['limit'];

        $this->addTables('user');

        $dir = ($params['dir'] == 'descending' ? 'older' : 'newer');
        $from = $params['from'] === null ? null : $this->getCanonicalUserName($params['from']);
        $to = $params['to'] === null ? null : $this->getCanonicalUserName($params['to']);

        # MySQL can't figure out that 'user_name' and 'qcc_title' are the same
        # despite the JOIN condition, so manually sort on the correct one.
        $userFieldToSort = $params['activeusers'] ? 'qcc_title' : 'user_name';

        # Some of these subtable joins are going to give us duplicate rows, so
        # calculate the maximum number of duplicates we might see.
        $maxDuplicateRows = 1;

        $this->addWhereRange($userFieldToSort, $dir, $from, $to);

        if ($params['prefix'] !== null) {
            $this->addWhere($userFieldToSort .
                $db->buildLike($this->getCanonicalUserName($params['prefix']), $db->anyString()));
        }

        if ($params['rights'] !== null && count($params['rights'])) {
            $groups = [];
            foreach ($params['rights'] as $r) {
                $groups = array_merge($groups, $this->groupPermissionsLookup->getGroupsWithPermission($r));
            }

            // no group with the given right(s) exists, no need for a query
            if ($groups === []) {
                $this->getResult()->addIndexedTagName(['query', $this->getModuleName()], '');

                return;
            }

            $groups = array_unique($groups);

            if ($params['group'] === null) {
                $params['group'] = $groups;
            } else {
                $params['group'] = array_unique(array_merge($params['group'], $groups));
            }
        }

        $this->requireMaxOneParameter($params, 'group', 'excludegroup');

        if ($params['group'] !== null && count($params['group'])) {
            // Filter only users that belong to a given group. This might
            // produce as many rows-per-user as there are groups being checked.
            $this->addTables('user_groups', 'ug1');
            $this->addJoinConds([
                'ug1' => [
                    'JOIN',
                    [
                        'ug1.ug_user=user_id',
                        'ug1.ug_group' => $params['group'],
                        'ug1.ug_expiry IS NULL OR ug1.ug_expiry >= ' . $db->addQuotes($db->timestamp())
                    ]
                ]
            ]);
            $maxDuplicateRows *= count($params['group']);
        }

        if ($params['excludegroup'] !== null && count($params['excludegroup'])) {
            // Filter only users don't belong to a given group. This can only
            // produce one row-per-user, because we only keep on "no match".
            $this->addTables('user_groups', 'ug1');

            if (count($params['excludegroup']) == 1) {
                $exclude = ['ug1.ug_group' => $params['excludegroup'][0]];
            } else {
                $exclude = [$db->makeList(
                    ['ug1.ug_group' => $params['excludegroup']],
                    LIST_OR
                )];
            }
            $this->addJoinConds(['ug1' => ['LEFT JOIN',
                array_merge([
                    'ug1.ug_user=user_id',
                    'ug1.ug_expiry IS NULL OR ug1.ug_expiry >= ' . $db->addQuotes($db->timestamp())
                ], $exclude)
            ]]);
            $this->addWhere('ug1.ug_user IS NULL');
        }

        if ($params['witheditsonly']) {
            $this->addWhere('user_editcount > 0');
        }

        $this->addBlockInfoToQuery($fld_blockinfo);

        if ($fld_groups || $fld_rights) {
            $this->addFields(['groups' =>
                                  $db->buildGroupConcatField('|', 'user_groups', 'ug_group', [
                                      'ug_user=user_id',
                                      'ug_expiry IS NULL OR ug_expiry >= ' . $db->addQuotes($db->timestamp())
                                  ])
            ]);
        }

        if ($params['activeusers']) {
            $activeUserSeconds = $activeUserDays * 86400;

            // Filter query to only include users in the active users cache.
            // There shouldn't be any duplicate rows in querycachetwo here.
            $this->addTables('querycachetwo');
            $this->addJoinConds(['querycachetwo' => [
                'JOIN', [
                    'qcc_type'      => 'activeusers',
                    'qcc_namespace' => NS_USER,
                    'qcc_title=user_name',
                ],
            ]]);

            // Actually count the actions using a subquery (T66505 and T66507)
            $tables = ['recentchanges', 'actor'];
            $joins = [
                'actor' => ['JOIN', 'rc_actor = actor_id'],
            ];
            $timestamp = $db->timestamp((int)wfTimestamp(TS_UNIX) - $activeUserSeconds);
            $this->addFields([
                'recentactions' => '(' . $db->selectSQLText(
                        $tables,
                        'COUNT(*)',
                        [
                            'actor_user = user_id',
                            'rc_type != ' . $db->addQuotes(RC_EXTERNAL), // no wikidata
                            'rc_log_type IS NULL OR rc_log_type != ' . $db->addQuotes('newusers'),
                            'rc_timestamp >= ' . $db->addQuotes($timestamp),
                        ],
                        __METHOD__,
                        [],
                        $joins
                    ) . ')'
            ]);
        }

        $sqlLimit = $limit + $maxDuplicateRows;
        $this->addOption('LIMIT', $sqlLimit);

        $this->addFields([
            'user_name',
            'user_id'
        ]);
        $this->addFieldsIf('user_editcount', $fld_editcount);
        $this->addFieldsIf('user_registration', $fld_registration);

        $res = $this->select(__METHOD__);
        $count = 0;
        $countDuplicates = 0;
        $lastUser = false;
        $result = $this->getResult();
        foreach ($res as $row) {
            $count++;

            if ($lastUser === $row->user_name) {
                // Duplicate row due to one of the needed subtable joins.
                // Ignore it, but count the number of them to sensibly handle
                // miscalculation of $maxDuplicateRows.
                $countDuplicates++;
                if ($countDuplicates == $maxDuplicateRows) {
                    ApiBase::dieDebug(__METHOD__, 'Saw more duplicate rows than expected');
                }
                continue;
            }

            $countDuplicates = 0;
            $lastUser = $row->user_name;

            if ($count > $limit) {
                // We've reached the one extra which shows that there are
                // additional pages to be had. Stop here...
                $this->setContinueEnumParameter('from', $row->user_name);
                break;
            }

            if ($count == $sqlLimit) {
                // Should never hit this (either the $countDuplicates check or
                // the $count > $limit check should hit first), but check it
                // anyway just in case.
                ApiBase::dieDebug(__METHOD__, 'Saw more duplicate rows than expected');
            }

            if ($params['activeusers'] && (int)$row->recentactions === 0) {
                // activeusers cache was out of date
                continue;
            }

            $data = [
                'userid' => (int)$row->user_id,
                'name'   => $row->user_name,
            ];

            if ($fld_centralids) {
                $data += ApiQueryUserInfo::getCentralUserInfo(
                    $this->getConfig(), $this->userFactory->newFromId((int)$row->user_id), $params['attachedwiki']
                );
            }

            if ($fld_blockinfo && $row->ipb_id !== null) {
                $data += $this->getBlockDetails(DatabaseBlock::newFromRow($row));
            }
            if ($row->ipb_deleted) {
                $data['hidden'] = true;
            }
            if ($fld_editcount) {
                $data['editcount'] = (int)$row->user_editcount;
            }
            if ($params['activeusers']) {
                $data['recentactions'] = (int)$row->recentactions;
            }
            if ($fld_registration) {
                $data['registration'] = $row->user_registration ?
                    wfTimestamp(TS_ISO_8601, $row->user_registration) : '';
            }

            if ($fld_implicitgroups || $fld_groups || $fld_rights) {
                $implicitGroups = $this->userGroupManager
                    ->getUserImplicitGroups($this->userFactory->newFromId((int)$row->user_id));
                if (isset($row->groups) && $row->groups !== '') {
                    $groups = array_merge($implicitGroups, explode('|', $row->groups));
                } else {
                    $groups = $implicitGroups;
                }

                if ($fld_groups) {
                    $data['groups'] = $groups;
                    ApiResult::setIndexedTagName($data['groups'], 'g');
                    ApiResult::setArrayType($data['groups'], 'array');
                }

                if ($fld_implicitgroups) {
                    $data['implicitgroups'] = $implicitGroups;
                    ApiResult::setIndexedTagName($data['implicitgroups'], 'g');
                    ApiResult::setArrayType($data['implicitgroups'], 'array');
                }

                if ($fld_rights) {
                    $data['rights'] = $this->groupPermissionsLookup->getGroupPermissions($groups);
                    ApiResult::setIndexedTagName($data['rights'], 'r');
                    ApiResult::setArrayType($data['rights'], 'array');
                }
            }

            $fit = $result->addValue(['query', $this->getModuleName()], null, $data);
            if (!$fit) {
                $this->setContinueEnumParameter('from', $data['name']);
                break;
            }
        }

        $result->addIndexedTagName(['query', $this->getModuleName()], 'u');
    }

    public function getCacheMode($params)
    {
        return 'anon-public-user-private';
    }

    public function getAllowedParams($flags = 0)
    {
        $userGroups = $this->userGroupManager->listAllGroups();

        if ($flags & ApiBase::GET_VALUES_FOR_HELP) {
            sort($userGroups);
        }

        return [
            'from'          => null,
            'to'            => null,
            'prefix'        => null,
            'dir'           => [
                ParamValidator::PARAM_DEFAULT => 'ascending',
                ParamValidator::PARAM_TYPE    => [
                    'ascending',
                    'descending'
                ],
            ],
            'group'         => [
                ParamValidator::PARAM_TYPE    => $userGroups,
                ParamValidator::PARAM_ISMULTI => true,
            ],
            'excludegroup'  => [
                ParamValidator::PARAM_TYPE    => $userGroups,
                ParamValidator::PARAM_ISMULTI => true,
            ],
            'rights'        => [
                ParamValidator::PARAM_TYPE    => $this->getPermissionManager()->getAllPermissions(),
                ParamValidator::PARAM_ISMULTI => true,
            ],
            'prop'          => [
                ParamValidator::PARAM_ISMULTI     => true,
                ParamValidator::PARAM_TYPE        => [
                    'blockinfo',
                    'groups',
                    'implicitgroups',
                    'rights',
                    'editcount',
                    'registration',
                    'centralids',
                ],
                ApiBase::PARAM_HELP_MSG_PER_VALUE => [],
            ],
            'limit'         => [
                ParamValidator::PARAM_DEFAULT => 10,
                ParamValidator::PARAM_TYPE    => 'limit',
                IntegerDef::PARAM_MIN         => 1,
                IntegerDef::PARAM_MAX         => ApiBase::LIMIT_BIG1,
                IntegerDef::PARAM_MAX2        => ApiBase::LIMIT_BIG2
            ],
            'witheditsonly' => false,
            'activeusers'   => [
                ParamValidator::PARAM_DEFAULT => false,
                ApiBase::PARAM_HELP_MSG       => [
                    'apihelp-query+allusers-param-activeusers',
                    $this->getConfig()->get(MainConfigNames::ActiveUserDays)
                ],
            ],
            'attachedwiki'  => null,
        ];
    }

    protected function getExamplesMessages()
    {
        return [
            'action=query&list=allusers&aufrom=Y'
            => 'apihelp-query+allusers-example-y',
        ];
    }

    public function getHelpUrls()
    {
        return 'https://www.mediawiki.org/wiki/Special:MyLanguage/API:Allusers';
    }
}
