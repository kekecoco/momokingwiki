/*!
 * mediawiki.filewarning
 *
 * @author Mark Holmquist, 2015
 * @since 1.25
 */
(function () {
    var warningConfig = mw.config.get('wgFileWarning'),
        warningMessages = warningConfig.messages,
        warningLink = warningConfig.link,
        $origMimetype = $('.fullMedia .fileInfo .mime-type'),
        $mimetype = $origMimetype.clone(),
        $header = $('<h3>')
            .addClass('mediawiki-filewarning-header empty'),
        $main = $('<p>')
            .addClass('mediawiki-filewarning-main empty'),
        $info = $('<a>')
            .addClass('mediawiki-filewarning-info empty'),
        $footer = $('<p>')
            .addClass('mediawiki-filewarning-footer empty'),
        dialog = new OO.ui.PopupButtonWidget({
            classes: ['mediawiki-filewarning-anchor'],
            label: $mimetype,
            flags: ['warning'],
            icon: 'alert',
            framed: false,
            popup: {
                // This popup is always "visible", but hidden using CSS. OOUI event handlers that try to
                // close it interfere with other things on the page. (T309093)
                autoClose: false,
                classes: ['mediawiki-filewarning'],
                padded: true,
                width: 400,
                $content: $header.add($main).add($info).add($footer)
            }
        });

    function loadMessage($target, message) {
        if (message) {
            $target.removeClass('empty')
                // eslint-disable-next-line mediawiki/msg-doc
                .text(mw.msg(message));
        }
    }

    // The main message must be populated for the dialog to show.
    if (warningConfig && warningConfig.messages && warningConfig.messages.main) {
        $mimetype.addClass('has-warning');

        $origMimetype.replaceWith(dialog.$element);

        if (warningMessages) {
            loadMessage($main, warningMessages.main);
            loadMessage($header, warningMessages.header);
            loadMessage($footer, warningMessages.footer);

            if (warningLink) {
                loadMessage($info, warningMessages.info);
                $info.attr('href', warningLink);
            }
        }

        // Make OOUI open the dialog, it won't appear until the user
        // hovers over the warning.
        dialog.getPopup().toggle(true);

        // Override toggle handler because we don't need it for this popup
        // object at all. Sort of nasty, but it gets the job done.
        dialog.getPopup().toggle = function () {
        };
    }
}());
