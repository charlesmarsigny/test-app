<?php
/**
 * Template Name: Documents group
 *
 * Description: Page template for sub group page of sub startup page
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Guillaume Dubois <guillaume.dubois@welikestartup.com>
 * @since AppLike 1.0
 */
?>
<div class="project-content-pitch">
	<h3>Documents du groupe</h3>
	<p>Test de la page des documents du groupe</p>
	<?php
	$group_id = htmlspecialchars(addslashes($_GET['id']));
	var_dump($group_id);
	?>
	<hr>

	<?php 
	$args = array(
	'include' => $group_id
	);
	if ( bp_has_groups( $args) ) : 

		while ( bp_groups() ) : bp_the_group();
			bp_group_description(); 

		endwhile;

	endif;
	?>
	
</div>