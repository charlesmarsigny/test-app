<?php
/**
 * Template Name: Comments startup
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

			<!-- item -->
			<?php
			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
			comments_template();
			endif;
			?>

		<?php endwhile; ?>
	<?php endif; ?>

	<?php else: ?>
	<div class="item-content"><p>Aucun post sélectionné</p></div>

<?php endif; ?>