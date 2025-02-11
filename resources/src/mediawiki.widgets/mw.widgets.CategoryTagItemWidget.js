/*!
 * MediaWiki Widgets - CategoryTagItemWidget class.
 *
 * @copyright 2011-2015 MediaWiki Widgets Team and others; see AUTHORS.txt
 * @license The MIT License (MIT); see LICENSE.txt
 */
(function () {

    var hasOwn = Object.prototype.hasOwnProperty;

    /**
     * @class mw.widgets.PageExistenceCache
     * @private
     * @param {mw.Api} [api]
     */
    function PageExistenceCache(api) {
        this.api = api || new mw.Api();
        this.processExistenceCheckQueueDebounced = OO.ui.debounce(this.processExistenceCheckQueue);
        this.currentRequest = null;
        this.existenceCache = {};
        this.existenceCheckQueue = {};
    }

    /**
     * Check for existence of pages in the queue.
     *
     * @private
     */
    PageExistenceCache.prototype.processExistenceCheckQueue = function () {
        var queue, titles,
            cache = this;
        if (this.currentRequest) {
            // Don't fire off a million requests at the same time
            this.currentRequest.always(function () {
                cache.currentRequest = null;
                cache.processExistenceCheckQueueDebounced();
            });
            return;
        }
        queue = this.existenceCheckQueue;
        this.existenceCheckQueue = {};
        titles = Object.keys(queue).filter(function (title) {
            if (hasOwn.call(cache.existenceCache, title)) {
                queue[title].resolve(cache.existenceCache[title]);
            }
            return !hasOwn.call(cache.existenceCache, title);
        });
        if (!titles.length) {
            return;
        }
        this.currentRequest = this.api.get({
            formatversion: 2,
            action: 'query',
            prop: ['info'],
            titles: titles
        }).done(function (response) {
            var
                normalized = {},
                pages = {};
            (response.query.normalized || []).forEach(function (data) {
                normalized[data.fromencoded ? decodeURIComponent(data.from) : data.from] = data.to;
            });
            response.query.pages.forEach(function (page) {
                pages[page.title] = !page.missing;
            });
            titles.forEach(function (title) {
                var normalizedTitle = title;
                while (hasOwn.call(normalized, normalizedTitle)) {
                    normalizedTitle = normalized[normalizedTitle];
                }
                cache.existenceCache[title] = pages[normalizedTitle];
                queue[title].resolve(cache.existenceCache[title]);
            });
        });
    };

    /**
     * Register a request to check whether a page exists.
     *
     * @private
     * @param {mw.Title} title
     * @return {jQuery.Promise} Promise resolved with true if the page exists or false otherwise
     */
    PageExistenceCache.prototype.checkPageExistence = function (title) {
        var key = title.getPrefixedText();
        if (!hasOwn.call(this.existenceCheckQueue, key)) {
            this.existenceCheckQueue[key] = $.Deferred();
        }
        this.processExistenceCheckQueueDebounced();
        return this.existenceCheckQueue[key].promise();
    };

    /**
     * @class mw.widgets.ForeignTitle
     * @private
     * @extends mw.Title
     *
     * @constructor
     * @param {string} title
     * @param {number} [namespace]
     */
    function ForeignTitle(title, namespace) {
        // We only need to handle categories here... but we don't know the target language.
        // So assume that any namespace-like prefix is the 'Category' namespace...
        title = title.replace(/^(.+?)_*:_*(.*)$/, 'Category:$2'); // HACK
        ForeignTitle.parent.call(this, title, namespace);
    }

    OO.inheritClass(ForeignTitle, mw.Title);
    ForeignTitle.prototype.getNamespacePrefix = function () {
        // We only need to handle categories here...
        return 'Category:'; // HACK
    };

    /**
     * Category selector tag item widget. Extends OO.ui.TagItemWidget with the ability to link
     * to the given page, and to show its existence status (i.e., whether it is a redlink).
     *
     * @class mw.widgets.CategoryTagItemWidget
     * @uses mw.Api
     * @extends OO.ui.TagItemWidget
     *
     * @constructor
     * @param {Object} config Configuration options
     * @cfg {mw.Title} title Page title to use (required)
     * @cfg {string} [apiUrl] API URL, if not the current wiki's API
     */
    mw.widgets.CategoryTagItemWidget = function MWWCategoryTagItemWidget(config) {
        var widget = this;
        // Parent constructor
        mw.widgets.CategoryTagItemWidget.parent.call(this, $.extend({
            data: config.title.getMainText(),
            label: config.title.getMainText()
        }, config));

        // Properties
        this.title = config.title;
        this.apiUrl = config.apiUrl || '';
        this.$link = $('<a>')
            .text(this.label)
            .attr('target', '_blank')
            .on('click', function (e) {
                // TagMultiselectWidget really wants to prevent you from clicking the link, don't let it
                e.stopPropagation();
            });

        // Initialize
        this.setMissing(false);
        this.$label.replaceWith(this.$link);
        this.setLabelElement(this.$link);

        if (!this.constructor.static.pageExistenceCaches[this.apiUrl]) {
            this.constructor.static.pageExistenceCaches[this.apiUrl] =
                new PageExistenceCache(new mw.ForeignApi(this.apiUrl));
        }
        this.constructor.static.pageExistenceCaches[this.apiUrl]
            .checkPageExistence(new ForeignTitle(this.title.getPrefixedText()))
            .done(function (exists) {
                widget.setMissing(!exists);
            });
    };

    /* Setup */

    OO.inheritClass(mw.widgets.CategoryTagItemWidget, OO.ui.TagItemWidget);

    /* Static Properties */

    /**
     * Map of API URLs to PageExistenceCache objects.
     *
     * @static
     * @inheritable
     * @property {Object}
     */
    mw.widgets.CategoryTagItemWidget.static.pageExistenceCaches = {
        '': new PageExistenceCache()
    };

    /* Methods */

    /**
     * Update label link href and CSS classes to reflect page existence status.
     *
     * @private
     * @param {boolean} missing Whether the page is missing (does not exist)
     */
    mw.widgets.CategoryTagItemWidget.prototype.setMissing = function (missing) {
        var
            title = new ForeignTitle(this.title.getPrefixedText()), // HACK
            prefix = this.apiUrl.replace('/w/api.php', ''); // HACK

        this.missing = missing;

        if (!missing) {
            this.$link
                .attr('href', prefix + title.getUrl())
                .attr('title', title.getPrefixedText())
                .removeClass('new');
        } else {
            this.$link
                .attr('href', prefix + title.getUrl({action: 'edit', redlink: 1}))
                .attr('title', mw.msg('red-link-title', title.getPrefixedText()))
                .addClass('new');
        }
    };
}());
