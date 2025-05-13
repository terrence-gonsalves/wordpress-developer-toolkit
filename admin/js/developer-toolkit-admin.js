(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	$(document).ready(function() {
		$(".nav-tab").on("click", function() {
			//$(".nav-tab").removeClass("nav-tab-active");
			console.log('this is the ID value: ' + $(this).attr("id"));

			if ($(this).attr("id") == "tab_1") {
				$("#what_new").show();
				$("#changelog").hide();
				$("#tab_1").toggleClass("nav-tab-active");
			}

			if ($(this).attr("id") == "tab_2") {
				$("#what_new").hide();
				$("#changelog").show();
				$("#tab_2").toggleClass("nav-tab-active");
			}
		});
	}); 
})( jQuery );
