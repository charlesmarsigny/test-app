<?php
/**
 * Template Name: Liquidities startup
 *
 * Description: Page template for sub startup page
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

// The variables
$post_type = 'liquidite';
if( isset($_GET['id']) ) :
	$startup_id = $_GET['id'];
endif;
$str_startup_id = strval($startup_id);
$post_link = get_permalink( $startup_id );
$current_user = wp_get_current_user();
$allowed_roles = array('administrator', 'webmaster');
?>

<!-- item sale -->
<div class="liquidity-content">

	<div class="card-header card-header-text">
	    <h4 class="card-title">Vente d'actions</h4>
	</div>

	<?php acf_form(array(
		'post_id'		=> 'new_post',
		'new_post'		=> array(
				'post_type'		=> $post_type,
				'post_status'	=> 'publish'
			),
		'honeypot' 		=> true,
		'fields' 		=> array(
							'nb_actions_liquidity',
							'value_type_liquidity',
							'action_value_liquidity',
							'amount_liquidity'
						),
		'html_after_fields' => '<input type="hidden" name="acf[field_586cdde5a60bf]" value="sale">
								<input type="hidden" name="acf[field_584840933f6e8]" value="'. $startup_id . '">',
		'return' => $post_link,
		'submit_value'	=> 'Vendre'
	)); ?>

	<?php // Get function
	if ( isset( $startup_id ) ) :

		// The parameters
		$args_sale = array(
			'meta_query' 		=> array(
					array(
						'key'     => 'linked_liquidite_startup',
						'value'   => $str_startup_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'type_liquidity',
						'value'   => 'sale',
						'compare' => 'LIKE',
					),
				),
			'post_type' 		=> $post_type,
			'nopaging' 			=> true
		);

		// The Query
		$ajax_query_sale = new WP_Query($args_sale);

		// The Loop
		if($ajax_query_sale->have_posts()) : ?>
			
			<table>
				<thead>
					<tr>
						<?php // ELSEIF Admin or Webmaster
						if( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
							<th>Actionnaires</th>
						<?php endif; ?>
						<th>Nombre d'actions</th>
						<th>Valeur de l'action</th>
						<th>Montant total</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php while ( $ajax_query_sale->have_posts() ) : $ajax_query_sale->the_post();
						
						// ELSEIF Admin or Webmaster
						if( array_intersect($allowed_roles, $current_user->roles ) ) :
							echo '<tr><td>';
							the_author();
							echo '</td>';
						endif;
						echo '<td>';
						the_field( 'nb_actions_liquidity' );
						echo '</td><td>';
						the_field( 'action_value_liquidity' );
						echo '</td><td>';
						the_field( 'amount_liquidity' );
						echo '</td><td>';
						echo '<a href="#">Modifier</a><a href="#">Supprimer</a><a href="#">Acheter</a>';
						echo '</td></tr>';

					endwhile; ?>
					
				</tbody>
			</table>

		<?php else: ?>

			<div class="empty-intention">Aucune action en vente</div>

		<?php endif; ?>

	<?php endif; ?>

</div>


<!-- item sale -->
<div class="liquidity-content">

	<div class="card-header card-header-text">
	    <h4 class="card-title">Achat d'actions</h4>
	</div>

	<?php acf_form(array(
		'post_id'		=> 'new_post',
		'new_post'		=> array(
				'post_type'		=> $post_type,
				'post_status'	=> 'publish'
			),
		'honeypot' 		=> true,
		'fields' 		=> array(
							'nb_actions_liquidity',
							'value_type_liquidity',
							'action_value_liquidity',
							'amount_liquidity'
						),
		'html_after_fields' => '<input type="hidden" name="acf[field_586cdde5a60bf]" value="buy">
								<input type="hidden" name="acf[field_584840933f6e8]" value="'. $startup_id . '">',
		'return' => $post_link,
		'submit_value'	=> 'Acheter'
	)); ?>

	<?php // Get function
	if ( isset( $startup_id ) ) :

		// The parameters
		$args_buy = array(
			'meta_query' 		=> array(
					array(
						'key'     => 'linked_liquidite_startup',
						'value'   => $str_startup_id,
						'compare' => 'LIKE',
					),
					array(
						'key'     => 'type_liquidity',
						'value'   => 'buy',
						'compare' => 'LIKE',
					),
				),
			'post_type' 		=> $post_type,
			'nopaging' 			=> true
		);

		// The Query
		$ajax_query_buy = new WP_Query($args_buy);

		// The Loop
		if($ajax_query_buy->have_posts()) : ?>
			
			<table>
				<thead>
					<tr>
						<?php // ELSEIF Admin or Webmaster
						if( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
							<th>Actionnaires</th>
						<?php endif; ?>
						<th>Nombre d'actions</th>
						<th>Valeur de l'action</th>
						<th>Montant total</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>

					<?php while ( $ajax_query_buy->have_posts() ) : $ajax_query_buy->the_post();
						
						// ELSEIF Admin or Webmaster
						if( array_intersect($allowed_roles, $current_user->roles ) ) :
							echo '<tr><td>';
							the_author();
							echo '</td>';
						endif;
						echo '<td>';
						the_field( 'nb_actions_liquidity' );
						echo '</td><td>';
						the_field( 'action_value_liquidity' );
						echo '</td><td>';
						the_field( 'amount_liquidity' );
						echo '</td><td>';
						echo '<a href="#">Modifier</a><a href="#">Supprimer</a><a href="#">Acheter</a>';
						echo '</td></tr>';

					endwhile; ?>
					
				</tbody>
			</table>

		<?php else: ?>

			<div class="empty-intention">Aucun souhait d'achat</div>

		<?php endif; ?>

	<?php endif; ?>

</div>

<script type="text/javascript">
	(function($) {
		
		// setup ACF fields
		acf.do_action('append', $('#popup-id'));
		
	})(jQuery);	
</script>