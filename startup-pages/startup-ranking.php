<?php

/**
 * Template Name: Startup ranking
 *
 * Description: Template Repeater loop for startup ranking
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



<?php function queryloop($select) {

	// The Query
	$select_query = new WP_Query($select);

	// The Loop
	if($select_query->have_posts()) :
		while ( $select_query->have_posts() ) : $select_query->the_post(); ?>
		
			<li class="bp-single-group public is-admin is-member group-has-avatar">
				<div class="item-wrap">

					<!-- Cover var -->
			        <?php $cover = get_field('cover_startup'); ?>
					<div class="item-cover has-cover" style="background: <?php if ($cover) { echo 'url(\'' . $cover . '\');'; } else { echo '#CCC;'; } ?> background-repeat: no-repeat; background-size: cover; background-position: center center !important;">
								
						<div class="item-avatar">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
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
                                  </a>
						</div>

					</div>
						
					<div class="item">
									
						<!-- Title -->
						<div class="item-title">
							<?php 
							$project_title = get_field('project_name');
							if ($project_title) : ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo $project_title; ?><br><small><?php the_title(); ?></small></a>
							<?php else : ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
							<?php endif; ?>
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

					</div>

				</div><!-- end item-wrap -->
			</li>

		<?php endwhile;

		// Restore original Post Data
		wp_reset_postdata();

	endif;
		
} ?>



<div class="main-content <?php echo Kleo::get_config('container_class'); ?>">

    <article id="post-0" class="post-0 page type-page status-publish hentry">

        <div class="entry-content">
                    
			<div id="buddypress" class="startup-selection">

				<div id="group-dir-search" class="dir-search" role="search">
					<form action="" method="get" id="search-groups-form">
						<label for="groups_search">
							<input type="text" name="groups_search" id="groups_search" placeholder="Rechercher un groupe...">
						</label>
						<input type="submit" id="groups_search_submit" name="groups_search_submit" value="Rechercher">
					</form>
				</div>

					<?php

					// check if the flexible content field has rows of data
					if ( have_rows('flexiblecontent_selection_startups') ):

					    // loop through the rows of data
					    while ( have_rows('flexiblecontent_selection_startups') ) : the_row();


					        if ( get_row_layout() == 'collection_startups' ) : // Selection by collection
					        	
					        	// Var
					        	$custom_title_collection = get_sub_field('title_collection_startup_field');
					        	$collection = get_sub_field('collection_startup_field');
					        	$order_collection = get_sub_field('collection_order_startup_field');
					        	$sort_collection = get_sub_field('collection_sort_startup_field');
					        	
					        	// Title
					        	echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
					        	if ( $custom_title_collection ) :
					        		echo $custom_title_collection;
					        	else :
					        		echo $collection->name;
					        	endif;
					        	echo '</h3>';
					        	// <ul id="groups-list"> for Masonry view
					        	echo '<ul id="groups-list" class="item-list" style="position: relative; height: 468px;">';

					        	// Parameters
					        	$collection_args = array(
					        		'tax_query' => array(
					        				array(
					        					'taxonomy' => $collection->taxonomy,
					        					'field'    => 'term_id',
					        					'terms'    => $collection->term_id,
					        				),
					        			),
					        		'orderby'   => $order_collection,
					        		'order'		=> $sort_collection,
					        		'post_type' => 'startup'
					        	);

					        	// Function
					        	queryloop($collection_args);

					        	echo '</ul></div>';


					        elseif ( get_row_layout() == 'category_startups' ) : // Selection by category
					        	
					        	// Var
					        	$custom_title_category = get_sub_field('title_category_startup_field');
					        	$category = get_sub_field('category_startup_field');
					        	$order_category = get_sub_field('category_order_startup_field');
					        	$sort_category = get_sub_field('category_sort_startup_field');

					        	// Title
					        	echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
					        	if ( $custom_title_category ) :
					        		echo $custom_title_category;
					        	else :
					        		echo $category->name;
					        	endif;
					        	echo '</h3>';
					        	// <ul id="groups-list"> for Masonry view
					        	echo '<ul id="groups-list" class="item-list" style="position: relative; height: 468px;">';

					        	// Parameters
					        	$category_args = array(
					        		'tax_query' => array(
					        				array(
					        					'taxonomy' => $category->taxonomy,
					        					'field'    => 'term_id',
					        					'terms'    => $category->term_id,
					        				),
					        			),
					        		'orderby'   => $order_category,
					        		'order'		=> $sort_category,
					        		'post_type' => 'startup'
					        	);

					        	// Function
					        	queryloop($category_args);

					        	echo '</ul></div>';


					        elseif ( get_row_layout() == 'process_startups' ) : // Selection by process
					        	
					        	// Var
					        	$custom_title_process = get_sub_field('title_process_startup_field');
					        	$dealflow = get_sub_field('dealflow_startup_field');
					        	$order_process = get_sub_field('process_order_startup_field');
					        	$sort_process = get_sub_field('process_sort_startup_field');

					        	$status_app = get_sub_field('app_status_startup_field');
					        	$status_wls = get_sub_field('wls_status_startup_field');
					        	$status_wrs = get_sub_field('wrs_status_startup_field');
					        	$status_invest = get_sub_field('invest_status_startup_field');
					        	$status_sibe1 = get_sub_field('sibe1_status_startup_field');
					        	$status_sibe2 = get_sub_field('sibe2_status_startup_field');

					        	// Title
					        	echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
					        	if ( $custom_title_process ) :
					        		echo $custom_title_process;
					        	else :
					        		echo 'Pas de titre';
					        	endif;
					        	echo '</h3>';
					        	// <ul id="groups-list"> for Masonry view
					        	echo '<ul id="groups-list" class="item-list" style="position: relative; height: 468px;">';

					        	// Parameters
					        	if ( $dealflow && $dealflow == 'app' && $status_app ) : // Deal flow app
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
												array(
													'key'     => 'statut_app_process',
													'value'   => $status_app,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
					        	elseif ( $dealflow && $dealflow == 'wls' && $status_wls ) : // Deal flow weLikeStartup
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
												array(
													'key'     => 'statut_wls_process',
													'value'   => $status_wls,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
					        	elseif ( $dealflow && $dealflow == 'wrs' && $status_wrs ) : // Deal flow weRaiseStartup
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
												array(
													'key'     => 'statut_wrs_process',
													'value'   => $status_wrs,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
					        	elseif ( $dealflow && $dealflow == 'ils' ) : // Deal flow iLikeStartup
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
					        	elseif ( $dealflow && $dealflow == 'invest' && $status_invest ) : // Deal flow investessor
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
												array(
													'key'     => 'statut_invest_process',
													'value'   => $status_invest,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
					        	elseif ( $dealflow && $dealflow == 'invest' && $status_invest ) : // Deal flow investessor
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
												array(
													'key'     => 'statut_invest_process',
													'value'   => $status_invest,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
					        	elseif ( $dealflow && $dealflow == 'sibe1' && $status_sibe1 ) : // Deal flow Sibessor 1
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
												array(
													'key'     => 'statut_sibe1_process',
													'value'   => $status_sibe1,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
					        	elseif ( $dealflow && $dealflow == 'sibe2' && $status_sibe2 ) : // Deal flow Sibessor 2
						        	$process_args = array(
										'meta_query' 		=> array(
												array(
													'key'     => 'dealflow_process',
													'value'   => $dealflow,
													'compare' => 'LIKE',
												),
												array(
													'key'     => 'statut_sibe2_process',
													'value'   => $status_sibe2,
													'compare' => 'LIKE',
												),
											),
						        		'orderby'   => $order_process,
						        		'order'		=> $sort_process,
						        		'post_type' => 'startup'
						        	);
						        endif;

						        // Function
					        	queryloop($process_args);

					        	echo '</ul></div>';


					        elseif ( get_row_layout() == 'last_startups' ) : // Selection last startups
					        	
					        	// Var
					        	$custom_title_last_startup = get_sub_field('title_last_startup_field');
					        	$type_last_startup = get_sub_field('type_last_startup_field');

					        	// Title
					        	echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
					        	if ( $custom_title_last_startup ) :
					        		echo $custom_title_last_startup;
					        	else :
					        		echo 'Dernières startups';
					        	endif;
					        	echo '</h3>';
					        	// <ul id="groups-list"> for Masonry view
					        	echo '<ul id="groups-list" class="item-list" style="position: relative; height: 468px;">';

					        	// Parameters
					        	$last_startup_args = array(
					        		'orderby'   => $type_last_startup,
					        		'order'		=> 'DESC',
					        		'post_type' => 'startup'
					        	);

					        	// Function
					        	queryloop($last_startup_args);

					        	echo '</ul></div>';


					        elseif ( get_row_layout() == 'period_startups' ) : // Selection period
					        	
					        	// Var
					        	$custom_period_title_startup = get_sub_field('period_title_startup_field');
					        	$order_period = get_sub_field('period_order_startup_field');
					        	$sort_period = get_sub_field('period_sort_startup_field');
					        	
					        	// Var start date
					        	$start_date_startup = get_sub_field('start_date_startup_field');
					        	$start_date = date_parse_from_format("Y-m-d", $start_date_startup);

					        	// Var end date
					        	$end_date_startup = get_sub_field('end_date_startup_field');
					        	$end_date = date_parse_from_format("Y-m-d", $end_date_startup);

					        	// Title
					        	echo '<div id="groups-dir-list" class="groups dir-list"><h3>';
					        	if ( $custom_period_title_startup ) :
					        		echo $custom_period_title_startup;
					        	else :
					        		echo 'Pas de titre';
					        	endif;
					        	echo '</h3>';
					        	// <ul id="groups-list"> for Masonry view
					        	echo '<ul id="groups-list" class="item-list" style="position: relative; height: 468px;">';

					        	// Parameters
					        	$period_startup_args = array(
					        		'date_query' => array(
					        				array(
					        					'year'  => $start_date['year'],
					        					'month' => $start_date['month'],
					        					'day'   => $start_date['day'],
					        					'compare'   => '>=',
					        				),
					        				array(
					        					'year'  => $end_date['year'],
					        					'month' => $end_date['month'],
					        					'day'   => $end_date['day'],
					        					'compare'   => '<=',
					        				),
					        			),
					        		'orderby'   => $order_period,
					        		'order'		=> $sort_period,
					        		'post_type' => 'startup'
					        	);

					        	// Function
					        	queryloop($period_startup_args);

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