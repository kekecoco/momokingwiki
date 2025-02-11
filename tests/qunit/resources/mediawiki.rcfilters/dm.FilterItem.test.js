/* eslint-disable camelcase */
(function () {
    QUnit.module('mediawiki.rcfilters - FilterItem');

    QUnit.test('Initializing filter item', function (assert) {
        var item,
            group1 = new mw.rcfilters.dm.FilterGroup('group1'),
            group2 = new mw.rcfilters.dm.FilterGroup('group2');

        item = new mw.rcfilters.dm.FilterItem('filter1', group1);
        assert.strictEqual(
            item.getName(),
            'group1__filter1',
            'Filter name is retained.'
        );
        assert.strictEqual(
            item.getGroupName(),
            'group1',
            'Group name is retained.'
        );

        item = new mw.rcfilters.dm.FilterItem(
            'filter1',
            group1,
            {
                label: 'test label',
                description: 'test description'
            }
        );
        assert.strictEqual(
            item.getLabel(),
            'test label',
            'Label information is retained.'
        );
        assert.strictEqual(
            item.getLabel(),
            'test label',
            'Description information is retained.'
        );

        item = new mw.rcfilters.dm.FilterItem(
            'filter1',
            group1,
            {
                selected: true
            }
        );
        assert.strictEqual(
            item.isSelected(),
            true,
            'Item can be selected in the config.'
        );
        item.toggleSelected(true);
        assert.strictEqual(
            item.isSelected(),
            true,
            'Item can toggle its selected state.'
        );

        // Subsets
        item = new mw.rcfilters.dm.FilterItem(
            'filter1',
            group1,
            {
                subset: ['sub1', 'sub2', 'sub3']
            }
        );
        assert.deepEqual(
            item.getSubset(),
            ['sub1', 'sub2', 'sub3'],
            'Subset information is retained.'
        );
        assert.strictEqual(
            item.existsInSubset('sub1'),
            true,
            'Specific item exists in subset.'
        );
        assert.strictEqual(
            item.existsInSubset('sub10'),
            false,
            'Specific item does not exists in subset.'
        );
        assert.strictEqual(
            item.isIncluded(),
            false,
            'Initial state of "included" is false.'
        );

        item.toggleIncluded(true);
        assert.strictEqual(
            item.isIncluded(),
            true,
            'Item toggles its included state.'
        );

        // Conflicts
        item = new mw.rcfilters.dm.FilterItem(
            'filter1',
            group1,
            {
                conflicts: {
                    group2__conflict1: {group: 'group2', filter: 'group2__conflict1'},
                    group2__conflict2: {group: 'group2', filter: 'group2__conflict2'},
                    group2__conflict3: {group: 'group2', filter: 'group2__conflict3'}
                }
            }
        );
        assert.deepEqual(
            item.getConflicts(),
            {
                group2__conflict1: {group: 'group2', filter: 'group2__conflict1'},
                group2__conflict2: {group: 'group2', filter: 'group2__conflict2'},
                group2__conflict3: {group: 'group2', filter: 'group2__conflict3'}
            },
            'Conflict information is retained.'
        );
        assert.strictEqual(
            item.existsInConflicts(new mw.rcfilters.dm.FilterItem('conflict1', group2)),
            true,
            'Specific item exists in conflicts.'
        );
        assert.strictEqual(
            item.existsInConflicts(new mw.rcfilters.dm.FilterItem('conflict10', group1)),
            false,
            'Specific item does not exists in conflicts.'
        );
        assert.strictEqual(
            item.isConflicted(),
            false,
            'Initial state of "conflicted" is false.'
        );

        item.toggleConflicted(true);
        assert.strictEqual(
            item.isConflicted(),
            true,
            'Item toggles its conflicted state.'
        );

        // Fully covered
        item = new mw.rcfilters.dm.FilterItem('filter1', group1);
        assert.strictEqual(
            item.isFullyCovered(),
            false,
            'Initial state of "full coverage" is false.'
        );
        item.toggleFullyCovered(true);
        assert.strictEqual(
            item.isFullyCovered(),
            true,
            'Item toggles its fully coverage state.'
        );

    });

    QUnit.test('Emitting events', function (assert) {
        var group1 = new mw.rcfilters.dm.FilterGroup('group1'),
            item = new mw.rcfilters.dm.FilterItem('filter1', group1),
            events = [];

        // Listen to update events
        item.on('update', function () {
            events.push(item.getState());
        });

        // Do stuff
        item.toggleSelected(true); // { selected: true, included: false, conflicted: false, fullyCovered: false }
        item.toggleSelected(true); // No event (duplicate state)
        item.toggleIncluded(true); // { selected: true, included: true, conflicted: false, fullyCovered: false }
        item.toggleConflicted(true); // { selected: true, included: true, conflicted: true, fullyCovered: false }
        item.toggleFullyCovered(true); // { selected: true, included: true, conflicted: true, fullyCovered: true }
        item.toggleSelected(); // { selected: false, included: true, conflicted: true, fullyCovered: true }

        // Check emitted events
        assert.deepEqual(
            events,
            [
                {selected: true, included: false, conflicted: false, fullyCovered: false},
                {selected: true, included: true, conflicted: false, fullyCovered: false},
                {selected: true, included: true, conflicted: true, fullyCovered: false},
                {selected: true, included: true, conflicted: true, fullyCovered: true},
                {selected: false, included: true, conflicted: true, fullyCovered: true}
            ],
            'Events emitted successfully.'
        );
    });

    QUnit.test('get/set boolean value', function (assert) {
        var group = new mw.rcfilters.dm.FilterGroup('group1', {type: 'boolean'}),
            item = new mw.rcfilters.dm.FilterItem('filter1', group);

        item.setValue('1');

        assert.strictEqual(item.getValue(), true, 'Value is coerced to boolean');
    });

    QUnit.test('get/set any value', function (assert) {
        var group = new mw.rcfilters.dm.FilterGroup('group1', {type: 'any_value'}),
            item = new mw.rcfilters.dm.FilterItem('filter1', group);

        item.setValue('1');

        assert.strictEqual(item.getValue(), '1', 'Value is kept as-is');
    });
}());
