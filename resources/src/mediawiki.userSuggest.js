/*!
 * Add autocomplete suggestions for names of registered users.
 */
(function () {
    var api, config;

    config = {
        fetch: function (userInput, response, maxRows) {
            var node = this[0];

            api = api || new mw.Api();

            $.data(node, 'request', api.get({
                formatversion: 2,
                action: 'query',
                list: 'allusers',
                auprefix: userInput,
                aulimit: maxRows
            }).done(function (data) {
                var users = data.query.allusers.map(function (userObj) {
                    return userObj.name;
                });
                response(users);
            }));
        },
        cancel: function () {
            var node = this[0],
                request = $.data(node, 'request');

            if (request) {
                request.abort();
                $.removeData(node, 'request');
            }
        }
    };

    $(function () {
        $('.mw-autocomplete-user').suggestions(config);
    });
}());
