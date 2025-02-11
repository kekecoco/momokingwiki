<?php
/**
 * Efficient paging for SQL queries.
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
 * @ingroup Pager
 */

/**
 * IndexPager with an alphabetic list and a formatted navigation bar
 * @stable to extend
 * @ingroup Pager
 */
abstract class AlphabeticPager extends IndexPager
{

    /**
     * Shamelessly stolen bits from ReverseChronologicalPager,
     * didn't want to do class magic as may be still revamped
     *
     * @stable to override
     *
     * @return string HTML
     */
    public function getNavigationBar()
    {
        if (!$this->isNavigationBarShown()) {
            return '';
        }

        if (isset($this->mNavigationBar)) {
            return $this->mNavigationBar;
        }

        $linkTexts = [
            'prev'  => $this->msg('prevn')->numParams($this->mLimit)->escaped(),
            'next'  => $this->msg('nextn')->numParams($this->mLimit)->escaped(),
            'first' => $this->msg('page_first')->escaped(),
            'last'  => $this->msg('page_last')->escaped()
        ];

        $lang = $this->getLanguage();

        $pagingLinks = $this->getPagingLinks($linkTexts);
        $limitLinks = $this->getLimitLinks();
        $limits = $lang->pipeList($limitLinks);

        $this->mNavigationBar = $this->msg('parentheses')->rawParams(
                $lang->pipeList([$pagingLinks['first'],
                    $pagingLinks['last']]))->escaped() . " " .
            $this->msg('viewprevnext')->rawParams($pagingLinks['prev'],
                $pagingLinks['next'], $limits)->escaped();

        if (is_array($this->getIndexField())) {
            $extra = '';
            $msgs = $this->getOrderTypeMessages();
            foreach ($msgs as $order => $msg) {
                if ($extra !== '') {
                    $extra .= $this->msg('pipe-separator')->escaped();
                }

                if ($order == $this->mOrderType) {
                    $extra .= $this->msg($msg)->escaped();
                } else {
                    $extra .= $this->makeLink(
                        $this->msg($msg)->escaped(),
                        ['order' => $order]
                    );
                }
            }

            if ($extra !== '') {
                $extra = ' ' . $this->msg('parentheses')->rawParams($extra)->escaped();
                $this->mNavigationBar .= $extra;
            }
        }

        $this->mNavigationBar = Html::rawElement('div', ['class' => 'mw-pager-navigation-bar'],
            $this->mNavigationBar
        );

        return $this->mNavigationBar;
    }

    /**
     * If this supports multiple order type messages, give the message key for
     * enabling each one in getNavigationBar.  The return type is an associative
     * array whose keys must exactly match the keys of the array returned
     * by getIndexField(), and whose values are message keys.
     *
     * @stable to override
     *
     * @return array|null
     */
    protected function getOrderTypeMessages()
    {
        return null;
    }
}
