var ViewSwitchWidget;

/**
 * A widget for the footer for the default view, allowing to switch views
 *
 * @class mw.rcfilters.ui.ViewSwitchWidget
 * @extends OO.ui.Widget
 *
 * @constructor
 * @param {mw.rcfilters.Controller} controller Controller
 * @param {mw.rcfilters.dm.FiltersViewModel} model View model
 * @param {Object} [config] Configuration object
 */
ViewSwitchWidget = function MwRcfiltersUiViewSwitchWidget(controller, model, config) {
    config = config || {};

    // Parent
    ViewSwitchWidget.parent.call(this, config);

    this.controller = controller;
    this.model = model;

    this.buttons = new OO.ui.ButtonGroupWidget({
        items: [
            new OO.ui.ButtonWidget({
                data: 'namespaces',
                icon: 'article',
                label: mw.msg('namespaces')
            }),
            new OO.ui.ButtonWidget({
                data: 'tags',
                icon: 'tag',
                label: mw.msg('rcfilters-view-tags')
            })
        ]
    });

    this.buttons.aggregate({click: 'buttonClick'});

    // Events
    this.model.connect(this, {update: 'onModelUpdate'});
    this.buttons.connect(this, {buttonClick: 'onButtonClick'});

    this.$element
        .addClass('mw-rcfilters-ui-viewSwitchWidget')
        .append(
            new OO.ui.LabelWidget({
                label: mw.msg('rcfilters-advancedfilters')
            }).$element,
            $('<div>')
                .addClass('mw-rcfilters-ui-viewSwitchWidget-buttons')
                .append(this.buttons.$element)
        );
};

/* Initialize */

OO.inheritClass(ViewSwitchWidget, OO.ui.Widget);

/**
 * Respond to model update event
 */
ViewSwitchWidget.prototype.onModelUpdate = function () {
    var currentView = this.model.getCurrentView();

    this.buttons.getItems().forEach(function (buttonWidget) {
        buttonWidget.setActive(buttonWidget.getData() === currentView);
    });
};

/**
 * Respond to button switch click
 *
 * @param {OO.ui.ButtonWidget} buttonWidget Clicked button
 */
ViewSwitchWidget.prototype.onButtonClick = function (buttonWidget) {
    this.controller.switchView(buttonWidget.getData());
};

module.exports = ViewSwitchWidget;
