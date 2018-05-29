<?php
/**
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );

// // Add parent style
// function theme_enqueue_styles() {
//   wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
// }
// add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// Force SSL on custom post types
// function wpc_force_ssl_cpt( $force_ssl,  $url = '' ) {
// 	if ( is_singular('startup') ) {
// 		return true;
// 	}
// 	return $force_ssl;
// }
// add_filter('force_ssl' , 'wpc_force_ssl_cpt', 1, 3);

// Remove metabox in admin to accelerate ACF
add_filter('acf/settings/remove_wp_meta_box', '__return_true');

// Remove parent style from the queue (theme.css)
function custom_dequeue_styles() {

	// theme
	wp_dequeue_style( 'buddyapp' );
	wp_deregister_style( 'buddyapp' );

	// parent font icons
	// wp_dequeue_style( 'kleo-font-icons' );
	// wp_deregister_style( 'kleo-font-icons' );
}
add_action( 'wp_print_styles', 'custom_dequeue_styles' );

// Add parent style
function theme_enqueue_styles() {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'parent-theme', get_template_directory_uri() . '/assets/less/theme.css', array(), '1.5.1' );
}
add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );

// Add admin style
function admin_styles() {
	wp_register_style( "admin-css", get_stylesheet_directory_uri() . '/assets/css/admin.css');
	wp_enqueue_style( 'admin-css' );
	wp_register_style( 'WLSappIcons', get_stylesheet_directory_uri() . '/assets/fonts/wlsapp-icons/style.css', array(), '1.0', 'all');
	wp_enqueue_style( 'WLSappIcons' );

}
add_action( 'admin_enqueue_scripts', 'admin_styles');

// Google maps API (ACF)
// function my_acf_init() {

// 	acf_update_setting('google_api_key', 'AIzaSyCuG7HRAieLEqn2-55mawmb0BM-PWDaiCQ');
// }

// add_action('acf/init', 'my_acf_init');
function my_acf_google_map_api( $api ){

	$api['key'] = 'AIzaSyCuG7HRAieLEqn2-55mawmb0BM-PWDaiCQ';
	return $api;

}
add_filter('acf/fields/google_map/api', 'my_acf_google_map_api');

// *******************************
// Additional options for User Role Editor (features)
// *******************************

// Prohibit access to admin
// add_filter('ure_role_additional_options', 'add_prohibit_access_to_admin_option', 10, 1);
// function add_prohibit_access_to_admin_option($items) {
//     $item = URE_Role_Additional_Options::create_item('prohibit_admin_access', esc_html__('Prohibit access to admin', 'user-role-editor'), 'init', 'prohibit_access_to_admin');
//     $items[$item->id] = $item;

//     return $items;
// }
// function prohibit_access_to_admin() {

//     if (is_admin()) {
//         wp_redirect(get_home_url());
//     }
// }

// Remove admin notices
// add_filter('ure_role_additional_options', 'ure_add_block_admin_notices_option', 10, 1);
// function ure_add_block_admin_notices_option($items) {
//     $item = URE_Role_Additional_Options::create_item('block_admin_notices', esc_html__('Block admin notices', 'user-role-editor'), 'admin_init', 'ure_block_admin_notices');
//     $items[$item->id] = $item;

//     return $items;
// }
// function ure_block_admin_notices() {
//     add_action('admin_print_scripts', 'ure_remove_admin_notices');
// }
// function ure_remove_admin_notices() {
//     global $wp_filter;
//     if (is_user_admin()) {
//         if (isset($wp_filter['user_admin_notices'])) {
//             unset($wp_filter['user_admin_notices']);
//         }
//     } elseif (isset($wp_filter['admin_notices'])) {
//         unset($wp_filter['admin_notices']);
//     }
//     if (isset($wp_filter['all_admin_notices'])) {
//         unset($wp_filter['all_admin_notices']);
//     }
// }

// *******************************
// Add role to admin body class
// *******************************
if ( is_user_logged_in() ) {
    add_filter('body_class','add_role_to_body');
    add_filter('admin_body_class','add_role_to_body');
}
function add_role_to_body($classes) {
    $current_user = new WP_User(get_current_user_id());
    $user_role = array_shift($current_user->roles);
    if (is_admin()) {
        $classes .= ' '. $user_role;
    } else {
        $classes[] = $user_role;
    }
    return $classes;
}

// ********************
// Give a string of key and value (key=value) in URL (http://.../?key=value) without the method GET
// ********************
function queryURL() {
	$queryFrame = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_QUERY);
	return $queryFrame;
}


// *******************************
// Add scripts and styles
// *******************************
function custom_scripts(){

	if (!is_admin()) {
		 // wp_register_style( 'wpDiscuz', '/wp-content/plugins/wpdiscuz/assets/css/wpdiscuz.css');
		 // wp_enqueue_style( 'wpDiscuz' );
		 // wp_register_style( 'wpDiscuCustom', '/wp-content/plugins/wpdiscuz/assets/css/wpdiscuz-custom-form.css');
		 // wp_enqueue_style( 'wpDiscuzCustom' );
		 // wp_register_style( 'MaterialKitCss', get_stylesheet_directory_uri() . '/assets/css/material-kit.css');
		 // wp_enqueue_style( 'MaterialKitCss' );
		 // wp_register_style( 'bootstrapCss', get_stylesheet_directory_uri() . '/assets/css/bootstrap.min.css');
		 // wp_enqueue_style( 'bootstrapCss' );

		// css for form startup front
		if( is_page_template( 'new-startup.php') ){
			wp_enqueue_style( 'common' );
			wp_register_style( 'startupForm', get_stylesheet_directory_uri() . '/assets/css/startup-form.css');
			wp_enqueue_style( 'startupForm' );
			wp_dequeue_style( 'parent-theme', get_template_directory_uri() . '/assets/less/theme.css', array(), '1.5.1' );
		}

	 	wp_register_style( 'FontAwesome', get_stylesheet_directory_uri() . '/assets/css/font-awesome.min.css');
	 	wp_enqueue_style( 'FontAwesome' );
	 	wp_register_style( 'CustomBox', get_stylesheet_directory_uri() . '/assets/css/custombox.min.css');
	 	wp_enqueue_style( 'CustomBox' );

		 // css for single startup
		 if ( is_singular('startup') ) {
			wp_register_style( 'FlexSlider', get_stylesheet_directory_uri() . '/assets/css/flexslider.css');
			wp_enqueue_style( 'FlexSlider' );
			wp_register_style( 'lightgallery', get_stylesheet_directory_uri() . '/assets/css/lightgallery.css');
			wp_enqueue_style( 'lightgallery' );
			wp_register_script( 'scrollNav', get_stylesheet_directory_uri() . '/assets/js/jquery.scrollNav.min.js', array('jquery'));
		 	wp_enqueue_script( 'scrollNav' );
		 }

		 wp_register_script( 'hashChange', get_stylesheet_directory_uri() . '/assets/js/jquery.hashchange.min.js', array('jquery'));
		 wp_enqueue_script( 'hashChange' );
		 wp_register_script( 'easyTabs', get_stylesheet_directory_uri() . '/assets/js/jquery.easytabs.min.js', array('jquery'));
		 wp_enqueue_script( 'easyTabs' );
		 wp_register_script( 'modaljs', get_stylesheet_directory_uri() . '/assets/js/jquery.modal.min.js', array('jquery'));
		 wp_enqueue_script( 'modaljs' );
		 wp_register_script( 'jquerySteps', get_stylesheet_directory_uri() . '/assets/js/jquery.steps.min.js', array('jquery'));
		 wp_enqueue_script( 'jquerySteps' );
		 wp_register_script( 'autoSize', get_stylesheet_directory_uri() . '/assets/js/autosize.js');
		 wp_enqueue_script( 'autoSize' );
		 wp_register_script( 'CustomBoxJs', get_stylesheet_directory_uri() . '/assets/js/custombox.min.js');
		 wp_enqueue_script( 'CustomBoxJs' );
		 wp_register_script( 'CustomBoxLegacyJs', get_stylesheet_directory_uri() . '/assets/js/custombox.legacy.min.js');
		 wp_enqueue_script( 'CustomBoxLegacyJs' );
		 wp_register_script( 'JssorSlider', get_stylesheet_directory_uri() . '/assets/js/jssor.slider.js');
		 wp_enqueue_script( 'JssorSlider' );
		 wp_register_script( 'lightgallery', get_stylesheet_directory_uri() . '/assets/js/lightgallery.js', array('jquery'), '2', 'true');
		 wp_enqueue_script( 'lightgallery' );
		 wp_register_script( 'lightgalleryall', get_stylesheet_directory_uri() . '/assets/js/lightgallery-all.js', array('jquery'), '2', 'true');
		 wp_enqueue_script( 'lightgalleryall' );
		 wp_register_script( 'PictureFill', get_stylesheet_directory_uri() . '/assets/js/picturefill.js', array(), '2.3.1', '2', 'true');
		 wp_enqueue_script( 'PictureFill' );
		 wp_register_script( 'MouseWheeljs', get_stylesheet_directory_uri() . '/assets/js/jquery.mousewheel.js', array('jquery'));
		 wp_enqueue_script( 'MouseWheeljs' );
		 // wp_dequeue_script( 'buddyPress', get_template_directory_uri() . '/buddypress/js/buddypress.js' );
		 // wp_register_script( 'buddyPressChild', get_stylesheet_directory_uri() . '/buddypress/js/buddypress.js');
		 // wp_enqueue_script( 'buddyPressChild' );

		 // JQuery for single startup
		 if ( is_singular('startup') ) {
			// wp_register_script( 'jqueryFlexslider', get_stylesheet_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'));
			// wp_enqueue_script( 'jqueryFlexslider' );

			// wp_register_script( 'jqueryStartup', get_stylesheet_directory_uri() . '/assets/js/startup.js', array('jquery'));
			// wp_enqueue_script( 'jqueryStartup' );
		 }

		 wp_register_script( 'googleMapAPI', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCuG7HRAieLEqn2-55mawmb0BM-PWDaiCQ&callback=initMap');
		 wp_enqueue_script( 'googleMapAPI' );
		 // wp_register_script( 'MaterialKitJs', get_stylesheet_directory_uri() . '/assets/js/material-kit.min.js', array('jquery'));
		 // wp_enqueue_script( 'MaterialKitJs' );
		 // wp_register_script( 'bootstraptJs', get_stylesheet_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'));
		 // wp_enqueue_script( 'bootstraptJs' );

		 // jQuery replace
		 // wp_deregister_script('jquery');
		 // wp_register_script('jquery','https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js', false, '3.2.1');
		 // wp_enqueue_script('jquery');
	}
}
add_action('wp_enqueue_scripts', 'custom_scripts');

// *******************************
// Add scripts and styles after parent theme
// *******************************
function custom_scripts_after(){

	$current_user = wp_get_current_user();
	$allowed_roles = array('administrator');
	if( is_user_logged_in() && array_intersect($allowed_roles, $current_user->roles ) ) {
		// wp_register_style( 'newUI', get_stylesheet_directory_uri() . '/assets/css/new-style.css', array(), '1.0', 'all');
		// wp_enqueue_style( 'newUI' );
	}

	if (!is_admin()) {
	 	wp_register_style( 'WLSappIcons', get_stylesheet_directory_uri() . '/assets/fonts/wlsapp-icons/style.css', array(), '1.0', 'all');
	 	wp_enqueue_style( 'WLSappIcons' );
	}
}
add_action('wp_enqueue_scripts', 'custom_scripts_after', 999);

// *******************************
// Add WLS app icons
// *******************************
function kleo_icons_array($prefix = '', $before = array('')) {

    // Get any existing copy of our transient data
    $transient_name = 'wlsapp_font_icons' . $prefix . implode('', $before);

    // It wasn't there, so regenerate the data and save the transient
    if (false === ($icons = get_transient($transient_name))) {

        $icons = $before;

        /* Icons json path */
        $icons_json_uri = THEME_URI . '/assets/fonts/wlsapp-icons/selection.json';
        $icons_json_dir = THEME_DIR . '/assets/fonts/wlsapp-icons/selection.json';

        if (is_child_theme() && file_exists(CHILD_THEME_DIR . '/assets/fonts/wlsapp-icons/style.css')) {
            $icons_json_uri = CHILD_THEME_URI . '/assets/fonts/wlsapp-icons/selection.json';
            $icons_json_dir = CHILD_THEME_DIR . '/assets/fonts/wlsapp-icons/selection.json';
        }

        /* Retrieve icons json data */
        if ($icons_json = sq_fs_get_contents($icons_json_dir)) {
            //do nothing
        } else {
            $icons_json_data = wp_remote_get($icons_json_uri);
            $icons_json = wp_remote_retrieve_body($icons_json_data);
        }

        if ($icons_json) {
            $arr = json_decode($icons_json, true);
            foreach ($arr['icons'] as $icon) {
                if (isset($icon['properties']) && isset($icon['properties']['name'])) {
                    $icons[$prefix . $icon['properties']['name']] = $icon['properties']['name'];
                    asort($icons);
                }
            }
        }

        // set transient for one day
        set_transient($transient_name, $icons, 86400);
    }

    return $icons;
}


// *******************************
// INSERT and UPDATE startup in group meta field
// *******************************
function save_meta_startup_in_group() {
	$groups_id_from_startup = array();
	$group_count_from_startup = 0;
	$group_count_metaquery = 0;
	$startup_id = 0;
	$post_type = 0;

	// Recover startup ID and type
	if ( get_the_ID() ) {
		$startup_id = get_the_ID();
		$post_type = get_post_type($startup_id);
	} else { return; }

	// IF this isn't a 'startup' post => stop
	if( $post_type != 'startup' ) return;

	// Recover groups ID
	if( have_rows('startup_groups') ) :
		while ( have_rows('startup_groups') ) : the_row();
			// Groups ID recovered in the startup
			$groups_id_from_startup[$group_count_from_startup] = get_sub_field('group_select_field');
			$group_count_from_startup++;
		endwhile;
	endif;

	// INSERT or UPDATE metafield in groups of the startup
	for( $i=0; $i<$group_count_from_startup; $i++ ){
		groups_update_groupmeta( $groups_id_from_startup[$i], '_startup_in_group', $startup_id );
	}

	// Search for groups by the metafield startup
	$group_args = array(
		'meta_query' => array(
			'relation' => 'AND',
			array(
				'key' => '_startup_in_group',
				'value' => $startup_id
			)
		)
	);
	if ( bp_has_groups ( $group_args ) ) :
		while ( bp_groups() ) : bp_the_group();
			$groups_metaquery[$group_count_metaquery] = bp_get_group_id();
			$group_count_metaquery++;
		endwhile;
	endif;

	// Comparison between groups in startups and groups found by metafield
	$groups_intruder = array_diff($groups_metaquery, $groups_id_from_startup);

	// DELETE metafield in groups of the startup when UPDATE the startup
	if ( !empty($groups_intruder) ) {
		foreach ($groups_intruder as $key => $value) {
			groups_delete_groupmeta( $value, '_startup_in_group', $startup_id );
		}
	}

}
add_action( 'save_post', 'save_meta_startup_in_group', 10, 3 );
// add_action( 'acf/save_post', 'save_meta_startup_in_group', 1 );


// *******************************
// DELETE startup in group meta field
// *******************************
function delete_meta_startup_in_group() {
	$group_id = array();
	$group_count = 0;
	$startup_id = 0;
	$post_type = 0;

	// Recover startup ID and type
	if ( get_the_ID() ) {
		$startup_id = get_the_ID();
		$post_type = get_post_type($startup_id);
	} else { return; }

	// IF this isn't a 'startup' post => stop
	if( $post_type != 'startup' ) return;

	// Recover groups ID
	if( have_rows('startup_groups') ) :
		while ( have_rows('startup_groups') ) : the_row();
			// Groups ID recovered in the startup
			$group_id[$group_count] = get_sub_field('group_select_field');
			$group_count++;
		endwhile;
	endif;

	// DELETE metafield in groups of the startup
	for( $i=0; $i<$group_count; $i++ ){
		groups_delete_groupmeta( $group_id[$i], '_startup_in_group', $startup_id );
	}
}
add_action( 'delete_post', 'delete_meta_startup_in_group', 10, 3 );


// *******************************
// Display Group in startup meta field
// *******************************

//it's important to check if the Groups component is active
if( bp_is_active( 'groups' ) ) :

	class BP_StartupID_Group {
	    public function __construct() {
	        $this->setup_hooks();
	    }
	    private function setup_hooks() {
	        // in Group Administration screen, you add a new metabox to display the name of linked startup
	        add_action( 'bp_groups_admin_meta_boxes', array( $this, 'admin_ui_edit_startup' ) );
	    }
	    /* registers a new metabox in Edit Group Administration screen, edit group panel */
	    public function admin_ui_edit_startup() {
	        add_meta_box(
	            'startup-linked-box',
	            __( 'Startup attachée' ),
	            array( &$this, 'admin_ui_metabox_startup'),
	            get_current_screen()->id,
	            'side',
	            'core'
	        );
	    }
	    /* Displays the meta box */
	    public function admin_ui_metabox_startup( $item = false ) {
	        if( empty( $item ) )
	            return;
	        // Display the startup linked to the group
	        $attached_startup_id = groups_get_groupmeta( $item->id, '_startup_in_group' );
	    	if( !empty($attached_startup_id) ) {
	    		echo '<p>'. get_the_title($attached_startup_id) .'</p>';
	    	} else {
	    		echo '<p>Aucune startup attachée</p>';
	    	}
	    }
	}

	function bp_startupid_group() {
	    if( bp_is_active( 'groups') )
	        return new BP_StartupID_Group();
	}

	add_action( 'bp_init', 'bp_startupid_group' );

endif;


// *******************************
// Groups redirect
// *******************************
function group_redirect() {

	$allowed_roles = array('administrator');
	$current_user = wp_get_current_user();
	$group_url = '';
	$group_slug = array();
	$group_id_requested = '';
	$attached_startup = '';

	if ( strstr( $_SERVER['REQUEST_URI'], '/groupes/' ) ) {
		$group_url = strstr( $_SERVER['REQUEST_URI'], '/groupes/' );
		$group_slug = explode( "/", $group_url );

		if ( empty( $group_slug[2] ) ) {
			// Admin OR Webmaster => NO REDIRECTION
			if( is_user_logged_in() ) {
				if ( array_intersect($allowed_roles, $current_user->roles) ) {
					return;
				}
			}
			// Redirection for "https://app.welikestartup.io/groupes/"
			wp_redirect( "https://app.welikestartup.io/groupes/type/echanges/", 301 );
			exit;
		} elseif ( $group_slug[2] == 'type' && $group_slug[3] != 'echanges' ) {
			// Admin OR Webmaster => NO REDIRECTION
			if( is_user_logged_in() ) {
				if ( array_intersect($allowed_roles, $current_user->roles) ) {
					return;
				}
			}
			// Redirection for "https://app.welikestartup.io/groupes/type/acceleration/ OR campagne, ..."
			wp_redirect( "https://app.welikestartup.io/groupes/type/echanges/", 301 );
			exit;
		} elseif ( strstr( $_SERVER['REQUEST_URI'], '/groupes/create/' ) ) {
			// Group creation => NO REDIRECTION
			return;
		} elseif ( ( strstr( $_SERVER['HTTP_REFERER'], '/groupes/' ) && strstr( $_SERVER['HTTP_REFERER'], $group_slug[2] ) )
			|| strstr( $_SERVER['HTTP_REFERER'], '/startup/' ) ) {
			/* IF we are already in the group => NO REDIRECTON */
			return;
		} else {
			// ID of the group
			$args = array(
				'slug' => $group_slug[2]
			);
			if ( bp_has_groups ( $group_args ) ) :
				while ( bp_groups() ) : bp_the_group();
					$group_id_requested = bp_get_group_id();
				endwhile;
			endif;
			// ID of the startup attached to the group
			$attached_startup = groups_get_groupmeta( $group_id_requested, '_startup_in_group' );

			/* IF no attached startup => NO REDIRECTION */
			if ( $attached_startup == '' ) {
				return;
			} else {
				// URL of the startup
				$attached_startup_url = get_permalink( $attached_startup );

				// add GET for request of document, invitation and activity from email
				$group_request = '';
				if ( $group_slug[3] == 'documents' ) {
					$group_request = '?request-group=documents';
				} elseif ( $group_slug[3] == 'admin' && $group_slug[4] == 'membership-requests' ) {
					$group_request = '?request-group=membership-requests';
				} elseif ( strstr($group_url, 'activity-' ) ) {
					$group_request = '?request-group=' . strstr($group_url, 'activity-' );
				} elseif ( strstr($group_url, 'acomment-' ) ) {
					$group_request = '?request-group=' . strstr($group_url, 'acomment-' );
				}
				// $truc = strstr( $_SERVER['REQUEST_URI'], 'activity-' );
				// $group_request = '?request-group=' . $truc;

				// Construction of url for the redirection
				$attached_startup_url = $attached_startup_url . $group_request . '#groupe-'. $group_id_requested;

				// echo '<div class="hidden trrruc" style="display:none;">';
				// var_dump($_SERVER['REQUEST_URI']);
				// echo'</div>';

				/* REDIRECTION */
				wp_redirect( $attached_startup_url, 301 );
				exit;
			}
		}
	}
}
add_action('template_redirect', 'group_redirect');


// *******************************
// Template redirect
// *******************************

// if search engine result == 1 -> redirect to post
add_action('template_redirect', 'redirect_search_to_single_post_result');
function redirect_search_to_single_post_result() {
    if( is_search() ) {
        global $wp_query;
        if ($wp_query->post_count == 1) {
            if( $wp_query->posts['0']->post_type == 'post' )
            	wp_redirect( get_permalink( $wp_query->posts['0']->ID ) );
        }
    }
}

// *******************************
// Add wpDiscuz to CPT
// *******************************
function my_wpdiscuz_shortcode() {
	 if(file_exists(ABSPATH . 'wp-content/plugins/wpdiscuz/templates/comment/comment-form.php')){
			include_once ABSPATH . 'wp-content/plugins/wpdiscuz/templates/comment/comment-form.php';
	 }
}
add_shortcode( 'wpdiscuz_comments', 'my_wpdiscuz_shortcode' );

// *******************************
// Member types
// *******************************
// function bbg_register_member_types_with_directory() {
//     bp_register_member_type( 'investisseur', array(
//         'labels' => array(
//             'name'          => 'Investisseurs',
//             'singular_name' => 'Investisseur',
//         ),
//         'has_directory' => 'investisseurs'
//     ) );
//     bp_register_member_type( 'utilisateur', array(
//         'labels' => array(
//             'name'          => 'Utilisateurs',
//             'singular_name' => 'Utilisateur',
//         ),
//         'has_directory' => 'utilisateurs'
//     ) );
//     bp_register_member_type( 'administrateur', array(
//         'labels' => array(
//             'name'          => 'Administrateurs',
//             'singular_name' => 'Administrateur',
//         ),
//         'has_directory' => 'administrateurs'
//     ) );
//     bp_register_member_type( 'webmaster', array(
//         'labels' => array(
//             'name'          => 'Webmasters',
//             'singular_name' => 'Webmaster',
//         ),
//         'has_directory' => 'webmasters'
//     ) );
// }
// add_action( 'bp_register_member_types', 'bbg_register_member_types_with_directory' );


// *******************************
// Group types
// *******************************
function my_bp_custom_group_types() {
		bp_groups_register_group_type( 'test', array(
				'labels' => array(
						'name' => 'Groupe de test',
						'singular_name' => 'Groupe de test'
				),

				// New parameters as of BP 2.7.
				'has_directory' => 'test',
				'show_in_create_screen' => true,
				'show_in_list' => true,
				'description' => 'Test groups',
				'create_screen_checked' => true
		) );
		bp_groups_register_group_type( 'echanges', array(
				'labels' => array(
						'name' => 'Groupe d\'échanges',
						'singular_name' => 'Groupe d\'échanges'
				),

				// New parameters as of BP 2.7.
				'has_directory' => 'echanges',
				'show_in_create_screen' => true,
				'show_in_list' => true,
				'description' => 'Echange groups',
				'create_screen_checked' => true
		) );
		bp_groups_register_group_type( 'acceleration', array(
				'labels' => array(
						'name' => 'Groupe d\'accélération',
						'singular_name' => 'Groupe d\'accélération'
				),

				// New parameters as of BP 2.7.
				'has_directory' => 'acceleration',
				'show_in_create_screen' => true,
				'show_in_list' => true,
				'description' => 'Acceleration groups',
				'create_screen_checked' => true
		) );
		bp_groups_register_group_type( 'campagne', array(
				'labels' => array(
						'name' => 'Groupe de campagne',
						'singular_name' => 'Groupe de campagne'
				),

				// New parameters as of BP 2.7.
				'has_directory' => 'campagne',
				'show_in_create_screen' => true,
				'show_in_list' => true,
				'description' => 'Campagne groups',
				'create_screen_checked' => true
		) );
		bp_groups_register_group_type( 'closing', array(
				'labels' => array(
						'name' => 'Groupe de closing',
						'singular_name' => 'Groupe de closing'
				),

				// New parameters as of BP 2.7.
				'has_directory' => 'closing',
				'show_in_create_screen' => true,
				'show_in_list' => true,
				'description' => 'Closing groups',
				'create_screen_checked' => true
		) );
		bp_groups_register_group_type( 'actionnaires', array(
				'labels' => array(
						'name' => 'Groupe d\'actionnaires',
						'singular_name' => 'Groupe d\'actionnaires'
				),

				// New parameters as of BP 2.7.
				'has_directory' => 'actionnaires',
				'show_in_create_screen' => true,
				'show_in_list' => true,
				'description' => 'Actionnaire groups',
				'create_screen_checked' => true
		) );
		bp_groups_register_group_type( 'sortie', array(
				'labels' => array(
						'name' => 'Groupe de sortie',
						'singular_name' => 'Groupe de sortie'
				),

				// New parameters as of BP 2.7.
				'has_directory' => 'sortie',
				'show_in_create_screen' => true,
				'show_in_list' => true,
				'description' => 'Exit groups',
				'create_screen_checked' => true
		) );
}
add_action( 'bp_groups_register_group_types', 'my_bp_custom_group_types' );

// *******************************
// Updating post modified date (ACF edit frontend form)
// *******************************
function my_acf_save_post( $post_id ) {
	// bail out early if we don't need to update the date
	if( is_admin() || $post_id == 'new' ) {

		 return;

	 }
	 global $wpdb;
	 $datetime = date("Y-m-d H:i:s");
	 $query = "UPDATE $wpdb->posts
			 SET
							post_modified = '$datetime'
						 WHERE
							ID = '$post_id'";
		$wpdb->query( $query );
}
// run after ACF saves the $_POST['acf'] data
add_action('acf/save_post', 'my_acf_save_post', 20);


// *********************************************
// Replace title, content and image startup post
// *********************************************
function my_post_title_updater( $post_id ) {

		$my_post = array();
		$my_post['ID'] = $post_id;

		if ( get_post_type() == 'startup' ) {
			$my_post['post_title'] = get_field('startup_name');
			$my_post['post_excerpt'] = get_field('excerpt_startup');
			$my_post['post_content'] = get_field('excerpt_startup');
		}

		// Update the post into the database
		wp_update_post( $my_post );

	}

// run after ACF saves the $_POST['fields'] data
add_action('acf/save_post', 'my_post_title_updater', 20);

function acf_set_featured_image( $value, $post_id, $field  ){

		if($value != ''){
			//Add the value which is the image ID to the _thumbnail_id meta data for the current post
			add_post_meta($post_id, '_thumbnail_id', $value);
		}

		return $value;
}
// acf/update_value/name={$field_name} - filter for a specific field based on it's name
add_filter('acf/update_value/name=logo_startup', 'acf_set_featured_image', 10, 3);


/**
 * Redirects group intentions to the startup intentions
 *
 * The bp_is_active( 'groups' ) check is recommended, to prevent problems
 * during upgrade or when the Groups component is disabled
 */
// if ( bp_is_active( 'groups' ) ) :

// class Intentions_Extension extends BP_Group_Extension {
// 		/**
// 		 * Here you can see more customization of the config options
// 		 */
// 		function __construct() {
// 				$args = array(
// 						'slug' => 'intentions',
// 						'name' => 'Intentions',
// 						'nav_item_position' => 105
// 				);
// 				parent::init( $args );
// 		}

// 		function display( $group_id = NULL ) {
// 				$group_id = bp_get_group_id();
// 				$group_slug = bp_get_group_slug();
// 				// echo "<div class='hidden'><pre>";
// 				// var_dump ($_SERVER);
// 				// echo "</pre></div>";
// 				$template = 'buddypress/groups/single/group-intentions-redirection.php';
// 				if ( file_exists($_SERVER{'DOCUMENT_ROOT'} . "/wp-content/themes/buddyapp-child/" . $template) ) {
// 						include $template;
// 				}
// 		}
// }
// bp_register_group_extension( 'Intentions_Extension' );

// endif;


 /**
 * Function for looking for a value in a multi-dimensional array
 */
function in_multi_array($value, $array)
{
		foreach ($array as $key => $item)
		{
				// Item is not an array
				if (!is_array($item))
				{
						// Is this item our value?
						if ($item == $value) return true;
				}

				// Item is an array
				else
				{
						// See if the array name matches our value
						//if ($key == $value) return true;

						// See if this array matches our value
						if (in_array($value, $item)) return true;

						// Search this array
						else if (in_multi_array($value, $item)) return true;
				}
		}

		// Couldn't find the value in array
		return false;
}

/**
* Function used to add a count bubble for pending startup
*/
add_filter( 'add_menu_classes', 'show_pending_number');
function show_pending_number( $menu ) {
    $type = "startup";
    $status = "pending";
    $num_posts = wp_count_posts( $type, 'readable' );
    $pending_count = 0;
    if ( !empty($num_posts->$status) )
        $pending_count = $num_posts->$status;

    // build string to match in $menu array
    if ($type == 'post') {
        $menu_str = 'edit.php';
    // support custom post types
    } else {
        $menu_str = 'edit.php?post_type=' . $type;
    }

    // loop through $menu items, find match, add indicator
    foreach( $menu as $menu_key => $menu_data ) {
        if( $menu_str != $menu_data[2] )
            continue;
        $menu[$menu_key][0] .= " <span class='update-plugins count-$pending_count'><span class='plugin-count'>" . number_format_i18n($pending_count) . '</span></span>';
    }
    return $menu;
}

/**
* Function used to create a specific WYSIWYG TinyMCE Editor in ACF
*/
add_filter( 'acf/fields/wysiwyg/toolbars' , 'my_toolbars'  );
function my_toolbars( $toolbars )
{
	// Uncomment to view format of $toolbars
	/*
	echo '< pre >';
		print_r($toolbars);
	echo '< /pre >';
	die;
	*/

	// Add a new toolbar called "Very Simple"
	// - this toolbar has only 1 row of buttons
	$toolbars['Very Simple' ] = array();
	$toolbars['Very Simple' ][1] = array('bold' , 'italic' , 'underline', 'numlist', 'bullist' );

	// return $toolbars - IMPORTANT!
	return $toolbars;
}

/**
* Function used to set max length for WYSIWYG TinyMCE Editor in ACF (specific fields)
*/
add_filter('acf/validate_value/name=project_resume', 'my_editor_length_750', 10, 4);
add_filter('acf/validate_value/name=currentstate_resume', 'my_editor_length_750', 10, 4);
add_filter('acf/validate_value/name=ambition_resume', 'my_editor_length_750', 10, 4);
add_filter('acf/validate_value/name=unbreakdownfunds_rusume', 'my_editor_length_750', 10, 4);
add_filter('acf/validate_value/name=outputstrategy_rusume', 'my_editor_length_750', 10, 4);
function my_editor_length_750( $valid, $value, $field, $input ){
    // bail early if value is already invalid
    if( !$valid ) {
        return $valid;
    }
    $trimValue = strip_tags($value);
    $trimValue = str_replace([" ","\n", "\r\n", "\r", "\t","&ndash;","&rsquo;","&#39;","&quot;","&nbsp;"], '', $trimValue);
    $totalCharacter = strlen(utf8_decode($trimValue));
    if( $totalCharacter > 750 ) {
        $valid = 'Vous ne pouvez pas entrer plus de 750 caractères (' . $totalCharacter . ')';
    }
    // return
    return $valid;
}
add_filter('acf/validate_value/name=market_resume', 'my_editor_length_1000', 10, 4);
add_filter('acf/validate_value/name=businessmodel_resume', 'my_editor_length_1000', 10, 4);
function my_editor_length_1000( $valid, $value, $field, $input ){
    // bail early if value is already invalid
    if( !$valid ) {
        return $valid;
    }
    $trimValue = strip_tags($value);
    $trimValue = str_replace([" ","\n", "\r\n", "\r", "\t","&ndash;","&rsquo;","&#39;","&quot;","&nbsp;"], '', $trimValue);
    $totalCharacter = strlen(utf8_decode($trimValue));
    if( $totalCharacter > 1000 ) {
        $valid = 'Vous ne pouvez pas entrer plus de 1000 caractères (' . $totalCharacter . ')';
    }
    // return
    return $valid;
}

/**
* Function used to customize the message when access to the group is blocked
*/
function extend_bp_group_status_message( $group = null ) {
		global $groups_template;
		$current_user = wp_get_current_user();
		$investor_roles = array('app_investor', 'app_premium_investor');
		$user_roles = array('app_user', 'app_premium_user');
		$group_type = bp_groups_get_group_type( $groups_template->group->group_id );
		$group_name = $groups_template->group->name;

		// Group not passed so look for loop.
		if ( empty( $group ) ) {
				$group =& $groups_template->group;
		}

		// Group status is not set (maybe outside of group loop?).
		if ( empty( $group->status ) ) {
				$message = __( 'This group is not currently accessible.', 'buddypress' );

		// Group has a status.
		} else {
				switch( $group->status ) {

						// Private group.
						case 'private' :
								// IF no request membership
								if ( ! bp_group_has_requested_membership( $group ) ) {
										// IF logged
										if ( is_user_logged_in() ) {
												// IF invited
												if ( bp_group_is_invited( $group ) ) {
														$liaison = '';
														if ( $group_type == 'actionnaires' ) {
																$liaison = 'd\'actionnaires de ';
														} elseif ( $group_type == 'campagne' || $group_type == 'closing' ) {
																$liaison = 'de '. $group_type .' de ';
														}
														$message = "
																<i class='fa fa-info-circle icone-huge' aria-hidden='true'></i>
																<h3>Invitation à valider</h3>
																<p>Vous devez accepter l'invitation en attente avant de pouvoir accéder au groupe ". $liaison ."<b>". $group_name ."</b>.</p>
																<a class='button' href='" . add_query_arg( 'redirect_to', bp_get_group_permalink( $group ), bp_get_group_accept_invite_link( $group ) ) . "'>Accepter l'invitation au groupe ". $group_name ."</a>
														";
												// ENDIF invited
												} else {
														// IF user or user premium logged
														if ( array_intersect($user_roles, $current_user->roles) ) {
																if ( $group_type == 'campagne' ) {
																		$message = "
																				<i class='fa fa-exclamation-triangle icone-huge' aria-hidden='true'></i>
																				<h3> Accès restreint</h3>
																				<p>Vous n'avez pas accès à ce groupe de campagne en tant qu'utilisateur.</p>
																				<p class='important'>Devenez investisseur pour accédez à plus de contenu en nous contactant directement via le live chat.</p>
																				<button type='button' class='slaask-open-widget'>Je souhaite devenir investisseur</button>
																				<p>Si vous êtes un membre de l'équipe de la startup faites le nous savoir via le live chat.<p>
																				<button type='button' class='slaask-open-widget'>Je suis un membre de l'équipe de la startup</button>
																		";
																} elseif ( $group_type == 'closing' || $group_type == 'actionnaires') {
																		$message = "
																				<i class='fa fa-exclamation-triangle icone-huge' aria-hidden='true'></i>
																				<h3> Accès restreint</h3>
																				<p>Vous n'avez pas accès à ce groupe en tant qu'utilisateur.</p>
																				<p class='important'>Devenez investisseur pour accédez à plus de contenu en nous contactant directement via le live chat.</b></p>
																				<button type='button' class='slaask-open-widget'>Je souhaite devenir investisseur</button>
																		";
																} else {
																		$message = __( 'This is a private group and you must request group membership in order to join.', 'buddypress' );
																}

														// IF investor or investor premium logged
														} elseif ( array_intersect($investor_roles, $current_user->roles) ) {
																if ( $group_type == 'campagne' || $group_type == 'closing' ) {
																		$liaison = 'au ';
																		if ( $group_type == 'campagne' ) {
																				$liaison = 'à la ';
																		}
																		$message = "
																				<i class='fa fa-exclamation-triangle icone-huge' aria-hidden='true'></i>
																				<h3> Accès restreint</h3>
																				<p>Vous n'avez pas accès à ce groupe de ". $group_type .".</p>
																				<p class='important'>Adhérez à ce groupe et devenez un participant du groupe de ". $group_type ." de ". $group_name .".</p>
																				<a class='button' href='".wp_nonce_url( bp_get_group_permalink( $group ) . 'request-membership', 'groups_request_membership' )."'>Adhérer ". $liaison . $group_type ." de ". $group_name ."</a>
																		";
																} elseif ( $group_type == 'actionnaires') {
																		$message = "
																				<i class='fa fa-exclamation-triangle icone-huge' aria-hidden='true'></i>
																				<h3> Accès restreint</h3>
																				<p>Vous n'avez pas accès à ce groupe d'". $group_type .".</p>
																				<p class='important'>Pour adhérer à ce groupe vous devenez être actionnaire de ". $group_name .".</p>
																				<a class='button' href='".wp_nonce_url( bp_get_group_permalink( $group ) . 'request-membership', 'groups_request_membership' )."'>Je suis actionnaire de ". $group_name ."</a>
																		";
																} else {
																		$message = __( 'This is a private group and you must request group membership in order to join.', 'buddypress' );
																}
														} else {
																$message = __( 'This is a private group and you must request group membership in order to join.', 'buddypress' );
														}
												}
										// ENDIF logged
										} else {
										// IF no log
												$message = '
														<i class="fa fa-exclamation-triangle icone-huge" aria-hidden="true"></i>
														<h3> Accès restreint</h3>
														<p>Ce groupe est privé ! Vous devez être membre du site, puis faire une demande d\'adhésion au groupe.</p>
														<p class="important">Connectez-vous ou créer un compte</p>
														<div class="show-login">
																<a class="button-connexion" href="" onclick="KLEO.main.ajaxLogin()">
																		<i class="icon-lock"></i>Connexion
																</a>
														</div>
												';
										}
								// ENDIF no request membership
								} else {
								// IF request membership
										$liaison = '';
										if ( $group_type == 'actionnaires' ) {
												$liaison = 'd\'actionnaires de ';
										} elseif ( $group_type == 'campagne' || $group_type == 'closing' ) {
												$liaison = 'de '. $group_type .' de ';
										}
										$message = "
												<i class='fa fa-info-circle icone-huge' aria-hidden='true'></i>
												<h3>Demande en attente</h3>
												<p>Votre demande d'adhésion au groupe ". $liaison ."<b>". $group_name ."</b> est en attente de validation par l'administrateur du groupe.</p>
										";
								}

								break;

						// Hidden group.
						case 'hidden' :
						default :
								$message = __( 'This is a hidden group and only invited members can join.', 'buddypress' );
								break;
				}
		}

		/**
		 * Filters a message if the group is not visible to the current user.
		 *
		 * This will be true if it is a hidden or private group, and the user does not have access.
		 *
		 * @since 1.6.0
		 *
		 * @param string $message Message to display to the current user.
		 * @param object $group   Group to get status message for.
		 */
		echo apply_filters( 'extend_bp_group_status_message', $message, $group );
}


/**
* Kill function bp_group_documents_email_notification( $document )
* of the plugin bp-group-documents
* who send an email notification when a doc is added in a group
*/
// add_action( 'plugins_loaded', 'remove_doc_email' );
// function remove_doc_email () {
//   if ( class_exists('BP_Group_Documents_Plugin_Extension') ) {
//   remove_action( 'bp_group_documents_add_success', 'bp_group_documents_email_notification' );
//   }
// }


/**
* Puts a number in the euro currency format
*
* @param string $number Number to be formatted in euros
*/
function euro_format($number) {
	$number = str_replace(',', '.', $number);
	$number = str_replace(' ', '', $number);
	$number = floatval($number);
	setlocale(LC_MONETARY, 'fr_FR');
	$money_format =  money_format('%!n &euro;', $number); // Format to 47 463,50 €
	return str_replace(" ", "&nbsp;", $money_format); // return money format with &nbsp;
}
