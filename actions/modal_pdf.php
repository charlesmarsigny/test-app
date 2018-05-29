<?php
/**
 * Template Name: PDF modal
 *
 * Description: Page template for choose pdf option
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Guillaume Dubois <guillaume.dubois@welikestartup.fr>
 * @since AppLike 1.0
 */

// The variables
$startup_id = $_GET['startupid'];
?>

<div class="form-modal-pdf">

	<h2><?php the_title(); ?></h2>

	<form id="form-pdf" action="/pdf" method="POST" target="_blank">
		<input type="hidden" name="startup_id" value="<?php echo $startup_id; ?>" />
		<p>
			<input type="radio" name="pdf-test" value="project-team" checked>Fiche projet et équipe
			<br>
			<input type="radio" name="pdf-test" value="project">Fiche projet uniquement
			<br>
			<input type="radio" name="pdf-test" value="team">Fiche équipe uniquement
		</P>
		<input type="submit" value="Valider" >
	</form>

</div>