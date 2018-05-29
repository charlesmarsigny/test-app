<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Kleo
 * @since Kleo 1.0
 */

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('full');
?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php get_template_part( 'page-parts/page-title' ); ?>

<div class="main-content <?php echo Kleo::get_config('container_class'); ?>">

    <article id="post-0" class="post-0 page type-page status-publish hentry">

        <div class="entry-content">
                    
			<div id="buddypress" class="archive-startups">

				<!-- <div id="group-dir-search" class="dir-search" role="search">
					<form action="" method="get" id="search-groups-form">
						<label for="groups_search">
							<input type="text" name="groups_search" id="groups_search" placeholder="Rechercher un groupe...">
						</label>
						<input type="submit" id="groups_search_submit" name="groups_search_submit" value="Rechercher">
					</form>
				</div> --><!-- #group-dir-search -->

					<!-- <div class="item-list-tabs" role="navigation">
						<ul>
							<li class="" id="groups-all"><a href="http://dev.app.youlikestartup.io/groupes/">Toutes les startups <span>1</span></a></li>

												<li id="groups-personal" class="selected"><a href="http://dev.app.youlikestartup.io/members/cms/groups/my-groups/">Mes startups <span>1</span></a></li>
							
							<li id="group-create-nav"><a href="http://dev.app.youlikestartup.io/groupes/create/" title="Créer un groupe" class="group-create no-ajax">Ajouter une startup</a></li>

							
							<li id="groups-order-select" class="last filter">

								<label for="groups-order-by">Trier par:</label>

								<select id="groups-order-by">
									<option value="active">Récemment actifs</option>
									<option value="popular">Le plus de membres</option>
									<option value="newest">Nouvellement créés</option>
									<option value="alphabetical">Par ordre alphabétique</option>

														</select>
							</li>
						</ul>
					</div> -->

					<div id="groups-dir-list" class="groups dir-list">

				
				<ul id="groups-list" class="item-list" style="position: relative; height: 468px;">

					<?php if ( have_posts() ) : ?>

					<?php
							// Start the Loop.
							while ( have_posts() ) : the_post(); ?>
					
					<li class="bp-single-group public is-admin is-member group-has-avatar">
					<a href="<?php the_permalink(); ?>">
						<div class="item-wrap">

							<!-- Cover var -->
					        <?php $cover = get_field('cover_startup'); ?>
							<div class="item-cover has-cover" style="background: <?php if ($cover) { echo 'url(\'' . $cover . '\');'; } else { echo '#CCC;'; } ?> background-repeat: no-repeat; background-size: cover; background-position: center center !important;">
								
								<div class="item-avatar">
									<?php
                                    $logo = get_field('logo_startup');
                                    if ($logo) {
                                        $size = 'thumbnail'; // thumbnail, medium, large, full or custom size : array('160, 160')
                                        echo '<img src="' . wp_get_attachment_image_url( $logo, $size ) . '" class="avatar group-1-avatar avatar-50 photo" alt="<?php the_title(); ?>">';
                                    } else {
                                        $url = content_url( '/themes/kleo-child/img/' );
                                        $fakelogo = "no-logo.png";
                                        echo '<div class="img"><img width="50" height="50" src=" ' . $url . $fakelogo . ' " alt="Aucun logo" class="fake-logo"></div>';
                                    } ?>
								</div>

							</div>
						
						<div class="item">
								
							<!-- Title -->
							<div class="item-title">
								<?php 
								$project_title = get_field('project_name');
								if ($project_title) :
									echo $project_title . '<br><small>';
									the_title();
									echo '</small>';
								else :
									the_title();
								endif; ?>
							</div>
							<!-- Category -->
							<div class="item-meta">
                                <?php
                                $category_startup_term = get_field( 'category_startup' );
                                if ( $category_startup_term ) {
                                    echo '<span class="activity">' . $category_startup_term->name . '</span>';
                                } ?>
                            </div>
							
							<!-- Description -->
							<div class="item-desc">
								<p><?php the_field('excerpt_startup'); ?></p>
							</div>

							<!-- Deal flow -->
							<?php
							$dealflow = get_field('dealflow_process');
							
							if ( $dealflow ) : ?>

							    <div class="wrap-status">

							        <?php // Deal flow app weLikeStartup = Premium
							        if ( $dealflow && in_array('app', $dealflow) && get_field('statut_app_process') == 'premium' ) : ?>
							            <div class="status-bar app-dealflow premium">
							                <div class="left-box">Startup</div>
							                <div class="right-box">Premium</div>
							            </div>
							        <?php endif;

							        // Deal flow weLikeStartup = Campaign
							        if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'campaign' ) : ?>
							            <div class="status-bar wls-dealflow campaign">
							                <div class="left-box">weLikeStartup</div>
							                <div class="right-box">Recherche de fonds</div>
							            </div>
							        <?php endif;

							        // Deal flow weLikeStartup = Closing
							        if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'closing' ) : ?>
							            <div class="status-bar wls-dealflow closing">
							                <div class="left-box">weLikeStartup</div>
							                <div class="right-box">Levée en cours</div>
							            </div>
							        <?php endif;

							        // Deal flow weLikeStartup = Funded
							        if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'funded' ) : ?>
							            <div class="status-bar wls-dealflow funded">
							                <div class="left-box">weLikeStartup</div>
							                <div class="right-box">Financées</div>
							            </div>
							        <?php endif;

							        // Deal flow weRaiseStartup = Accelerate
							        if ( $dealflow && in_array('wrs', $dealflow) && get_field('statut_wrs_process') == 'accelerate'  ) : ?>
							            <div class="status-bar wrs-dealflow accelerate">
							                <div class="left-box">weRaiseStartup</div>
							                <div class="right-box">Accélération</div>
							            </div>
							        <?php endif;

							        // Deal flow weRaiseStartup = Accelerated
							        if ( $dealflow && in_array('wrs', $dealflow) && get_field('statut_wrs_process') == 'accelerated'  ) : ?>
							            <div class="status-bar wrs-dealflow accelerated">
							                <div class="left-box">weRaiseStartup</div>
							                <div class="right-box">Accéléréé</div>
							            </div>
							        <?php endif;

							        // Deal flow iLikeStartup
							        if ( $dealflow && in_array('ils', $dealflow) ) : ?>
							            <div class="status-bar ils-dealflow">
							                <div class="left-box">iLikeStartup</div>
							                <div class="right-box">Inscrite</div>
							            </div>
							        <?php endif;

							        // Deal flow investessor
							        if ( $dealflow && in_array('invest', $dealflow) ) : ?>
							            <div class="status-bar invest-dealflow">
							                <div class="left-box">Investessor</div>
							                <div class="right-box">Inscrite</div>
							            </div>
							        <?php endif; ?>

							    </div>

							<?php endif; ?>
						</div>



						</div><!-- end item-wrap -->
					</a>
					</li>

				<?php endwhile; ?>
				
				</ul>

				
				<div id="pag-bottom" class="pagination">

					<div class="pagination-links" id="group-dir-pag-bottom">
						<?php kleo_pagination( 'pagination pag-type-1' ); ?>
					</div>

				</div>

				<?php endif; ?>

				</div><!-- #groups-dir-list -->

	
			</div><!-- #buddypress -->

        </div><!-- .entry-content -->

    </article><!-- #post-## -->
      
</div>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>