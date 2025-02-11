<?php
/**
 * Copyright © 2008 Bryan Tong Minh <Bryan.TongMinh@Gmail.com>
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

use Wikimedia\ParamValidator\ParamValidator;

/**
 * API Module to facilitate sending of emails to users
 * @ingroup API
 */
class ApiEmailUser extends ApiBase
{

    public function execute()
    {
        $params = $this->extractRequestParams();

        // Validate target
        $targetUser = SpecialEmailUser::getTarget($params['target'], $this->getUser());
        if (!($targetUser instanceof User)) {
            switch ($targetUser) {
                case 'notarget':
                    $this->dieWithError('apierror-notarget');
                // dieWithError prevents continuation

                case 'noemail':
                    $this->dieWithError(['noemail', $params['target']]);
                // dieWithError prevents continuation

                case 'nowikiemail':
                    $this->dieWithError('nowikiemailtext', 'nowikiemail');
                // dieWithError prevents continuation

                default:
                    $this->dieWithError(['apierror-unknownerror', $targetUser]);
            }
        }

        // Check permissions and errors
        $error = SpecialEmailUser::getPermissionsError(
            $this->getUser(),
            $params['token'],
            $this->getConfig()
        );
        if ($error) {
            $this->dieWithError($error);
        }

        $data = [
            'Target'  => $targetUser->getName(),
            'Text'    => $params['text'],
            'Subject' => $params['subject'],
            'CCMe'    => $params['ccme'],
        ];
        $retval = SpecialEmailUser::submit($data, $this->getContext());
        if (!$retval instanceof Status) {
            // This is probably the reason
            $retval = Status::newFatal('hookaborted');
        }

        $result = array_filter([
            'result'   => $retval->isGood() ? 'Success' : ($retval->isOK() ? 'Warnings' : 'Failure'),
            'warnings' => $this->getErrorFormatter()->arrayFromStatus($retval, 'warning'),
            'errors'   => $this->getErrorFormatter()->arrayFromStatus($retval, 'error'),
        ]);

        $this->getResult()->addValue(null, $this->getModuleName(), $result);
    }

    public function mustBePosted()
    {
        return true;
    }

    public function isWriteMode()
    {
        return true;
    }

    public function getAllowedParams()
    {
        return [
            'target'  => [
                ParamValidator::PARAM_TYPE     => 'string',
                ParamValidator::PARAM_REQUIRED => true
            ],
            'subject' => [
                ParamValidator::PARAM_TYPE     => 'string',
                ParamValidator::PARAM_REQUIRED => true
            ],
            'text'    => [
                ParamValidator::PARAM_TYPE     => 'text',
                ParamValidator::PARAM_REQUIRED => true
            ],
            'ccme'    => false,
        ];
    }

    public function needsToken()
    {
        return 'csrf';
    }

    protected function getExamplesMessages()
    {
        return [
            'action=emailuser&target=WikiSysop&text=Content&token=123ABC'
            => 'apihelp-emailuser-example-email',
        ];
    }

    public function getHelpUrls()
    {
        return 'https://www.mediawiki.org/wiki/Special:MyLanguage/API:Email';
    }
}
