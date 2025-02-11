(function () {
    QUnit.module('mediawiki.toc', {
        beforeEach: function () {
            this.getCookie = this.stub(mw.cookie, 'get').returns(null);
            this.setCookie = this.stub(mw.cookie, 'set').returns(null);
            this.tocHtml = '<div class="toc" role="navigation">' +
                '<input type="checkbox" role="button" id="toctogglecheckbox" class="toctogglecheckbox" />' +
                '<div class="toctitle" lang="en" dir="ltr">' +
                '<span class="toctogglespan"><label class="toctogglelabel" for="toctogglecheckbox"></label></span>' +
                '</div>' +
                '<ul><li class="toclevel-1 tocsection-1">…</li></ul>' +
                '</div>';
        }
    });

    QUnit.test('Use toggle', function (assert) {
        var tocNode, tocToggle;

        tocNode = $.parseHTML(this.tocHtml)[0];
        tocToggle = tocNode.querySelector('.toctogglelabel');
        $('#qunit-fixture').append(tocNode);
        mw.hook('wikipage.content').fire($('#qunit-fixture'));

        assert.strictEqual(this.getCookie.callCount, 1, 'Initial cookie reads');
        assert.strictEqual(this.setCookie.callCount, 0, 'Initial cookie writes');

        tocToggle.click();

        assert.propEqual(this.setCookie.args[0], ['hidetoc', '1'], 'Cookie set');
        assert.strictEqual(this.getCookie.callCount, 1, 'Final cookie reads');
        assert.strictEqual(this.setCookie.callCount, 1, 'Final cookie writes');
    });

    QUnit.test('Initially hidden', function (assert) {
        var tocNode;

        this.getCookie.returns('1');

        tocNode = $.parseHTML(this.tocHtml)[0];
        $('#qunit-fixture').append(tocNode);
        mw.hook('wikipage.content').fire($('#qunit-fixture'));

        assert.strictEqual(this.getCookie.callCount, 1, 'Initial cookie reads');
        assert.strictEqual(this.setCookie.callCount, 0, 'Initial cookie writes');
    });
}());
