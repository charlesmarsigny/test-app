<?php
echo '<p class="hidden">Template part is here !</p>';

// check if the flexible content field has rows of data
if( have_rows('content_pitch') ):

	// Start nav container
	echo '<div id="pitch-menu" class="inner-nav hidden">';

		// Start nav list
		echo '<ul class="pitch-nav">';

			// loop through the rows of data
			while( have_rows('content_pitch') ) : the_row();

				if( get_row_layout() == 'title_section_pitch' ): // Title
				
					// Get title nav
					$title = get_sub_field('title_field_pitch');
					$anchor_title = $title;
					$titlenav = get_sub_field('navsubtitle_field_pitch');
					$anchor_titlenav = $titlenav;

					// Nav level 1
					if( $titlenav ) :
						echo '<li class="parent-level">
								<a href="' . $anchor_titlenav . '" title="Voir la section ' . $titlenav . '">' . $titlenav . '</a>
							  </li>';
					else :
						echo '<li class="parent-level">
								<a href="' . $anchor_title . '" title="Voir la section ' . $title . '">' . $title . '</a>
							  </li>';
					endif;

				elseif (get_row_layout() == 'subtitle_section_pitch'): // Sub title
				
					// Get title nav
					$subtitle = get_sub_field('subtitle_field_pitch');
					$anchor_subtitle = $subtitle;
					$subtitlenav = get_sub_field('navsubtitle_field_pitch');
					$anchor_subtitlenav = $subtitlenav;

					// Nav level 2
					if( $subtitlenav ) :
						echo '<li class="child-level">
								<a href="' . $anchor_subtitlenav . '" title="Voir la section ' . $subtitlenav . '">' . $subtitlenav . '</a>
							  </li>';
					else :
						echo '<li class="child-level">
								<a href="' . $anchor_subtitle . '" title="Voir la section ' . $subtitle . '">' . $subtitle . '</a>
							  </li>';
					endif;

				elseif (get_row_layout() == 'separator_section_pitch'): // Section separator
				
				endif;

			endwhile;

		// End nav list
		echo '</ul>';

	// End nav container
	echo '</div>';

endif;