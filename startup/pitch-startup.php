<?php
/**
 * Template Name: Pitch startup
 *
 * Description: Page template for sub startup page
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

// Get function
if ( isset($_GET['id']) ) :

	// The get variables
	$post_type = 'startup';
	$startup_id = $_GET['id'];

	// The counter gallery pitch
	$count_gallery_pitch = 0;

	// The parameters
	$args = array(
		'p' => $startup_id, // id of a page, post, or custom type
		'post_type' => $post_type,
	);

	// The Query
	$ajax_query = new WP_Query($args);

	// The Loop
	if($ajax_query->have_posts()) :
		while ( $ajax_query->have_posts() ) : $ajax_query->the_post(); ?>	
			
			<!-- Pitch nav menu -->
			<?php get_template_part('startup/nav-parts/nav-menu-pitch'); ?>
			
			<!-- Pitch wrapper (for nav menu) -->
			<div class="pitch-wrapper">

				<!-- item -->
				<div class="first-section-pitch">
					<?php 
					$header_pitch = get_field('header_pitch');
					if ($header_pitch == 'video') { 
						echo '<div class="embed-container">';
					 	the_field('video_pitch');
					 	echo '</div>';
					} elseif ($header_pitch == 'gallery') {
						set_query_var('nb_gallery','head');
						get_template_part('startup/pitch-parts/gallery-slider-pitch');

					} elseif ($header_pitch == 'img') {
					 	$img_header_pitch = get_field('image_pitch');
					 	echo '<img width="' . $img_header_pitch[width] . '" height="' . $img_header_pitch[height] . '" src="' . $img_header_pitch[url] . '" class="img-header-pitch" alt="' . $img_header_pitch[alt] . '" title="' . $img_header_pitch[title] . '">';
					} else {

					} ?>

					
					<?php // Description
					$slogan = get_field('slogan_startup');
					$excerpt = get_field('excerpt_startup');
					if ($slogan) {
						echo '<div class="slogan-startup"><p>' . $slogan . '</p></div>';
					}
					if ($excerpt) {
						echo '<div class="excerpt-startup"><p>' . $excerpt . '</p></div>';
					} ?>

				</div>

				<div class="flexible-content-pitch">

					<div class="scroll-nav hidden"></div>
					
					<?php
					// Users variables access
					$current_user = wp_get_current_user();
					$allowed_roles = array('administrator', 'webmaster');
					$owner = get_field('owner_startup');
					$totalaccess = get_field('totalaccess_paricipant');
					$members_count = 0;
					$team_members = array();
					if( have_rows('members_team') ):
						while( have_rows('members_team') ): the_row(); 
							$user_fields = get_sub_field('subscriber_section_team');
							$team_members[$members_count] = $user_fields['ID'];
							$members_count++;
						endwhile;
					endif;

					// echo '<div class="hidden zzzzzzzzzz">';
					// var_dump($owner);
					// var_dump($totalaccess);
					// var_dump($team_members);
					// echo '</div>';

					// check if the flexible content field has rows of data
					if( have_rows('content_pitch') ):

					    // loop through the rows of data
					    while ( have_rows('content_pitch') ) : the_row();

					    	if ( empty( get_sub_field('confidentiality_field_pitch') )	// IF confidentiality doesn't exit OR equal false
					    	|| ( is_user_logged_in() && (
				    			($totalaccess && in_multi_array($current_user->ID, $totalaccess))  // IF connected user AND participant
				    			|| ($current_user->roles[0] == 'app_premium_investor' ) // OR IF premium investor
				    			|| array_intersect($allowed_roles, $current_user->roles ) // OR IF allowed roles (admin)
				    			|| ( !empty($owner) && in_multi_array($current_user->ID, $owner) == true ) // OR IF owner 
				    			|| ( !empty($team_members) && in_multi_array($current_user->ID, $team_members) == true ) // OR IF team member
					    		)
					    	)
					    	):

						        if( get_row_layout() == 'title_section_pitch' ): // Title

						        	$menu_title = get_sub_field('navtitle_field_pitch');
						        	if( $menu_title ) {
							        	echo '<h2 class="title-pitch"><span class="menu-title">' . $menu_title . '</span>';
							        	the_sub_field('title_field_pitch');
							        	echo '</h2>';
							        } else {
							        	echo '<h2 class="title-pitch menu-title">';
							        	the_sub_field('title_field_pitch');
							        	echo '</h2>';
							        }

						        elseif(get_row_layout() == 'subtitle_section_pitch'): // Sub title
						        	echo '<h3 class="subtitle-pitch">';
						        	the_sub_field('subtitle_field_pitch');
						        	echo '</h3>';

						        elseif(get_row_layout() == 'separator_section_pitch'): // Section separator
						        	echo '</div><div class="flexible-content-pitch">';

						        elseif( get_row_layout() == 'text_section_pitch' ): // Text

						        	the_sub_field('text_field_pitch');

						        elseif( get_row_layout() == 'textwysiwig_section_pitch' ): // Text WYSIWYG

						        	the_sub_field('textwysiwig_field_pitch');

						        elseif( get_row_layout() == 'code_section_pitch' || get_sub_field('code_field_pitch') ): // Code

						        	the_sub_field('code_field_pitch');

						        elseif( get_row_layout() == 'column_section_pitch' ): // Column

						        	if( have_rows('column_repeater_pitch') ):

						        		$total_column = 0;

						        		while ( have_rows('column_repeater_pitch') ) : the_row();
						        			$total_column++;
						        		endwhile;

						        		echo '<div class="column-wrapper columns-' . $total_column . '" >';

						        		$column_count = 1;

						        	 	// loop through the rows of data
						        	    while ( have_rows('column_repeater_pitch') ) : the_row();

						        	    	echo '<div class="pitch-column column-' . $column_count . '">';

						        	        // check if the flexible content field has rows of data
						        	        if( have_rows('flexiblecontent_column_pitch') ):

						        	             // loop through the rows of data
						        	            while ( have_rows('flexiblecontent_column_pitch') ) : the_row();

											        if( get_row_layout() == 'text_column_pitch' ): // Text
											        	
											        	the_sub_field('text_field_pitch');

											        elseif( get_row_layout() == 'textwysiwyg_column_pitch' ): // Text WYSIWYG
											        	
											        	the_sub_field('textwysiwig_field_pitch');

											        elseif( get_row_layout() == 'image_column_pitch' ): // Image
											        	
											        	$img_pitch = get_sub_field('image_field_pitch');
											        	$size = 'full'; // (thumbnail, medium, large, full or custom size)
											        	echo '<img width="' . $img_pitch[width] . '" height="' . $img_pitch[height] . '" src="' . wp_get_attachment_url( $img_pitch[id], $size ) . '" class="img-pitch" alt="' . $img_pitch[alt] . '" title="' . $img_pitch[title] . '">';

						        	                endif;

						        	            endwhile;

						        	        else :

						        	            // no layouts found

						        	        endif;

						        	        $column_count++;

						        	        echo '</div>';

						        	    endwhile;

						        	    echo '</div>';

						        	endif;

						        elseif( get_row_layout() == 'image_section_pitch' ): // Image

						        	$img_pitch = get_sub_field('image_field_pitch');
						        	$size = 'full'; // (thumbnail, medium, large, full or custom size)
						        	echo '<img width="' . $img_pitch[width] . '" height="' . $img_pitch[height] . '" src="' . wp_get_attachment_url( $img_pitch[id], $size ) . '" class="img-pitch" alt="' . $img_pitch[alt] . '" title="' . $img_pitch[title] . '">';

						        elseif( get_row_layout() == 'gallery_section_pitch' ): // Gallery

						        	// $image_ids = get_sub_field('gallery_field_pitch', false, false);	        				        	

						        	// set_query_var('varGallery', 'content'.$count_gallery_pitch);
						        	// get_template_part('startup/pitch-parts/gallery-slider-pitch');

						        	$gallery_type = get_sub_field('gallery_type_field_pitch');

						        	if ( $gallery_type == "slider" ) {
						        		set_query_var('nb_gallery', 'content' . $count_gallery_pitch);
						        		get_template_part('startup/pitch-parts/gallery-slider-pitch');

						        		
						        	} elseif ( $gallery_type == "carrousel" ) {
						        		set_query_var('nb_gallery', 'content' . $count_gallery_pitch);
						        		get_template_part('startup/pitch-parts/gallery-carrousel-pitch');
						        		
						        	} elseif ( $gallery_type == "grid" ) {
						        		set_query_var('nb_gallery', 'content' . $count_gallery_pitch);
						        		get_template_part('startup/pitch-parts/gallery-grid-pitch');	
						        	}

						        	$count_gallery_pitch++;

						        elseif( get_row_layout() == 'video_section_pitch' ): // Video

						        	echo '<div class="embed-container">';
						        	the_sub_field('video_field_pitch');
						        	echo '</div>';

						        elseif( get_row_layout() == 'list_section_pitch' ): // List

						        	// check if the nested repeater field has rows of data list
			        	        	if( have_rows('list_repeter_pitch') ):
			        	        		
			        	        		echo '<ul class="list-pitch">';

			        	        		// loop through the rows of data
			        				    while ( have_rows('list_repeter_pitch') ) : the_row();
			        				    	
			        				    	$title_list = get_sub_field('title_list_field_pitch');

			        				    	echo '<li>';
			        				    	if( $title_list == '' ) {	        				    		
			        				    		the_sub_field('text_list_field_pitch');
			        				    	}
			        				    		
			        				    	else {	        				    		
			        				    		echo '<strong>';
			        				    		echo '<div class = "title-pitch-position">';
			        				    		echo '<i class="fa fa-dot-circle-o" aria-hidden="true"></i>';
			        				    		echo '&nbsp;'; //space
			        				    		the_sub_field('title_list_field_pitch');
			        				    		echo '</div>';
			        				    		echo '</strong><br>';
			        				    		the_sub_field('text_list_field_pitch');	        				    		
			        				    	}	        				    	
			        				    	
			        				    	echo '</li>';
			        				    	
			        				    endwhile;

			        				    echo '</ul>';

			        				endif;

						        elseif( get_row_layout() == 'table_section_pitch' ): // Table
						        				        	
						        	$table = get_sub_field( 'table_field_pitch' );

						        	if ( $table ) :

						        		echo '<div class="scroll">';
						        	    echo '<table border="0">';
						        	        if ( $table['header'] ) :
						        	            echo '<thead>';
						        	                echo '<tr>';
						        	                    foreach ( $table['header'] as $th ) :
						        	                        echo '<th>';
						        	                            echo $th['c'];
						        	                        echo '</th>';
						        	                    endforeach;
						        	                echo '</tr>';
						        	            echo '</thead>';
						        	        endif;
						        	        echo '<tbody>';
						        	            foreach ( $table['body'] as $tr ) :
						        	                echo '<tr>';
						        	                    foreach ( $tr as $td ) :
						        	                        echo '<td>';
						        	                            echo $td['c'];
						        	                        echo '</td>';
						        	                    endforeach;
						        	                echo '</tr>';
						        	            endforeach;
						        	        echo '</tbody>';
						        	    echo '</table>';
						        	    echo '</div>';				        	    

						        	endif;

						        elseif( get_row_layout() == 'faq_section_pitch' ): // FAQ

						        	$faq = get_sub_field('faq_repeter_pitch');
						        					        	
						        	if ( $faq ) :
						        		echo '<div class ="faq">';
						        		echo '<h3 class="title-pitch">F.A.Q.</h3>';
								        	echo '<div class="accordion-container">';      	  
								        		foreach ($faq as $a) :
								        	  		echo'<ol class="set">';
								        	    			echo'<span>';
								        	     				echo $a["question_field_pitch"] ;
								        	      				echo'<i class="fa fa-chevron-down"></i>';
								        	    			echo'</span>';
								        	    		echo'<ol class="inner">';
								        	    			echo'<li class="talkbubble">';
								        					echo $a["answer_field_pitch"];
								        					echo '</li>';		
								        	  			echo'</ol>';
								        	  		echo'</ol>';
								        		endforeach;  
								        	echo'</div>';	
								        echo '</div>';
						        	endif;
						        	

						        elseif( get_row_layout() == 'integration_section_pitch' ): // Integrations oembed

						        	// check if the flexible content field has rows of data integrations
						        	if( have_rows('integration_flexible_pitch') ):

						        		// loop through the rows of data
						        		while ( have_rows('integration_flexible_pitch') ) : the_row();

						        			if( get_row_layout() == 'kickstarter_integration_pitch' ): // Kickstarter

						        				echo'<div class="media-integration">';
						        				the_sub_field('kickstarter_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'ted_integration_pitch' ): // TED

						        				echo'<div class="media-integration">';
						        				the_sub_field('ted_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'cloudup_integration_pitch' ): // Cloudup

						        				echo'<div class="media-integration">';
						        				the_sub_field('cloudup_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'flickr_integration_pitch' ): // Flickr

						        				the_sub_field('flickr_field_pitch');

						        			elseif( get_row_layout() == 'imgur_integration_pitch' ): // Imgur

						        				the_sub_field('imgur_field_pitch');

						        			elseif( get_row_layout() == 'instagram_integration_pitch' ): // Instagram

						        				echo '<div class="instagram-integration">';
						        				the_sub_field('instagram_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'photobucket_integration_pitch' ): // Photobucket

						        				the_sub_field('photobucket_field_pitch');

						        			elseif( get_row_layout() == 'issuu_integration_pitch' ): // Issuu

						        				echo'<div class="issuu-integration">';
						        				the_sub_field('issuu_field_pitch');
						        				echo'</div>';

						        			elseif( get_row_layout() == 'scribd_integration_pitch' ): // Scribd

						        				the_sub_field('scribd_field_pitch');

						        			elseif( get_row_layout() == 'slideshare_integration_pitch' ): // SlideShare

						        				echo'<div class="media-integration">';
						        				the_sub_field('slideshare_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'speakerdeck_integration_pitch' ): // Speaker Deck

						        				echo'<div class="media-integration">';
						        				the_sub_field('speakerdeck_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'polldaddy_integration_pitch' ): // PollDaddy

						        				the_sub_field('polldaddy_field_pitch');

						        			elseif( get_row_layout() == 'meetup_integration_pitch' ): // Meetup

						        				the_sub_field('meetup_field_pitch');

						        			elseif( get_row_layout() == 'soundcloud_integration_pitch' ): // SoundCloud

						        				echo '<div class="media-integration">';
						        				the_sub_field('soundcloud_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'reverbnation_integration_pitch' ): // ReverbNation

						        				echo'<div class="media-integration">';
						        				the_sub_field('reverbnation_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'spotify_integration_pitch' ): // Spotify

						        				echo'<div class="media-integration">';
						        				the_sub_field('spotify_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'mixcloud_integration_pitch' ): // Mixcloud

						        				echo'<div class="media-integration">';
						        				the_sub_field('mixcloud_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'reddit_integration_pitch' ): // Reddit

						        				echo '<div class="reddit-integration">';
						        				the_sub_field('reddit_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'tumblr_integration_pitch' ): // Tumblr

						        				echo '<div class="tumblr-integration">';
						        				the_sub_field('tumblr_field_pitch');
						        				echo '</div>';

						        			elseif( get_row_layout() == 'twitter_integration_pitch' ): // Twitter

						        				echo'<div class="twitter-integration">'; 
						        				the_sub_field('twitter_field_pitch');
						        				echo'</div>';

						        			elseif( get_row_layout() == 'facebook_integration_pitch' ): // Facebook

						        				echo '<div class="facebook-integration"><br>';
						        				the_sub_field('facebook_field_pitch');
						        				echo '</div>';

						        			endif;

						        		endwhile;

						        	endif;

						        endif;

						    endif;

					    endwhile;

					else : // no layouts found ?>
						<div class="pitch-construct">
							
							<h3>Pitch en construction</h3>
							<img src="https://png.icons8.com/wired/100/ceced2/design.png">

							<?php 
							$post_id = get_the_ID();
							$project_url = get_home_url().'/startup/'. $post_id . '/#projet';

							if ( is_user_logged_in() && (	// IF user logged AND
								($current_user->roles[0] == 'app_premium_investor' ) // IF premium investor
								|| array_intersect($allowed_roles, $current_user->roles ) // OR IF allowed roles
								) ) : ?>
								<a href="<?php echo $project_url; ?>" title="Projet">Voir le projet</a>
							<?php endif; ?>

						</div>
					<?php endif; ?>

				</div>
	
			</div>
			<!-- /Pitch wrapper (for nav menu) -->

		<?php endwhile; ?>
	<?php endif; ?>

	<?php else: ?>
	<div class="item-content"><p>Aucun post sélectionné</p></div>

<?php endif; ?>

<script>
	(function($) {
		//Gallery script setup
		$(document).ready(function() {
		  $('.flexslider').flexslider({
		    animation: "slide",
		    controlNav: "thumbnails",
		    start: function(slider){
		      $('body').removeClass('loading');
		    }
		  });
		});		

		//FAQ script 
		$(document).ready(function(){
		  $(".set > span").on("click", function(){
		    if($(this).hasClass('active')){
		      $(this).removeClass("active");
		      $(this).siblings('.inner').slideUp('slow');
		      $(".set > span i").removeClass("fa fa-chevron-up").addClass("fa fa-chevron-down");
		    }else{
		      $(".set > span i").removeClass("fa fa-chevron-up").addClass("fa fa-chevron-down");
		    $(this).find("i").removeClass("fa fa-chevron-down").addClass("fa fa-chevron-up");
		    $(".set > span").removeClass("active");
		    $(this).addClass("active");
		    $('.inner').slideUp('slow');
		    $(this).siblings('.inner').slideDown('slow');
		    }
		    
		  });
		});

		$(document).ready(function(){
			$('.pitch-wrapper').scrollNav({
			    sections: '.menu-title',
			    subSections: true,
			    sectionElem: 'div',
			    showHeadline: true,
			    headlineText: 'Sommaire',
			    showTopLink: true,
			    topLinkText: 'Aperçu',
			    fixedMargin: 40,
			    scrollOffset: 40,
			    animated: true,
			    speed: 500,
			    insertTarget: this.selector,
			    insertLocation: 'insertBefore',
			    arrowKeys: false,
			    scrollToHash: false,
			    onInit: null,
			    onRender: null,
			    onDestroy: null
			});
		});
	})(jQuery);
</script>
<script src="<?= get_stylesheet_directory_uri() ?>/assets/js/jquery.easing.js"></script>
<script src="<?= get_stylesheet_directory_uri() ?>/assets/js/jquery.mousewheel.js"></script>
<script defer src="<?= get_stylesheet_directory_uri() ?>/assets/js/demo.js"></script>