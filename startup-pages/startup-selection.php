<?php

/**
 * Template Name: Startup selection
 *
 * Description: Template Repeater loop for startup collections
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

get_header(); ?>

<?php
//create full width template
kleo_switch_layout('full');
?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php get_template_part( 'page-parts/page-title' ); ?>



<?php function queryloop($select, $action) {

	// The variables


	// The Query
	$select_query = new WP_Query($select);

	// The Loop
	if($select_query->have_posts()) :
		while ( $select_query->have_posts() ) : $select_query->the_post(); ?>
		
			<li class="bp-single-group public is-admin is-member group-has-avatar">
				<?php if( $action == 'page') {
					echo '<a href="' . get_permalink() . '">';
				} elseif( $action == 'summary') {
					// content
				} elseif( $action == 'editorial') {
					// content
				} ?>
					<div class="item-wrap">

						<!-- Cover var -->
						<?php $cover = get_field('cover_startup'); ?>
						<div class="item-cover has-cover" style="background: <?php if ($cover) { echo 'url(\'' . $cover . '\');'; } else { echo '#CCC;'; } ?> background-repeat: no-repeat; background-size: cover; background-position: center center !important;">
									
							<div class="item-avatar">
									<?php
									$logo = get_field('logo_startup');
									if ($logo) {
										$size = array('50, 50'); // (thumbnail, medium, large, full or custom size)
										echo '<img width="50" height="50" src="' . wp_get_attachment_url( $logo, $size ) . '" class="avatar group-1-avatar avatar-50 photo" alt="Logo du groupe Goupe test 1" title="Goupe test 1">';
									} else {
										$url = content_url( '/themes/kleo-child/img/' );
										$fakelogo = "no-logo.png";
										echo '<div class="img"><img width="50" height="50" src=" ' . $url . $fakelogo . ' " alt="Aucun logo" class="fake-logo"></div>';
									} ?>
							</div>

						</div>
							
						<div class="item-overlay">
							<div class="item">
											
								<!-- Title -->
								<div class="item-title">
									<?php 
									$project_title = get_field('project_name');
									if ($project_title) :
										the_title();
										echo '<br><small>';
										echo $project_title;
										echo '</small>';
									else :
										the_title();
									endif; ?>
								</div>

								<!-- Category -->
								   <?php
									$category_startup_term = get_field( 'indexing_startup' );
									if ( $category_startup_term ) {
										echo '<div class="item-meta">';
										if ( $category_startup_term['category1_startup']->name && !$category_startup_term['category2_startup']->name ) {
											echo '<span class="activity">' . $category_startup_term['category1_startup']->name . '</span>';
										} elseif ( !$category_startup_term['category1_startup']->name && $category_startup_term['category2_startup']->name ) {
											echo '<span class="activity">' . $category_startup_term['category2_startup']->name . '</span>';
										} elseif ( $category_startup_term['category1_startup']->name && $category_startup_term['category2_startup']->name ) {
											echo '<div class="item-activity"><span class="activity">' . $category_startup_term['category1_startup']->name . '</span><span class="activity">' . $category_startup_term['category2_startup']->name . '</span></div>';
										}
										echo '</div>';
									} ?>

								<!-- Description -->
								<div class="item-desc">
									<?php the_field('excerpt_startup'); ?>
								</div>

							</div>
						</div>

					</div><!-- end item-wrap -->
				<?php if( $action == 'page') {
					echo '</a>';
				} elseif( $action == 'summary') {
					// content
				} elseif( $action == 'editorial') {
					// content
				} ?>
			</li>

		<?php endwhile;

		// Restore original Post Data
		wp_reset_postdata();

	endif;
		
} ?>



<div class="main-content <?php echo Kleo::get_config('container_class'); ?> inline-scroll-content">

	<article id="post-0" class="post-0 page type-page status-publish hentry">

		<div class="entry-content">
					
			<div id="buddypress" class="startup-selection">

				<!-- <div id="group-dir-search" class="dir-search" role="search">
					<form action="" method="get" id="search-groups-form">
						<label for="groups_search">
							<input type="text" name="groups_search" id="groups_search" placeholder="Rechercher un groupe...">
						</label>
						<input type="submit" id="groups_search_submit" name="groups_search_submit" value="Rechercher">
					</form>
				</div> -->

					<?php

					// check if the flexible content field has rows of data
					if ( have_rows('flexiblecontent_selection_startups') ):

						// loop through the rows of data
						while ( have_rows('flexiblecontent_selection_startups') ) : the_row();


							if ( get_row_layout() == 'collection_startups' ) : // Selection by collection
								
								// Var
								$custom_collection_title = get_sub_field('title_collection_startup_field');
								$collection = get_sub_field('collection_startup_field');
								$collection_order = get_sub_field('collection_order_startup_field');
								$collection_sort = get_sub_field('collection_sort_startup_field');
								$collection_display = get_sub_field('collection_display_startup_field');
								$collection_quantity = get_sub_field('collection_quantity_startup_field');
								$collection_action = get_sub_field('collection_action_startup_field');
								
								// Title
								echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
								if ( $custom_collection_title ) :
									echo $custom_collection_title;
								else :
									echo $collection->name;
								endif;
								echo '</h3>';
								// <ul id="groups-list"> for Masonry view
								echo '<ul id="groups-inline-list" class="item-list ' . $collection_display . '" style="position: relative; height: 468px;">';

								// Parameters
								$collection_args = array(
									'post_type' => 'startup',
									'tax_query' => array(
											array(
												'taxonomy' => $collection->taxonomy,
												'field'    => 'term_id',
												'terms'    => $collection->term_id,
											),
										),
									'posts_per_page' => $collection_quantity,
									'orderby'   => $collection_order,
									'order'		=> $collection_sort,
									'suppress_filters'	 => false,
									'fields'			 => ''
								);

								// Function
								queryloop($collection_args, $collection_action);

								echo '</ul></div>';


							elseif ( get_row_layout() == 'category_startups' ) : // Selection by category
								
								// Var
								$custom_category_title = get_sub_field('title_category_startup_field');
								$category = get_sub_field('category_startup_field');
								$category_order = get_sub_field('category_order_startup_field');
								$category_sort = get_sub_field('category_sort_startup_field');
								$category_display = get_sub_field('category_display_startup_field');
								$category_quantity = get_sub_field('category_quantity_startup_field');
								$category_action = get_sub_field('category_action_startup_field');

								// Title
								echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
								if ( $custom_category_title ) :
									echo $custom_category_title;
								else :
									echo $category->name;
								endif;
								echo '</h3>';
								// <ul id="groups-list"> for Masonry view
								echo '<ul id="groups-inline-list" class="item-list ' . $category_display . '" style="position: relative; height: 468px;">';

								// Parameters
								$category_args = array(
									'post_type' => 'startup',
									'tax_query' => array(
											array(
												'taxonomy' => $category->taxonomy,
												'field'    => 'term_id',
												'terms'    => $category->term_id,
											),
										),
									'posts_per_page' => $category_quantity,
									'orderby'   => $category_order,
									'order'		=> $category_sort,
									'suppress_filters'	 => false,
									'fields'			 => ''
								);

								// Function
								queryloop($category_args, $category_action);

								echo '</ul></div>';


							elseif ( get_row_layout() == 'process_startups' ) : // Selection by process
								
								// Var
								$dealflow = get_sub_field('dealflow_startup_field');

								$custom_process_title = get_sub_field('title_process_startup_field');
								$process_order = get_sub_field('process_order_startup_field');
								$process_sort = get_sub_field('process_sort_startup_field');
								$process_display = get_sub_field('process_display_startup_field');
								$process_quantity = get_sub_field('process_quantity_startup_field');
								$process_action = get_sub_field('process_action_startup_field');

								$status_app = get_sub_field('app_status_startup_field');
								$status_wls = get_sub_field('wls_status_startup_field');
								$status_wrs = get_sub_field('wrs_status_startup_field');
								$status_invest = get_sub_field('invest_status_startup_field');
								$status_wlsc = get_sub_field('wlsc_status_startup_field');
								$status_sibe2 = get_sub_field('sibe2_status_startup_field');
								$status_gpbac = get_sub_field('gpbac_status_startup_field');
								$status_lnf = get_sub_field('lnf_status_startup_field');


								// Conditions to set the status
								if ( $dealflow && $dealflow == 'app' && $status_app ) : // Dealflow app
									$status_key = 'statut_app_process';
									$status_value = $status_app;
								elseif ( $dealflow && $dealflow == 'wls' && $status_wls ) : // Dealflow weLikeStartup
									$status_key = 'statut_wls_process';
									$status_value = $status_wls;
								elseif ( $dealflow && $dealflow == 'wrs' && $status_wrs ) : // Dealflow weRaiseStartup
									$status_key = 'statut_wrs_process';
									$status_value = $status_wrs; 
								elseif ( $dealflow && $dealflow == 'invest' && $status_invest ) : // Dealflow investessor
									$status_key = 'statut_invest_process';
									$status_value = $status_invest;
								elseif ( $dealflow && $dealflow == 'wlsc' && $status_wlsc ) : // Dealflow WeLikeStartup Challenge
									$status_key = 'statut_wlsc_process';
									$status_value = $status_wlsc;
								elseif ( $dealflow && $dealflow == 'sibe2' && $status_sibe2) : // Dealflow Sibessor 2
									$status_key = 'statut_sibe2_process';
									$status_value = $status_sibe2;
								elseif ( $dealflow && $dealflow == 'gpbac' && $status_gpbac) : // Deal flow Granx Prix BAC
									$status_key = 'statut_gpbac_process';
									$status_value = $status_gpbac;
								elseif ( $dealflow && $dealflow == 'lnf' && $status_lnf) : // Dealflow Les Nouveaux Financiers
									$status_key = 'statut_lnf_process';
									$status_value = $status_lnf;
								endif;


								// Title
								echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
								if ( $custom_process_title ) :
									echo $custom_process_title;
								else :
									echo 'Pas de titre';
								endif;
								echo '</h3>';

								// <ul id="groups-list"> for Masonry view
								echo '<ul id="groups-inline-list" class="item-list ' . $process_display . '" style="position: relative; height: 468px;">';

								// Parameters
								$process_args = array(
									'post_type' => 'startup',
									'meta_query' 		=> array(
											array(
												'key'     => 'dealflow_process',
												'value'   => $dealflow,
												'compare' => 'LIKE'
												// Possible values are '=', '!=', '>', '>=', '<', '<=', 'LIKE', 'NOT LIKE', 'IN', 'NOT IN', 'BETWEEN', 'NOT BETWEEN', 'EXISTS' and 'NOT EXISTS'. Default value is '='.
											),
											array(
												'key'     => $status_key,
												'value'   => $status_value,
												'compare' => '='
											),
										),
									'posts_per_page' => $process_quantity,
									'orderby'   => $process_order,
									'order'		=> $process_sort,
									'suppress_filters'	 => false,
									'fields'			 => ''
								);

								// Function
								queryloop($process_args, $process_action);

								echo '</ul></div>';


							elseif ( get_row_layout() == 'last_startups' ) : // Selection last startups
								
								// Var
								$custom_last_startup_title = get_sub_field('title_last_startup_field');
								$last_startup_type = get_sub_field('type_last_startup_field');
								$last_startup_display = get_sub_field('display_last_startup_field');
								$last_startup_quantity = get_sub_field('quantity_last_startup_field');
								$last_startup_action = get_sub_field('action_last_startup_field');

								// Title
								echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
								if ( $custom_last_startup_title ) :
									echo $custom_last_startup_title;
								else :
									echo 'Dernières startups';
								endif;
								echo '</h3>';
								// <ul id="groups-list"> for Masonry view
								echo '<ul id="groups-inline-list" class="item-list ' . $last_startup_display . '" style="position: relative; height: 468px;">';

								// Parameters
								$last_startup_args = array(
									'post_type' => 'startup',
									'posts_per_page' => $last_startup_quantity,
									'orderby'   => $last_startup_type,
									'order'		=> 'DESC'
								);

								// Function
								queryloop($last_startup_args, $last_startup_action);

								echo '</ul></div>';


							elseif ( get_row_layout() == 'period_startups' ) : // Selection period
								
								// Var
								$custom_period_title = get_sub_field('period_title_startup_field');
								$period_order_period = get_sub_field('period_order_startup_field');
								$period_sort_period = get_sub_field('period_sort_startup_field');
								$period_display_period = get_sub_field('period_display_startup_field');
								$period_quantity = get_sub_field('period_quantity_startup_field');
								$period_action = get_sub_field('period_action_startup_field');
								
								// Var start date
								$start_date_period = get_sub_field('start_date_startup_field');
								$start_date = date_parse_from_format("Y-m-d", $start_date_period);

								// Var end date
								$end_date_period = get_sub_field('end_date_startup_field');
								$end_date = date_parse_from_format("Y-m-d", $end_date_period);

								// Title
								echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
								if ( $custom_period_title ) :
									echo $custom_period_title;
								else :
									echo 'Pas de titre';
								endif;
								echo '</h3>';
								// <ul id="groups-list"> for Masonry view
								echo '<ul id="groups-inline-list" class="item-list ' . $display_period . '" style="position: relative; height: 468px;">';

								// Parameters
								$period_args = array(
									'post_type' => 'startup',
									'date_query' => array(
											array(
												'after'     => array(
													'year'  => $start_date['year'],
													'month' => $start_date['month'],
													'day'   => $start_date['day'],
												),
												'before'    => array(
													'year'  => $end_date['year'],
													'month' => $end_date['month'],
													'day'   => $end_date['day'],
												),
												'inclusive' => true,
											),
										),
									'posts_per_page' => $period_quantity,
									'orderby'   => $order_period,
									'order'		=> $sort_period,
									'suppress_filters'	 => false,
									'fields'			 => ''
								);

								// Function
								queryloop($period_args, $period_action);

								echo '</ul></div>';

							endif;

						endwhile;

					endif; ?>

	
			</div><!-- #buddypress -->

		</div><!-- .entry-content -->

	</article><!-- #post-## -->
	  
</div>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>