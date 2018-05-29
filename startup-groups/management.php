<?php
/**
 * Template Name: Management group
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
<div id="modal-content" style="background-color: #fff; padding: 80px 20px 20px;">
	<h3>Administration du groupe</h3>
	<p>Test de la page d'administration du groupe</p>

	<?php
	if ($_GET['id']) :
		$group_id = htmlspecialchars(addslashes($_GET['id']));
		// var_dump($group_id);
		$args = array(
		'include' => $group_id
		);
		if ( bp_has_groups( $args) ) : ?>

			<?php while ( bp_groups() ) : bp_the_group(); ?>
				
				<?php
				$informations_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/informations/' ) );
				$reglages_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/reglages/' ) );
				$photo_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/photo/' ) );


				?>
				
				<div id="admin-block-<?php echo $group_id ?>">

					<div class="item-list-tabs" id="admin-subnav-<?php echo $group_id ?>" role="navigation">
						<ul id="management" class="etabs">
							<li id="group-li-informations-<?php echo $group_id ?>" class="tab">
								<a id="group-tab-informations-<?php echo $group_id ?>" href="<?php echo $informations_url; ?>" data-target="#informations-<?php echo $group_id ?>">Informations <b>sans modal</b></a>
							</li>
							<li id="group-li-reglages-<?php echo $group_id ?>" class="tab">
								<a id="group-tab-reglages-<?php echo $group_id ?>" href="<?php echo $reglages_url; ?>" data-target="#reglages-<?php echo $group_id ?>">Réglages</a>
							</li>
							<li id="group-li-photo-<?php echo $group_id ?>" class="tab">
								<a id="group-tab-photo-<?php echo $group_id ?>" href="<?php echo $photo_url; ?>" data-target="#photo-<?php echo $group_id ?>">Photo</a>
							</li>
						</ul>
					</div>

					<div id="informations-div-<?php echo $group_id ?>" class="button-administration">
						<span id="informations-button-<?php echo $group_id ?>">Informations <b>avec modal</b></span>
					</div>

					<!-- TAB Information -->
					<div id="informations-<?php echo $group_id ?>" class="item-tab"></div>
					<!-- /TAB Information -->

					<!-- TAB Réglage -->
					<div id="reglages-<?php echo $group_id ?>" class="item-tab"></div>
					<!-- /TAB Réglage -->

					<!-- TAB Photo -->
					<div id="photo-<?php echo $group_id ?>" class="item-tab"></div>
					<!-- /TAB Photo -->

					<!-- Button save modifications -->
					<div id="group-administration-save" class="button-administration">
						<button id="group-tab-admin-<?php echo $group_id ?>-save">Enregistrer les modifications</button>
					</div>
					<!-- /Button save modifications -->

				</div>


				<!-- Group description on activity top -->
				<div class="group-desc project-content-pitch">
					<hr>
					<?php bp_group_description(); ?>
					<hr>
				</div>

				

			<?php endwhile; ?>
			<script type="text/javascript">
				(function($) {

					$('#admin-subnav-<?php echo $group_id ?>')
					.easytabs({
					  panelContext: $(document),
					  cache: false,
					  defaultTab: 'li#group-li-informations-<?php echo $group_id ?>',
					  tabs: 'ul#management > li',
					  transitionIn: 'fadeIn',
					  transitionOut: 'fadeOut',
					  tabActiveClass: 'current'
					})
					.bind('easytabs:ajax:complete', function(e, $clicked, $targetPanel, settings) {
					  if ( $targetPanel.get(0).id === 'reglages-<?php echo $group_id ?>' ) {
						$.scrollTo($targetPanel, 800);
					  }
					  if ( $targetPanel.get(0).id === 'photo-<?php echo $group_id ?>' ) {
						$.scrollTo($targetPanel, 800);
					  }
					});

					// Custombox
					$('#informations-button-<?php echo $group_id ?>').on('click', function( e ) {
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

		<?php else: ?> 
		<?php endif; ?>

	<?php endif; ?>

</div>