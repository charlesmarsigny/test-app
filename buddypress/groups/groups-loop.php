<?php

/**
 * BuddyPress - Groups Loop
 *
 * Querystring is set via AJAX in _inc/ajax.php - bp_legacy_theme_object_filter()
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

?>

<?php

/**
 * Fires before the display of groups from the groups loop.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_before_groups_loop' ); ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<div id="pag-top" class="pagination" xmlns="http://www.w3.org/1999/html">

		<div class="pag-count" id="group-dir-count-top">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-top">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the listing of the groups list.
	 *
	 * @since BuddyPress (1.1.0)
	 */
	do_action( 'bp_before_directory_groups_list' ); ?>

	<ul id="groups-list" class="item-list">

	<?php while ( bp_groups() ) : bp_the_group(); ?>

		<li <?php bp_group_class(); ?>>
			<div class="item-wrap">
			<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
				<div <?php // Cover attributes
					 $cover_attr = kleo_bp_get_member_cover_attr();
					 $bg_colors = array('#2078EE', '#F53053', '#00D471', '#6432B4', '#FF783C', '#FFBE3D');
					 $rand_bg = array_rand($bg_colors, 1);
					 if ( !empty($cover_attr[18]) ) :
					 	echo $cover_attr;
					 else :
					 	echo 'class="item-cover has-cover" style="background-color: ' . $bg_colors[$rand_bg] . '"';
					 endif; ?>>
					<div class="item-avatar">
						<a href="<?php bp_group_permalink(); ?>"><?php bp_group_avatar( 'type=thumb&width=50&height=50' ); ?></a>
					</div>
				</div>
			<?php endif; ?>

			<div class="item">

					<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?>
						<?php // Add group type
						$group_id = bp_get_group_id();
						$group_type = bp_groups_get_group_type( $group_id );
						if ( $group_type == 'echanges' ) :
							echo '<h3 class="group-type">Groupe d\'échanges</h3>';
						elseif ( $group_type == 'acceleration' ) :
							echo '<h3 class="group-type">Groupe d\'accélération</h3>';
						elseif ( $group_type == 'campagne' ) :
							echo '<h3 class="group-type">Groupe de campagne</h3>';
						elseif ( $group_type == 'closing' ) :
							echo '<h3 class="group-type">Groupe de closing</h3>';
						elseif ( $group_type == 'actionnaires' ) :
							echo '<h3 class="group-type">Groupe d\'actionnaires</h3>';
						elseif ( $group_type == 'sortie' ) :
							echo '<h3 class="group-type">Groupe de sortie</h3>';
						endif; ?>
					</a></div>
					<div class="item-meta"><span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span></div>

				<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

				<?php

				/**
				 * Fires inside the listing of an individual group listing item.
				 *
				 * @since BuddyPress (1.1.0)
				 */
				do_action( 'bp_directory_groups_item' ); ?>

				<div class="action">

					<?php

					/**
					 * Fires inside the action section of an individual group listing item.
					 *
					 * @since BuddyPress (1.1.0)
					 */
					do_action( 'bp_directory_groups_actions' ); ?>

				</div>
				<div class="meta">

					<?php bp_group_type(); ?> / <?php bp_group_member_count(); ?>

				</div>
			</div>



			</div><!-- end item-wrap -->
		</li>

	<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the listing of the groups list.
	 *
	 * @since BuddyPress (1.1.0)
	 */
	do_action( 'bp_after_directory_groups_list' ); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="group-dir-count-bottom">

			<?php bp_groups_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="group-dir-pag-bottom">

			<?php bp_groups_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( 'There were no groups found.', 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of groups from the groups loop.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_after_groups_loop' ); ?>
