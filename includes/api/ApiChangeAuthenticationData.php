<?php
/**
 * Copyright © 2016 Wikimedia Foundation and contributors
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

use MediaWiki\Auth\AuthManager;
use MediaWiki\MainConfigNames;

/**
 * Change authentication data with AuthManager
 *
 * @ingroup API
 */
class ApiChangeAuthenticationData extends ApiBase
{
    /** @var AuthManager */
    private $authManager;

    /**
     * @param ApiMain $main
     * @param string $action
     * @param AuthManager $authManager
     */
    public function __construct(
        ApiMain $main,
        $action,
        AuthManager $authManager
    )
    {
        parent::__construct($main, $action, 'changeauth');
        $this->authManager = $authManager;
    }

    public function execute()
    {
        if (!$this->getUser()->isRegistered()) {
            $this->dieWithError('apierror-mustbeloggedin-changeauthenticationdata', 'notloggedin');
        }

        $helper = new ApiAuthManagerHelper($this, $this->authManager);

        // Check security-sensitive operation status
        $helper->securitySensitiveOperation('ChangeCredentials');

        // Fetch the request
        $reqs = ApiAuthManagerHelper::blacklistAuthenticationRequests(
            $helper->loadAuthenticationRequests(AuthManager::ACTION_CHANGE),
            $this->getConfig()->get(MainConfigNames::ChangeCredentialsBlacklist)
        );
        if (count($reqs) !== 1) {
            $this->dieWithError('apierror-changeauth-norequest', 'badrequest');
        }
        $req = reset($reqs);

        // Make the change
        $status = $this->authManager->allowsAuthenticationDataChange($req, true);
        $this->getHookRunner()->onChangeAuthenticationDataAudit($req, $status);
        if (!$status->isGood()) {
            $this->dieStatus($status);
        }
        $this->authManager->changeAuthenticationData($req);

        $this->getResult()->addValue(null, 'changeauthenticationdata', ['status' => 'success']);
    }

    public function isWriteMode()
    {
        return true;
    }

    public function needsToken()
    {
        return 'csrf';
    }

    public function getAllowedParams()
    {
        return ApiAuthManagerHelper::getStandardParams(AuthManager::ACTION_CHANGE,
            'request'
        );
    }

    public function dynamicParameterDocumentation()
    {
        return ['api-help-authmanagerhelper-additional-params', AuthManager::ACTION_CHANGE];
    }

    protected function getExamplesMessages()
    {
        return [
            'action=changeauthenticationdata' .
            '&changeauthrequest=MediaWiki%5CAuth%5CPasswordAuthenticationRequest' .
            '&password=ExamplePassword&retype=ExamplePassword&changeauthtoken=123ABC'
            => 'apihelp-changeauthenticationdata-example-password',
        ];
    }

    public function getHelpUrls()
    {
        return 'https://www.mediawiki.org/wiki/Special:MyLanguage/API:Manage_authentication_data';
    }
}
