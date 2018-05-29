<?php
/**
 * Template Name: Team Print Modal 
 *
 * Description: Page template for choose print option for team
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

<div class="form-print-modal">

	<h2>Choix de la fiche à imprimer</h2>

	<div class="wrap-choice-box">
		<div class="choice-box">
			<div class="choice-description">
				<h3>Fiche complète</h3>
				<p>Détails des informations sur le projet et l'équipe de la startup.</p>
			</div>
			<div class="choice-form">
				<form id="form-print-complete" class="form-print" action="/print" method="POST" target="_blank">
					<input type="hidden" name="startup_id" value="<?php echo $startup_id; ?>" />
					<input type="hidden" name="complete-print" value="print-complete" />
					<a href="#equipe" class="button-print" onclick="document.getElementById('form-print-complete').submit();">Imprimer</a>
				</form>
			</div>
		</div>
		<div class="choice-box">
			<div class="choice-description">
				<h3>Fiche simplifiée</h3>
				<p>Informations essentielles sur le projet et l'équipe de la startup.</p>
			</div>
			<div class="choice-form">
				<form id="form-print-simplified" class="form-print" action="/print-simplified" method="POST" target="_blank">
					<input type="hidden" name="startup_id" value="<?php echo $startup_id; ?>" />					
					<a href="#equipe" class="button-print-secondary" onclick="document.getElementById('form-print-simplified').submit();">Imprimer</a>
				</form>
			</div>
		</div>
		<div class="choice-box">
			<div class="choice-description">
				<h3>Fiche équipe</h3>
				<p>Pour imprimer uniquement la fiche équipe de la startup.</p>
			</div>
			<div class="choice-form">
				<form id="form-print-team" class="form-print" action="/print" method="POST" target="_blank">
					<input type="hidden" name="startup_id" value="<?php echo $startup_id; ?>" />
					<input type="hidden" name="team-print" value="print-team" />
					<a href="#equipe" class="button-print-secondary" onclick="document.getElementById('form-print-team').submit();">Imprimer</a>
				</form>
			</div>
		</div>
	</div>

</div>