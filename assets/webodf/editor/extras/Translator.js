/*global define, runtime, XMLHTTPRequest */

define("webodf/editor/extras/Translator", [], function () {
    "use strict";

    return function Translator(translationsPath, locale, callback) {
        var self = this,
            dictionary = {};

        function translate(key) {
            return dictionary[key];
        }
        function setLocale(newLocale, cb) {
            // TODO: Add smarter locale resolution at some point
            if (newLocale.split('-')[0] === "de" || newLocale.split('_')[0] === "de") {
                newLocale = "de-DE";
            } else if (newLocale.split('-')[0] === "nl" || newLocale.split('_')[0] === "nl") {
                newLocale = "nl-NL";
            } else if (newLocale.split('-')[0] === "it" || newLocale.split('_')[0] === "it") {
                newLocale = "it-IT";
            } else if (newLocale.split('-')[0] === "eu" || newLocale.split('_')[0] === "eu") {
                newLocale = "eu";
            } else if (newLocale.split('-')[0] === "en" || newLocale.split('_')[0] === "en") {
                newLocale = "en-US";
            } else {
                newLocale = "en-US";
            }

            var xhr = new XMLHttpRequest(),
                path = translationsPath + '/' + newLocale + ".json";
            xhr.open("GET", path);
            xhr.onload = function () {
                if (xhr.status === 200) {// HTTP OK
                    dictionary = JSON.parse(xhr.response);
                    locale = newLocale;
                }
                cb();
            };
            xhr.send(null);
        }
        function getLocale() {
            return locale;
        }

        this.translate = translate;
        this.getLocale = getLocale;

        function init() {
            setLocale(locale, function () {
                callback(self);
            });
        }
        init();
    };
});
