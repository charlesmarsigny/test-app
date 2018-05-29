<?php
/**
 * Template Name: News startup
 *
 * Description: Page template for sub startup page
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

// Get function
if ( isset($_GET['id']) ) :

	// The get variables
	$post_type = 'actualite';
	$startup_id = strval($_GET['id']);

	// The parameters
	$args = array(
		'meta_key'     => 'linked_actualite_startup',
		'meta_value'   => $startup_id,
		'meta_compare'   => 'LIKE',
		'post_type' => $post_type
	);

	// The Query
	$ajax_query = new WP_Query($args);

	// The Loop
	if($ajax_query->have_posts()) :
		while ( $ajax_query->have_posts() ) : $ajax_query->the_post(); ?>

			<!-- item -->
			<?php the_title( '<h3>', '</h3>' ); ?>

		<?php endwhile; ?>
	<?php endif; ?>

	<?php else: ?>
	<div class="item-content"><p>Aucun post sélectionné</p></div>

<?php endif; ?>