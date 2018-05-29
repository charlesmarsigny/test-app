<?php
if( $_GET['framegroup'] && $_GET['framegroup'] != 'integrated' ) :
	// Slaask gathering more info about user 
	$current_user = wp_get_current_user();
	$user_info = get_userdata( $current_user->ID );
	$widget_key = '878c38f38c067603a4aea749c27c463f';

	// Make role readable
	if ( $user_info->roles[0] == 'app_user' ) {
			$user_role = 'Utilisateur';
	} elseif ( $user_info->roles[0] == 'app_premium_user' ) {
			$user_role = 'Utilisateur premium';
	} elseif ( $user_info->roles[0] == 'app_investor' ) {
			$user_role = 'Investisseur';
	} elseif ( $user_info->roles[0] == 'app_premium_investor' ) {
			$user_role = 'Investisseur premium';
	} elseif ( $user_info->roles[0] == 'webmaster' ) {
			$user_role = 'Webmaster';
	} elseif ( $user_info->roles[0] == 'administrator' ) {
			$user_role = 'Administrateur';
	} else {
			$user_role = $user_info->roles[0];
	}

	?>

	<?php if (isset($current_user)): ?>
		<script>
			_slaask.identify('<?php echo $user_info->display_name . ' [' . $user_role . '] -' . $user_info->user_login ?>', {
				user_id: <?php echo $user_info->ID ?>,
				email: '<?php echo $user_info->user_email ?>',
				speciality: '<?php echo $user_role ?>'
			});

			_slaask.init('<?php echo $widget_key ?>', { visitor_token: '<?php echo $user_info->ID ?>' });
		</script>
	<?php else: ?>
		<script>
			_slaask.init('<?php echo $widget_key ?>');
		</script>
	<?php endif; ?>
	<!-- /Slaask gathering more info about user -->

	<!-- Headway changelog widget -->
	<script>
		var HW_config = {
			selector: ".changelog-widget", // CSS selector where to inject the badge
			account: "Jr8l0x" // our account ID
		};
	</script>
	<script async src="//cdn.headwayapp.co/widget.js"></script>
	<div class="hidden">
	trrruc
	</div>
	<!-- /Headway changelog widget -->
	
	<script>if (!window.customElements) { document.write('<!--'); }</script>
	<script src="https://cdn.noticeable.io/v1/libs/webcomponentsjs/custom-elements-es5-adapter.js"></script>
	<!--! do not remove this comment -->
	<script src="https://cdn.noticeable.io/v1/libs/webcomponentsjs/webcomponents-loader.js"></script>
	<link rel="import" href="https://cdn.noticeable.io/v1/libs/noticeable-widget/noticeable-widget.html">
	                    
<?php endif ?>