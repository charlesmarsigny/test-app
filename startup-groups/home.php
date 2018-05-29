<?php
/**
 * Template Name: Home group
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
if ($_GET['id']) :
	$group_id = htmlspecialchars(addslashes($_GET['id']));
	// var_dump($group_id);
	$args = array(
	'include' => $group_id
	);
	if ( bp_has_groups( $args) ) : ?>

		<?php while ( bp_groups() ) : bp_the_group(); ?>
			
			<?php
			$activity_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/activites/' ) );
			$adherer_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/adherer/' ) );
			$documents_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/documents/' ) );
			$members_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/membres/' ) );
			$invitation_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/inviter/' ) );
			$mail_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/courriels/' ) );
			$admin_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/admin/' ) );

			$modal_admin_url = esc_url( add_query_arg( array('id' => $group_id), '/startup-page/groupes/gestion/' ) );

			?>

			<div class="item-list-tabs project-content-pitch" id="group-subnav-<?php echo $group_id ?>" role="navigation">
				<ul id="home" class="etabs">
					<li id="group-li-activity-<?php echo $group_id ?>" class="tab">
						<a id="group-tab-activity" href="<?php echo $activity_url; ?>" data-target="#activites-<?php echo $group_id ?>">Accueil</a>
					</li>
					<li id="group-li-join-<?php echo $group_id ?>" class="tab">
						<a id="group-tab-join" href="<?php echo $adherer_url; ?>" data-target="#adherer-<?php echo $group_id ?>">Adhérer au groupe</a>
					</li>
					<li id="group-li-docs-<?php echo $group_id ?>" class="tab">
						<a id="group-tab-docs" href="<?php echo $documents_url; ?>" data-target="#documents-<?php echo $group_id ?>">Documents</a>
					</li>
					<li id="group-li-members-<?php echo $group_id ?>" class="tab">
						<a id="group-tab-members" href="<?php echo $members_url; ?>" data-target="#membres-<?php echo $group_id ?>">Membres</a>
					</li>
					<li id="group-li-invitation-<?php echo $group_id ?>" class="tab">
						<a id="group-tab-invitation" href="<?php echo $invitation_url; ?>" data-target="#inviter-<?php echo $group_id ?>">Inviter</a>
					</li>
					<li id="group-li-mail-<?php echo $group_id ?>" class="tab">
						<a id="group-tab-mail" href="<?php echo $mail_url; ?>" data-target="#courriels-<?php echo $group_id ?>">Option des courriels</a>
					</li>
					<li id="group-li-admin-<?php echo $group_id ?>" class="tab">
						<a id="group-tab-admin" href="<?php echo $modal_admin_url; ?>" data-target="#admin-<?php echo $group_id ?>">Template admin <b>sans</b> modal</a>
					</li>
				</ul>
			</div>

			<div id="group-administration-<?php echo $group_id ?>" class="button-administration">
				<span id="group-admin-<?php echo $group_id ?>" class="group-admin-open-lock" >Template admin <b>avec</b> modal</span>
			</div>

			<!-- Group description on activity top -->
			<div class="group-desc project-content-pitch">
				<hr>
				<?php bp_group_description(); ?>
				<hr>
			</div>

			<!-- TAB Activity -->
			<div id="activites-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Activity -->

			<!-- TAB Adherer -->
			<div id="adherer-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Adherer -->

			<!-- TAB Documents -->
			<div id="documents-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Documents -->

			<!-- TAB Membres -->
			<div id="membres-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Membres -->

			<!-- TAB Invitation -->
			<div id="inviter-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Invitation -->

			<!-- TAB Mail options -->
			<div id="courriels-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Mail Options -->

			<!-- TAB Admin -->
			<div id="admin-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Admin -->

			<!-- TAB Administration -->
			<div id="administration-<?php echo $group_id ?>" class="item-tab"></div>
			<!-- /TAB Administration -->


		<?php endwhile; ?>

		<script type="text/javascript">

			(function($) {

			  	$('#group-subnav-<?php echo $group_id ?>')
				.easytabs({
				  panelContext: $(document),
				  cache: false,
				  defaultTab: 'li#group-li-activity-<?php echo $group_id ?>',
				  panelActiveClass: 'active-content-div',
				  tabActiveClass: 'selected-tab',
				  tabs: 'ul#home > li',
				  transitionIn: 'fadeIn',
				  transitionOut: 'fadeOut',
				  tabActiveClass: 'current'
				})
				.bind('easytabs:ajax:complete', function(e, $clicked, $targetPanel, settings) {
				  if ( $targetPanel.get(0).id === 'adherer-<?php echo $group_id ?>' ) {
					$.scrollTo($targetPanel, 800);
				  }
				  if ( $targetPanel.get(0).id === 'documents-<?php echo $group_id ?>' ) {
					$.scrollTo($targetPanel, 800);
				  }
				  if ( $targetPanel.get(0).id === 'membres-<?php echo $group_id ?>' ) {
					$.scrollTo($targetPanel, 800);
				  }
				  if ( $targetPanel.get(0).id === 'inviter-<?php echo $group_id ?>' ) {
					$.scrollTo($targetPanel, 800);
				  }
				  if ( $targetPanel.get(0).id === 'courriels-<?php echo $group_id ?>' ) {
					$.scrollTo($targetPanel, 800);
				  }
				  if ( $targetPanel.get(0).id === 'admin-<?php echo $group_id ?>' ) {
					$.scrollTo($targetPanel, 800);
				  }
				});

				// Custombox
				$('#group-admin-<?php echo $group_id ?>').on('click', function( e ) {
				   var modal = new Custombox.modal({
				      content: {
				      	target: '<?php echo $modal_admin_url; ?>',
				        effect: 'slide',
				        positionY: 'top',
				        width: '60%'
				      }
				   });
				   modal.open();
				});
				document.addEventListener('custombox:overlay:open', function() {
					$('#content').css('filter', 'blur(20px)');
					$('.sidemenu-main').css('filter', 'blur(20px)');
				});
				document.addEventListener('custombox:overlay:close', function() {
					$('#content').css('filter', 'blur(0px)');
					$('.sidemenu-main').css('filter', 'blur(0px)');
				});

				// Modal jQuery
				$('.group-admin-open').click(function(event) {
					event.preventDefault();
					$.get(this.href, function(html) {
				 		$(html).appendTo('body').modal({
				      		fadeDuration: 200
				    	});
				  	});
				});
				

			})(jQuery);

		</script>

	<?php else: ?> 
	<?php endif; ?>

<?php endif; ?>
