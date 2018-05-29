<?php
/**
 * Template Name: PDF Startup
 *
 * Description: Page template for pdf card
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Guillaume Dubois <guillaume.dubois@welikestartup.fr>
 * @since AppLike 1.0
 */

ob_start();	// Turn on output buffering

// The variables
$pdf_test = htmlspecialchars($_POST['pdf-test']);
$pdf_content = '';



$pdf_content .= "<style>
	#print {
		background-color: #FFF;
	}
</style>";

// $_POST['startup_id'] = 14822;
// Variables
if( isset($_POST['startup_id']) ) {
	$startup_id = $_POST['startup_id'];
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

		endwhile;
	endif;

endif;

if (!is_user_logged_in()) : // IF no logged 

	$pdf_content = '<div class="message-warning">
		
    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n\'avez pas accès au projet.</p>
		<p class="important">Vous devez être connecté en tant qu\'investisseur.</p>
		<div class="show-login">
	        <a class="button-connexion" href="" onclick="KLEO.main.ajaxLogin()">
	            <i class="icon-lock"></i>
	            <?php esc_html_e( "Login", "buddyapp" ); ?>
	        </a>
	    </div>
	    
	</div>';

// ELSEIF user or user premium logged
elseif ( ( ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) || ($projectacces && (in_multi_array($current_user->ID, $projectacces) == false)) ) && array_intersect($user_roles, $current_user->roles) ) : 
	
	$pdf_content = '<div class="message-warning">
		
    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n\'avez pas accès au projet en tant qu\'utilisateur.</p>
		<p class="important">Devenez investisseur et accédez à plus de contenu en nous contactant directement via le livechat.</p>
		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">
			<input type="hidden" name="chat-projet" value="active">
			<input type="submit" value="Je souhaite devenir investisseur">
		</form>
			    
	</div>';

// ELSEIF investor logged
elseif ( ( ($totalaccess && (in_multi_array($current_user->ID, $totalaccess) == false)) || ($projectacces && (in_multi_array($current_user->ID, $projectacces) == false)) ) && $current_user->roles[0] == 'app_investor' ) : 
	$pdf_content = '<div class="message-warning">

    	<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
		<h3> Accès restreint</h3>
		<p>Vous n\'avez pas accès à la fiche projet.</p>
		<p class="important">Vous pouvez nous en faire la demande via le livechat.</p>
		<form action="<?php get_permalink( get_the_ID() ) ?>#chat-open" method="POST">
			<input type="hidden" name="chat-projet" value="active">
			<input type="submit" value="Je souhaite accéder à la fiche projet">
		</form>
	    
	</div>';?>

<?php else : // ELSE user logged & participant OR premium investor

	// Get function
	if ( isset($startup_id) ) :

		// The get variables
		$post_type = 'startup';

		// The parameters
		$args = array(
			'p' => $startup_id, // id of a page, post, or custom type
			'post_type' => $post_type,
		);

		// The Query
		$ajax_query = new WP_Query($args);

		// The Loop
		if($ajax_query->have_posts()) :
			while ( $ajax_query->have_posts() ) : $ajax_query->the_post();

		/**********  PROJECT PART  **********/
				
				// Item Company
				$pdf_content .= '
				<div class="project-content-pitch company">
					<h2>PDF en cours de mise en forme</h2><h3>Ne pas tenir compte de ce contenu</h3>';
					
					$if_company = get_field( 'if_company' );
					if( $if_company == 'oui' ):
						$pdf_content .= '
						<div class="project-logo">';
						
						$jei = get_field( 'jei_company' );
						$eip = get_field( 'eip_company' );
						if( $eip['value'] == 'oui' ): 
							$pdf_content .= '
							<img width="50px;" src="'. get_stylesheet_directory_uri() .'/assets/svg/logo_eip.jpg" id="eip" class="svg-logo" title="Entreprise Innovente des Pôles (E.I.P)" alt="Entreprise Innovente des Pôles (E.I.P)">';
						endif;
						if( $jei['value'] == 'oui' ):
							$pdf_content .= '
							<img width="50px;" src="'. get_stylesheet_directory_uri() .'/assets/svg/logo_jei.jpg" id="jei" class="svg-logo" title="Jeune Entreprise Innovante (J.E.I)" alt="Jeune Entreprise Innovante (J.E.I)">';
						endif;
						$pdf_content .= '
						</div>

						<div class="card-header card-header-icon"><i class="icon-location-city"></i></div> <!-- Icon card -->
						<h4 class="card-title society">Société</h4> <!-- Title -->

						<div class="item-company name-company">
							<h5 class="field-title">Raison sociale</h5>'.
							get_field( "name_company" ) .'
						</div>
						<div class="item-company siren-company">
							<h5 class="field-title">SIREN</h5>';
														
							$siren_company= get_field('siren_company');
							$length=3;
							while ( preg_match('/(\S+)(\S{'.$length.'})/', $siren_company, $matches) ) {
								$siren_company = str_replace($matches[0], $matches[1] . ' ' . $matches[2], $siren_company);	
							}
						$pdf_content .= $siren_company;
							
						$pdf_content .= '
						</div>
						<div class="item-company ape-company">
							<h5 class="field-title">Code APE (NAF)</h5>'. 
							get_field( "ape_company" ) .'
						</div>
						<p>Quod cum ita sit, paucae domus studiorum seriis cultibus antea celebratae nunc ludibriis ignaviae torpentis exundant, vocali sonu, perflabili tinnitu fidium resultantes. denique pro philosopho cantor et in locum oratoris doctor artium ludicrarum accitur et bybliothecis sepulcrorum ritu in perpetuum clausis organa fabricantur hydraulica, et lyrae ad speciem carpentorum ingentes tibiaeque et histrionici gestus instrumenta non levia.
						</p>
						<p>
							Omitto iuris dictionem in libera civitate contra leges senatusque consulta; caedes relinquo; libidines praetereo, quarum acerbissimum extat indicium et ad insignem memoriam turpitudinis et paene ad iustum odium imperii nostri, quod constat nobilissimas virgines se in puteos abiecisse et morte voluntaria necessariam turpitudinem depulisse. Nec haec idcirco omitto, quod non gravissima sint, sed quia nunc sine teste dico.
						</p>
						<p>
							Postremo ad id indignitatis est ventum, ut cum peregrini ob formidatam haut ita dudum alimentorum inopiam pellerentur ab urbe praecipites, sectatoribus disciplinarum liberalium inpendio paucis sine respiratione ulla extrusis, tenerentur minimarum adseclae veri, quique id simularunt ad tempus, et tria milia saltatricum ne interpellata quidem cum choris totidemque remanerent magistris.
						</p>
						<p>
							Illud tamen clausos vehementer angebat quod captis navigiis, quae frumenta vehebant per flumen, Isauri quidem alimentorum copiis adfluebant, ipsi vero solitarum rerum cibos iam consumendo inediae propinquantis aerumnas exitialis horrebant.
						</p>
						<p>
							Accedat huc suavitas quaedam oportet sermonum atque morum, haudquaquam mediocre condimentum amicitiae. Tristitia autem et in omni re severitas habet illa quidem gravitatem, sed amicitia remissior esse debet et liberior et dulcior et ad omnem comitatem facilitatemque proclivior.
						</p>
						<p>
							Quod opera consulta cogitabatur astute, ut hoc insidiarum genere Galli periret avunculus, ne eum ut praepotens acueret in fiduciam exitiosa coeptantem. verum navata est opera diligens hocque dilato Eusebius praepositus cubiculi missus est Cabillona aurum secum perferens, quo per turbulentos seditionum concitores occultius distributo et tumor consenuit militum et salus est in tuto locata praefecti. deinde cibo abunde perlato castra die praedicto sunt mota.
						</p>
						<p>
							Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.
						</p>
						<p>
							Quis enim aut eum diligat quem metuat, aut eum a quo se metui putet? Coluntur tamen simulatione dumtaxat ad tempus. Quod si forte, ut fit plerumque, ceciderunt, tum intellegitur quam fuerint inopes amicorum. Quod Tarquinium dixisse ferunt, tum exsulantem se intellexisse quos fidos amicos habuisset, quos infidos, cum iam neutris gratiam referre posset.
						</p>
						<p>
							Quam ob rem ut ii qui superiores sunt submittere se debent in amicitia, sic quodam modo inferiores extollere. Sunt enim quidam qui molestas amicitias faciunt, cum ipsi se contemni putant; quod non fere contingit nisi iis qui etiam contemnendos se arbitrantur; qui hac opinione non modo verbis sed etiam opere levandi sunt.
						</p>
						<p>
							Has autem provincias, quas Orontes ambiens amnis imosque pedes Cassii montis illius celsi praetermeans funditur in Parthenium mare, Gnaeus Pompeius superato Tigrane regnis Armeniorum abstractas dicioni Romanae coniunxit.
						</p>
						<p>
							Sed quid est quod in hac causa maxime homines admirentur et reprehendant meum consilium, cum ego idem antea multa decreverim, que magis ad hominis dignitatem quam ad rei publicae necessitatem pertinerent? Supplicationem quindecim dierum decrevi sententia mea. Rei publicae satis erat tot dierum quot C. Mario ; dis immortalibus non erat exigua eadem gratulatio quae ex maximis bellis. Ergo ille cumulus dierum hominis est dignitati tributus.
						</p>
						<p>
							Cyprum itidem insulam procul a continenti discretam et portuosam inter municipia crebra urbes duae faciunt claram Salamis et Paphus, altera Iovis delubris altera Veneris templo insignis. tanta autem tamque multiplici fertilitate abundat rerum omnium eadem Cyprus ut nullius externi indigens adminiculi indigenis viribus a fundamento ipso carinae ad supremos usque carbasos aedificet onerariam navem omnibusque armamentis instructam mari committat.
						</p>
						<p>
							Ex turba vero imae sortis et paupertinae in tabernis aliqui pernoctant vinariis, non nulli velariis umbraculorum theatralium latent, quae Campanam imitatus lasciviam Catulus in aedilitate sua suspendit omnium primus; aut pugnaciter aleis certant turpi sono fragosis naribus introrsum reducto spiritu concrepantes; aut quod est studiorum omnium maximum ab ortu lucis ad vesperam sole fatiscunt vel pluviis, per minutias aurigarum equorumque praecipua vel delicta scrutantes.
						</p>
						<p>
							Duplexque isdem diebus acciderat malum, quod et Theophilum insontem atrox interceperat casus, et Serenianus dignus exsecratione cunctorum, innoxius, modo non reclamante publico vigore, discessit.
						</p>
						<p>
							Hae duae provinciae bello quondam piratico catervis mixtae praedonum a Servilio pro consule missae sub iugum factae sunt vectigales. et hae quidem regiones velut in prominenti terrarum lingua positae ob orbe eoo monte Amano disparantur.
						</p>
						';
					

					endif;
				$pdf_content .= '</div>




						';
			endwhile;
		endif;
	endif;

endif; // End of the part with logged user & participant OR premium investor

/*****  Début de blocage du contenu  ******/
if( $pdf_test && ($pdf_test == 'sdf') ){

?>

<?php } /******  FIN de blocage du contenu  ******/ ?>

<?php 
if( $pdf_test && ($pdf_test == "project-team" ) || ($pdf_test == "project" ) || ($pdf_test == "team" )){
	$pdf = ob_get_clean();	// Get current buffer contents and delete current output buffer
    $pdf = '<page>'.$pdf_content.'</page>';	// Contenu du pdf
    // convert in PDF
	require( get_stylesheet_directory()."/html2pdf/vendor/autoload.php" );
    
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
//      $html2pdf->setModeDebug();
        $html2pdf->pdf->SetDisplayMode('real');
        $html2pdf->writeHTML($pdf);
        $html2pdf->Output();
   
} 
?>

