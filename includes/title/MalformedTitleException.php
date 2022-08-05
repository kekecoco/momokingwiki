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
 */

/**
 * MalformedTitleException is thrown when a TitleParser is unable to parse a title string.
 * @newable
 * @since 1.23
 */
class MalformedTitleException extends Exception implements ILocalizedException
{

    /** @var string|null */
    private $titleText;
    /** @var string */
    private $errorMessage;
    /** @var array */
    private $errorMessageParameters;

    /**
     * @stable to call
     * @param string $errorMessage Localisation message describing the error (since MW 1.26)
     * @param string|null $titleText The invalid title text (since MW 1.26)
     * @param array $errorMessageParameters Additional parameters for the error message.
     * $titleText will be appended if it's not null. (since MW 1.26)
     */
    public function __construct(
        $errorMessage, $titleText = null, $errorMessageParameters = []
    )
    {
        $this->errorMessage = $errorMessage;
        $this->titleText = $titleText;
        if ($titleText !== null) {
            $errorMessageParameters[] = wfEscapeWikiText($titleText);
        }
        $this->errorMessageParameters = $errorMessageParameters;

        // Supply something useful for Exception::getMessage() to return.
        $enMsg = wfMessage($errorMessage, $errorMessageParameters);
        $enMsg->inLanguage('en')->useDatabase(false);
        parent::__construct($enMsg->text());
    }

    /**
     * @return string|null
     * @since 1.26
     */
    public function getTitleText()
    {
        return $this->titleText;
    }

    /**
     * @return string
     * @since 1.26
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * @return array
     * @since 1.26
     */
    public function getErrorMessageParameters()
    {
        return $this->errorMessageParameters;
    }

    /**
     * @return Message
     * @since 1.29
     */
    public function getMessageObject()
    {
        return wfMessage($this->getErrorMessage(), $this->getErrorMessageParameters());
    }
}
