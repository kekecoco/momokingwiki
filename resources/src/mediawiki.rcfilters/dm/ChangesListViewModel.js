/**
 * View model for the changes list
 *
 * @class mw.rcfilters.dm.ChangesListViewModel
 * @mixins OO.EventEmitter
 *
 * @param {jQuery} $initialFieldset The initial server-generated legacy form content
 * @constructor
 */
var ChangesListViewModel = function MwRcfiltersDmChangesListViewModel($initialFieldset) {
    // Mixin constructor
    OO.EventEmitter.call(this);

    this.valid = true;
    this.newChangesExist = false;
    this.liveUpdate = false;
    this.unseenWatchedChanges = false;

    this.extractNextFrom($initialFieldset);
};

/* Initialization */
OO.initClass(ChangesListViewModel);
OO.mixinClass(ChangesListViewModel, OO.EventEmitter);

/* Events */

/**
 * @event invalidate
 *
 * The list of changes is now invalid (out of date)
 */

/**
 * @event update
 * @param {jQuery|string} $changesListContent List of changes
 * @param {jQuery} $fieldset Server-generated form
 * @param {string} noResultsDetails Type of no result error
 * @param {boolean} isInitialDOM Whether the previous dom variables are from the initial page load
 * @param {boolean} fromLiveUpdate These are new changes fetched via Live Update
 *
 * The list of changes has been updated
 */

/**
 * @event newChangesExist
 * @param {boolean} newChangesExist
 *
 * The existence of changes newer than those currently displayed has changed.
 */

/**
 * @event liveUpdateChange
 * @param {boolean} enable
 *
 * The state of the 'live update' feature has changed.
 */

/* Methods */

/**
 * Invalidate the list of changes
 *
 * @fires invalidate
 */
ChangesListViewModel.prototype.invalidate = function () {
    if (this.valid) {
        this.valid = false;
        this.emit('invalidate');
    }
};

/**
 * Update the model with an updated list of changes
 *
 * @param {jQuery|string} changesListContent
 * @param {jQuery} $fieldset
 * @param {string} noResultsDetails Type of no result error
 * @param {boolean} [isInitialDOM] Using the initial (already attached) DOM elements
 * @param {boolean} [separateOldAndNew] Whether a logical separation between old and new changes is needed
 * @fires update
 */
ChangesListViewModel.prototype.update = function (changesListContent, $fieldset, noResultsDetails, isInitialDOM, separateOldAndNew) {
    var from = this.nextFrom;
    this.valid = true;
    this.extractNextFrom($fieldset);
    this.checkForUnseenWatchedChanges(changesListContent);
    this.emit('update', changesListContent, $fieldset, noResultsDetails, isInitialDOM, separateOldAndNew ? from : null);
};

/**
 * Specify whether new changes exist
 *
 * @param {boolean} newChangesExist
 * @fires newChangesExist
 */
ChangesListViewModel.prototype.setNewChangesExist = function (newChangesExist) {
    if (newChangesExist !== this.newChangesExist) {
        this.newChangesExist = newChangesExist;
        this.emit('newChangesExist', newChangesExist);
    }
};

/**
 * @return {boolean} Whether new changes exist
 */
ChangesListViewModel.prototype.getNewChangesExist = function () {
    return this.newChangesExist;
};

/**
 * Extract the value of the 'from' parameter from a link in the field set
 *
 * @param {jQuery} $fieldset
 */
ChangesListViewModel.prototype.extractNextFrom = function ($fieldset) {
    var data = $fieldset.find('.rclistfrom > a, .wlinfo').data('params');
    if (data && data.from) {
        this.nextFrom = data.from;
        this.nextFromFormatted = data.fromFormatted;
    }
};

/**
 * @return {string} The 'from' parameter that can be used to query new changes
 */
ChangesListViewModel.prototype.getNextFrom = function () {
    return this.nextFrom;
};

/**
 * @return {string} The 'from' parameter formatted per the user's datetime format preference
 */
ChangesListViewModel.prototype.getNextFromFormatted = function () {
    return this.nextFromFormatted;
};

/**
 * Toggle the 'live update' feature on/off
 *
 * @param {boolean} enable
 */
ChangesListViewModel.prototype.toggleLiveUpdate = function (enable) {
    enable = enable === undefined ? !this.liveUpdate : enable;
    if (enable !== this.liveUpdate) {
        this.liveUpdate = enable;
        this.emit('liveUpdateChange', this.liveUpdate);
    }
};

/**
 * @return {boolean} The 'live update' feature is enabled
 */
ChangesListViewModel.prototype.getLiveUpdate = function () {
    return this.liveUpdate;
};

/**
 * Check if some of the given changes watched and unseen
 *
 * @param {jQuery|string} changeslistContent
 */
ChangesListViewModel.prototype.checkForUnseenWatchedChanges = function (changeslistContent) {
    this.unseenWatchedChanges = changeslistContent !== 'NO_RESULTS' &&
        changeslistContent.find('.mw-changeslist-line-watched').length > 0;
};

/**
 * @return {boolean} Whether some of the current changes are watched and unseen
 */
ChangesListViewModel.prototype.hasUnseenWatchedChanges = function () {
    return this.unseenWatchedChanges;
};

module.exports = ChangesListViewModel;
