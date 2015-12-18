/*global Node, define, runtime */

define("webodf/editor/extras/SessionListView", [], function () {
    "use strict";

    return function SessionListView(sessionList, sessionListDiv, cb) {
        var self = this,
            memberDataChangedHandler;

        function createSessionDescription(sessionDetails) {
            return " ("+sessionDetails.cursors.length+" members) ";
        }

        /**
         */
        function createSessionViewItem(sessionDetails) {
            runtime.assert(sessionListDiv, "sessionListDiv unavailable");
            var doc = sessionListDiv.ownerDocument,
                htmlns = doc.documentElement.namespaceURI,
                sessionDiv = doc.createElementNS(htmlns, "div"),
                sessionDescriptionDiv = doc.createElementNS(htmlns, "span"),
                sessionDownloadDiv;

            sessionDiv.sessionId = sessionDetails.id; // TODO: namespace?
            sessionDiv.appendChild(sessionDescriptionDiv);
            sessionDiv.appendChild(doc.createTextNode(createSessionDescription(sessionDetails)));

            sessionDescriptionDiv.appendChild(doc.createTextNode(sessionDetails.title));
            sessionDescriptionDiv.style.cursor = "pointer"; // TODO: do not set on each element, use CSS
            sessionDescriptionDiv.style.fontWeight = "bold";
            sessionDescriptionDiv.onclick = function () {
                cb(sessionDetails.id);
            };

            if (sessionDetails.fileUrl) {
                sessionDownloadDiv = doc.createElementNS(htmlns, "a");
                sessionDownloadDiv.appendChild(doc.createTextNode("Download"));
                sessionDownloadDiv.setAttribute("href", sessionDetails.fileUrl);
                sessionDiv.appendChild(sessionDownloadDiv);
            }

            sessionListDiv.appendChild(sessionDiv);
        }

        function updateSessionViewItem(sessionDetails) {
            var node = sessionListDiv.firstChild;
            while (node) {
                if (node.sessionId === sessionDetails.id) {
                    node.firstChild.nextSibling.data = createSessionDescription(sessionDetails);
                    return;
                }
                node = node.nextSibling;
            }
        }

        /**
         * @param {!string} sessionId
         */
        function removeSessionViewItem(sessionId) {
            var node = sessionListDiv.firstChild;
            while (node) {
                if (node.sessionId === sessionId) {
                    sessionListDiv.removeChild(node);
                    return;
                }
                node = node.nextSibling;
            }
        }

        function init() {
            var idx,
                subscriber = {onCreated: createSessionViewItem, onUpdated: updateSessionViewItem, onRemoved: removeSessionViewItem},
                sessions = sessionList.getSessions(subscriber);

            // fill session list
            for (idx = 0; idx < sessions.length; idx += 1) {
                createSessionViewItem(sessions[idx]);
            }
        }

        init();
    };
});
