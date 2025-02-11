<?php
/**
 * Special page which uses an HTMLForm to handle processing.
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

/**
 * Special page which uses an HTMLForm to handle processing.  This is mostly a
 * clone of FormAction.  More special pages should be built this way; maybe this could be
 * a new structure for SpecialPages.
 *
 * @ingroup SpecialPage
 */
abstract class FormSpecialPage extends SpecialPage
{
    /**
     * The sub-page of the special page.
     * @var string|null
     */
    protected $par = null;

    /**
     * @var array|null POST data preserved across re-authentication
     * @since 1.32
     */
    protected $reauthPostData = null;

    /**
     * Get an HTMLForm descriptor array
     * @return array
     */
    abstract protected function getFormFields();

    /**
     * Add pre-HTML to the form
     * @return string HTML which will be sent to $form->addPreHtml()
     * @since 1.38
     */
    protected function preHtml()
    {
        return '';
    }

    /**
     * Add post-HTML to the form
     * @return string HTML which will be sent to $form->addPostHtml()
     * @since 1.38
     */
    protected function postHtml()
    {
        return '';
    }

    /**
     * Add pre-text to the form
     * @return string HTML which will be sent to $form->addPreText()
     * @deprecated since 1.38, use preHtml() instead
     */
    protected function preText()
    {
        return $this->preHtml();
    }

    /**
     * Add post-text to the form
     * @return string HTML which will be sent to $form->addPostText()
     * @deprecated since 1.38, use postHtml() instead
     */
    protected function postText()
    {
        return $this->postHtml();
    }

    /**
     * Play with the HTMLForm if you need to more substantially
     * @param HTMLForm $form
     */
    protected function alterForm(HTMLForm $form)
    {
    }

    /**
     * Get message prefix for HTMLForm
     *
     * @return string
     * @since 1.21
     */
    protected function getMessagePrefix()
    {
        return strtolower($this->getName());
    }

    /**
     * Get display format for the form. See HTMLForm documentation for available values.
     *
     * @return string
     * @since 1.25
     */
    protected function getDisplayFormat()
    {
        return 'table';
    }

    /**
     * Get the HTMLForm to control behavior
     * @return HTMLForm|null
     */
    protected function getForm()
    {
        $context = $this->getContext();
        $onSubmit = [$this, 'onSubmit'];

        if ($this->reauthPostData) {
            // Restore POST data
            $context = new DerivativeContext($context);
            $oldRequest = $this->getRequest();
            $context->setRequest(new DerivativeRequest(
                $oldRequest, $this->reauthPostData + $oldRequest->getQueryValues(), true
            ));

            // But don't treat it as a "real" submission just in case of some
            // crazy kind of CSRF.
            $onSubmit = static function () {
                return false;
            };
        }

        $form = HTMLForm::factory(
            $this->getDisplayFormat(),
            $this->getFormFields(),
            $context,
            $this->getMessagePrefix()
        );
        $form->setSubmitCallback($onSubmit);
        if ($this->getDisplayFormat() !== 'ooui') {
            // No legend and wrapper by default in OOUI forms, but can be set manually
            // from alterForm()
            $form->setWrapperLegendMsg($this->getMessagePrefix() . '-legend');
        }

        $headerMsg = $this->msg($this->getMessagePrefix() . '-text');
        if (!$headerMsg->isDisabled()) {
            $form->addHeaderText($headerMsg->parseAsBlock());
        }

        // preText / postText are deprecated, but we need to keep calling them until the end of
        // the deprecation process so a subclass overriding *Text and *Html both work
        $form->addPreText($this->preText());
        $form->addPostText($this->postText());
        $this->alterForm($form);
        if ($form->getMethod() == 'post') {
            // Retain query parameters (uselang etc) on POST requests
            $params = array_diff_key(
                $this->getRequest()->getQueryValues(), ['title' => null]);
            $form->addHiddenField('redirectparams', wfArrayToCgi($params));
        }

        // Give hooks a chance to alter the form, adding extra fields or text etc
        $this->getHookRunner()->onSpecialPageBeforeFormDisplay($this->getName(), $form);

        return $form;
    }

    /**
     * Process the form on POST submission.
     * @phpcs:disable MediaWiki.Commenting.FunctionComment.ExtraParamComment
     * @param array $data
     * @param HTMLForm|null $form
     * @suppress PhanCommentParamWithoutRealParam Many implementations don't have $form
     * @return bool|string|array|Status As documented for HTMLForm::trySubmit.
     * @phpcs:enable MediaWiki.Commenting.FunctionComment.ExtraParamComment
     */
    abstract public function onSubmit(array $data /* HTMLForm $form = null */);

    /**
     * Do something exciting on successful processing of the form, most likely to show a
     * confirmation message
     * @since 1.22 Default is to do nothing
     */
    public function onSuccess()
    {
    }

    /**
     * Basic SpecialPage workflow: get a form, send it to the user; get some data back,
     *
     * @param string|null $par Subpage string if one was specified
     */
    public function execute($par)
    {
        $this->setParameter($par);
        $this->setHeaders();

        // This will throw exceptions if there's a problem
        $this->checkExecutePermissions($this->getUser());

        $securityLevel = $this->getLoginSecurityLevel();
        if ($securityLevel !== false && !$this->checkLoginSecurityLevel($securityLevel)) {
            return;
        }

        $form = $this->getForm();
        if ($form->show()) {
            $this->onSuccess();
        }
    }

    /**
     * Maybe do something interesting with the subpage parameter
     * @param string|null $par
     */
    protected function setParameter($par)
    {
        $this->par = $par;
    }

    /**
     * Called from execute() to check if the given user can perform this action.
     * Failures here must throw subclasses of ErrorPageError.
     * @param User $user
     * @throws UserBlockedError
     */
    protected function checkExecutePermissions(User $user)
    {
        $this->checkPermissions();

        if ($this->requiresUnblock()) {
            $block = $user->getBlock();
            if ($block && $block->isSitewide()) {
                throw new UserBlockedError(
                    $block,
                    $user,
                    $this->getLanguage(),
                    $this->getRequest()->getIP()
                );
            }
        }

        if ($this->requiresWrite()) {
            $this->checkReadOnly();
        }
    }

    /**
     * Whether this action requires the wiki not to be locked
     * @return bool
     */
    public function requiresWrite()
    {
        return true;
    }

    /**
     * Whether this action cannot be executed by a blocked user
     * @return bool
     */
    public function requiresUnblock()
    {
        return true;
    }

    /**
     * Preserve POST data across reauthentication
     *
     * @param array $data
     * @since 1.32
     */
    protected function setReauthPostData(array $data)
    {
        $this->reauthPostData = $data;
    }
}
