/**
 * Make the two-step login easier.
 *
 * @author Niklas Laxström
 * @class mw.Api.plugin.login
 * @since 1.22
 */
(function () {
    'use strict';

    $.extend(mw.Api.prototype, {
        /**
         * @param {string} username
         * @param {string} password
         * @return {jQuery.Promise} See mw.Api#post
         */
        login: function (username, password) {
            var params, apiPromise, innerPromise,
                api = this;

            params = {
                action: 'login',
                lgname: username,
                lgpassword: password
            };

            apiPromise = api.post(params);

            return apiPromise
                .then(function (data) {
                    params.lgtoken = data.login.token;
                    innerPromise = api.post(params)
                        .then(function (response) {
                            var code;
                            if (response.login.result !== 'Success') {
                                // Set proper error code whenever possible
                                code = response.error && response.error.code || 'unknown';
                                return $.Deferred().reject(code, response);
                            }
                            return response;
                        });
                    return innerPromise;
                })
                .promise({
                    abort: function () {
                        apiPromise.abort();
                        if (innerPromise) {
                            innerPromise.abort();
                        }
                    }
                });
        }
    });

    /**
     * @class mw.Api
     * @mixins mw.Api.plugin.login
     */

}());
