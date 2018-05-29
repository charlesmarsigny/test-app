/*
 * jQuery StartupTabs
 *
 * Copyright (c) 2016-2017 Charles Marsigny
 *
 * Dual licensed under the MIT and GPL licenses:
 *   http://www.opensource.org/licenses/mit-license.php
 *   http://www.gnu.org/licenses/gpl.html
 */

( function($) {

	$( "#object-nav a" ).click(function() {
		alert($(this).attr('href'));
	});

})(jQuery);