<?php

/**

 * Template Name: Print Simplified Startup

 *

 * Description: Page template for simplified startup printing

 *

 *

 * @package WordPress

 * @subpackage BuddyApp

 * @author Guillaume Dubois <guillaume.dubois@welikestartup.fr>

 * @since AppLike 1.0

 */





// The variables

$current_user = wp_get_current_user();





/* remove sidemenu */

remove_action( 'kleo_after_body', 'kleo_show_side_menu' );



/* remove header */

remove_action( 'kleo_header', 'kleo_show_header', 12 );



get_header();



?>

<style>

	/* Remove the preloader */

	.css3-spinner {

		display: none;

	}

</style>

<div id="content" class="tpl-full-width startup">

<div id="print-startup">

    <div id="main-container" class="clearfix">



        <div class="main" role="main">

            <div class="content-wrap">

        



<div class="main-content <?php echo Kleo::get_config('container_class'); ?>">



<?php

// $_POST['startup_id'] = 14822;

// Variables

if( isset($_POST['startup_id']) ) {

	$startup_id = $_POST['startup_id'];

}

$investor_roles = array('app_investor', 'app_premium_investor');

$user_roles = array('app_user', 'app_premium_user');





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



		endwhile;

	endif;



endif;



if (!is_user_logged_in()) : // IF no logged ?>



	<div class="message-warning">

		

    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>

		<h3> Accès restreint</h3>

		<p>Vous n'avez pas accès au projet.</p>

		<p class="important">Vous devez être connecté en tant qu'investisseur.</p>

		<div class="show-login">

	        <a class="button-connexion" href="" onclick="KLEO.main.ajaxLogin()">

	            <i class="icon-lock"></i>

	            <?php esc_html_e( "Login", 'buddyapp' ); ?>

	        </a>

	    </div>

	    

	</div>



<?php // ELSEIF user or user premium logged

elseif ( ( ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) || ($projectacces && (in_multi_array($current_user->ID, $projectacces) == false)) ) && array_intersect($user_roles, $current_user->roles) ) : ?>

	

	<div class="message-warning">

		

    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>

		<h3> Accès restreint</h3>

		<p>Vous n'avez pas accès au projet en tant qu'utilisateur.</p>

		<p class="important">Devenez investisseur et accédez à plus de contenu en nous contactant directement via le livechat.</p>

		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">

			<input type="hidden" name="chat-projet" value="active">

			<input type="submit" value="Je souhaite devenir investisseur">

		</form>

			    

	</div>



<?php // ELSEIF investor logged

elseif ( ( ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) || ($projectacces && (in_multi_array($current_user->ID, $projectacces) == false)) ) && $current_user->roles[0] == 'app_investor' ) : ?>

	<div class="message-warning">



    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>

		<h3> Accès restreint</h3>

		<p>Vous n'avez pas accès à la fiche projet.</p>

		<p class="important">Vous pouvez nous en faire la demande via le livechat.</p>

		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">

			<input type="hidden" name="chat-projet" value="active">

			<input type="submit" value="Je souhaite accéder à la fiche projet">

		</form>

	    

	</div>



<?php else : // ELSE user logged & participant OR premium investor



	// Get function

	if ( isset($startup_id) ) :



		// The get variables

		$post_type = 'startup';



		// The parameters

		$args = array(

			'p' => $startup_id, // id of a page, post, or custom type

			'post_type' => $post_type,

		);



		// The Query

		$ajax_query = new WP_Query($args);



		// The Loop

		if($ajax_query->have_posts()) :

			while ( $ajax_query->have_posts() ) : $ajax_query->the_post();



				/* Recovery of main contact info */



				/* The variables */

				$member_id = 0;	// ID of the first team member

				$member_registered= '';

				$member_name = '';

				$member_function = '';

				$member_phone = '';

				$member_mail = '';

				$member_photo = '';

				$member_registered_photo = '';



				if( have_rows('members_team') ) {

					while( have_rows('members_team') ): the_row();



						// IF registered user

						if ( (!get_sub_field('usercheck_section_team')) && ($member_id == 0) ){

							$member_function = get_sub_field('function_section_team');

							$user_fields = get_sub_field('subscriber_section_team');

							$user_id = $user_fields['ID'];

							$member_name = bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Name' ) );

							$member_mail = $user_fields['user_email'];

							$member_phone = bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Téléphone' ) );

							if ( $member_phone && preg_match("#^(0|\+33[0]?|00[-. ]?33[0]?)[-. ]?[1-9]([-. ]?[0-9]{2}){4}$#", $member_phone) ) {

								$member_phone = preg_replace( "#^(?:0|\+33[0]?|00[-. ]?33[0]?)[-. ]?([1-9])[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$#", "0$1 $2 $3 $4 $5", $member_phone );	// 06 52 12 32 45

							}

							$member_registered_photo = explode( '"', bp_get_displayed_user_avatar( array('item_id'=>$user_id, 'type'=>'full' ) ) );

							$member_registered_photo = $member_registered_photo[1];

							$member_registered = 'yes';

							$member_id++; // Must be placed at the end of IF

						// IF not a user registered

						} elseif ( (get_sub_field('usercheck_section_team')) && ($member_id == 0) ) {

							$member_function = get_sub_field('function_section_team');

							$member_name = get_sub_field('nosubscriber_section_team');

							$member_mail = get_sub_field('mail_section_team');

							$member_phone = get_sub_field('phone_section_team');

							if ( $member_phone && preg_match("#^(0|\+33[0]?|00[-. ]?33[0]?)[-. ]?[1-9]([-. ]?[0-9]{2}){4}$#", $member_phone) ) {

								$member_phone = preg_replace( "#^(?:0|\+33[0]?|00[-. ]?33[0]?)[-. ]?([1-9])[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})[-. ]?([0-9]{2})$#", "0$1 $2 $3 $4 $5", $member_phone );	// 06 52 12 32 45

							$member_photo = get_sub_field('photo_section_team');

							}

							$member_registered = 'no';

							$member_id++; // Must be placed at the end of ELSEIF

						}

					endwhile;

				}









				/***********  STARTUP HEADER  ***********/

		

				/* The variables */

				// Company exist ?

				$if_company = get_field( 'if_company' );

				// Name company 

				$name_company = get_field( 'name_company' );

				// Web site

				$website = get_field( 'website_company' );

				// SIREN

				$siren_company= get_field('siren_company');

				$length=3;

				while ( preg_match('/(\S+)(\S{'.$length.'})/', $siren_company, $matches) ) {

					$siren_company = str_replace($matches[0], $matches[1] . ' ' . $matches[2], $siren_company);	

				}

				// APE or NAF code

				$naf = get_field( 'ape_company' );

				// Legal form

				$legalform_company_array = get_field( 'legalform_company' );

				$legalform_company = '';

				if ( $legalform_company_array ) {

					$legalform_company = $legalform_company_array['label'];

				}

				// Creation date

				$date_company = get_field( 'date_company' );

				// Share capital

				$capital_company = get_field( 'capital_company' );

				if ($capital_company) {

					$capital_company = euro_format($capital_company); 

				} else {

					$capital_company = 'Capital non précisé';

				}

				// JEI & EIP

				$jei = get_field( 'jei_company' );

				$eip = get_field( 'eip_company' );

				// Headquarters location

				$location_headquarters = 'Adresse non spécifiée';

				$location_headquarters_array = get_field( 'address_headquarters_company' );

				if( !empty($location_headquarters_array) ) {

					$location_headquarters = $location_headquarters_array['address'];

				}

				// Location if company not created

				$location = 'Adresse non spécifiée';

				$location_array = get_field( 'address_company' );

				if( !empty($location_array) ) {

					$location = $location_array['address'];

				}







				/* HTML part */

			?>

				<div class="block">

					<table class="table-header">

						<tr>

							<td class="td-logos">

								<div class="block-logos">	<!-- logos -->

								    <?php

								    $logo = get_field('logo_startup');

								    if ($logo) {

								        $size = 'medium'; // (thumbnail, medium, large, full or custom size)

								        echo '<img src="' . wp_get_attachment_url( $logo, $size ) . '" class="avatar group-1-avatar avatar-150 photo avatar-startup" alt="Logo du groupe Goupe test 1" title="Goupe test 1">';

								    } else {

								        $url = content_url( '/themes/kleo-child/img/' );

								        $fakelogo = "no-logo.png";

								        echo '<div class="img"><img src=" ' . $url . $fakelogo . ' " alt="Aucun logo" class="fake-logo avatar-startup"></div>';

								    } ?>

								    <div class="project-logo">

								    <?php

								    if( $eip['value'] == 'oui' ): ?>

								    	<img width="50px;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/logo_eip.svg" id="eip" class="svg-logo" title="Entreprise Innovente des Pôles (E.I.P)" alt="Entreprise Innovente des Pôles (E.I.P)">

								    <?php endif; ?>

								    <?php if( $jei['value'] == 'oui' ): ?>

								    	<img width="50px;" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/logo_jei.svg" id="jei" class="svg-logo" title="Jeune Entreprise Innovante (J.E.I)" alt="Jeune Entreprise Innovante (J.E.I)">

								    <?php endif; ?>

								    </div>

								</div>	<!-- /logos -->

							</td>

							<td class="td-startup">

								<div class="block">	<!-- Startup informations -->

								    <?php the_title('<h2>', '</h2>'); ?>

								    <?php if( $if_company == 'oui' ): // IF company created?>

									    <ul>

									       <!-- Category -->

								    		<?php

								    		$category_startup_term = get_field( 'category_startup' );

								    		if ( $category_startup_term ) {

								    		    echo "<li>Catégorie : <b>" . $category_startup_term->name . "</b></li>";

								    		} ?>

									    	<li>

									    		<b><?= $name_company ?></b> au capital de <b><?= $capital_company ?></b>

									    	</li>

									    	<li>

									    		SIREN : <b><?= $siren_company ?></b>

									    	</li>

									    	<li>

									    		Adresse : <b><?= $location_headquarters ?></b>

									    	</li>

									    	<li>

									    		Date de création : <b><?= $date_company ?></b>

									    	</li>

									    	<li>

									    		Code NAF : <b><?= $naf ?></b>

									    	</li>

									    </ul>

									<?php else: // ELSE company not created ?>

										    <ul>

										    	<li class='li-contact'>

										    		Site web : <b><?= $website ?></b>

										    	</li>

										    	<li>

										    		Adresse : <b><?= $location ?></b>

										    	</li>

										    </ul>



									<?php endif; // END company info ?>

								</div>	<!-- /Startup informations -->

							</td>

							<td>

								<div class="block">	<!-- Contact informations -->

									<h2>Contact principal</h2>

									<?php if( !empty($member_name) ): ?>

										<?php

										if( $member_registered == 'yes' ){

											if ( !empty($member_registered_photo) ) {

											    echo '<img src="' . $member_registered_photo . '" class="avatar-member">';

											}

										} elseif( $member_registered == 'no' ) {

											if ($member_photo) {

											    $size = 'medium'; // (thumbnail, medium, large, full or custom size)

											    echo '<img src="' . wp_get_attachment_url( $member_photo, $size ) . '" class="avatar-member">';

											}

										}

										?>

									<ul>

										<li>

											<b><?= $member_name ?></b>

										</li>

										<li>

											<b><?= $member_function ?></b>

										</li>

										<?php if( !empty($member_phone) ) {

											echo "<li class='li-contact'><i class='icon-phone'></i> <b>" . $member_phone . "</b></li>";

										} 

										if( !empty($member_mail) ) {

											echo "<li class='li-contact member-mail'><i class='fa fa-envelope' aria-hidden='true'></i> <b>" . $member_mail . "</b></li>";

										} ?>

										<?php if( $website ) {

											echo "<li class='li-contact'><i class='icon-web'></i> <b>" . $website . "</b></li>";

										} ?>

									</ul>

									<?php else: ?>

									<ul>

										<li>

											<b>Aucune personne à contacter renseignée</b>

										</li>

									</ul>

									<?php endif; ?>

								</div>	<!-- /Contact informations -->

							</td>

						</tr>

					</table>

				</div>



			

		<?php

				/*********  END STARTUP HEADER  *********/







				/**********  SIMPLIFIED PART  **********/ ?>

				

				<div class="big-title">Fiche Simplifiée</div>

				<div class="project-description"><?php the_field('excerpt_startup'); ?></div>





				<?php // Project resume

				$project_resume = get_field( 'project_resume' );

				if( $project_resume ): ?>

					<div class="project-content-pitch project-resume-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-light-bulb"></i> Projet</h4><hr> <!-- Title -->

						</div>

						<div class="item-company project-resume">

							<?php echo $project_resume; ?>

						</div>

					</div>

				<?php endif; ?>





				<?php // Team part

				if( have_rows('members_team') ): ?>

				<div class="project-content-pitch members-content-pitch">

					<div class="block-header">

						<h4 class="block-title"><i class="icon-user"></i> Équipe</h4><hr> <!-- Title -->

					</div>

					<div class="item-company members-resume">



						<?php 

						$clear_counter_float_member = 0;

						?>



						<?php while( have_rows('members_team') ): the_row(); 



							$function = get_sub_field('function_section_team');



							// IF not a user registered

							if (get_sub_field('usercheck_section_team')) :



								// vars

								$photo = get_sub_field('photo_section_team');

								$name = get_sub_field('nosubscriber_section_team');

								$mail = get_sub_field('mail_section_team');?>

								<?php if( $clear_counter_float_member < 6 ): ?>

									<div class="thumbnail-member-content">

										<?php

										if ($photo) {

										    $size = 'medium'; // (thumbnail, medium, large, full or custom size)

										    echo '<img src="' . wp_get_attachment_url( $photo, $size ) . '" class="photo-member">';

										} elseif ($mail) {

											$url_photo = get_avatar_url( $mail, array('size'=>150) );		

										    echo '<img src=" ' . $url_photo . ' " class="photo-member">';

										} ?>



										<div class="member-infos">

											<div class="name"><?php echo $name; ?></div>

											<div class="function">

												<?php

												if( $function ) {

													echo $function; 

												} else {

													echo 'Fonction non spécifiée';

												}

												 ?>

											</div>

										</div>

									</div>

								<?php endif; // ENDIF Print 6 members max ?>

								

							<?php  // IF registered user

							elseif ( !get_sub_field('usercheck_section_team') ) :

															

								// vars

								$user_fields = get_sub_field('subscriber_section_team');

								$user_id = $user_fields['ID'];

								$user_type = bp_get_member_type($user_id);

								$photo = explode( '"', bp_get_displayed_user_avatar( array('item_id'=>$user_id, 'type'=>'full' ) ) );

								$photo = $photo[1];

								$name = bp_get_profile_field_data( array('user_id'=>$user_id,'field'=>'Name' ) );

								?>



								<?php if( $clear_counter_float_member < 6 ): ?>

									<div class="thumbnail-member-content">

										<?php

										if ($photo) {

										    echo '<img src="' . $photo . '" class="photo-member">';

										} 

										?>



										<div class="member-infos">

											<div class="name"><?php echo $name; ?></div>

											<div class="function">

												<?php

												if( $function ) {

													echo $function; 

												} else {

													echo 'Fonction non spécifiée';

												}

												 ?>

											</div>

										</div>

									</div>

								<?php endif; // ENDIF Print 6 members max ?>



							<?php endif; // ENDIF user of startup ?>



							<?php 

							// Increment of counter float

							$clear_counter_float_member++; 

							if( $clear_counter_float_member % 2 == 0 ) {	// Insert a clear:both every 2 float

								echo '<div style="clear:both; height: 0; overflow: hidden;"></div>';

							}

							?>





						<?php endwhile; ?>

						<div style="clear:both; height: 0; overflow: hidden;"></div>



					</div>

				</div>

				<?php endif; // ENDIF exist team members ?>





				<?php // Shareholders resume

				// check if the nested repeater field has rows of data

				if( have_rows('shareholders_resume') ): ?>

					<div class="project-content-pitch shareholders-resume-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-users"></i> Actionnariat</h4><hr> <!-- Title -->

						</div>

						<div class="item-company shareholders-resume scroll">

							<table>

								<thead>

									<tr>

										<th>Nom</th>

										<th>Nombre de parts</th>

										<th>% détenu</th>

									</tr>

								</thead>

								<tbody>

									<?php // loop through the rows of data

									while ( have_rows('shareholders_resume') ) : the_row();

										echo '<tr><td class="shareholders-name">';

										the_sub_field('name_section-shareholders');

										echo '</td><td class="shareholders-nbactions">';

										the_sub_field('nbactions_section_shareholders');

										echo '</td><td class="shareholders-percentage">';

										the_sub_field('percentage_section_shareholders');

										echo ' %</td></tr>';

									endwhile; ?>

								</tbody>

							</table>

						</div>

					</div>

				<?php endif; ?>





				<?php // Fundraising resume

				// check if the nested repeater field has rows of data

				if( have_rows('fundraising_resume') ): ?>

					<div class="project-content-pitch fundraising-resume-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-attach-money"></i> Levée(s) de fonds réalisée(s)</h4><hr> <!-- Title -->

						</div>

						<div class="item-company fundraising-resume scroll">

							<table>

								<thead>

									<tr>

										<th>Date</th>

										<th>Montant</th>

										<th>Prime</th>

										<th>Nominal</th>

										<th>Réseau / investisseur</th>

									</tr>

								</thead>

								<tbody>

									<?php // loop through the rows of data

									while ( have_rows('fundraising_resume') ) : the_row();

										// Data recovery

										$date_section_fundraising = get_sub_field('date_section_fundraising');

										$amount_section_fundraising = get_sub_field('amount_section_fundraising');

										$bonus_section_fundraising = get_sub_field('bonus_section_fundraising');

										$nominal_section_fundraising = get_sub_field('nominal_section_fundraising');

										$investor_section_fundraising = get_sub_field('investor_section_fundraising');



										echo '<tr><td class="fundraising-date">';

										if ($date_section_fundraising) {

											echo $date_section_fundraising;

										} else {

											echo 'Date non précisé';

										}

										echo '</td><td class="fundraising-amount">';

										if ($amount_section_fundraising) {

											echo euro_format($amount_section_fundraising);

										} else {

											echo 'Montant non précisé';

										}

										echo '</td><td class="fundraising-bonus">';

										if ($bonus_section_fundraising) {

											echo euro_format($bonus_section_fundraising);

										} else {

											echo 'Montant non précisé';

										}

										echo '</td><td class="fundraising-nominal">';

										if ($nominal_section_fundraising) {

											echo euro_format($nominal_section_fundraising);

										} else {

											echo 'Montant non précisé';

										}

										echo '</td><td class="fundraising-investor">';

										if ($investor_section_fundraising) {

											echo $investor_section_fundraising;

										} else {

											echo 'Investisseur non précisé';

										}

										echo '</td></tr>';

									endwhile; ?>

								</tbody>

							</table>

						</div>

					</div>

				<?php endif; ?>



				

				<?php // Business model resume

				$businessmodel_resume = get_field( 'businessmodel_resume' );

				if( $businessmodel_resume ): ?>

					<div class="project-content-pitch businessmodel-resume-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-star-outline"></i> Offre, modèle économique</h4><hr> <!-- Title -->

						</div>

						<div class="item-company businessmodel-resume">

							<?php echo $businessmodel_resume; ?>

						</div>

					</div>

				<?php endif; ?>





				<?php // Market resume

				$market_resume = get_field( 'market_resume' );

				if( $market_resume ): ?>

					<div class="project-content-pitch market-resume-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-local-mall"></i> Marché</h4><hr> <!-- Title -->

						</div>

						<div class="item-company market-resume">

							<?php echo $market_resume; ?>

						</div>

					</div>

				<?php endif; ?>





				<?php // Competitor resume

				// check if the nested repeater field has rows of data

				if( have_rows('competitor_resume') ): ?>



					<div class="project-content-pitch competitor-resume-section-with-title">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-whatshot"></i> Concurrence</h4><hr> <!-- Title -->

						</div>

						<div class="item-company competitor-resume">

							<?php // loop through the rows of data

							$clear_counter = 0;

							while ( have_rows('competitor_resume') ) : the_row();

								if( $clear_counter < 3 ){

									echo '<div class="competitor-thumbnail-simplified">

											<div class="competitor-thumbnail-contents">

												<div class="competitor-name">';

									the_sub_field('namecompetitor_section_resume');

									$competitor_url = get_sub_field('websitecompetitor_section_resume');

									echo '

												</div>

												<div class="website">

													' . $competitor_url . '

												</div>

											</div>

										</div>';

								}

								$clear_counter++;

							endwhile; ?>

							<div style="clear:both; height: 0; overflow: hidden;"></div>

						</div>

					</div>

					<div class="project-content-pitch competitor-resume-section">

						<div class="item-company competitor-resume">

							<?php // loop through the rows of data

							$clear_counter = 0;

							while ( have_rows('competitor_resume') ) : the_row();

								if( ($clear_counter >= 3) && ($clear_counter < 6) ){

									echo '<div class="competitor-thumbnail-simplified">

											<div class="competitor-thumbnail-contents">

												<div class="competitor-name">';

									the_sub_field('namecompetitor_section_resume');

									$competitor_url = get_sub_field('websitecompetitor_section_resume');

									echo '

												</div>

												<div class="website">

													' . $competitor_url . '

												</div>

											</div>

										</div>';

								}

								$clear_counter++;

								if( $clear_counter % 3 == 0 ) {	// Insert a clear:both every 3 float

									echo '<div style="clear:both; height: 0; overflow: hidden;"></div>';

								}

							endwhile; ?>

							<div style="clear:both; height: 0; overflow: hidden;"></div>

						</div>

					</div>





				<?php endif; ?>





				<?php // Current state resume

				$currentstate_resume = get_field( 'currentstate_resume' );

				if( $currentstate_resume ): ?>

					<div class="project-content-pitch currentstate-resume-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-flag2"></i> État actuel du projet</h4><hr> <!-- Title -->

						</div>

						<div class="item-company currentstate-resume">

							<?php echo $currentstate_resume; ?>

						</div>

					</div>

				<?php endif; ?>





				<!-- Item Financial -->

				<div class="project-content-pitch financial">

					<div class="block-header">

						<h4 class="block-title"><i class="icon-local-atm"></i> Financier</h4><hr> <!-- Title -->

					</div>

					<?php

					// Year n-1

					$date__n_1 				= get_field( 'date_financial_n-1' );

					$turnover__n_1 			= get_field( 'turnover_financial_n-1' );

					$netprofit__n_1 		= get_field( 'netprofit_financial_n-1' );

					$employees_fte__n_1 	= get_field( 'employees_fte_financial_n-1' );

					// Year n

					$date__n 				= get_field( 'date_financial_n' );

					$turnover__n 			= get_field( 'turnover_financial_n' );

					$netprofit__n 			= get_field( 'netprofit_financial_n' );

					$employees_fte__n 		= get_field( 'employees_fte_financial_n' );

					// Year n+1

					$date__n1 				= get_field( 'date_financial_n+1' );

					$turnover__n1 			= get_field( 'turnover_financial_n+1' );

					$netprofit__n1 			= get_field( 'netprofit_financial_n+1' );

					$employees_fte__n1 		= get_field( 'employees_fte_financial_n+1' );

					// Year n+2

					$date__n2 				= get_field( 'date_financial_n+2' );

					$turnover__n2 			= get_field( 'turnover_financial_n+2' );

					$netprofit__n2 			= get_field( 'netprofit_financial_n+2' );

					$employees_fte__n2 		= get_field( 'employees_fte_financial_n+2' );



					if( $date__n_1 || $date__n || $date__n1 || $date__n2 ||

						$turnover__n_1 || $turnover__n || $turnover__n1 || $turnover__n2 ||

						$netprofit__n_1 || $netprofit__n || $netprofit__n1 || $netprofit__n2 ||

						$employees_fte__n_1 || $employees_fte__n || $employees_fte__n1 || $employees_fte__n2 ): ?>

					<div class="item-company">

						<div class="scroll">

							<table>

								<thead>

									<tr>

										<th></th>

										<th>Année n-1</th>

										<th>Année n</th>

										<th>Année n+1</th>

										<th>Année n+2</th>

									</tr>

								</thead>

								<tbody>

									<tr>

										<td>Date</td>

										<td><?php echo $date__n_1; ?></td>

										<td><?php echo $date__n; ?></td>

										<td><?php echo $date__n1; ?></td>

										<td><?php echo $date__n2; ?></td>

									</tr>

									<tr>

										<td>Chiffre d'affaires</td>

										<td><?php 

											if ($turnover__n_1) {

												echo euro_format($turnover__n_1); 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($turnover__n) {

												echo euro_format($turnover__n); 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($turnover__n1) {

												echo euro_format($turnover__n1); 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($turnover__n2) {

												echo euro_format($turnover__n2); 

											} else {

												echo "non précisé";

											}

										?></td>

									</tr>

									<tr>

										<td>Résultat net</td>

										<td><?php 

											if ($netprofit__n_1) {

												echo euro_format($netprofit__n_1); 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($netprofit__n) {

												echo euro_format($netprofit__n); 

											} else {

												echo "non précisé";

											}

										?></td>	

										<td><?php 

											if ($netprofit__n1) {

												echo euro_format($netprofit__n1); 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($netprofit__n2) {

												echo euro_format($netprofit__n2); 

											} else {

												echo "non précisé";

											}

										?></td>

									</tr>

									<tr>

										<td>Salariés (ETP)</td>

										<td><?php 

											if ($employees_fte__n_1) {

												echo $employees_fte__n_1; 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($employees_fte__n) {

												echo $employees_fte__n; 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($employees_fte__n1) {

												echo $employees_fte__n1; 

											} else {

												echo "non précisé";

											}

										?></td>

										<td><?php 

											if ($employees_fte__n2) {

												echo $employees_fte__n2; 

											} else {

												echo "non précisé";

											}

										?></td>

									</tr>

								</tbody>

							</table>

						</div>

					</div>

					<?php endif; ?>

				</div>





				<?php // Wanted funds

				$wantedfunds_rusume = get_field( 'wantedfunds_rusume' );

				$datefunds_rusume = get_field( 'datefunds_rusume' );

				$postmoneyvalue_rusume = get_field( 'postmoneyvalue_rusume' );

				$estimationmethod_rusume = get_field( 'estimationmethod_rusume' );

				if( $wantedfunds_rusume || $postmoneyvalue_rusume || $datefunds_rusume ): ?>

					<div class="project-content-pitch wantedfunds-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-graph"></i> Augmentation de capital</h4><hr> <!-- Title -->

						</div>

						<div class="block-dl">

							<dl>

							 	<dt>Fonds propres recherchés</dt>

							  	<dd>

							    	<?php

								    if ( $wantedfunds_rusume ) {

								    	echo euro_format($wantedfunds_rusume);

								    } else {

								    	echo 'Non spécifié';

								    }?>

								</dd>

							</dl>

							<dl>

							  	<dt>Date souhaitée de la levée de fonds</dt>

							  	<dd>

							    	<?php

								    if ( $datefunds_rusume ) {

										echo $datefunds_rusume;

									} else {

										echo 'Date non spécifiée';

									}?>

								</dd>

							</dl>

							<dl>

								<dt>Valeur postmoney estimée</dt>

								<dd>

									<?php 

									if ( $postmoneyvalue_rusume ) {

										echo euro_format($postmoneyvalue_rusume);

									} else {

										echo 'Non spécifiée';

									}?>	

								</dd>

							</dl>

							<dl class="estimationmethod-rusume">

								<dt>Méthode d'estimation</dt>

								<dd>

									<?php 

									if ( $estimationmethod_rusume ) {

										echo $estimationmethod_rusume;

									} else {

										echo 'Méthode non spécifiée';

									}?>

								</dd>

							</dl>

						</div>

					</div>

				<?php endif; ?>





				<!-- 2 colonnes : Breakdown funds resume & Output strategy resume -->

				<div class="two-columns">

					<div class="column">

						<?php // Breakdown funds resume

						// Data recovery

						$unbreakdownfunds_rusume = get_field( 'unbreakdownfunds_rusume' );

						// IF Amount in Euros

						// check if the nested repeater field has rows of data

						if( have_rows('breakdownfunds_rusume') ): ?>

							<div class="project-content-pitch breakdownfunds-resume-section">

								<div class="block-header">

									<h4 class="block-title"><i class="icon-open-with"></i> Répartition des fonds</h4><hr> <!-- Title -->

								</div>

								<div class="item-company breakdownfunds-resume scroll">

									<table>

										<thead>

											<tr>

												<th>Poste</th>

												<th>Montant</th>

											</tr>

										</thead>

										<tbody>

											<?php // loop through the rows of data

											while ( have_rows('breakdownfunds_rusume') ) : the_row();

												echo '<tr><td class="breakdownfunds-item">';

												the_sub_field('item_section_breakdownfunds');

												echo '</td><td class="breakdownfunds-amount">';

												$amount_section_breakdownfunds = get_sub_field('amount_section_breakdownfunds');

												if ($amount_section_breakdownfunds) {

													echo euro_format($amount_section_breakdownfunds);

												} else {

													echo 'Montant non précisé';

												}

												echo '</td></tr>';

											endwhile; ?>

										</tbody>

									</table>

								</div>

							</div>

						<?php

						//ELSEIF Percentage

						elseif ( have_rows('ratebreakdownfunds_rusume') ): ?>

							<div class="project-content-pitch ratebreakdownfunds-resume-section">

								<div class="block-header">

									<h4 class="block-title"><i class="icon-open-with"></i> Répartition des fonds</h4><hr> <!-- Title -->

								</div>

								<div class="item-company ratebreakdownfunds-resume scroll">

									<table>

										<thead>

											<tr>

												<th>Poste</th>

												<th>Pourcentage</th>

											</tr>

										</thead>

										<tbody>

											<?php // loop through the rows of data

											while ( have_rows('ratebreakdownfunds_rusume') ) : the_row();

												echo '<tr><td class="ratebreakdownfunds-item">';

												the_sub_field('item_section_ratebreakdownfunds');

												echo '</td><td class="ratebreakdownfunds-amount">';

												$rate_section_ratebreakdownfunds = get_sub_field('rate_section_ratebreakdownfunds');

												echo '<div class="hidden sdf"><pre>';

												var_dump ($rate_section_ratebreakdownfunds);

												echo '</pre></div>';

												if ($rate_section_ratebreakdownfunds) {

													echo $rate_section_ratebreakdownfunds." %";

												} else {

													echo 'Pourcentage non précisé';

												}

												echo '</td></tr>';

											endwhile; ?>

										</tbody>

									</table>

								</div>

							</div>

						<?php 

						//ELSEIF Not defined

						elseif( $unbreakdownfunds_rusume ): ?>

							<div class="project-content-pitch unbreakdownfunds-resume-section">

								<div class="block-header">

									<h4 class="block-title"><i class="icon-open-with"></i> Répartition des fonds</h4><hr> <!-- Title -->

								</div>

								<div class="item-company unbreakdownfunds-resume">

									<?php echo $unbreakdownfunds_rusume; ?>

								</div>

							</div>

						<?php endif; ?>

					</div>

					<div class="column">

						<?php // Output strategy resume

						$outputstrategy_rusume = get_field( 'outputstrategy_rusume' );

						if( $outputstrategy_rusume ): ?>

							<div class="project-content-pitch outputstrategy-resume-section">

								<div class="block-header">

									<h4 class="block-title"><i class="icon-assignment-return"></i> Stratégie de sortie</h4><hr> <!-- Title -->

								</div>

								<div class="item-company outputstrategy-resume">

									<?php echo $outputstrategy_rusume; ?>

								</div>

							</div>

						<?php endif; ?>

					</div>

					<div style="clear:both"></div>

				</div>





				<?php // Other application resume

				// check if the nested repeater field has rows of data

				if( have_rows('otherapplication_rusume') ): ?>

					<div class="project-content-pitch otherapplication-resume-section">

						<div class="block-header">

							<h4 class="block-title"><i class="icon-assignment"></i> Autre(s) dossier(s) de demande de fonds</h4><hr> <!-- Title -->

						</div>

						<div class="item-company otherapplication-resume scroll">

							<table>

								<thead>

									<tr>

										<th>Réseau / Fonds / Investisseur</th>

										<th>Type</th>

										<th>Statut</th>

										<?php

										if ($secureamount_section_application) {

											echo '<th>Montant sécurisé</th>';

										} else {

											echo '<th>Montant demandé</th>';

										}

										?>

										<th>Commentaire</th>

									</tr>

								</thead>

								<tbody>

									<?php // loop through the rows of data

									while ( have_rows('otherapplication_rusume') ) : the_row();

										// Data recovery

										$networkfund_section_application = get_sub_field('networkfund_section_application');

										$type_section_application = get_sub_field('type_section_application');

										$status_section_application = get_sub_field('status_section_application');

										$requestamount_section_application = get_sub_field('requestamount_section_application');

										$secureamount_section_application = get_sub_field('secureamount_section_application');

										$comment_section_application = get_sub_field('comment_section_application');



										$debug = false;

										if ($debug) {

											echo '<div class="hidden dosss"><pre>';

											echo 'investisseur<br>';

											var_dump ($networkfund_section_application);

											echo '<br>type<br>';

											var_dump ($type_section_application);

											echo '<br>statut<br>';

											var_dump ($status_section_application);

											echo '<br>montant demandé<br>';

											var_dump ($requestamount_section_application);

											echo '<br>montant sécurisé<br>';

											var_dump ($secureamount_section_application);

											echo '<br>commentaire<br>';

											var_dump ($comment_section_application);

											echo '</pre></div>';

										}



										echo '<tr><td class="otherapplication-item">';

										if ($networkfund_section_application) {

											echo $networkfund_section_application;

										} else {

											echo 'Investisseur non renseigné';

										}

										echo '</td><td class="otherapplication-item">';

										echo $type_section_application['label'];

										echo '</td><td class="otherapplication-item">';

										echo $status_section_application['label'];

										echo '</td><td class="otherapplication-item">';

										if ($requestamount_section_application) {

											echo euro_format($requestamount_section_application);

										} elseif ($secureamount_section_application) {

											echo euro_format($secureamount_section_application);

										} else {

											echo 'Montant non précisé';

										}

										echo '</td><td class="otherapplication-item">';

										if ($comment_section_application) {

											echo $comment_section_application;

										} else {

											echo '';

										}

										echo '</td></tr>';

									endwhile; ?>

								</tbody>

							</table>

						</div>

					</div>

				<?php endif; ?>

				



			<?php endwhile; ?>

		<?php endif; ?>



		<?php else: ?>

		<div class="item-content"><p>Aucun post sélectionné</p></div>



	<?php endif; ?>



<?php endif; // End of the part with logged user & participant OR premium investor ?>



</div>

        

           

            </div><!--end .content-wrap-->

        </div><!--end .main-->



        

    </div><!--end #main-container-->

   </div><!--end #print-->

</div>

<!--END MAIN SECTION-->



<?php

get_footer();

?>



<script>



// Print page

window.onload = setTimeout(function() { window.print(); }, 1500);

// Close page

window.onload = setTimeout(function() { window.close(); }, 2500);



</script>

