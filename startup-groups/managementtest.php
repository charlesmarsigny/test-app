<?php
/**
 * Template Name: Test management group
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
<?php
$informations_url = '/startup-page/groupes/informations/';
$reglages_url = '/startup-page/groupes/reglages/';
$photo_url = '/startup-page/groupes/photo/';
?>
<div id="management-block">

	<div class="item-list-tabs project-content-pitch" id="management-subnav" role="navigation">
		<ul id="management" class="etabs">
			<li id="li-informations" class="tab">
				<a id="tab-informations" href="<?php echo $informations_url; ?>" data-target="#management-informations">Informations <b>sans modal</b></a>
			</li>
			<li id="li-reglages" class="tab">
				<a id="tab-reglages" href="<?php echo $reglages_url; ?>" data-target="#management-reglages">Réglages</a>
			</li>
			<li id="li-photo" class="tab">
				<a id="tab-photo" href="<?php echo $photo_url; ?>" data-target="#management-photo">Photo</a>
			</li>
		</ul>
	</div>

	<div class="button-administration">
		<span id="informations-button2">Informations <b>avec modal</b></span>
	</div>

	<!-- TAB Information -->
	<div id="management-informations" class="item-tab"></div>
	<!-- /TAB Information -->

	<!-- TAB Réglage -->
	<div id="management-reglages" class="item-tab"></div>
	<!-- /TAB Réglage -->

	<!-- TAB Photo -->
	<div id="management-photo" class="item-tab"></div>
	<!-- /TAB Photo -->

	<!-- Button save modifications -->
	<div id="group-administration-save2" class="button-administration">
		<button id="group-tab-admin-save2">Enregistrer les modifications</button>
	</div>
	<!-- /Button save modifications -->

</div>

<script type="text/javascript">
	(function($) {

		$('#management-subnav')
		.easytabs({
		  panelContext: $(document),
		  transitionIn: 'fadeIn',
		  transitionOut: 'fadeOut',
		  tabActiveClass: 'current'
		})
		.bind('easytabs:ajax:complete', function(e, $clicked, $targetPanel, settings) {
		  if ( $targetPanel.get(0).id === 'management-reglages' ) {
			$.scrollTo($targetPanel, 800);
		  }
		  if ( $targetPanel.get(0).id === 'management-photo' ) {
			$.scrollTo($targetPanel, 800);
		  }
		});

		// Custombox
		$('#informations-button2').on('click', function( e ) {
		   var modal = new Custombox.modal({
		      content: {
		      	target: '<?php echo $informations_url; ?>',
		        effect: 'slide',
		        positionY: 'top',
		        width: '60%'
		      }
		   });
		   modal.open();
		});

	})(jQuery);
</script>