/*global ops*/

/*jslint emptyblock: true, unparam: true*/

/**
 * Abstracts any backend that provides a session.
 * @interface
 */
SessionBackend = function SessionBackend() {"use strict"; };

/**
 * Get the memberId (a unique identifier for this client) for the current session.
 * @return {!string}
 */
SessionBackend.prototype.getMemberId = function () {"use strict"; };

/**
 * @param {!odf.OdfContainer} odfContainer TODO: needed for pullbox writing to server at end, find better solution
 * @param {!function(!Object)} errorCallback
 * @return {!ops.OperationRouter}
 */
SessionBackend.prototype.createOperationRouter = function (odfContainer, errorCallback) {"use strict"; };

/**
 * A URL to the document in it's initial state, before the playback of any operations.
 * @return {!string}
 */
SessionBackend.prototype.getGenesisUrl = function () {"use strict"; };
