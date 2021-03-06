<?php
/**
 * Template Name: Delete post
 *
 * Description: Page template for delete post
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

$post_id = $_POST['postid'];
$startup_id = $_POST['startupid'];
$startup_link = get_permalink( $startup_id );

if ( $post_id ) :

	wp_delete_post( $post_id );

endif;

if ( $startup_id ) :
	header('Location: ' . $startup_link . '?delete=true#intentions');
else :
	header("Location: {$_SERVER['HTTP_REFERER']}?delete=true#intentions");
endif;

exit;

?>