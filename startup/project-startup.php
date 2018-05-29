<?php
/**
 * Template Name: Project startup
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
		<p>Vous n'avez pas accès au projet en tant qu'utilisateur.</p>
		<p class="important">Devenez investisseur et accédez à plus de contenu en nous contactant directement via le livechat.</p>
		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">
			<input type="hidden" name="chat-projet" value="active">
			<input type="submit" value="Je souhaite devenir investisseur">
		</form>
			    
	</div>

<?php // ELSEIF investor logged
elseif ( ( empty($totalaccess) || ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) || ($projectacces && (in_multi_array($current_user->ID, $projectacces) == false)) ) && $current_user->roles[0] == 'app_investor' ) : ?>
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
				
				<div class="print-card-div"><a href="/actions/modal-print-project/?startupid=<?php echo $startup_id; ?>" class="project-modal print-card-button" title="Impression">Impression</a></div>

				<!-- Item Company -->
				<div class="project-content-pitch company">
					<?php
					$if_company = get_field( 'if_company' );
					if( $if_company == 'oui' ): ?>
						<div class="project-logo">
						<?php
						$jei = get_field( 'jei_company' );
						$eip = get_field( 'eip_company' );
						if( $eip['value'] == 'oui' ): ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/logo_eip.svg" id="eip" class="svg-logo" title="Entreprise Innovente des Pôles (E.I.P)" alt="Entreprise Innovente des Pôles (E.I.P)">
						<?php endif; ?>
						<?php if( $jei['value'] == 'oui' ): ?>
							<img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/svg/logo_jei.svg" id="jei" class="svg-logo" title="Jeune Entreprise Innovante (J.E.I)" alt="Jeune Entreprise Innovante (J.E.I)">
						<?php endif; ?>
						</div>

						<div class="card-header card-header-icon"><i class="icon-location-city"></i></div> <!-- Icon card -->
						<h4 class="card-title society">Société</h4> <!-- Title -->

						<div class="item-company name-company">
							<h5 class="field-title">Raison sociale</h5>
							<?php the_field( 'name_company' ); ?>
						</div>
						<div class="item-company siren-company">
							<h5 class="field-title">SIREN</h5>
							<?php 								
								
								$siren_company= get_field('siren_company');						
								
								
								$length=3;
								while ( preg_match('/(\S+)(\S{'.$length.'})/', $siren_company, $matches) ) {
									$siren_company = str_replace($matches[0], $matches[1] . ' ' . $matches[2], $siren_company);	
								}
								echo $siren_company;
							?>
						</div>
						<div class="item-company ape-company">
							<h5 class="field-title">Code APE (NAF)</h5>
							<?php the_field( 'ape_company' ); ?>
						</div>
						<div class="item-company legalform-company">
							<h5 class="field-title">Forme juridique</h5>
							<?php
							$legalform_company_array = get_field( 'legalform_company' );
							if ( $legalform_company_array ):
								echo $legalform_company_array['label'];
							endif;
							?>
						</div>
						<div class="item-company capital-company">
							<h5 class="field-title">Capital social</h5>
							<?php 
							$capital_company = get_field( 'capital_company' );
							if ($capital_company) {
								echo euro_format($capital_company); 
							} else {
								echo 'Capital non précisé';
							}
							?>
						</div>
						<div class="item-company date-company">
							<h5 class="field-title">Date de création</h5>
							<?php the_field( 'date_company' ); ?>
						</div>
						<?php
						// JEI & EIP in comment
						$alternative = false;
						if( $alternative ):
							$jei = get_field( 'jei_company' );
							$eip = get_field( 'eip_company' );
							if( $jei['value'] == 'oui' ): ?>
								<div class="item-company jei-company">
									<h5 class="field-title">Statut</h5>
									Jeune Entreprise Innovante (J.E.I)
								</div>
							<?php 
							endif;
							if( $eip['value'] == 'oui' ): ?>
								<div class="item-company eip-company">
									<h5 class="field-title">Label</h5>
									Entreprise Innovante des Pôles (E.I.P)
								</div>
							<?php endif;
						endif; ?>
						<div class="item-company address-company">
							<?php $location_array = get_field( 'address_headquarters_company' );
							if( !empty($location_array) ):
							?>
							<h5 class="field-title">Adresse du siège social</h5>
							<?php echo $location_array['address']; ?>
							<div class="acf-map">
								<div class="marker" data-lat="<?php echo $location_array['lat']; ?>" data-lng="<?php echo $location_array['lng']; ?>"></div>
							</div>
						    
							<?php endif; ?>
						</div>

					<?php else: ?>
						
						
						<div class="card-header card-header-icon"><i class=" icon-location"></i></div> <!-- Icon card -->
						<h4 class="card-title">Coordonnées</h4> <!-- Title -->

						<div class="item-company website-company">
							<?php $website = get_field( 'website_company' );
							if( !empty($website) ):
							?>
							<h5 class="field-title">Site web</h5>
							<p><a href="<?php echo $website; ?>"><?php echo $website; ?></a></p>
							<?php endif; ?>
						</div>
						<div class="item-company address-company">
							<?php $location_array = get_field( 'address_company' );
							if( !empty($location_array) ):
							?>
							<h5 class="field-title">Adresse</h5>
							<p><?php echo $location_array['address']; ?></p>
							<div class="acf-map">
								<div class="marker" data-lat="<?php echo $location_array['lat']; ?>" data-lng="<?php echo $location_array['lng']; ?>"></div>
							</div>
						    
							<?php endif; ?>
						</div>

					<?php endif; ?>
				</div>
					

				<?php // Project resume
				$project_resume = get_field( 'project_resume' );
				if( $project_resume ): ?>
					<div class="project-content-pitch project-resume-section">
						<div class="card-header card-header-icon"><i class="icon-light-bulb"></i></div> <!-- Icon card -->
						<h4 class="card-title">Projet</h4> <!-- Title -->

						<div class="item-company project-resume">
							<?php echo $project_resume; ?>
						</div>
					</div>
				<?php endif; ?>


				<?php // Shareholders resume
				// check if the nested repeater field has rows of data
				if( have_rows('shareholders_resume') ): ?>
					<div class="project-content-pitch shareholders-resume-section">
						<div class="card-header card-header-icon"><i class="icon-users"></i></div> <!-- Icon card -->
						<h4 class="card-title">Actionnariat</h4> <!-- Title -->

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
						<div class="card-header card-header-icon"><i class="icon-attach-money"></i></div> <!-- Icon card -->
						<h4 class="card-title">Levée(s) de fonds réalisée(s)</h4> <!-- Title -->

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
						<div class="card-header card-header-icon"><i class="icon-star-outline"></i></div> <!-- Icon card -->
						<h4 class="card-title">Offre, modèle économique</h4> <!-- Title -->

						<div class="item-company businessmodel-resume">
							<?php echo $businessmodel_resume; ?>
						</div>
					</div>
				<?php endif; ?>


				<?php // Market resume
				$market_resume = get_field( 'market_resume' );
				if( $market_resume ): ?>
					<div class="project-content-pitch market-resume-section">
						<div class="card-header card-header-icon"><i class="icon-local-mall"></i></div> <!-- Icon card -->
						<h4 class="card-title">Marché</h4> <!-- Title -->

						<div class="item-company market-resume">
							<?php echo $market_resume; ?>
						</div>
					</div>
				<?php endif; ?>


				<?php // Competitor resume
				// check if the nested repeater field has rows of data
				if( have_rows('competitor_resume') ): ?>
					<div class="project-content-pitch competitor-resume-section">
						<div class="card-header card-header-icon"><i class="icon-whatshot"></i></div> <!-- Icon card -->
						<h4 class="card-title">Concurrence</h4> <!-- Title -->

						<div class="item-company competitor-resume">
								<?php // loop through the rows of data
								while ( have_rows('competitor_resume') ) : the_row();
									echo '<div class="competitor-thumbnail">
											<div class="competitor-thumbnail-contents">
												<div class="competitor-name">';
									the_sub_field('namecompetitor_section_resume');
									$competitor_url = get_sub_field('websitecompetitor_section_resume');
									echo '
												</div>
												<div class="website">
													<a href="' . $competitor_url . '" class="competitor-url">' . $competitor_url . '</a>
												</div>
												<div class="competitor-description">';
									the_sub_field('descriptioncompetitor_section_resume');
									echo '
												</div>
											</div>
										</div>';
								endwhile; ?>
						</div>
					</div>
				<?php endif; ?>


				<?php // Current state resume
				$currentstate_resume = get_field( 'currentstate_resume' );
				if( $currentstate_resume ): ?>
					<div class="project-content-pitch currentstate-resume-section">
						<div class="card-header card-header-icon"><i class="icon-flag2"></i></div> <!-- Icon card -->
						<h4 class="card-title">État actuel du projet</h4> <!-- Title -->

						<div class="item-company currentstate-resume">
							<?php echo $currentstate_resume; ?>
						</div>
					</div>
				<?php endif; ?>


				<!-- Item Financial -->
				<div class="project-content-pitch financial">
					<div class="card-header card-header-icon"><i class="icon-local-atm"></i></div> <!-- Icon card -->
					<h4 class="card-title">Financier</h4> <!-- Title -->
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
					<?php endif; ?>
				</div>


				<?php // Wanted funds
				$wantedfunds_rusume = get_field( 'wantedfunds_rusume' );
				$datefunds_rusume = get_field( 'datefunds_rusume' );
				$postmoneyvalue_rusume = get_field( 'postmoneyvalue_rusume' );
				$estimationmethod_rusume = get_field( 'estimationmethod_rusume' );

				if( $wantedfunds_rusume || $postmoneyvalue_rusume || $datefunds_rusume ): ?>
					<div class="project-content-pitch wantedfunds-section">
						<div class="card-header card-header-icon"><i class="icon-graph"></i></div> <!-- Icon card -->
						<h4 class="card-title">Augmentation de capital</h4> <!-- Title -->
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


				<?php // Breakdown funds resume
				// Data recovery
				$unbreakdownfunds_rusume = get_field( 'unbreakdownfunds_rusume' );
				$breakdownfunds_radio = get_field( 'methodbreakdownfunds_rusume' );
				// echo "test";
				// var_dump($breakdownfunds_radio);
				// IF Amount in Euros
				// check if the nested repeater field has rows of data
				if( have_rows('breakdownfunds_rusume') && ($breakdownfunds_radio["value"] == "amount") ): ?>
					<div class="project-content-pitch fundraising-resume-section">
						<div class="card-header card-header-icon"><i class="icon-open-with"></i></div> <!-- Icon card -->
						<h4 class="card-title">Répartition des fonds</h4> <!-- Title -->

						<div class="item-company breakdownfunds-resume scroll">
							<table>
								<thead>
									<tr>
										<th>Poste</th>
										<th class="amount">Montant</th>
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
				elseif ( have_rows('ratebreakdownfunds_rusume') && ($breakdownfunds_radio["value"] == "rate") ): ?>
					<div class="project-content-pitch ratebreakdownfunds-resume-section">
						<div class="card-header card-header-icon"><i class="icon-open-with"></i></div> <!-- Icon card -->
						<h4 class="card-title">Répartition des fonds</h4> <!-- Title -->

						<div class="item-company ratebreakdownfunds-resume scroll">
							<table>
								<thead>
									<tr>
										<th>Poste</th>
										<th class="amount">Pourcentage</th>
									</tr>
								</thead>
								<tbody>
									<?php // loop through the rows of data
									while ( have_rows('ratebreakdownfunds_rusume') ) : the_row();
										echo '<tr><td class="ratebreakdownfunds-item">';
										the_sub_field('item_section_ratebreakdownfunds');
										echo '</td><td class="ratebreakdownfunds-amount amount">';
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
				elseif( $unbreakdownfunds_rusume && ($breakdownfunds_radio["value"] == "undefined") ): ?>
					<div class="project-content-pitch unbreakdownfunds-resume-section">
						<div class="card-header card-header-icon"><i class="icon-open-with"></i></div> <!-- Icon card -->
						<h4 class="card-title">Répartition des fonds</h4> <!-- Title -->

						<div class="item-company unbreakdownfunds-resume">
							<?php echo $unbreakdownfunds_rusume; ?>
						</div>
					</div>
				<?php endif; ?>


				<?php // Output strategy resume
				$outputstrategy_rusume = get_field( 'outputstrategy_rusume' );
				if( $outputstrategy_rusume ): ?>
					<div class="project-content-pitch outputstrategy-resume-section">
						<div class="card-header card-header-icon"><i class="icon-assignment-return"></i></div> <!-- Icon card -->
						<h4 class="card-title">Stratégie de sortie</h4> <!-- Title -->

						<div class="item-company outputstrategy-resume">
							<?php echo $outputstrategy_rusume; ?>
						</div>
					</div>
				<?php endif; ?>


				<?php // Other application resume
				// check if the nested repeater field has rows of data
				if( have_rows('otherapplication_rusume') ): ?>
					<div class="project-content-pitch otherapplication-resume-section">
						<div class="card-header card-header-icon"><i class="icon-assignment"></i></div> <!-- Icon card -->
						<h4 class="card-title">Autre(s) dossier(s) de demande de fonds</h4> <!-- Title -->

						<div class="item-company otherapplication-resume scroll">
							<table>
								<thead>
									<tr>
										<th>Réseau / Fonds / Investisseur</th>
										<th>Type</th>
										<th>Statut</th>
										<?php
										if ($secureamount_section_application) {
											echo '<th class="amount">Montant sécurisé</th>';
										} else {
											echo '<th class="amount">Montant demandé</th>';
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
										echo '</td><td class="otherapplication-item amount">';
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

	<?php endif; 
	echo '<div class="hidden iddd"><pre>';
	var_dump ($startup_id);
	echo '</pre></div>';?>

		<!-- PDF button -->
		<div class="action-button" style="color:#ddd; background-color: #eee;"><a href="/actions/modal-pdf/?startupid=<?php echo $startup_id; ?>" class="project-modal" style="color:#ddd; background-color: #eee;" title="PDF">PDF</a></div>    

		<?php
		$pdf_test = "non";
		if( $pdf_test == "oui" ){
			// INCLUDE THE phpToPDF.php FILE
		    require( get_stylesheet_directory()."/assets/pdf/phpToPDF.php" );

		    // PUT YOUR HTML IN A VARIABLE
		    $my_html="<HTML>
		    <h2>Test HTML 02</h2><br><br>
		    <div style=\"display:block; padding:20px; border:2pt solid:#FE9A2E; background-color:#F6E3CE; font-weight:bold;\">
		    phpToPDF is pretty cool! <br><br>
		    [This was orange, but I set the PDF option to monochrome (Black & White)]
		    </div><br><br>
		    For more examples, visit us here --> http://phptopdf.com/examples/
		    </HTML>";

		    // SET YOUR PDF OPTIONS -- FOR ALL AVAILABLE OPTIONS, VISIT HERE:  http://phptopdf.com/documentation/
		    $pdf_options = array(
		      "source_type" => 'url',
		      "source" => 'https://app.welikestartup.io/startup/wls/#projet',
		      "action" => 'view',
		      "color" => 'monochrome',
		      "page_orientation" => 'landscape');

		    // CALL THE phpToPDF FUNCTION WITH THE OPTIONS SET ABOVE
		    phptopdf($pdf_options);
		}
	    ?>

<?php endif; // End of the part with logged user & participant OR premium investor ?>

<script>
(function($) {

/*************************
**  DISPLAY GOOGLE MAP  **
**************************/
/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$el (jQuery element)
*  @return	n/a
*/

function new_map( $el ) {
	
	// var
	var $markers = $el.find('.marker');
	
	
	// vars
	var args = {
		zoom		: 16,
		center		: new google.maps.LatLng(0, 0),
		mapTypeId	: google.maps.MapTypeId.ROADMAP,
		scrollwheel: false
	};
	
	
	// create map	        	
	var map = new google.maps.Map( $el[0], args);
	
	
	// add a markers reference
	map.markers = [];
	
	
	// add markers
	$markers.each(function(){
		
    	add_marker( $(this), map );
		
	});
	
	
	// center map
	center_map( map );
	
	
	// return
	return map;
	
}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	$marker (jQuery element)
*  @param	map (Google Map object)
*  @return	n/a
*/

function add_marker( $marker, map ) {

	// var
	var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );

	// create marker
	var marker = new google.maps.Marker({
		position	: latlng,
		map			: map
	});

	// add to array
	map.markers.push( marker );

	// if marker contains HTML, add it to an infoWindow
	if( $marker.html() )
	{
		// create info window
		var infowindow = new google.maps.InfoWindow({
			content		: $marker.html()
		});

		// show info window when marker is clicked
		google.maps.event.addListener(marker, 'click', function() {

			infowindow.open( map, marker );

		});
	}

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type	function
*  @date	8/11/2013
*  @since	4.3.0
*
*  @param	map (Google Map object)
*  @return	n/a
*/

function center_map( map ) {

	// vars
	var bounds = new google.maps.LatLngBounds();

	// loop through all markers and create bounds
	$.each( map.markers, function( i, marker ){

		var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

		bounds.extend( latlng );

	});

	// only 1 marker?
	if( map.markers.length == 1 )
	{
		// set center of map
	    map.setCenter( bounds.getCenter() );
	    map.setZoom( 16 );
	}
	else
	{
		// fit to bounds
		map.fitBounds( bounds );
	}

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type	function
*  @date	8/11/2013
*  @since	5.0.0
*
*  @param	n/a
*  @return	n/a
*/
// global var
var map = null;

$(document).ready(function(){

	$('.acf-map').each(function(){

		// create map
		map = new_map( $(this) );

	});
	
	// popup is shown and map is not visible
	google.maps.event.trigger(map, 'resize');
});
/********************************
**  END OF DISPLAY GOOGLE MAP  **
*********************************/

// Open modal in AJAX callback
$('.project-modal').click(function(event) {
	event.preventDefault();
	$.get(this.href, function(html) {
 		$(html).appendTo('body').modal({
      		fadeDuration: 200
    	});
  	});
});

// setup ACF fields
acf.do_action('append');

})(jQuery);
</script>
