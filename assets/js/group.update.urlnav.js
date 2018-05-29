(function($) {
	$(document).ready(function(){
		/* Header */
		// Links admin & moderator
		$('div#item-actions a').each( function(){
			$(this).attr('target', '_blank');
		})
		/* /END Header */

		/* Page Accueil */
		// RSS
		$('li.feed a').each( function(){
			$(this).attr('target', '_blank');
		})
		// Links members
		$('ul#activity-stream a').each( function(){
			var url = $(this).attr('href');
			if( url.indexOf("groupes") == -1 ) {
				$(this).attr('target', '_blank');
			}
		})
		/* /END Accueil */

		/* Page Documents */
		$('ul#bp-group-documents-list a').each( function(){
			var url = $(this).attr('href');
			if( url.indexOf("members") != -1 ) {
				$(this).attr('target', '_blank');
			}
		})
		/* /END Documents */

		/* Page Members */
		$('div.item-cover a').each( function(){
			$(this).attr('target', '_blank');
		})
		$('div.item-title a').each( function(){
			$(this).attr('target', '_blank');
		})
		
		/* /END Members */

		// Page Gestion du groupe => Membres
		$('div.bp-widget h5 > a:first-child').each( function(){
			$(this).attr('target', '_blank');
		})

	});
})(jQuery);