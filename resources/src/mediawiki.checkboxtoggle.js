/*!
 * Allows users to perform all / none / invert operations on a list of
 * checkboxes on the page.
 *
 * @licence GNU GPL v2+
 * @author Luke Faraone <luke at faraone dot cc>
 *
 * Based on ext.nuke.js from https://www.mediawiki.org/wiki/Extension:Nuke by
 * Jeroen De Dauw <jeroendedauw at gmail dot com>
 */

(function () {
    'use strict';

    $(function () {
        // FIXME: This shouldn't be a global selector to avoid conflicts
        // with unrelated content on the same page. (T131318)
        var $checkboxes = $('li input[type="checkbox"]');

        function selectAll(check) {
            $checkboxes.prop('checked', check).trigger('change');
        }

        $('.mw-checkbox-all').on('click', function () {
            selectAll(true);
        });
        $('.mw-checkbox-none').on('click', function () {
            selectAll(false);
        });
        $('.mw-checkbox-invert').on('click', function () {
            $checkboxes.prop('checked', function (i, val) {
                return !val;
            }).trigger('change');
        });

    });

}());
