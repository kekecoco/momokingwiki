<?php
/**
 * Creation and parsing of MW-style timestamps.
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
 * @since 1.20
 * @author Tyler Romeo, 2012
 */

use MediaWiki\MainConfigNames;
use MediaWiki\MediaWikiServices;
use MediaWiki\User\UserIdentity;
use MediaWiki\User\UserTimeCorrection;
use Wikimedia\Timestamp\ConvertibleTimestamp;

/**
 * Library for creating and parsing MW-style timestamps. Based on the JS
 * library that does the same thing.
 *
 * @newable
 *
 * @since 1.20
 */
class MWTimestamp extends ConvertibleTimestamp
{
    /**
     * Get a timestamp instance in GMT
     *
     * @param bool|string $ts Timestamp to set, or false for current time
     * @return MWTimestamp The instance
     */
    public static function getInstance($ts = false)
    {
        return new static($ts);
    }

    /**
     * Get the timestamp in a human-friendly relative format, e.g., "3 days ago".
     *
     * Determine the difference between the timestamp and the current time, and
     * generate a readable timestamp by returning "<N> <units> ago", where the
     * largest possible unit is used.
     *
     * @param MWTimestamp|null $relativeTo The base timestamp to compare to (defaults to now)
     * @param UserIdentity|null $user User the timestamp is being generated for
     *  (or null to use main context's user)
     * @param Language|null $lang Language to use to make the human timestamp
     *  (or null to use main context's language)
     * @return string Formatted timestamp
     * @since 1.22 Uses Language::getHumanTimestamp to produce the timestamp
     * @deprecated since 1.26 Use Language::getHumanTimestamp directly
     *
     * @since 1.20
     */
    public function getHumanTimestamp(
        MWTimestamp $relativeTo = null, UserIdentity $user = null, Language $lang = null
    )
    {
        wfDeprecated(__METHOD__, '1.26');
        if ($lang === null) {
            $lang = RequestContext::getMain()->getLanguage();
        }

        return $lang->getHumanTimestamp($this, $relativeTo, $user);
    }

    /**
     * Adjust the timestamp depending on the given user's preferences.
     *
     * @param UserIdentity $user User to take preferences from
     * @return DateInterval Offset that was applied to the timestamp
     * @since 1.22
     *
     */
    public function offsetForUser(UserIdentity $user)
    {
        $option = MediaWikiServices::getInstance()
            ->getUserOptionsLookup()
            ->getOption($user, 'timecorrection');

        $value = new UserTimeCorrection(
            $option,
            $this->timestamp,
            MediaWikiServices::getInstance()->getMainConfig()->get(MainConfigNames::LocalTZoffset)
        );
        $tz = $value->getTimeZone();
        if ($tz) {
            $this->timestamp->setTimezone($tz);

            return new DateInterval('P0Y');
        }
        $interval = $value->getTimeOffsetInterval();
        $this->timestamp->add($interval);

        return $interval;
    }

    /**
     * Generate a purely relative timestamp, i.e., represent the time elapsed between
     * the given base timestamp and this object.
     *
     * @param MWTimestamp|null $relativeTo Relative base timestamp (defaults to now)
     * @param UserIdentity|null $user Use to use offset for
     * @param Language|null $lang Language to use
     * @param array $chosenIntervals Intervals to use to represent it
     * @return string Relative timestamp
     */
    public function getRelativeTimestamp(
        MWTimestamp $relativeTo = null,
        UserIdentity $user = null,
        Language $lang = null,
        array $chosenIntervals = []
    )
    {
        if ($relativeTo === null) {
            $relativeTo = new self;
        }
        if ($user === null) {
            $user = RequestContext::getMain()->getUser();
        }
        if ($lang === null) {
            $lang = RequestContext::getMain()->getLanguage();
        }

        $ts = '';
        $diff = $this->diff($relativeTo);

        $user = User::newFromIdentity($user); // For compatibility with the hook signature
        if (Hooks::runner()->onGetRelativeTimestamp(
            $ts, $diff, $this, $relativeTo, $user, $lang)
        ) {
            $seconds = ((($diff->days * 24 + $diff->h) * 60 + $diff->i) * 60 + $diff->s);
            $ts = wfMessage('ago', $lang->formatDuration($seconds, $chosenIntervals))
                ->inLanguage($lang)->text();
        }

        return $ts;
    }

    /**
     * Get the localized timezone message, if available.
     *
     * Premade translations are not shipped as format() may return whatever the
     * system uses, localized or not, so translation must be done through wiki.
     *
     * @return Message The localized timezone message
     * @since 1.27
     */
    public function getTimezoneMessage()
    {
        $tzMsg = $this->format('T');  // might vary on DST changeover!
        $key = 'timezone-' . strtolower(trim($tzMsg));
        $msg = wfMessage($key);
        if ($msg->exists()) {
            return $msg;
        }

        return new RawMessage($tzMsg);
    }

    /**
     * Get a timestamp instance in the server local timezone ($wgLocaltimezone)
     *
     * @param bool|string $ts Timestamp to set, or false for current time
     * @return MWTimestamp The local instance
     * @since 1.22
     */
    public static function getLocalInstance($ts = false)
    {
        $localtimezone = MediaWikiServices::getInstance()->getMainConfig()->get(MainConfigNames::Localtimezone);
        $timestamp = new self($ts);
        $timestamp->setTimezone($localtimezone);

        return $timestamp;
    }
}
