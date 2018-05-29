<?php
/**
 * The Template for displaying all single startup posts
 *
 * @package WordPress
 * @subpackage Kleo
 * @since WLS 1.0
 */

acf_form_head();
get_header();

// The variables
$post_id = get_the_ID();
// echo '<div class="hidden iddd"><pre>';
// var_dump ($post_id);
// echo '</pre></div>';


$current_user = wp_get_current_user();
$allowed_roles = array('administrator', 'webmaster');
$investor_roles = array('app_investor', 'app_premium_investor');
$user_roles = array('app_user', 'app_premium_user');

$members_count = 0;
$team_members = array();
if( have_rows('members_team') ):
	while( have_rows('members_team') ): the_row(); 
		$user_fields = get_sub_field('subscriber_section_team');
		$team_members[$members_count] = $user_fields['ID'];
		$members_count++;
	endwhile;
endif;

// Access variables
$totalaccess = get_field('totalaccess_paricipant');
$projectacces = get_field('projectaccess_paricipant');
$documentaccess = get_field('documentaccess_paricipant');
$owner = get_field('owner_startup');

// Array for groups infos
$groups_user_nav = array();
$groups_user_count = 0;
$groups_admin_nav = array();
$groups_admin_count = 0;
?>

<div id="content" class="tpl-full-width startup">
	<div id="main-container" class="clearfix">

		<div class="main" role="main">
			<div class="content-wrap">
		

<div class="main-content <?php echo Kleo::get_config('container_class'); ?>">
	
	<!-- Start the Loop -->
	<?php while ( have_posts() ) : the_post(); ?>
		
		<!-- Cover var -->
		<?php
		$cover = get_field('cover_startup'); 
		?>

		<style>
			<?php if ($cover) : ?>
				body.single-startup div#item-header #header-cover-image {
					background-image: url('<?php echo $cover; ?>');
					background-repeat: no-repeat;
					background-size: cover;
					background-position: center center !important;
				}
			<?php endif; ?>
		</style>

		<article id="post-0" class="bp_group type-bp_group post-0 page type-page status-publish hentry">

			<div class="entry-content">
						
				<div id="buddypress">
					
					<div id="item-header-wrap">

						<div class="item-scroll-header">

							<div id="item-header" role="complementary">
								
								<?php if ($cover) : ?>
									<div id="header-cover-image"></div><!-- Cover div -->
								<?php endif; ?>
								<div class="profile-cover-inner"></div>
								<!-- <span class="highlight">Groupe Public</span> -->

								<!-- Logo -->
								<div id="item-header-avatar">
									<?php
									$logo = get_field('logo_startup');
									if ($logo) {
										$size = 'medium'; // (thumbnail, medium, large, full or custom size)
										echo '<img width="150" height="150" src="' . wp_get_attachment_url( $logo, $size ) . '" class="avatar group-1-avatar avatar-150 photo" alt="Logo du groupe Goupe test 1" title="Goupe test 1">';
									} else {
										$url = content_url( '/themes/kleo-child/img/' );
										$fakelogo = "no-logo.png";
										echo '<div class="img"><img width="150" height="150" src=" ' . $url . $fakelogo . ' " alt="Aucun logo" class="fake-logo"></div>';
									} ?>
								</div>
								<!-- /logo -->

								<div id="item-header-content">
									<?php 
									$project_title = get_field('project_name');
									if ($project_title) :
										the_title('<h1 class="startup-title">', '<br><small>' . $project_title . '</small></h1>');
									else :
										the_title('<h1 class="startup-title">', '</h1>');
									endif; ?>
									
									<!-- Category -->
									<?php
									$category_startup_term = get_field( 'indexing_startup' );
									if ( $category_startup_term ) {
										if ( $category_startup_term['category1_startup']->name && !$category_startup_term['category2_startup']->name ) {
											echo '<span class="activity">' . $category_startup_term['category1_startup']->name . '</span>';
										} elseif ( !$category_startup_term['category1_startup']->name && $category_startup_term['category2_startup']->name ) {
											echo '<span class="activity">' . $category_startup_term['category2_startup']->name . '</span>';
										} elseif ( $category_startup_term['category1_startup']->name && $category_startup_term['category2_startup']->name ) {
											echo '<span class="activity">' . $category_startup_term['category1_startup']->name . ", " . $category_startup_term['category2_startup']->name . '</span>';
										}
									} ?>

									
									<div id="item-meta">

										<div id="item-buttons">
											
											<?php if (is_user_logged_in()) : ?>
												<div class="modified-date">
													<small>Dernière modification</small><br>
													<strong><?php the_modified_date('j F Y'); ?></strong>
												</div>
											<?php endif; ?>
											
										</div><!-- #item-buttons -->

										
									</div>
								</div><!-- #item-header-content -->

								<div id="item-actions">

									<!-- Social Nework -->
									<div class="social-network">
										
										<?php
										$facebook = get_field('facebook_startup');
										$twitter = get_field('twitter_startup');
										$linkedin = get_field('linkedin_startup');
										$google = get_field('google_startup');
										$pinterest = get_field('pinterest_startup');
										$instagram = get_field('instagram_startup');
										if ( $facebook || $twitter || $linkedin || $google || $pinterest || $instagram ) : ?>
											<h3>Réseaux sociaux</h3>
											<ul id="social">
												<?php if ($facebook) : ?><li class="facebook-startup"><a href="<?php echo $facebook; ?>" title="Page facebook"><i class="icon-facebook"></i></a></li><?php endif; ?>
												<?php if ($twitter) : ?><li class="twitter-startup"><a href="<?php echo $twitter; ?>" title="Page twitter"><i class="icon-twitter"></i></a></li><?php endif; ?>
												<?php if ($linkedin) : ?><li class="linkedin-startup"><a href="<?php echo $linkedin; ?>" title="Page linkedin"><i class="icon-linkedin"></i></a></li><?php endif; ?>
												<?php if ($google) : ?><li class="google-startup"><a href="<?php echo $google; ?>" title="Page google"><i class="icon-googleplus"></i></a></li><?php endif; ?>
												<?php if ($pinterest) : ?><li class="pinterest-startup"><a href="<?php echo $pinterest; ?>" title="Page pinterest"><i class="icon-pinterest"></i></a></li><?php endif; ?>
												<?php if ($instagram) : ?><li class="instagram-startup"><a href="<?php echo $instagram; ?>" title="Page instagram"><i class="icon-instagram"></i></a></li><?php endif; ?>
											</ul>
										<?php endif; ?>
									</div>
									<!-- /Social Nework -->

								</div><!-- #item-actions -->
						

							</div><!-- #item-header -->

							<!-- Edit -->
							<?php
							if( array_intersect($allowed_roles, $current_user->roles ) || $current_user->ID == $post->post_author || ( ($owner && in_multi_array($current_user->ID, $owner) == true) && array_intersect($user_roles, $current_user->roles) ) ) : ?>
								<div class="item-edit">
									<a href="<?php echo esc_url( add_query_arg( array('id' => $post_id), '/actions/mod-startup/' ) ); ?>">Modifier</a>
								</div>
							<?php endif; ?>

							<div id="item-nav">
								<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">

									<ul id="global-startup" class="etabs">
										<?php
										// Count variables
										$news_count = count( get_field('linked_actualite_startup') );
										$comments_count = wp_count_comments($post_id);
										$documents_count = count( get_field('linked_doc_startup') );
										// $groups_count = count( get_field('linked_group_startup') );
										$intentions_count = count( get_field('linked_intention_startup') );
										$liquidities_count = count( get_field('linked_liquidite_startup') );

										// Process variable
										$dealflow = get_field('dealflow_process');

										// URLs variables
										$pitch_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/pitch/' ) );
										$comment_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/commentaires/' ) );
										$project_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/projet/' ) );
										$team_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/equipe/' ) );
										$group_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/groupes/' ) );
										$intention_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/intentions/' ) );
										$liquidity_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/liquidites/' ) );

										$management_test_url = esc_url( add_query_arg( array('id' => $post_id), '/startup-page/groupes/management-test/' ) );

										// Icons
										$lock_icon = 'lock-14';
										$unlock_icon = 'lock-unlock-1';
										$hide_icon = 'hide';

										// Menu names
										$pitch_name = 'Pitch';
										$comment_name = 'Commentaires';
										$comment_invest_name = 'Commentaires publics';
										$projet_name = 'Projet';
										$team_name = 'Équipe';
										$intention_name = 'Intentions';
										$liquidity_name = 'Liquidité';

										?>


										<!-- Pitch tab menu -->

										<li id="pitch-li" class="tab">
											<a id="pitch-tab" href="<?php echo $pitch_url; ?>" data-target="#pitch">Pitch</a>
										</li>

										<!-- Pitch tab menu -->

										<!-- Comment tab menu -->

										<li id="comments-li" class="tab">
											<a id="comments-tab" href="<?php echo $comment_url; ?>" data-target="#commentaires">
											<?php if( array_intersect($investor_roles, $current_user->roles ) ) {
												echo $comment_invest_name;
											} else {
												echo $comment_name;
											}
											if ( $comments_count->approved > 0 ) { echo '<span>' . $comments_count->approved . '</span>'; } ?>
											</a>
										</li>

										<!-- Comment tab menu -->


										<!-- **************** -->
										<!-- Project tab menu -->
										<!-- **************** -->

										<?php
										if (!is_user_logged_in()) :

											echo '<li id="project-li" class="lock">
													  <a id="project-tab" href="' . $project_url . '" data-target="#projet"><i class="icon-' . $lock_icon . '"></i>' . $projet_name . '</a>
												  </li>';

										else : // ELSE user logged
										
											if( ( $dealflow && in_array('wls', $dealflow) // IF dealflow wls
												&& ( get_field('statut_wls_process') == 'campaign'  
												|| get_field('statut_wls_process') == 'closing' 
												|| get_field('statut_wls_process') == 'funded') ) 
												|| ( $dealflow && in_array('wrs', $dealflow) ) ) : // IF dealflow wrs

												// IF ACCESS
												if ( is_user_logged_in() // IF connected user
													&& ($totalaccess && in_multi_array($current_user->ID, $totalaccess)) // AND IF total access
													|| ($projectacces && in_multi_array($current_user->ID, $projectacces)) // OR IF project access
													|| ($current_user->roles[0] == 'app_premium_investor' ) // OR IF premium investor
													|| array_intersect($allowed_roles, $current_user->roles ) // OR IF allowed roles
													|| (!empty($owner) && in_multi_array($current_user->ID, $owner) == true) // OR IF owner 
													|| ( !empty($team_members) && in_multi_array($current_user->ID, $team_members) == true ) // OR IF team member
													) :
													echo '<li id="project-li" class="tab">
															  <a id="project-tab" href="' . $project_url . '" data-target="#projet"><i class="icon-' . $unlock_icon . '"></i>' . $projet_name . '</a>
														  </li>';

												else : // LOCK
													echo '<li id="project-li" class="lock">
															  <a id="project-tab" href="' . $project_url . '" data-target="#projet"><i class="icon-' . $lock_icon . '"></i>' . $projet_name . '</a>
														  </li>';

												endif;

											// ELSEIF Admin or Webmaster (no logic dealflow view)
											elseif( is_user_logged_in() && array_intersect($allowed_roles, $current_user->roles ) ) :
												echo '<li id="project-li" class="tab">
														  <a id="project-tab" href="' . $project_url . '" data-target="#projet"><i class="icon-' . $hide_icon . '"></i>' . $projet_name . '</a>
													  </li>';

											else : // LOCK
												echo '<li id="project-li" class="lock">
														  <a id="project-tab" href="' . $project_url . '" data-target="#projet"><i class="icon-' . $lock_icon . '"></i>' . $projet_name . '</a>
													  </li>';

											endif;

										endif; ?>

										<!-- /Project tab menu -->


										<!-- ************* -->
										<!-- Team tab menu -->
										<!-- ************* -->
										
										<?php
										if (!is_user_logged_in()) :

											echo '<li id="team-li" class="lock">
													  <a id="team-tab" href="' . $team_url . '" data-target="#equipe"><i class="icon-' . $lock_icon . '"></i>' . $team_name . '</a>
												  </li>';

										else : // ELSE user logged

											if( ( $dealflow && in_array('wls', $dealflow) // IF dealflow wls
												&& (get_field('statut_wls_process') == 'campaign'  
												|| get_field('statut_wls_process') == 'closing' 
												|| get_field('statut_wls_process') == 'funded') ) 
												|| ( $dealflow && in_array('wrs', $dealflow) ) ) : // IF dealflow wrs

												// IF ACCESS
												if ( is_user_logged_in() // IF connected user
													&& ($totalaccess && in_multi_array($current_user->ID, $totalaccess)) // AND IF total access
													|| ($projectacces && in_multi_array($current_user->ID, $projectacces)) // OR IF project access
													|| ($current_user->roles[0] == 'app_premium_investor' ) // OR IF premium investor
													|| array_intersect($allowed_roles, $current_user->roles ) // OR IF allowed roles
													|| ( !empty($owner) && in_multi_array($current_user->ID, $owner) == true ) // OR IF owner 
													|| ( !empty($team_members) && in_multi_array($current_user->ID, $team_members) == true ) // OR IF team member
													) :
													echo '<li id="team-li" class="tab">
															  <a id="team-tab" href="' . $team_url . '" data-target="#equipe"><i class="icon-' . $unlock_icon . '"></i>' . $team_name . '</a></a>
														  </li>';

												else : // LOCK 
													echo '<li id="team-li" class="lock">
															  <a id="team-tab" href="' . $team_url . '" data-target="#equipe"><i class="icon-' . $lock_icon . '"></i>' . $team_name . '</a>
														  </li>';

												endif;

											// ELSEIF Admin or Webmaster
											elseif( is_user_logged_in() && array_intersect($allowed_roles, $current_user->roles ) ) :
												echo '<li id="team-li" class="tab">
														  <a id="team-tab" href="' . $team_url . '" data-target="#equipe"><i class="icon-' . $hide_icon . '"></i>' . $team_name . '</a>
														</li>';

											else : // LOCK
												echo '<li id="team-li" class="lock">
														  <a id="team-tab" href="' . $team_url . '" data-target="#equipe"><i class="icon-' . $lock_icon . '"></i>' . $team_name . '</a>
													  </li>';

											endif;

										endif; ?>
												
										<!-- /Team tab menu -->


										<!-- Group tab menu -->

										<?php if (!is_user_logged_in()) : ?>

											<!-- <li id="groups-toggle" class="locked">
												<span class="group-span"><i class="icon-lock"></i>Groupes bloqués</span>
											</li> -->

											<li id="groups-toggle" class="lock">
												<a id="groups-tab-lock" href="/startup-page/gp-accueil" data-target="#groupes-lock"><i class="icon-<?= $lock_icon ?>"></i>Groupes</a>
											</li>

										<?php else : // ELSE user logged
											
												/* Group data retrieval */
												if( have_rows('startup_groups') ) :
													while ( have_rows('startup_groups') ) : the_row();

														// Group ID
														$group_id = get_sub_field('group_select_field');

														// Group type (campagne, closing...)
														$group_type = bp_groups_get_group_type($group_id);
														// echo '<div class="hidden azerty" style="display:none;">';
														// echo var_dump($group_type);
														// echo '</div>';
														if ($group_type =="acceleration") {
															$group_type = "Accélération";
														} elseif ($group_type =="campagne") {
															$group_type = "Campagne";
														} elseif ($group_type == 'closing') {
															$group_type = "Closing";
														} elseif ($group_type == "actionnaires") {
															$group_type = "Actionnaires";
														} elseif ($group_type == 'sortie') {
															$group_type = "Sortie";
														}
														// Group type displayed
														if ( get_sub_field('if_custom_nav_groupname') ) {
															$group_type = get_sub_field('custom_nav_groupname');
														} elseif ( $group_type == '' ) {
															$group_type = 'Sans type'; 
														}

														// Group Object
														$group_object = new BP_Groups_Group($group_id);

														// Group status (public, privé, masqué)
														$group_status = bp_get_group_type($group_object);
														if ($group_status =="Groupe Public") {
															$group_status = "Public";
														} elseif ($group_status =="Groupe Privé") {
															$group_status = "Privé";
														} elseif ($group_status == "Groupe Masqué") {
															$group_status = "Masqué";
														}

														// GET Parameter from group_redirect function in functions.php
														$group_request = '0';
														if ( $_GET['request-group'] && $_GET['request-group'] == 'documents' ) {
															$group_request = 'documents';
														} elseif ( $_GET['request-group'] && $_GET['request-group'] == 'membership-requests' ) {
															$group_request = 'membership-requests';
														} elseif ( $_GET['request-group'] && strstr($_GET['request-group'], 'activity-' ) ) {
															$group_request = htmlspecialchars($_GET['request-group']);
														} elseif ( $_GET['request-group'] && strstr($_GET['request-group'], 'acomment-' ) ) {
															$group_request = htmlspecialchars($_GET['request-group']);
														}

														echo '<div class="hidden trrruc" style="display:none;">';
														var_dump($_GET);
														echo'</div>';
														
														// Group URL for template with iframe
														$group_home_url = esc_url( add_query_arg( array(
															'id' => $group_id,
															'request-group' => $group_request
														), '/startup-page/gp-accueil' ) );

														// Filling tables for groups nav
														if( $group_status != "Masqué" ) : // IF user : 
															$groups_user_nav[$groups_user_count]['id'] = $group_id;
															$groups_user_nav[$groups_user_count]['type'] = $group_type;
															$groups_user_nav[$groups_user_count]['status'] = $group_status;
															$groups_user_nav[$groups_user_count]['url'] = $group_home_url;
															$groups_user_count++;
														endif;
														$groups_admin_nav[$groups_admin_count]['id'] = $group_id;
														$groups_admin_nav[$groups_admin_count]['type'] = $group_type;
														$groups_admin_nav[$groups_admin_count]['status'] = $group_status;
														$groups_admin_nav[$groups_admin_count]['url'] = $group_home_url;
														$groups_admin_count++;

													endwhile;
												endif;
												/* /Group data retrieval */
												
												/* Group nav for Admin and Webmaster (can show hidden group) */
												if ( array_intersect($allowed_roles, $current_user->roles) ) :
													if( $groups_admin_count == 1 ) : ?>
														<li id="groups-toggle" class="tab">
															<a id="groups-tab-<?php echo $groups_admin_nav[0]['id']; ?>" href="<?php echo $groups_admin_nav[0]['url'] ?>" data-target="#groupe-<?php echo $groups_admin_nav[0]['id']; ?>">
																<div class="group-div"><!-- <i class="icon-visibility-off"> --></i>Groupe</div>															
																<ul>
																	<li class="group-li tab-group-type">
																		<?php echo $groups_admin_nav[0]['type']; ?>
																		<span class="group-status"><?php echo $groups_admin_nav[0]['status']; ?></span>
																	</li>
																</ul>
															</a>
															<span class="group-arrow"></span>
														</li>

													<?php elseif( $groups_admin_count > 1) : ?>
														<li id="groups-toggle" class="">
															<span class="group-span"><!-- <i class="icon-visibility-off"> --></i>Groupes</span>
															<span class="group-arrow"></span>
															<ul>
															<?php for( $i=0; $i<$groups_admin_count; $i++ ) : ?>
																<li id="groups-toggle-<?php echo $groups_admin_nav[$i]['id']; ?>" class="tab tab-group-type">
																	<a id="groups-tab-<?php echo $groups_admin_nav[$i]['id']; ?>" href="<?php echo $groups_admin_nav[$i]['url'] ?>" data-target="#groupe-<?php echo $groups_admin_nav[$i]['id']; ?>">
																		<?php echo $groups_admin_nav[$i]['type']; ?>
																		<span class="group-status" style="top:5px;"><?php echo $groups_admin_nav[$i]['status']; ?></span>
																	</a>
																</li>
															<?php endfor; ?>
															</ul>
														</li>
													<?php endif; 
												/* /END Group nav for Admin and Webmaster */

												/* Group nav for other user */
													?>
												<?php else :
													if( $groups_user_count == 1 ) : ?>
														<li id="groups-toggle" class="tab">
															<a id="groups-tab-<?php echo $groups_user_nav[0]['id']; ?>" href="<?php echo $groups_user_nav[0]['url'] ?>" data-target="#groupe-<?php echo $groups_user_nav[0]['id']; ?>">
																<div class="group-div">Groupe</div>															
																<ul>
																	<li class="group-li tab-group-type">
																		<?php echo $groups_user_nav[0]['type']; ?>
																		<span class="group-status"><?php echo $groups_user_nav[0]['status']; ?></span>
																	</li>
																</ul>
															</a>
															<span class="group-arrow"></span>
														</li>

													<?php elseif( $groups_user_count > 1) : ?>
														<li id="groups-toggle" class="">
															<span class="group-span">Groupes</span>
															<span class="group-arrow"></span>
															<ul>
															<?php for( $i=0; $i<$groups_user_count; $i++ ) : ?>
																<li id="groups-toggle-<?php echo $groups_user_nav[$i]['id']; ?>" class="tab tab-group-type">
																	<a id="groups-tab-<?php echo $groups_user_nav[$i]['id']; ?>" href="<?php echo $groups_user_nav[$i]['url'] ?>" data-target="#groupe-<?php echo $groups_user_nav[$i]['id']; ?>">
																		<?php echo $groups_user_nav[$i]['type']; ?>
																		<span class="group-status" style="top:5px;"><?php echo $groups_user_nav[$i]['status']; ?></span>
																	</a>
																</li>
															<?php endfor; ?>
															</ul>
														</li>
													<?php endif; ?>
												<?php endif; 
												/* /END Group nav for other user */
												?>													

										<?php endif; ?>

										<!-- /Group tab menu-->

										
										<!-- ****************** -->
										<!-- Intention tab menu -->
										<!-- ****************** -->

										<?php if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'closing' ) :
										
											// IF ACCESS
											if ( is_user_logged_in() // IF connected user
												&& ($totalaccess && in_multi_array($current_user->ID, $totalaccess)) // AND IF total access
												|| ($current_user->roles[0] == 'app_premium_investor' ) // OR IF premium investor
												|| array_intersect($allowed_roles, $current_user->roles ) // OR IF allowed roles
												) :
												echo '<li id="intentions-li" class="tab">
														  <a id="intention-tab" href="' . $intention_url . '" data-target="#intentions"><i class="icon-' . $unlock_icon . '"></i>' . $intention_name;
												if ( $intentions_count > 0 ) { echo '<span>' . $intentions_count . '</span>'; }
												echo '</a></li>';

											else : // LOCK
												echo '<li id="intentions-li" class="lock">
														  <a id="intention-tab" href="' . $intention_url . '" data-target="#intentions"><i class="icon-' . $lock_icon . '"></i>' . $intention_name . '</a>
													  </li>';

											endif;

										// ELSEIF Admin or Webmaster
										elseif( is_user_logged_in() && array_intersect($allowed_roles, $current_user->roles ) ) :
											echo '<li id="intentions-li" class="tab">
													  <a id="intention-tab" href="' . $intention_url . '" data-target="#intentions"><i class="icon-' . $hide_icon . '"></i>' . $intention_name;
											if ( $intentions_count > 0 ) { echo '<span>' . $intentions_count . '</span>'; }
											echo '</a></li>';

										endif; ?>

										<!-- /Intention tab menu -->


										<!-- ****************** -->
										<!-- Liquidity tab menu -->
										<!-- ****************** -->

										<?php // IF Deal flow WLS
										if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'funded' ) :

											// IF ACCESS
											if ( is_user_logged_in() // IF connected user
												&& ($totalaccess && in_multi_array($current_user->ID, $totalaccess)) // AND IF total access
												|| ($current_user->roles[0] == 'app_premium_investor' ) // OR IF premium investor
												|| array_intersect($allowed_roles, $current_user->roles ) // OR IF allowed roles
												) :
												echo '<li id="liquidities-li" class="tab">
														  <a id="liquidity-tab" href="' . $liquidity_url . '" data-target="#liquidites">' . $liquidity_name;
												if ( $liquidities_count > 0 ) { echo '<span>' . $liquidities_count . '</span>'; }
												echo '</a></li>';

											else : // LOCK
											echo '<li id="liquidities-li" class="lock">
													  <a id="liquidity-tab" href="' . $liquidity_url . '" data-target="#liquidites"><i class="icon-' . $lock_icon . '"></i>' . $liquidity_name . '</a>
												  </li>';

											 endif;

										// ELSEIF Admin or Webmaster
										elseif( array_intersect($allowed_roles, $current_user->roles ) ) :
											echo '<li id="liquidities-li" class="tab">
												<a id="liquidity-tab" href="' . $liquidity_url . '" data-target="#liquidites"><i class="icon-' . $hide_icon . '"></i>' . $liquidity_name;
											if ( $liquidities_count > 0 ) { echo '<span>' . $liquidities_count . '</span>'; }
											echo '</a></li>';

										endif; ?>

										<!-- /Liquidity tab menu -->

									</ul>
								</div>
							</div><!-- #item-nav -->

						</div><!-- .item-scroll-header -->

					</div><!-- #item-header-wrap -->


					<!-- startup body -->
					<div id="item-body">

						<?php
						$dealflow = get_field('dealflow_process');

						
						if ( $dealflow ) : ?>

							<div class="wrap-status">

								<?php // Deal flow app weLikeStartup = Premium
								if ( $dealflow && in_array('app', $dealflow) && get_field('statut_app_process') == 'premium' ) : ?>
									<!-- <div class="status-bar app-dealflow premium">
										<div class="left-box">Startup</div>
										<div class="right-box">Premium</div>
									</div> -->
								<?php endif;

								// Deal flow weLikeStartup = Campaign
								if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'campaign' ) : ?>
									<!-- <div class="status-bar wls-dealflow campaign">
										<div class="left-box">weLikeStartup</div>
										<div class="right-box">Recherche de fonds</div>
									</div> -->
								<?php endif;

								// Deal flow weLikeStartup = Closing
								if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'closing' ) : ?>
									<!-- <div class="status-bar wls-dealflow closing">
										<div class="left-box">weLikeStartup</div>
										<div class="right-box">Levée en cours</div>
									</div> -->
								<?php endif;

								// Deal flow weLikeStartup = Funded
								if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'funded' ) : ?>
									<!-- <div class="status-bar wls-dealflow funded">
										<div class="left-box">weLikeStartup</div>
										<div class="right-box">Financées</div>
									</div> -->
								<?php endif;

								// Deal flow weRaiseStartup = Accelerate
								if ( $dealflow && in_array('wrs', $dealflow) && get_field('statut_wrs_process') == 'accelerate'  ) : ?>
									<!-- <div class="status-bar wrs-dealflow accelerate">
										<div class="left-box">weRaiseStartup</div>
										<div class="right-box">Accélération</div>
									</div> -->
								<?php endif;

								// Deal flow weRaiseStartup = Accelerated
								if ( $dealflow && in_array('wrs', $dealflow) && get_field('statut_wrs_process') == 'accelerated'  ) : ?>
									<!-- <div class="status-bar wrs-dealflow accelerated">
										<div class="left-box">weRaiseStartup</div>
										<div class="right-box">Accéléréé</div>
									</div> -->
								<?php endif;

								// Deal flow iLikeStartup
								if ( $dealflow && in_array('ils', $dealflow) ) : ?>
									<!-- <div class="status-bar ils-dealflow">
										<div class="left-box">iLikeStartup</div>
										<div class="right-box">Inscrite</div>
									</div> -->
								<?php endif;

								// Deal flow investessor
								if ( $dealflow && in_array('invest', $dealflow) ) : ?>
									<!-- <div class="status-bar invest-dealflow">
										<div class="left-box">Investessor</div>
										<div class="right-box">Inscrite</div>
									</div> -->
								<?php endif; ?>

							</div>

						<?php endif; ?>


						<!-- TAB Pitch -->
						<div id="pitch" class="item-tab"></div>
						<!-- /TAB Pitch -->

						<!-- TAB Comments -->
						<div id="commentaires" class="item-tab"></div>
						<!-- /TAB Comments -->

						<!-- TAB Project -->
						<div id="projet" class="item-tab"></div>
						<!-- /TAB Project -->

						<!-- TAB Team -->
						<div id="equipe" class="item-tab"></div>
						<!-- /TAB Team -->

						<!-- TAB Groups lock -->
						<div id="groupes-lock" class="item-tab"></div>
						<!-- /TAB Groups lock -->

						<?php for( $i=0; $i<$groups_admin_count; $i++ ) : ?>
							<div id="groupe-<?php echo $groups_admin_nav[$i]['id']; ?>" class="item-tab group-tab"></div>
						<?php endfor; ?>
						
						<!-- TAB Intentions -->
						<div id="intentions" class="item-tab"></div>
						<!-- /TAB Intentions -->

						<!-- TAB Liquidites -->
						<div id="liquidites" class="item-tab"></div>
						<!-- /TAB Liquidites -->

						<!-- TAB Edit -->
						<!-- <div id="modifier" class="item-tab"></div> -->
						<!-- /TAB Edit -->

						<?php
						// Previous/next post navigation.
						kleo_post_nav();
						?>

					</div><!-- /startup body -->  
					
				</div><!-- #buddypress -->
			</div><!-- .entry-content -->

		</article><!-- #post-## -->

	<?php endwhile; ?>
		
</div>
		
		   
			</div><!--end .content-wrap-->
		</div><!--end .main-->

		
	</div><!--end #main-container-->
</div>
<!--END MAIN SECTION-->

<script type="text/javascript">
	(function($) {

	  $('#object-nav')
		.easytabs({
		  panelContext: $(document),
		  tabs: 'ul#global-startup li.tab, ul#global-startup li.lock',
		  transitionIn: 'fadeIn',
		  transitionOut: 'fadeOut',
		  tabActiveClass: 'current'
		})
		.bind('easytabs:ajax:complete', function(e, $clicked, $targetPanel, settings) {
		  if ( $targetPanel.get(0).id === 'commentaires' ) {
			$.scrollTo($targetPanel, 800);
		  }
		  if ( $targetPanel.get(0).id === 'projet' ) {
			$.scrollTo($targetPanel, 800);
		  }
		  if ( $targetPanel.get(0).id === 'equipe' ) {
			$.scrollTo($targetPanel, 800);
		  }
		  if ( $targetPanel.get(0).id === 'groupes-lock' ) {
			$.scrollTo($targetPanel, 800);
		  }

		  <?php for( $i=0; $i<$groups_admin_count; $i++ ) : ?>
		    if ( $targetPanel.get(0).id === 'groupe-<?php echo $groups_admin_nav[$i]['id']; ?>' ) {
		  		$.scrollTo($targetPanel, 800);
		    }
		  <?php endfor; ?>
		  
		  if ( $targetPanel.get(0).id === 'intentions' ) {
			$.scrollTo($targetPanel, 800);
		  }
		  if ( $targetPanel.get(0).id === 'liquidites' ) {
			$.scrollTo($targetPanel, 800);
		  }
		  // if ( $targetPanel.get(0).id === 'modifier' ) {
		  //   $.scrollTo($targetPanel, 800);
		  // }
		});

		// Toggle nav groups
		$(document).ready(function(){
			$(".tab-group-type").hide();
		    $(".group-span").click(function(){
		    	$("#groups-toggle").toggleClass( "open-group" );
		        $(".tab-group-type").toggle();
		    });
		    $(".group-div").click(function(){
		    	$("#groups-toggle").toggleClass( "open-group" );
		        $(".tab-group-type").toggle();
		    });
		    $(".group-iframe").load(function(){
		    	$("#groups-toggle").toggleClass( "open-group" );
		        $(".tab-group-type").toggle();
		    });
		    /* Marche pas */
		    // if( $(".group-iframe").length > 0 ) {
		    // 	$("#groups-toggle").toggleClass( "open-group" );
		    //     $(".tab-group-type").toggle();
		    // }
		    // $(".group-tab").on('load', '.group-iframe', function(){
		    // 	$("#groups-toggle").toggleClass( "open-group" );
		    //     $(".tab-group-type").toggle();
		    // });
		    $(".group-arrow").click(function(){
		    	$("#groups-toggle").toggleClass( "open-group" );
		        $(".tab-group-type").toggle();
		    });
		});


	})(jQuery);

	<?php
		if ( $_POST['chat-intentions'] && $_POST['chat-intentions'] == 'active' ) {
			unset($_POST['chat-intentions']);
			$permalink = get_permalink( get_the_ID() ); ?>
			document.onreadystatechange = function () {
				if (document.readyState == "complete") {
					window.setTimeout('location=("<?= $permalink ?>#intentions");',2000);
				}
			}
		<?php 
		} 
		if ( $_POST['chat-projet'] && $_POST['chat-projet'] == 'active' ) {
			unset($_POST['chat-projet']);
			$permalink = get_permalink( get_the_ID() ); ?>
			document.onreadystatechange = function () {
				if (document.readyState == "complete") {
					window.setTimeout('location=("<?= $permalink ?>#projet");',2000);
				}
			}
		<?php 
		} 
		if ( $_POST['chat-equipe'] && $_POST['chat-equipe'] == 'active' ) {
			unset($_POST['chat-equipe']);
			$permalink = get_permalink( get_the_ID() ); ?>
			document.onreadystatechange = function () {
				if (document.readyState == "complete") {
					window.setTimeout('location=("<?= $permalink ?>#equipe");',2000);
				}
			}
		<?php 
		} ?>
</script>


<?php get_footer(); ?>