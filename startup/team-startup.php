<?php
/**
 * Template Name: Team startup
 *
 * Description: Page template for sub startup page
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */


// Variables
if( isset($_GET['id']) ) {
	$startup_id = $_GET['id'];
}
$investor_roles = array('app_investor', 'app_premium_investor');
$user_roles = array('app_user', 'app_premium_user');
$members_count = 0;
$team_members = array();



// Get function
if ( isset( $startup_id ) ) :

	// The parameters
	$permission_args = array(
		'post_type' 		=> 'startup',
		'p'					=> $startup_id,
		'nopaging' 			=> true
	);

	// The Query
	$permission_query = new WP_Query($permission_args);

	// The Loop
	if($permission_query->have_posts()) :
		while ( $permission_query->have_posts() ) : $permission_query->the_post();
			
			$totalaccess = get_field('totalaccess_paricipant');
            $projectacces = get_field('projectaccess_paricipant');
            $owner = get_field('owner_startup');
            if( have_rows('members_team') ):
            	while( have_rows('members_team') ): the_row(); 
            		$user_fields = get_sub_field('subscriber_section_team');
            		$team_members[$members_count] = $user_fields['ID'];
            		$members_count++;
            	endwhile;
            endif;

		endwhile;
	endif;

endif;

if (!is_user_logged_in()) : // IF no logged ?>

	<div class="message-warning">

    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n'avez pas accès à la fiche équipe.</p>
		<p class="important">Vous devez être connecté en tant qu'investisseur.</p>
		<div class="show-login">
	        <a class="button-connexion" href="" onclick="KLEO.main.ajaxLogin()">
	            <i class="icon-lock"></i>
	            <?php esc_html_e( "Login", 'buddyapp' ); ?>
	        </a>
	    </div>
	    
	</div>

<?php // ELSEIF user or user premium logged
elseif ( array_intersect($user_roles, $current_user->roles)
		&& ( empty($totalaccess) 
			|| (!empty($totalaccess) && (in_multi_array($current_user->ID, $totalaccess) == false)) 
			|| (!empty($projectacces) && (in_multi_array($current_user->ID, $projectacces) == false)) )
	 	&& ( empty($owner) 
	 		|| ($owner && (in_multi_array($current_user->ID, $owner) == false)) ) 
	 	&& ( empty($team_members) 
	 		|| ($team_members && (in_multi_array($current_user->ID, $team_members) == false)) )
	 	) : ?>
	
	<div class="message-warning">
		
    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n'avez pas accès à la fiche équipe en tant qu'utilisateur.</p>
		<p class="important">Devenez investisseur et accédez à plus de contenu en nous contactant directement via le livechat.</p>
		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">
			<input type="hidden" name="chat-equipe" value="active">
			<input type="submit" value="Je souhaite accéder à la fiche équipe">
		</form>
			    
	</div>

<?php // ELSEIF investor logged
elseif ( ( empty($totalaccess) || ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) || ($projectacces && (in_multi_array($current_user->ID, $projectacces) == false)) ) && $current_user->roles[0] == 'app_investor' ) : ?>
	
	<div class="message-warning">

    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n'avez pas accès à la fiche équipe.</p>
		<p class="important">Vous pouvez nous en faire la demande via le livechat.</p>
		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">
			<input type="hidden" name="chat-equipe" value="active">
			<input type="submit" value="Je souhaite accéder à la fiche équipe">
		</form>
	    
	</div>

<?php else : // ELSE user logged & participant OR premium investor

	// Get function
	if ( isset($_GET['id']) ) :

		// The get variables
		$post_type = 'startup';
		$startup_id = $_GET['id'];

		// The parameters
		$args = array(
			'p' => $startup_id, // id of a page, post, or custom type
			'post_type' => $post_type,
		);

		// The Query
		$ajax_query = new WP_Query($args);

		// The Loop
		if($ajax_query->have_posts()) :
			while ( $ajax_query->have_posts() ) : $ajax_query->the_post(); ?>
				
					<!-- Print button -->
					<div class="print-card-div"><a href="/actions/modal-print-team/?startupid=<?php echo $startup_id; ?>" class="project-modal print-card-button" title="Impression">Impression</a></div>

				<?php if( have_rows('members_team') ): ?>

					<div class="team-members">


					<?php 
					// id generation for member biography
					$bio_id = 0;
					$bio_height_standard = '105px';
					?>
					<?php while( have_rows('members_team') ): the_row(); 

						$function = get_sub_field('function_section_team');
						$bio_id_used = '-member'.$bio_id;

						// IF not a user registered
						if (get_sub_field('usercheck_section_team')) :

							// vars
							$photo = get_sub_field('photo_section_team');
							$name = get_sub_field('nosubscriber_section_team');
							$bio = get_sub_field('bio_section_team');
							$bio_height = '';
							$bio_padding = 'padding-bottom: 20px;';
							if ( $bio && ( (strlen($bio) > 256) || ( wp_is_mobile() && (strlen($bio) > 50) ) ) ) {
								$bio_height = 'height: '.$bio_height_standard.';';
								$bio_padding = 'padding-bottom: 50px;';
							}

							$mail = get_sub_field('mail_section_team');
							$phone = get_sub_field('phone_section_team');
							$phone_call = $phone;							
							if ( $phone && preg_match("#^(0|\+33[0]?|00[-. ]?33[0]?)[-. ]?[1-9]([-. ]?[0-9]{2}){4}$#", $phone) ) {
								$phone_call = preg_replace( "#^(?:0|\+33[0]?|00[-. ]?33[0]?)[-. ]?([1-9])[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$#", "+33$1$2$3$4$5", $phone );	// +33652123245
								$phone = preg_replace( "#^(?:0|\+33[0]?|00[-. ]?33[0]?)[-. ]?([1-9])[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$#", "0$1 $2 $3 $4 $5", $phone );	// 06 52 12 32 45
							}
							
							$facebook = get_sub_field('facebook_section_team');
							$twitter = get_sub_field('twitter_section_team');
							$linkedin = get_sub_field('linkedin_section_team');
							$google = get_sub_field('google_section_team');

							
							?>
							<div class="member-content">
								
								<?php
								if ($photo) {
								    $size = 'medium'; // (thumbnail, medium, large, full or custom size)
								    // echo '<img width="150" height="150" src="' . wp_get_attachment_url( $photo, $size ) . '" class="photo-member">';
								   	echo '<div style="background-image:url(' . wp_get_attachment_url( $photo, $size ) . ')" class="photo-member-background"></div>';
								} elseif ($mail) {
									$url_photo = get_avatar_url( $mail, array('size'=>150) );		
									if ( wp_is_mobile() ) {
										$url_photo = get_avatar_url( $mail, array('size'=>300) );
									}
								    // echo '<img width="150" height="150" src=" ' . $url_photo . ' " class="photo-member">';
								    echo '<div style="background-image:url(' . $url_photo . ')" class="photo-member-background"></div>';
								} ?>

								<div class="member-infos">
									
									<div class="name">
										<?php echo $name; ?>
									</div>
									<div class="function"><?php echo $function; ?></div>
									<div class="social-networks">
										<?php if ($facebook) : ?>
											<div class="social facebook"><a href="<?= $facebook ?>" title="Partager sur Facebook" target="_blank"><i class="icon-facebook2"></i></a></div>
										<?php endif;
										if ($twitter) : ?>
											<div class="social twitter"><a href="<?= $twitter ?>" title="Partager sur Twitter" target="_blank"><i class="icon-twitter2"></i></a></div>
										<?php endif;
										if ($linkedin) : ?>
											<div class="social linkedin"><a href="<?= $linkedin ?>" title="Partager sur Linkedin" target="_blank"><i class="icon-linkedin2"></i></a></div>
										<?php endif;
										if ($google) : ?>
											<div class="social google"><a href="<?= $google ?>" title="Partager sur Google+" target="_blank"><i class="icon-googleplus2"></i></a></div>
										<?php endif; ?>
									</div>
									<div class="contacts">
										<?php if ($mail) : ?>
											<a class="button-contact" href="mailto:<?php echo $mail; ?>" title="Envoyer un email à <?php echo $mail; ?>"><i class="fa fa-envelope" aria-hidden="true"></i><?php echo $mail; ?></a>
										<?php endif; ?>
										<?php if ($phone) : ?>
											<a class="button-contact" href="tel:<?php echo $phone_call; ?>" title="Téléphoner au <?php echo $phone; ?>"><i class="icon-phone"></i><?php echo $phone; ?></a>
										<?php endif; ?>
									</div>
								</div>
								<?php if ($bio) : ?>
										
								<div class="bio-member">
									<div id="bio<?= $bio_id_used ?>" class="bio-content" style="<?= $bio_height.' '.$bio_padding; ?>">
										<h3>Biographie</h3>
										<p><?php echo $bio; ?></p>
									</div>
									<?php if ( $bio_height == ('height: '.$bio_height_standard.';') ) : ?>

									<div id="degrade<?= $bio_id_used ?>" class="bio-degrade"></div>
									<span id="show<?= $bio_id_used ?>" class="bio-button bio-show">Lire la suite<i class="fa fa-caret-down" aria-hidden="true"></i></span>
									<span id="hide<?= $bio_id_used ?>" class="bio-button" style="display:none;">Masquer la biographie<i class="fa fa-caret-up" aria-hidden="true"></i></span>

									<?php endif; ?>
								</div>

								<?php endif; ?>
							</div>
							

						<?php  // IF registered user
						elseif ( !get_sub_field('usercheck_section_team') ) :
							
							// $test = bp_get_displayed_user_avatar( array('item_id'=>$user_id, 'type'=>'full' ) );
							// echo bp_get_displayed_user_avatar( array('item_id'=>$user_id, 'type'=>'medium' ) );
							// echo bp_get_displayed_user_avatar( array('item_id'=>$user_id, 'type'=>'full' ) );

							// echo "<div class='member-infos'><pre>";
							// echo "test";
							// var_dump( $test );
							// echo "</pre></div>";

							// echo "Pseudonyme : ";
							// echo bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Name' ) );
							
							// vars
							$user_fields = get_sub_field('subscriber_section_team');
							$user_id = $user_fields['ID'];
							$user_type = bp_get_member_type($user_id);
							$photo = explode( '"', bp_get_displayed_user_avatar( array('item_id'=>$user_id, 'type'=>'full' ) ) );
							$photo = $photo[1];
							$name = bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Name' ) );
							$bio = '';
							$bio = get_sub_field('bio_section_team');
							if ( !empty($bio) ) {
								$bio = '<h3>Biographie</h3><p>'. $bio .'</p>';
							}
							$experiences = bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Expériences' ) );
							if ( $experiences ) {
								$bio .= '<h3>Expériences</h3><p>'. $experiences .'</p>';
							}
							$formations = bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Formations' ) );
							if ( $formations ) {
								$bio .= '<h3>Formations</h3><p>'. $formations .'</p>';
							}
							$bio_height = '';
							$bio_padding = 'padding-bottom: 20px;';
							if ( $bio && ( (strlen($bio) > 256) || ( wp_is_mobile() && (strlen($bio) > 50) ) ) ) {
								$bio_height = 'height: '.$bio_height_standard.';';
								$bio_padding = 'padding-bottom: 50px;';
							}

							$mail = $user_fields['user_email'];
							$phone = bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Téléphone' ) );
							$phone_call = $phone;
							if ( $phone && preg_match("#^(0|\+33[0]?|00[-. ]?33[0]?)[-. ]?[1-9]([-. ]?[0-9]{2}){4}$#", $phone) ) {
								$phone_call = preg_replace( "#^(?:0|\+33[0]?|00[-. ]?33[0]?)[-. ]?([1-9])[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$#", "+33$1$2$3$4$5", $phone );	// +33652123245
								$phone = preg_replace( "#^(?:0|\+33[0]?|00[-. ]?33[0]?)[-. ]?([1-9])[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$#", "0$1 $2 $3 $4 $5", $phone );	// 06 52 12 32 45
							}

							$facebook = explode( '"', bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Profil Facebook' ) ) );
							$facebook = $facebook[1];
							$twitter = explode( '"', bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Profil Twitter' ) ) );
							$twitter = $twitter[1];
							$linkedin = explode( '"', bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Profil Linkedin' ) ) );
							$linkedin = $linkedin[1];
							$google = explode( '"', bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Profil Google+' ) ) );
							$google = $google[1];
							?>

							<div class="member-content">
								
								<?php
								if ($photo) {
								    // echo '<img width="150" height="150" src="' . $photo . '" class="photo-member">';
								    echo '<div style="background-image:url(' . $photo . ')" class="photo-member-background"></div>';
								} 
								// else {
								//     $url = content_url( '/themes/kleo-child/img/' );
								//     $fakelogo = "no-logo.png";
								//     echo '<img width="150" height="150" src=" ' . $url . $fakelogo . ' " class="fake-logo">';
								// } 
								?>

								<div class="member-infos">
									
									<div class="name">
										<a class="link-profil" href="<?= bp_core_get_user_domain($user_id); ?>"><span class="name-span"><?php echo $name; ?></span><span class="label-profil">Profil utilisateur</span></a>
									</div>
									<div class="function"><?php echo $function; ?></div>
									<div class="social-networks">
										<?php if ($facebook) : ?>
											<div class="social facebook"><a href="<?= $facebook ?>" title="Partager sur Facebook" target="_blank"><i class="icon-facebook2"></i></a></div>
										<?php endif;
										if ($twitter) : ?>
											<div class="social twitter"><a href="<?= $twitter ?>" title="Partager sur Twitter" target="_blank"><i class="icon-twitter2"></i></a></div>
										<?php endif;
										if ($linkedin) : ?>
											<div class="social linkedin"><a href="<?= $linkedin ?>" title="Partager sur Linkedin" target="_blank"><i class="icon-linkedin2"></i></a></div>
										<?php endif;
										if ($google) : ?>
											<div class="social google"><a href="<?= $google ?>" title="Partager sur Google+" target="_blank"><i class="icon-googleplus2"></i></a></div>
										<?php endif; ?>
									</div>
									<div class="contacts">
										<?php if ($mail) : ?>
											<a class="button-contact" href="mailto:<?php echo $mail; ?>" title="Envoyer un email à <?php echo $mail; ?>"><i class="fa fa-envelope" aria-hidden="true"></i><?php echo $mail; ?></a>
										<?php endif; ?>
										<?php if ($phone) : ?>
											<a class="button-contact" href="tel:<?php echo $phone_call; ?>" title="Téléphoner au <?php echo $phone; ?>"><i class="icon-phone"></i><?php echo $phone; ?></a>
										<?php endif; ?>
									</div>
								</div>
								<?php if ( !empty($bio) ) : ?>

								<div class="bio-member">
									<div id="bio<?= $bio_id_used ?>" class="bio-content" style="<?= $bio_height.' '.$bio_padding; ?>">
										<?php echo $bio; ?>
									</div>
									<?php if ( $bio_height == ('height: '.$bio_height_standard.';') ) : ?>

									<div id="degrade<?= $bio_id_used ?>" class="bio-degrade"></div>
									<span id="show<?= $bio_id_used ?>" class="bio-button bio-show">Lire la suite<i class="fa fa-caret-down" aria-hidden="true"></i></span>
									<span id="hide<?= $bio_id_used ?>" class="bio-button" style="display:none;">Masquer la biographie<i class="fa fa-caret-up" aria-hidden="true"></i></span>

									<?php endif; ?>
								</div>

								<?php else : ?>

								<div class="bio-content"></div>

								<?php endif; ?>
								<?php if ( bp_is_active( 'friends' ) && bp_is_active( 'messages' ) ) : ?>

								<div class="bottom-button">
									<ul>
										<li><a href="<?= wp_nonce_url( bp_loggedin_user_domain() . bp_get_friends_slug() . '/add-friend/' . $user_id . '/', 'friends_add_friend' ) ?>">Ajouter aux contacts</a></li><li><a class="message" href="<?= wp_nonce_url( bp_loggedin_user_domain() . bp_get_messages_slug() . '/compose/?r=' . bp_core_get_username( $user_id ) ) ?>">Message privé</a></li>
									</ul>
								</div>

								<?php endif; ?>
							</div>


						<?php endif; // ENDIF user of startup ?>

						<script>
						(function($) {
						    $("#hide<?= $bio_id_used ?>").click(function(){
						        $(this).hide();
						        $("#show<?= $bio_id_used ?>").show();
						        $("#bio<?= $bio_id_used ?>").animate({
						        height: "<?= $bio_height_standard; ?>"
						        }, "slow");
						        $("#degrade<?= $bio_id_used ?>").animate({
						        opacity: '1'
						        }, "slow");
						    });
						    $("#show<?= $bio_id_used ?>").click(function(){
						        $("#hide<?= $bio_id_used ?>").show();
						        $(this).hide();
						        $("#bio<?= $bio_id_used ?>").animate({
						        height: $("#bio<?= $bio_id_used ?>")[0].scrollHeight
						        }, "slow");
						        $("#degrade<?= $bio_id_used ?>").animate({
						        opacity: '0'
						        }, "slow");    
						    });

						    // Open modal in AJAX callback
						    $('.project-modal').click(function(event) {
						    	event.preventDefault();
						    	$.get(this.href, function(html) {
						     		$(html).appendTo('body').modal({
						          		fadeDuration: 200
						        	});
						      	});
						    });
						})(jQuery);
						</script>

						<?php 
						// Increment of id generation for member biography
						$bio_id++; 
						?>

					<?php endwhile; ?>

					</div>

				<?php endif; ?>

				<!-- item -->

			<?php endwhile; ?>
		<?php endif; ?>

		<?php else: ?>
		<div class="item-content"><p>Aucun post sélectionné</p></div>

	<?php endif; ?>

<?php endif; ?>