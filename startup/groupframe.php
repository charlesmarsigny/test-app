<?php
/**
 * Template Name: iframe Group
 *
 * Description: Page template for sub group page of sub startup page
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Guillaume Dubois <guillaume.dubois@welikestartup.com>
 * @since AppLike 1.0
 */
?>

<?php if (!is_user_logged_in()) : // IF no logged ?>

	<div class="message-warning">

    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n'avez pas accès aux groupes.</p>
		<p class="important">Vous devez être connecté.</p>
		<div class="show-login">
	        <a class="button-connexion" href="" onclick="KLEO.main.ajaxLogin()">
	            <i class="icon-lock"></i>
	            <?php esc_html_e( "Login", 'buddyapp' ); ?>
	        </a>
	    </div>
	    
	</div>
<?php elseif ($_GET['id']) :

	$group_id = htmlspecialchars(addslashes($_GET['id']));

	$args = array(
		'include' => $group_id
	);

	if ( bp_has_groups( $args) ) : ?>
		<?php while ( bp_groups() ) : bp_the_group(); ?>

			<?php
			// $group_type = bp_groups_get_group_type($group_id);
			echo '<div class="hidden trrruc" style="display:none;">';
			var_dump($_GET);
			echo'</div>';
			?>
			
			<script>
				function getDocHeight(doc) {
				    doc = doc || document;
				    var body = doc.body, html = doc.documentElement;
				    var height = Math.max( body.scrollHeight, body.offsetHeight, 
				        html.clientHeight, html.scrollHeight, html.offsetHeight );
				    return height;
				}

				function setIframeHeight(id) {
				    var ifrm = document.getElementById(id);
				    var doc = ifrm.contentDocument? ifrm.contentDocument: 
				        ifrm.contentWindow.document;
				    ifrm.style.visibility = 'hidden';
				    ifrm.style.height = "10px"; // reset to minimal height ...
				    // IE opt. for bing/msn needs a bit added or scrollbar appears
				    ifrm.style.height = getDocHeight( doc ) + 4 + "px";
				    ifrm.style.visibility = 'visible';
				}
				// Soucis corrigé : Plusieurs ID ifrm pour adapter la hauteur de chaque iframe
				var el = document.getElementById("ifrm<?php echo $group_id; ?>");
				el.addEventListener("load", function(event) {
					setIframeHeight("ifrm<?php echo $group_id; ?>");
				});

				// var els = document.getElementsByClassName("load-more");
				// els.forEach(function(element) {
				// 	element.addEventListener("click", function(event) {
				// 		setIframeHeight("ifrm");
				// 	});
				// });

				// els[0].addEventListener("click", function(event) {
				// setIframeHeight("ifrm");
				// });		
			</script>
			
			<?php

			// GET Parameter from single-startup.php that come from group_redirect function in functions.php
			$url_request = '';
			if ( $_GET['request-group'] && $_GET['request-group'] == 'documents' ) {
				$url_request = 'documents';
			} elseif ( $_GET['request-group'] && $_GET['request-group'] == 'membership-requests' ) {
				$url_request = 'admin/membership-requests';
			} elseif ( $_GET['request-group'] && strstr($_GET['request-group'], 'activity-' ) ) {
				$url_request = '?request-group=' . htmlspecialchars($_GET['request-group']);
			} elseif ( $_GET['request-group'] && strstr($_GET['request-group'], 'acomment-' ) ) {
				$url_request = '?request-group=' . htmlspecialchars($_GET['request-group']);
			}

			?>


			<iframe id="ifrm<?php echo $group_id; ?>" src="<?php echo bp_get_group_permalink() . $url_request; ?>" allowfullscreen scrolling="auto" frameborder="no" class="group-iframe" >
				<p>Votre navigateur ne supporte pas les iframes.</p>
			</iframe>

			<script>
				// document.addEventListener("load", function(event) {
				// 	document.getElementById("ifrm27284").contentWindow.location.hash = "#activity-42855";
				// });

				// (function($) {
				// 	$(document).ready(function (event) {
				// 	    $("#ifrm27284").attr('src','https://app.welikestartup.io/groupes/test-support-technique/#activity-42855');

				// 	    // var yOffset = $("#activity-42855").offset().top;
				// 	    // $("body").scrollTop(yOffset);

				// 		// $('html, body').animate({
				// 		//     scrollTop: $("#activity-42855").offset().top
				// 		// }, 2000);
				// 	});
				// })(jQuery);
				// document.addEventListener("load", function(event) {
				// 	setInterval(function() {
				// 		document.getElementById('ifrm27284').contentWindow.reload();
				// 	}, 1000);
				// });
				// (function($) {
				//     $(document).ready(function (event) {
				//         $("<?= $url_request; ?>").css("background-color", "#FCF3CF");
				//     });
				// })(jQuery);
			</script>
		<?php endwhile; ?>

	<?php else: ?> 
	<?php endif; ?>

<?php endif; ?>

