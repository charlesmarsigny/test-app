<?php

/**
 * Template Name: Investor Loop
 *
 * Description: BuddyPress - Members Loop
 *
 * @package BuddyPress
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

<div class="main-content <?php echo Kleo::get_config('container_class'); ?>">

    <article id="post-0" class="post-0 page type-page status-publish hentry">

        <div class="entry-content">
                    
			<div id="buddypress" class="archive-startups">

				<!-- <div id="members-dir-search" class="dir-search" role="search">
					<form action="" method="get" id="search-groups-form">
						<label for="groups_search">
							<input type="text" name="groups_search" id="groups_search" placeholder="Rechercher un investisseur...">
						</label>
						<input type="submit" id="groups_search_submit" name="groups_search_submit" value="Rechercher">
					</form>
				</div> --><!-- #group-dir-search -->

<?php

/**
 * Fires before the display of the members loop.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_before_members_loop' ); ?>

<?php if ( bp_get_current_member_type() ) : ?>
	<p class="current-member-type"><?php bp_current_member_type_message() ?></p>
<?php endif; ?>

<?php 

$member_args = array(
    'member_type' => array( 'investisseur', 'investisseur-premium' ),
);

if ( bp_has_members( $member_args) ) : ?>

	<div id="pag-top" class="pagination">

		<div class="pag-count" id="member-dir-count-top">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-top">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

	<?php

	/**
	 * Fires before the display of the members list.
	 *
	 * @since BuddyPress (1.1.0)
	 */
	do_action( 'bp_before_directory_members_list' ); ?>

	<ul id="members-list" class="item-list">

	<?php while ( bp_members() ) : bp_the_member(); ?>

		<li <?php bp_member_class(); ?>>
			<div class="item-wrap">
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
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_avatar(array('type' => 'full', 'width' => 80, 'height' => 80)); ?></a>
						<?php do_action('bp_member_online_status', bp_get_member_user_id()); ?>
					</div>

				</div>

				<div class="item">

					<div class="item-title">
						<a href="<?php bp_member_permalink(); ?>"><?php bp_member_name(); ?></a>
					</div>

					<div class="item-meta"><span class="activity"><?php bp_member_last_active(); ?></span></div>

					<?php if ( bp_get_member_latest_update() ) : ?>

						<span class="update"> <?php bp_member_latest_update(); ?></span>

					<?php endif; ?>



					<?php

					/**
					 * Fires inside the display of a directory member item.
					 *
					 * @since BuddyPress (1.1.0)
					 */
					do_action( 'bp_directory_members_item' ); ?>

					<?php
					 /***
					  * If you want to show specific profile fields here you can,
					  * but it'll add an extra query for each member in the loop
					  * (only one regardless of the number of fields you show):
					  *
					  * bp_member_profile_data( 'field=the field name' );
					  */
					?>

					<div class="action">

						<?php

						/**
						 * Fires inside the members action HTML markup to display actions.
						 *
						 * @since BuddyPress (1.1.0)
						 */
						do_action( 'bp_directory_members_actions' ); ?>

					</div><!-- end action -->
				</div><!-- end item -->
			</div><!-- end item-wrap -->
		</li>

	<?php endwhile; ?>

	</ul>

	<?php

	/**
	 * Fires after the display of the members list.
	 *
	 * @since BuddyPress (1.1.0)
	 */
	do_action( 'bp_after_directory_members_list' ); ?>

	<?php bp_member_hidden_fields(); ?>

	<div id="pag-bottom" class="pagination">

		<div class="pag-count" id="member-dir-count-bottom">

			<?php bp_members_pagination_count(); ?>

		</div>

		<div class="pagination-links" id="member-dir-pag-bottom">

			<?php bp_members_pagination_links(); ?>

		</div>

	</div>

<?php else: ?>

	<div id="message" class="info">
		<p><?php _e( "Sorry, no members were found.", 'buddypress' ); ?></p>
	</div>

<?php endif; ?>

<?php

/**
 * Fires after the display of the members loop.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_after_members_loop' ); ?>

			</div>
		</div>
	</article>
</div>

<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>
