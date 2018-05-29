<?php
/**
 * Template Name: edit intention
 *
 * Description: Page template for edit intention
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */
?>

<div class="edit-modal-intention">

	<h2><?php the_title(); ?></h2>

	<?php
	// The variables
	$post_type = 'intention';
	$startup_id = $_GET['startupid'];
	$intention_id = $_GET['intentionid'];
	$post_link = get_permalink( $startup_id );
	$link_intentions = $post_link . '?updated=true#intentions';

	acf_form(array(
		'post_id'		=> $intention_id,
		'new_post'		=> array(
				'post_type'		=> $post_type
			),
		'honeypot' 		=> true,
		'fields' 		=> array( 'amount_intention' ),
		'html_after_fields' => '<input type="hidden" name="acf[field_5848407a33699]" value="' . $startup_id . '">',
		'return' => $link_intentions,
		'submit_value'	=> 'Enregistrer l\'intention'
	));

	?>

</div>