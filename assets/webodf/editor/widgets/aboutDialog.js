/**
 * Copyright (C) 2014 KO GmbH <copyright@kogmbh.com>
 *
 * @licstart
 * This file is part of WebODF.
 *
 * WebODF is free software: you can redistribute it and/or modify it
 * under the terms of the GNU Affero General Public License (GNU AGPL)
 * as published by the Free Software Foundation, either version 3 of
 * the License, or (at your option) any later version.
 *
 * WebODF is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with WebODF.  If not, see <http://www.gnu.org/licenses/>.
 * @licend
 *
 * @source: http://www.webodf.org/
 * @source: https://github.com/kogmbh/WebODF/
 */

/*global define,require,webodf */

define("webodf/editor/widgets/aboutDialog", ["dijit/Dialog"], function (Dialog) {
    "use strict";

    var editorBase = dojo.config && dojo.config.paths && dojo.config.paths["webodf/editor"],
        kogmbhImageUrl = editorBase+ "/images/mdata-fusion.png";

    runtime.assert(editorBase, "webodf/editor path not defined in dojoConfig");

    return function AboutDialog(callback) {
        var self = this;

        this.onToolDone = function () {};

        function init() {
            // TODO: translation, once the the about text has been decided about
            var tr = runtime.tr,
                dialog;

            // Dialog
            dialog = new Dialog({
                style: "width: 400px",
                title: "mData Fusion Text Editor",
                autofocus: false,
                content: "<p>The mData Fusion Text Editor is an easy to use Javascript-based plugin for webpages. " +
                            "It provides a stand-alone editor for text documents in the OpenDocument Format.</p>" +
                                                        "<p>Version " + webodf.Version + "</p>" 
                  
            });
            dialog.onHide = function() { self.onToolDone(); };

            callback(dialog);
        }

        init();
    };

});
