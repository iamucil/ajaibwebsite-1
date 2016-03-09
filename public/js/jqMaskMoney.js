/**
 * Format Number input Form
 * @param  {[type]} ) {}          [description]
 * @return {[type]}   [description]
 */
$(function($, document, window) {
    // Plugin definition.
    $.fn.hilight = function( options ) {
        debug( this );
    };

    // Private function for debugging.
    function debug( obj ) {
        if ( window.console && window.console.log ) {
            window.console.log( obj );
        }
    };

}(jQuery, document, window));