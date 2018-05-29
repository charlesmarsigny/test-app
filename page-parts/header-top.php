<!-- Header
============================================= -->

<?php
//white or dark logo
$logo_mobile = Kleo::get_config( 'logo_mobile' );
$logo_attr = sq_option( $logo_mobile . '_retina', '' ) ? 'data-retina="' . esc_attr( sq_option( $logo_mobile . '_retina' ) ) . '"' : '';
$logo_link = home_url();

$current_header_classes = 'header-colors header-layout-01';

/* Check if search is active */
if ( sq_option( 'header_search', true, true ) )  {
	$current_header_classes .= ' has-search';
}

/* Check how dropdown triggers */
if ( sq_option( 'menu_dropdown', 'hover', true ) == 'hover' )  {
	$current_header_classes .= ' hover-menu';
} else {
	$current_header_classes .= ' click-menu';
}


?>
<div class="hidden appicons">
	<pre><?= var_dump(kleo_icons_array()) ?></pre>
</div>
<header id="header" <?php kleo_header_class( $current_header_classes ); ?>>

	<div id="header-wrap">

			<div class="logo">
				<!-- top-header and mobile logo only-->
				<?php if ( sq_option( $logo_mobile, Kleo::get_config($logo_mobile . '_default') ) ) : ?>

					<a href="<?php echo esc_url( $logo_link ); ?>" class="mobile-logo standard-logo" <?php echo $logo_attr;?>>
						<img src="<?php echo sq_option( $logo_mobile, Kleo::get_config($logo_mobile . '_default') ); ?>" alt="<?php bloginfo('name'); ?>">
					</a>

				<?php endif; ?>

			</div>

			<div class="header-left">
				<a href="#" class="sidemenu-trigger sidemenu-icon-wrapper">
					<span class="sidemenu-icon">
						<span><i></i><b></b></span>
						<span><i></i><b></b></span>
						<span><i></i><b></b></span>
					</span>
				</a>
			</div>
			<div class="header-right">
				<a href="#" class="second-menu-trigger second-menu-icon-wrapper">
					<span class="second-menu-icon">
						<span></span>
						<span></span>
						<span></span>
					</span>
					
					<!--<i class="icon-storage"></i>-->
				</a>
			</div>

			<div class="second-menu">
					<div class="second-menu-main">
					   <div class="second-menu-inner">
						<div class="scroll-container-wrapper">
							<div class="scroll-container">
								<div class="second-menu-section">
								   
									<?php
									// Top left navigation menu.
									wp_nav_menu( array(
										'theme_location' => 'top-left',
										'menu_class'     => 'basic-menu header-icons kleo-nav-menu',
										'container' => false,
										'link_before'       => '<span>',
										'link_after'        => '</span>',
										'depth' => 4,
										'max_elements' => 5,
										'walker' => new kleo_walker_nav_menu(),
										'fallback_cb' => 'kleo_header_icons_menu'
									) );
									?>


									<?php
									/* Check if search is active */
									if ( sq_option( 'header_search', true, true ) ) : ?>

										<!-- The search form -->
										<div class="search-form-wrapper">
											<?php
											$context = sq_option( 'search_context', '' );
											echo kleo_search_form(array('context' => $context)); ?>
										</div>

									<?php endif; ?>
									

									<!-- Headway changelog widget -->
									<!-- <div class="headway changelog-widget">
										<span class="changelog-button">Mises à jour</span>
									</div> -->
									<!-- /Headway changelog widget -->

									<!-- Noticeable changelog widget -->
									<custom-style>
										<style>
											#custom-noticeable-widget {
												display: block;
												max-height: 60px;
												position: relative;
												order: 4;
												--noticeable-widget-trigger-badge: {
													display: block;
													position: absolute;
													top: 50%;
													right: 0;
													margin-top: -16px;
												};
												--noticeable-widget-trigger-badge-enabled: {
													background-color: #F53053;
												};
												--noticeable-widget-trigger-badge-disabled: {
													background-color: #eff4f6;
												};
												--noticeable-widget-popup-container: {
													background-color: white;
													border: none;
													box-shadow: rgba(63, 49, 178, 0.1) 0px 4px 16px, rgba(63, 49, 178, 0.03) 0px 12px 30px;
												};
												--noticeable-widget-popup-header: {
													border-bottom: 1px solid #e5e5e5;
									                color: #232346;
									            };
									            --noticeable-widget-popup-content: {
									                background-color: white;
									                color: #4C5577;
									                font-size: 13px;
									            };
									            --noticeable-widget-popup-post-content-a: {
						                            color: #232346;
						                        };
						                        --noticeable-widget-popup-entry-title: {
			                                        color: #232346;
			                                    };
											}
											#custom-noticeable-widget a {
												border: solid 2px #EFF3F6;
												-webkit-border-radius: 100px;
												-moz-border-radius: 100px;
												border-radius: 100px;
												padding: 7px 17px 6px;
												display: block;
												position: relative;
												margin: 15px 0;
												font-size: 12px;
												line-height: 14px;
												text-transform: uppercase;
												font-weight: bold;
												color: #4C5577;
												width: 120px;
												white-space: nowrap;
											}
											iron-overlay-backdrop {
												display: none;
											}
										</style>
									</custom-style>

									<noticeable-widget id="custom-noticeable-widget" access-token="twZ5tPicZi31iHCsbxOy" project-id="7fTgHXEhmgmLrm0yBbDy" popup-backdrop="true" trigger-eye-catching="true">
										<a title="Nouveautés de l'application">Mises à jour</a>
									</noticeable-widget>
									<!-- /Noticeable changelog widget -->


									<?php
									/* Show my menu under the profile image just for logged in members */
									if ( sq_option('header_right_logic', 'default', true ) == 'default' ): ?>

										<?php if (is_user_logged_in()) : ?>

											<ul class="basic-menu header-menu">
												<li class="has-submenu kleo-user_avatar-nav my-profile-default">
													<?php
													echo '<a href="#" class="open-submenu">' . kleo_get_avatar();
													echo '<span>';
													$current_user = wp_get_current_user();
													echo esc_html( $current_user->display_name );
													echo '</span>';
													echo '</a><span class="menu-arrow"></span>';
													?>

													<?php
													// Top right navigation menu.
													wp_nav_menu( array(
														'theme_location' => 'top-right',
														'menu_class'     => 'submenu',
														'container'      => false,
														'link_before'    => '',
														'link_after'     => '',
														'depth'          => 4,
														'walker'         => new kleo_walker_nav_menu(),
														'fallback_cb'    => 'kleo_bp_menu',
													) );
													?>
												</li>
											</ul>

										<?php else : ?>

											<div class="show-login">
												<a href="">
													<i class="icon-lock"></i>
													<?php esc_html_e( "Login", 'buddyapp' ); ?>
												</a>
											</div>

										<?php endif; ?>

									<?php
									/* Show my menu horizontally */
									else: ?>

										<?php
										// Top right navigation menu.
										wp_nav_menu( array(
											'theme_location' => 'top-right',
											'menu_class'     => 'basic-menu header-menu',
											'container'      => false,
											'link_before'    => '',
											'link_after'     => '',
											'depth'          => 4,
											'walker'         => new kleo_walker_nav_menu(),
											'fallback_cb'    => 'kleo_bp_menu'
										) );
										?>

									<?php endif; ?>

									<!-- <?php
									// Top second right navigation menu.
									// wp_nav_menu(
									//   array(
									//     'theme_location'  => 'second-top-right', // identifiant du menu, défini dans functions.php
									//     'menu_class'      => 'basic-menu header-menu second-top-nav', // class du menu
									//     'container'      => false,
									//     'echo'            => true, //true si on veut écrire le menu, false pour un simple return
									//     'fallback_cb'     => 'kleo_bp_menu', //fonction de substitution à utiliser si le menu n'existe pas
									//     'before'          => '', // texte à mettre devant le lien
									//     'after'           => '', // texte à mettre après le lien
									//     'link_before'     => '', // texte par lequel commence le lien
									//     'link_after'      => '', // texte par lequel termine le lien
									//     'items_wrap'      => '<ul id="\"%1$s\"" class="\"%2$s\"">%3$s</ul>', //défini la forme du menu (ul, ol, rien...)
									//     'depth'           => 4, // profondeur de menu admise (0 pour no-limit)
									//     'walker'          => new kleo_walker_nav_menu()
									//   )
									// );
									?> -->

									<?php
									/**
									 * If WPML plugin is active, the language sub-menu will show here
									 */

									do_action( 'kleo_header_language' );
									?>

								</div>
								
								
								
							</div>
						</div>
						
						
					   </div>
					</div>
					

			</div>



	</div>

</header><!-- #header end -->
