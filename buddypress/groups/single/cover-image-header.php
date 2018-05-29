<?php

/**
 * Fires before the display of a group's header.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_before_group_header' );

?>

<?php
// ASSET for integrated groups
$bp = groups_get_current_group();
$current_group_id = $bp->id;
$current_group_meta_startup = groups_get_groupmeta( $current_group_id, '_startup_in_group' );

if ( !empty( $current_group_meta_startup ) ) :
    wp_register_style( 'StartupGroup', get_stylesheet_directory_uri() . '/assets/css/startup-group.css');
    wp_enqueue_style( 'StartupGroup' );
    wp_register_script( 'groupUpdateURLnav', get_stylesheet_directory_uri() . '/assets/js/group.update.urlnav.js');
    wp_enqueue_script( 'groupUpdateURLnav' );

    if ( $_GET['request-group'] && (strstr($_GET['request-group'], 'activity-' ) || strstr($_GET['request-group'], 'acomment-' ) ) ) :
        $url_request = '#' . htmlspecialchars($_GET['request-group']); ?>
        <style>
            #buddypress ul#activity-stream li.heighlight-activity {
                background-color:#FFFFE0; 
            }
            #buddypress ul#activity-stream.activity-list >li .heighlight-comments {
                background-color:#f5f5d8; 
            }
            #buddypress ul#activity-stream li.heighlight-comment, #buddypress ul#activity-stream.activity-list > li .activity-comments ul > li.heighlight-comment {
                border: dashed 2px #f9e558;
                border-radius: 6px;
                margin-top: 5px;
                margin-bottom: 5px;
                padding-left: 5px;
                padding-right: 5px;
                background-color: #ffffe0;
            }
            #buddypress ul#activity-stream p.heighlight-activity-title {
                text-align:center; 
                background-color:#FFFF6B; 
                padding:6px 0 5px; margin: 0; 
                border-radius: 6px 6px 0 0; 
                text-transform:uppercase; 
                font-size: 10px; 
                line-height: 10px; font-weight: 600; 
                color: #ca9311;
            }
        </style>
        <?php if ( strstr($_GET['request-group'], 'activity-' ) ) : ?>
            <script>
                (function($) {
                    $(document).ready(function (event) {
                        var activity = $("<?= $url_request; ?>");
                        activity.addClass("heighlight-activity");
                        activity.prepend( "<p class='heighlight-activity-title'>Activité consultée</p>")
                    });
                })(jQuery);
            </script>
        <?php endif; ?>
        <?php if ( strstr($_GET['request-group'], 'acomment-' ) ) : ?>
            <script>
                (function($) {
                    $(document).ready(function (event) {
                        var comment = $("<?= $url_request; ?>");
                        comment.addClass("heighlight-comment");
                        var comments = comment.closest('div.activity-comments');
                        comments.addClass("heighlight-comments");
                        var activity = comment.closest('li.activity-item');
                        activity.addClass("heighlight-activity");
                        activity.prepend( "<p class='heighlight-activity-title'>Activité du commentaire consulté</p>")
                    });
                })(jQuery);
            </script>
        <?php endif; ?>
    <?php endif; ?>
<?php endif; ?>

<span class="highlight"><?php bp_group_type(); ?></span>


<?php if ( ! bp_disable_group_avatar_uploads() ) : ?>
	<div id="item-header-avatar">
		<a href="<?php bp_group_permalink(); ?>" title="<?php bp_group_name(); ?>">

			<?php bp_group_avatar(); ?>

		</a>
	</div><!-- #item-header-avatar -->
<?php endif; ?>

<div id="item-header-content">
    <h2><?php bp_group_name(); ?></h2>

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
    elseif ( $group_type == 'test' ) :
        echo '<h3 class="group-type">Groupe de test</h3>';
    endif; ?>

	<span class="activity"><?php printf( __( 'active %s', 'buddypress' ), bp_get_group_last_active() ); ?></span>

	<?php

	/**
	 * Fires before the display of the group's header meta.
	 *
	 * @since BuddyPress (1.2.0)
	 */
	do_action( 'bp_before_group_header_meta' ); ?>

	<div id="item-meta">

		<div id="item-buttons">

			<?php

			/**
			 * Fires in the group header actions section.
			 *
			 * @since BuddyPress (1.2.6)
			 */
			do_action( 'bp_group_header_actions' ); ?>

		</div><!-- #item-buttons -->

		<?php

		/**
		 * Fires after the group header actions section.
		 *
		 * @since BuddyPress (1.2.0)
		 */
		do_action( 'bp_group_header_meta' ); ?>

	</div>
</div><!-- #item-header-content -->

<div id="item-actions">

    <?php if ( bp_group_is_visible() ) : ?>

        <div class="group-admins">
        <h3><?php _e( 'Group Admins', 'buddypress' ); ?></h3>

        <?php bp_group_list_admins();

        /**
         * Fires after the display of the group's administrators.
         *
         * @since BuddyPress (1.1.0)
         */
        do_action( 'bp_after_group_menu_admins' );

        if ( bp_group_has_moderators() ) :

            /**
             * Fires before the display of the group's moderators, if there are any.
             *
             * @since BuddyPress (1.1.0)
             */
            do_action( 'bp_before_group_menu_mods' ); ?>
            </div><!-- end group-admins -->

            <div class="group-mods">
            <h3><?php _e( 'Group Mods' , 'buddypress' ); ?></h3>

            <?php bp_group_list_mods();

            /**
             * Fires after the display of the group's moderators, if there are any.
             *
             * @since BuddyPress (1.1.0)
             */
            do_action( 'bp_after_group_menu_mods' );

        endif; ?>
            </div><!-- end group-mods -->
    <?php endif; ?>

</div><!-- #item-actions -->

<?php

/**
 * Fires after the display of a group's header.
 *
 * @since BuddyPress (1.2.0)
 */
do_action( 'bp_after_group_header' );

/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
do_action( 'template_notices' );
?>
