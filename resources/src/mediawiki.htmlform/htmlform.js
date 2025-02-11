(function () {

    $(function () {
        mw.hook('htmlform.enhance').fire($(document));
    });

    mw.hook('htmlform.enhance').add(function ($root) {
        var $collapsible;

        // Turn HTML5 form validation back on, in cases where it was disabled server-side (see
        // HTMLForm::needsJSForHtml5FormValidation()) because we need extra logic implemented in JS to
        // validate correctly. Currently, this is only used for forms containing fields with 'hide-if'.
        $root.find('.mw-htmlform').removeAttr('novalidate');

        // Enable collapsible forms
        $collapsible = $root.find('.mw-htmlform-ooui .oo-ui-fieldsetLayout.mw-collapsible');
        if ($collapsible.length) {
            mw.loader.using('jquery.makeCollapsible').then(function () {
                $collapsible.makeCollapsible();
            });
        }
    });

}());
