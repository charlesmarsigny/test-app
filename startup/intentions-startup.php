<?php
/**
 * Template Name: Intentions startup
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
			$owner = get_field('owner_startup');

		endwhile;
	endif;

endif;

// $test = $current_user->ID;
// echo "<div class='hidden'><pre>";
// var_dump ($test);
// echo "</pre></div>";

if (!is_user_logged_in()) { // IF no logged ?>

	<div class="message-warning">
		
    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n'avez pas accès aux intentions d'investissement.</p>
		<p class="important">Vous devez être connecté en tant qu'investisseur participant à cette startup.</p>
		<div class="show-login">
	        <a class="button-connexion" href="" onclick="KLEO.main.ajaxLogin()">
	            <i class="icon-lock"></i>
	            <?php esc_html_e( "Login", 'buddyapp' ); ?>
	        </a>
	    </div>
	    
	</div>

<?php // ELSEIF user or user premium logged
} elseif ( ( empty($totalaccess) || ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) ) && array_intersect($user_roles, $current_user->roles) || ($owner && (in_multi_array($current_user->ID, $owner) == true)) ) { ?>
	
	<div class="message-warning">
		
    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n'avez pas accès aux intentions d'investissement en tant qu'utilisateur.</p>
		<p class="important">Devenez investisseur pour accédez à plus de contenu en nous contactant directement via le livechat.</p>
		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">
			<input type="hidden" name="chat-intentions" value="active">
			<input type="submit" value="Je souhaite devenir investisseur">
		</form>

	</div>

<?php 
// ELSEIF investor logged
} elseif ( ( empty($totalaccess) || ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) ) && $current_user->roles[0] == 'app_investor' ) { ?>
	
	<div class="message-warning">

    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n'avez pas accès aux intentions d'investissement sans participer à la levée de fonds.</p>
		<p class="important">Demandez-nous à y participer via le livechat.</p>
		<!--<button type="button" class="slaask-open-widget">Je souhaite participer</button>-->
	    <form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">
			<input type="hidden" name="chat-intentions" value="active">
			<input type="submit" value="Je souhaite devenir investisseur">
		</form>
	</div>

<?php } else { // ELSE user logged & participant

	// The variables
	$post_type = 'intention';
	if( isset($_GET['id']) ) {
		$startup_id = $_GET['id'];
		$str_startup_id = strval($startup_id);
	}
	$post_link = get_permalink( $startup_id );
	$total_intention_amount = 0;
	$current_user = wp_get_current_user();
	$allowed_roles = array('administrator', 'webmaster');

	// Set local money					
	setlocale(LC_MONETARY, 'fr_FR.UTF-8');
	?>

	<!-- item -->
	<div class="intention-content">

		<div class="card-header card-header-text">
		    <h4 class="card-title">Intentions d'investissement</h4>
		</div>

		<?php
		if( array_intersect($allowed_roles, $current_user->roles ) ) {
			acf_form(array(
				'post_id'		=> $startup_id,
				'new_post'		=> array(
						'post_type'		=> $post_type
					),
				'honeypot' 		=> true,
				'fields' 		=> array( 'targetamount_intention_startup' ),
				'return' => $post_link . '?addamount=true&admin=true#intentions',
				'submit_value'	=> 'Définir l\'objectif des intentions'
			));
			acf_form(array(
				'post_id'		=> 'new_post',
				'new_post'		=> array(
						'post_type'		=> $post_type,
						'post_status'	=> 'publish'
					),
				'honeypot' 		=> true,
				'fields' 		=> array( 'amount_intention', 'investor_intention' ),
				'html_after_fields' => '<input type="hidden" name="acf[field_5848407a33699]" value="' . $startup_id . '">',
				'return' => $post_link . '?new=true&admin=true#intentions',
				'submit_value'	=> 'Ajouter une intention'
			));
		} else {
			acf_form(array(
				'post_id'		=> 'new_post',
				'new_post'		=> array(
						'post_type'		=> $post_type,
						'post_status'	=> 'publish'
					),
				'honeypot' 		=> true,
				'fields' 		=> array( 'amount_intention' ),
				'html_after_fields' => '<input type="hidden" name="acf[field_5848407a33699]" value="' . $startup_id . '">
										<input type="hidden" name="acf[field_58ca759aec97a]" value="' . $current_user->ID . '">',
				'return' => $post_link . '?new=true#intentions',
				'submit_value'	=> 'Ajouter une intention'
			));
		} ?>

		<?php // Get function
		if ( isset( $startup_id ) ) :

			// The parameters
			$args1 = array(
				'meta_key'     		=> 'linked_intention_startup',
				'meta_value'   		=> $str_startup_id,
				'meta_compare'   	=> 'LIKE',
				'post_type' 		=> $post_type,
				'nopaging' 			=> true
			);

			// The Query
			$ajax_query1 = new WP_Query($args1);

			// The Loop
			if($ajax_query1->have_posts()) : ?>
				
				<table>
					<thead>
						<tr>
							<?php // ELSEIF Admin or Webmaster
							if( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
								<th>Dépositaire</th>
							<?php endif; ?>
							<th>Investisseur</th>
							<th>Date</th>
							<th style="text-align: right;">Montant</th>
							<th></th>
						</tr>
					</thead>
					<tbody>

						<?php while ( $ajax_query1->have_posts() ) : $ajax_query1->the_post();
							// var
							$intention_date = get_the_date();
							$intention_updated_date = get_the_modified_date();
							$intention_amount = get_field('amount_intention');
							$intention_id = get_the_ID();
							$intention_investor = get_field('investor_intention');
							$intention_amount_euro = money_format('%(#1n', $intention_amount);

							// ELSEIF Admin or Webmaster
							if( array_intersect($allowed_roles, $current_user->roles ) ) :
								echo '<tr><td>';
								the_author();
								echo '</td><td><b>' . $intention_investor['display_name'] . '</b>';
							else :
								echo '<tr><td><b>' . $intention_investor['display_name'] . '</b>';
							endif;
							echo '</td>';
							if ( $intention_date == $intention_updated_date )  {
								echo '<td>' . $intention_date . '</td><td style="text-align: right;">' . $intention_amount_euro . '</td><td>';
							} else {
								echo '<td style="line-height: 1.2em;">' . $intention_date . '<br><small>Modifié le ' . $intention_updated_date . '</small></td><td style="text-align: right;">' . $intention_amount_euro . '</td><td>';
							}
							if( array_intersect($allowed_roles, $current_user->roles) || $current_user->ID == $post->post_author || $current_user->ID == $intention_investor['ID'] ) {
								echo '<div class="action-button"><a href="/actions/modifier-intention?startupid=' . $startup_id . '&intentionid=' . $intention_id . '" class="submit edit-button" title="Modifier"><i class="icon-pencil"></i>Modifier</a></div>
									  <form id="cancel-intention-' . $intention_id . '" class="action-button cancel-action" action="/actions/supprimer" method="post">
										<input type="hidden" name="postid" value="' . $intention_id . '">
										<input type="hidden" name="startupid" value="' . $startup_id . '">
										<a href="#cancel-intention-' . $intention_id . '" class="submit cancel-button" onclick="document.getElementById(\'cancel-intention-' . $intention_id . '\').submit();" title="Annuler"><i class="icon-close"></i>Annuler</a>
									  </form>';
							}
							echo '</td></tr>';

							$total_intention_amount += $intention_amount;
							$total_intention_amount_euro = money_format('%(#1n', $total_intention_amount);

						endwhile; ?>
						
					</tbody>
					<tfoot>
					 	<tr>
					 		<?php // ELSEIF Admin or Webmaster
							if( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
								<td></td>
							<?php endif; ?>
					 		<td></td>
							<td><strong>Total</strong></td>
							<td style="text-align: right;"><strong><?php echo $total_intention_amount_euro; ?></strong></td>
							<td></td>
						</tr>
						<?php					
						// The parameters
						$startup_args = array(
							'post_type' 		=> 'startup',
							'p'					=> $startup_id,
							'nopaging' 			=> true
						);

						// The Query
						$startup_query = new WP_Query($startup_args);

						// The loop
						if($startup_query->have_posts()) :
							while ( $startup_query->have_posts() ) : $startup_query->the_post();

								// The variables
								$amount_target = get_field('targetamount_intention_startup');
								$amount_target_euro = money_format('%(#1n', (float)$amount_target);

								if ( $amount_target ) : ?>
								 	<tr>
								 		<?php // IF Admin or Webmaster
										if( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
											<td></td>
										<?php endif; ?>
								 		<td></td>
										<td><strong>Objectif</strong></td>
										<td style="text-align: right;"><strong><?php echo $amount_target_euro; ?></strong></td>
										<td></td>
									</tr>
								<?php endif;

							endwhile;
						endif; ?>
					</tfoot>
				</table>

			<?php else: ?>

				<div class="empty-intention">Aucune intention</div>

			<?php endif; ?>

		<?php endif; ?>

	</div>


	<?php // Intention in trash
	if( array_intersect($allowed_roles, $current_user->roles ) ) : ?>

		<!-- item -->
		<div class="intention-content delete">

			<div class="card-header card-header-text">
			    <h4 class="card-title">Intentions annulées</h4>
			</div>

			<?php // Get function
			if ( isset( $startup_id ) ) :

				// The parameters
				$args2 = array(
					'meta_key'     		=> 'linked_intention_startup',
					'meta_value'   		=> $str_startup_id,
					'meta_compare'   	=> 'LIKE',
					'post_type' 		=> $post_type,
					'post_status' 		=> 'trash',
					'nopaging' 			=> true
				);

				// The Query
				$ajax_query2 = new WP_Query($args2);

				// The Loop
				if($ajax_query2->have_posts()) : ?>
					
					<table>
						<thead>
							<tr>
								<?php // ELSEIF Admin or Webmaster
								if( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
									<th>Dépositaire</th>
								<?php endif; ?>
								<th>Investisseur</th>
								<th>Date</th>
								<th style="text-align: right;">Montant</th>
								<th></th>
							</tr>
						</thead>
						<tbody>

							<?php while ( $ajax_query2->have_posts() ) : $ajax_query2->the_post();
								// var
								$c_intention_date = get_the_date();
								$c_intention_updated_date = get_the_modified_date();
								$c_intention_amount = get_field( 'amount_intention' );
								$c_intention_id = get_the_ID();
								$c_intention_investor = get_field('investor_intention');
								$c_intention_amount_euro = money_format('%(#1n', $c_intention_amount);
								
								// ELSEIF Admin or Webmaster
								if( array_intersect( $allowed_roles, $current_user->roles ) ) {
									echo '<tr><td>';
									the_author();
									echo '</td><td><b>' . $c_intention_investor['display_name'] . '</b>';
								} else {
									echo '<tr><td><b>' . $c_intention_investor['display_name'] . '</b>';
								}
								echo '</td>';
								if ( $c_intention_date == $c_intention_updated_date )  {
									echo '<td>' . $c_intention_date . '</td><td style="text-align: right;">' . $c_intention_amount_euro . '</td><td>';
								} else {
									echo '<td style="line-height: 1.2em;">' . $c_intention_date . '<br><small>Modifié le ' . $c_intention_updated_date . '</small></td><td style="text-align: right;">' . $c_intention_amount_euro . '</td><td>';
								}
								echo '<form id="restore-intention-' . $c_intention_id . '" class="action-button restore-action" action="/actions/restaurer" method="post">
										<input type="hidden" name="postid" value="' . $c_intention_id . '">
										<input type="hidden" name="startupid" value="' . $startup_id . '">
										<a href="#restore-intention-' . $c_intention_id . '" class="submit restore-button" onclick="document.getElementById(\'restore-intention-' . $c_intention_id . '\').submit();" title="Restaurer"><i class="icon-forward2"></i>Restaurer</a>
									  </form>
									  <form id="delete-intention-' . $c_intention_id . '" class="action-button delete-action" action="/actions/supprimer-def" method="post">
										<input type="hidden" name="postid" value="' . $c_intention_id . '">
										<input type="hidden" name="startupid" value="' . $startup_id . '">
										<a href="#delete-intention-' . $c_intention_id . '" class="submit delete-button" onclick="document.getElementById(\'delete-intention-' . $c_intention_id . '\').submit();" title="Supprimer"><i class="icon-trash"></i>Supprimer</a>
									  </form>';
								echo '</td></tr>';

							endwhile; ?>
							
						</tbody>
					</table>

				<?php else: ?>

					<div class="empty-intention">Aucune intention annulée</div>

				<?php endif; ?>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<!-- Open modal in AJAX callback -->
	<script type="text/javascript">
	    (function($) {

	    $('.edit-button').click(function(event) {
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

<?php } // End of the part with logged user ?>
