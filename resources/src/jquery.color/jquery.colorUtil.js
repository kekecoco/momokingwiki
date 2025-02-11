/*!
 * jQuery Color Utilities
 *
 * Released under the MIT and GPL licenses.
 *
 * Mostly based on other plugins and functions (linted and optimized a little).
 * Sources cited inline.
 */
(function () {
    /**
     * @class jQuery.colorUtil
     * @singleton
     */
    $.colorUtil = {

        /**
         * Parse CSS color strings looking for color tuples
         *
         * Based on highlightFade by Blair Mitchelmore
         * <http://jquery.offput.ca/highlightFade/>
         *
         * @param {Array|string} color
         * @return {Array}
         */
        getRGB: function (color) {
            var result;

            // Check if we're already dealing with an array of colors
            if (color && Array.isArray(color) && color.length === 3) {
                return color;
            }
            if (typeof color !== 'string') {
                return undefined;
            }

            // Look for rgb(num,num,num)
            // eslint-disable-next-line no-cond-assign
            if (result = /rgb\(\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*,\s*([0-9]{1,3})\s*\)/.exec(color)) {
                return [
                    parseInt(result[1], 10),
                    parseInt(result[2], 10),
                    parseInt(result[3], 10)
                ];
            }

            // Look for rgb(num%,num%,num%)
            // eslint-disable-next-line no-cond-assign
            if (result = /rgb\(\s*([0-9]+(?:\.[0-9]+)?)%\s*,\s*([0-9]+(?:\.[0-9]+)?)%\s*,\s*([0-9]+(?:\.[0-9]+)?)%\s*\)/.exec(color)) {
                return [
                    parseFloat(result[1]) * 2.55,
                    parseFloat(result[2]) * 2.55,
                    parseFloat(result[3]) * 2.55
                ];
            }

            // Look for #a0b1c2
            // eslint-disable-next-line no-cond-assign
            if (result = /#([a-fA-F0-9]{2})([a-fA-F0-9]{2})([a-fA-F0-9]{2})/.exec(color)) {
                return [
                    parseInt(result[1], 16),
                    parseInt(result[2], 16),
                    parseInt(result[3], 16)
                ];
            }

            // Look for #fff
            // eslint-disable-next-line no-cond-assign
            if (result = /#([a-fA-F0-9])([a-fA-F0-9])([a-fA-F0-9])/.exec(color)) {
                return [
                    parseInt(result[1] + result[1], 16),
                    parseInt(result[2] + result[2], 16),
                    parseInt(result[3] + result[3], 16)
                ];
            }

            // Look for rgba(0, 0, 0, 0) == transparent in Safari 3
            // eslint-disable-next-line no-cond-assign
            if (result = /rgba\(0, 0, 0, 0\)/.exec(color)) {
                return $.colorUtil.colors.transparent;
            }

            // Otherwise, we're most likely dealing with a named color
            return $.colorUtil.colors[color.trim().toLowerCase()];
        },

        /**
         * Named color map
         *
         * Based on Interface by Stefan Petre
         * <http://interface.eyecon.ro/>
         *
         * @property {Object}
         */
        colors: {
            aqua: [0, 255, 255],
            azure: [240, 255, 255],
            beige: [245, 245, 220],
            black: [0, 0, 0],
            blue: [0, 0, 255],
            brown: [165, 42, 42],
            cyan: [0, 255, 255],
            darkblue: [0, 0, 139],
            darkcyan: [0, 139, 139],
            darkgrey: [169, 169, 169],
            darkgreen: [0, 100, 0],
            darkkhaki: [189, 183, 107],
            darkmagenta: [139, 0, 139],
            darkolivegreen: [85, 107, 47],
            darkorange: [255, 140, 0],
            darkorchid: [153, 50, 204],
            darkred: [139, 0, 0],
            darksalmon: [233, 150, 122],
            darkviolet: [148, 0, 211],
            fuchsia: [255, 0, 255],
            gold: [255, 215, 0],
            green: [0, 128, 0],
            indigo: [75, 0, 130],
            khaki: [240, 230, 140],
            lightblue: [173, 216, 230],
            lightcyan: [224, 255, 255],
            lightgreen: [144, 238, 144],
            lightgrey: [211, 211, 211],
            lightpink: [255, 182, 193],
            lightyellow: [255, 255, 224],
            lime: [0, 255, 0],
            magenta: [255, 0, 255],
            maroon: [128, 0, 0],
            navy: [0, 0, 128],
            olive: [128, 128, 0],
            orange: [255, 165, 0],
            pink: [255, 192, 203],
            purple: [128, 0, 128],
            violet: [128, 0, 128],
            red: [255, 0, 0],
            silver: [192, 192, 192],
            white: [255, 255, 255],
            yellow: [255, 255, 0],
            transparent: [255, 255, 255]
        },

        /**
         * Convert an RGB color value to HSL.
         *
         * Conversion formula based on
         * <http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript>
         *
         * Adapted from <https://en.wikipedia.org/wiki/HSL_color_space>.
         *
         * Assumes `r`, `g`, and `b` are contained in the set `[0, 255]` and
         * returns `h`, `s`, and `l` in the set `[0, 1]`.
         *
         * @param {number} r The red color value
         * @param {number} g The green color value
         * @param {number} b The blue color value
         * @return {number[]} The HSL representation
         */
        rgbToHsl: function (r, g, b) {
            var d, h, s, l, min, max;

            r = r / 255;
            g = g / 255;
            b = b / 255;

            max = Math.max(r, g, b);
            min = Math.min(r, g, b);
            l = (max + min) / 2;

            if (max === min) {
                // achromatic
                h = s = 0;
            } else {
                d = max - min;
                s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
                switch (max) {
                    case r:
                        h = (g - b) / d + (g < b ? 6 : 0);
                        break;
                    case g:
                        h = (b - r) / d + 2;
                        break;
                    case b:
                        h = (r - g) / d + 4;
                        break;
                }
                h /= 6;
            }

            return [h, s, l];
        },

        /**
         * Convert an HSL color value to RGB.
         *
         * Conversion formula based on
         * <http://mjijackson.com/2008/02/rgb-to-hsl-and-rgb-to-hsv-color-model-conversion-algorithms-in-javascript>
         *
         * Adapted from <https://en.wikipedia.org/wiki/HSL_color_space>.
         *
         * Assumes `h`, `s`, and `l` are contained in the set `[0, 1]` and
         * returns `r`, `g`, and `b` in the set `[0, 255]`.
         *
         * @param {number} h The hue
         * @param {number} s The saturation
         * @param {number} l The lightness
         * @return {number[]} The RGB representation
         */
        hslToRgb: function (h, s, l) {
            var r, g, b, hue2rgb, q, p;

            if (s === 0) {
                r = g = b = l; // achromatic
            } else {
                hue2rgb = function (t) {
                    if (t < 0) {
                        t += 1;
                    }
                    if (t > 1) {
                        t -= 1;
                    }
                    if (t < 1 / 6) {
                        return p + (q - p) * 6 * t;
                    }
                    if (t < 1 / 2) {
                        return q;
                    }
                    if (t < 2 / 3) {
                        return p + (q - p) * (2 / 3 - t) * 6;
                    }
                    return p;
                };

                q = l < 0.5 ? l * (1 + s) : l + s - l * s;
                p = 2 * l - q;
                r = hue2rgb(h + 1 / 3);
                g = hue2rgb(h);
                b = hue2rgb(h - 1 / 3);
            }

            return [r * 255, g * 255, b * 255];
        },

        /**
         * Get a brighter or darker rgb() value string.
         *
         * Usage:
         *
         *     $.colorUtil.getColorBrightness( 'red', +0.1 );
         *     // > "rgb(255,50,50)"
         *     $.colorUtil.getColorBrightness( 'rgb(200,50,50)', -0.2 );
         *     // > "rgb(118,29,29)"
         *
         * @param {Mixed} currentColor Current value in css
         * @param {number} mod Wanted brightness modification between -1 and 1
         * @return {string} Like `'rgb(r,g,b)'`
         */
        getColorBrightness: function (currentColor, mod) {
            var rgbArr = $.colorUtil.getRGB(currentColor),
                hslArr = $.colorUtil.rgbToHsl(rgbArr[0], rgbArr[1], rgbArr[2]);
            rgbArr = $.colorUtil.hslToRgb(hslArr[0], hslArr[1], hslArr[2] + mod);

            return 'rgb(' +
                [parseInt(rgbArr[0], 10), parseInt(rgbArr[1], 10), parseInt(rgbArr[2], 10)].join(',') +
                ')';
        }

    };

}());
