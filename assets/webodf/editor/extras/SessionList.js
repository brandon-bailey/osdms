/*global ops, runtime */

/**
 * A model which provides information about sessions.
 * @interface
 */
function SessionList() {"use strict"; };

/**
 * @param {{onCreated:function(!Object),
 *          onUpdated:function(!Object),
 *          onRemoved:function(!string) }} subscriber
 * @return {undefined}
 */
SessionList.prototype.getSessions = function (subscriber) {"use strict"; };

/**
 * @param {{onCreated:function(!Object),
 *          onUpdated:function(!Object),
 *          onRemoved:function(!string) }} subscriber
 * @return {undefined}
 */
SessionList.prototype.unsubscribe = function (subscriber) {"use strict"; };

/**
 * Per default updates are enabled.
 * @param {!boolean} enabled
 * @return {undefined}
 */
SessionList.prototype.setUpdatesEnabled = function (enabled) {"use strict"; };
