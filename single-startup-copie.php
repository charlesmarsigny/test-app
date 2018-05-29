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
$current_user = wp_get_current_user();
$allowed_roles = array('administrator', 'webmaster');
$investor_roles = array('app_investor', 'app_premium_investor');

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
                
                <!-- Admin action bar -->
                <?php if( array_intersect($allowed_roles, $current_user->roles) || is_author($current_user) ) : ?>
                    <style>
                    @media only screen and (min-width: 768px) {
                        #item-header-wrap {
                            top: 120px;
                        }
                        .single-startup .startup .main-content #item-body {
                            padding-top: 100px;
                        }
                    }
                    </style>

                    <div class="admin-action-bar">
                        <div class="left-box-admin">
                            <div class="admin-bar-title">Menu d'édition</div>
                            <ul>
                                <li class="button secondary-button half-button-left add-news"><a href="#"><i class="icon-newspaper"></i>Ajouter une actualité</a></li>
                                <li class="button secondary-button half-button-right small-padding news-more"><a href="#"><i class="icon-arrow-down"></i></a></li>
                                <li class="stats"><a href="#"><i class="icon-statistics"></i>Statistiques</a></li>
                                <li class="stats"><a href="#"><?php echo do_shortcode('[post-views]'); ?> visites</li>
                            </ul>
                        </div>
                        <div class="center-box-admin">
                            <ul>
                                <li class="status"><a href="#">Statut<i class="icon-arrow-down"></i></a></li>
                                <li class="startup-members"><a href="#">Participants</a></li>
                            </ul>
                        </div>
                        <div class="right-box-admin">
                            <ul>
                                <?php if( array_intersect($allowed_roles, $current_user->roles) ) : ?>
                                    <li class="button secondary-button admin-edit"><a href="<?php echo admin_url( 'post.php?post=' . $post_id . '&action=edit' ); ?>"><i class="icon-view-quilt"></i>Modifier</a></li>
                                <?php endif; ?>
                                <li class="button primary-button half-button-left edit"><a href="#"><i class="icon-edit"></i>Éditer</a></li>
                                <li class="button primary-button half-button-right small-padding edit-more"><a href="#"><i class="icon-arrow-down"></i></a></li>
                                <li class="button empty-button settings"><a href="#"><i class="icon-settings"></i><i class="icon-arrow-down"></i></a></li>
                            </ul>
                        </div>
                    </div> 
                <?php endif; ?>
                <!-- /Admin action bar -->
                
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
                                if ($project_title) : ?>
                                    <h2><?php echo $project_title; ?><br><small><?php the_title(); ?></small></h2>
                                <?php else : ?>
                                    <?php the_title('<h2>', '</h2>'); ?>
                                <?php endif; ?>
                                
                                <!-- Category -->
                                <?php
                                $category_startup_term = get_field( 'category_startup' );
                                if ( $category_startup_term ) {
                                    echo '<span class="activity">' . $category_startup_term->name . '</span>';
                                } ?>

                                
                                <div id="item-meta">

                                    <div id="item-buttons">

                                        
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

                        <div id="item-nav">
                            <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                                <ul class="etabs">
                                    <?php
                                    $news_count = count( get_field('linked_actualite_startup') );
                                    $comments_count = wp_count_comments($post_id);
                                    $documents_count = count( get_field('linked_doc_startup') );
                                    $groups_count = count( get_field('linked_group_startup') );
                                    $intentions_count = count( get_field('linked_intention_startup') );
                                    $liquidities_count = count( get_field('linked_liquidite_startup') );
                                    $dealflow = get_field('dealflow_process');
                                    $totalaccess = get_field('totalaccess_paricipant');
                                    $projectacces = get_field('projectaccess_paricipant');
                                    $documentaccess = get_field('documentaccess_paricipant');

                                     // Function for looking for a value in a multi-dimensional array
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
                                    ?>

                                    <!-- Pitch tab menu -->

                                    <li id="pitch-li" class="tab">
                                        <a id="pitch-tab" href="/startup-page/pitch/?id=<?php echo $post_id; ?>" data-target="#pitch">Pitch</a>
                                    </li>

                                    <!-- Pitch tab menu -->

                                    <!-- News tab menu -->

                                    <li id="news-li" class="tab">
                                        <a id="news-tab" href="/startup-page/actualites/?id=<?php echo $post_id; ?>" data-target="#actualites">Actualités
                                        <?php if ( $news_count > 0 ) {
                                            echo '<span>' . $news_count . '</span>';
                                        } ?>
                                        </a>
                                    </li>

                                    <!-- /News tab menu -->

                                    <!-- Comment tab menu -->

                                    <li id="comments-li" class="tab">
                                        <a id="comments-tab" href="/startup-page/commentaires/?id=<?php echo $post_id; ?>" data-target="#commentaires">
                                        <?php if( array_intersect($investor_roles, $current_user->roles ) ) {
                                            echo 'Commentaires publics';
                                        } else {
                                            echo 'Commentaires';
                                        } ?>
                                        <?php if ( $comments_count->approved > 0 ) {
                                            echo '<span>' . $comments_count->approved . '</span>';
                                        } ?>
                                        </a>
                                    </li>

                                    <!-- Comment tab menu -->


                                    <!-- Project tab menu -->

                                    <?php // IF Deal flow WLS
                                    if ( $dealflow && in_array('wls', $dealflow) && (get_field('statut_wls_process') == 'campaign'  || get_field('statut_wls_process') == 'closing' || get_field('statut_wls_process') == 'funded') ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="project-li" class="tab">
                                                <a id="project-tab" href="/startup-page/projet/?id=<?php echo $post_id; ?>" data-target="#projet">Projet</a>
                                            </li>

                                        <?php // ELSEIF project access
                                        elseif ( $projectacces && in_multi_array($current_user->ID, $projectacces) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="project-li" class="tab">
                                                <a id="project-tab" href="/startup-page/projet/?id=<?php echo $post_id; ?>" data-target="#projet">Projet</a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="project-li" class="lock">
                                                <a id="project-tab" href="#" data-target="#projet"><i class="icon-lock"></i>Projet</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Deal flow WRS
                                    elseif ( $dealflow && in_array('wrs', $dealflow) ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="project-li" class="tab">
                                                <a id="project-tab" href="/startup-page/projet/?id=<?php echo $post_id; ?>" data-target="#projet">Projet</a>
                                            </li>

                                        <?php // ELSEIF project access
                                        elseif ( $projectacces && in_multi_array($current_user->ID, $projectacces) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="project-li" class="tab">
                                                <a id="project-tab" href="/startup-page/projet/?id=<?php echo $post_id; ?>" data-target="#projet">Projet</a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="project-li" class="lock">
                                                <a id="project-tab" href="#" data-target="#projet"><i class="icon-lock"></i>Projet</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Admin or Webmaster
                                    elseif( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                        <li id="project-li" class="tab">
                                            <a id="project-tab" href="/startup-page/projet/?id=<?php echo $post_id; ?>" data-target="#projet"><i class="icon-visibility-off"></i>Projet</a>
                                        </li>

                                    <?php endif; ?>

                                    <!-- /Project tab menu -->


                                    <!-- Team tab menu -->
                                    
                                    <?php // IF Deal flow WLS
                                    if ( $dealflow && in_array('wls', $dealflow) && (get_field('statut_wls_process') == 'campaign'  || get_field('statut_wls_process') == 'closing' || get_field('statut_wls_process') == 'funded') ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="team-li" class="tab">
                                                <a id="team-tab" href="/startup-page/equipe/?id=<?php echo $post_id; ?>" data-target="#equipe">Équipe</a>
                                            </li>

                                        <?php // ELSEIF project access
                                        elseif ( $projectacces && in_multi_array($current_user->ID, $projectacces) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="team-li" class="tab">
                                                <a id="team-tab" href="/startup-page/equipe/?id=<?php echo $post_id; ?>" data-target="#equipe">Équipe</a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="team-li" class="lock">
                                                <a id="team-tab" href="#" data-target="#equipe"><i class="icon-lock"></i>Équipe</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Deal flow WRS
                                    elseif ( $dealflow && in_array('wrs', $dealflow) ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="team-li" class="tab">
                                                <a id="team-tab" href="/startup-page/equipe/?id=<?php echo $post_id; ?>" data-target="#equipe">Équipe</a>
                                            </li>

                                        <?php // ELSEIF project access
                                        elseif ( $projectacces && in_multi_array($current_user->ID, $projectacces) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="team-li" class="tab">
                                                <a id="team-tab" href="/startup-page/equipe/?id=<?php echo $post_id; ?>" data-target="#equipe">Équipe</a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="team-li" class="lock">
                                                <a id="team-tab" href="#" data-target="#equipe"><i class="icon-lock"></i>Équipe</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Admin or Webmaster
                                    elseif( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                        <li id="team-li" class="tab">
                                            <a id="team-tab" href="/startup-page/equipe/?id=<?php echo $post_id; ?>" data-target="#equipe"><i class="icon-visibility-off"></i>Équipe</a>
                                        </li>

                                    <?php endif; ?>
                                            

                                    <!-- /Team tab menu -->


                                    <!-- Doncument tab menu -->

                                    <?php // IF Deal flow WLS
                                    if ( $dealflow && in_array('wls', $dealflow) && (get_field('statut_wls_process') == 'campaign'  || get_field('statut_wls_process') == 'closing' || get_field('statut_wls_process') == 'funded') ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="documents-li" class="tab">
                                                <a id="documents-tab" href="/startup-page/documents/?id=<?php echo $post_id; ?>" data-target="#documents">Documents
                                                <?php if ( $documents_count > 0 ) {
                                                    echo '<span>' . $documents_count . '</span>';
                                                } ?>
                                                </a>
                                            </li>

                                        <?php // ELSEIF document access
                                        elseif ( $documentaccess && in_multi_array($current_user->ID, $documentaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="documents-li" class="tab">
                                                <a id="documents-tab" href="/startup-page/documents/?id=<?php echo $post_id; ?>" data-target="#documents">Documents
                                                <?php if ( $documents_count > 0 ) {
                                                    echo '<span>' . $documents_count . '</span>';
                                                } ?>
                                                </a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="documents-li" class="lock">
                                                <a id="documents-tab" href="#" data-target="#documents"><i class="icon-lock"></i>Documents</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Deal flow WRS
                                    elseif ( $dealflow && in_array('wrs', $dealflow) ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="documents-li" class="tab">
                                                <a id="documents-tab" href="/startup-page/documents/?id=<?php echo $post_id; ?>" data-target="#documents">Documents
                                                <?php if ( $documents_count > 0 ) {
                                                    echo '<span>' . $documents_count . '</span>';
                                                } ?>
                                                </a>
                                            </li>

                                        <?php // ELSEIF document access
                                        elseif ( $documentaccess && in_multi_array($current_user->ID, $documentaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="documents-li" class="tab">
                                                <a id="documents-tab" href="/startup-page/documents/?id=<?php echo $post_id; ?>" data-target="#documents">Documents
                                                <?php if ( $documents_count > 0 ) {
                                                    echo '<span>' . $documents_count . '</span>';
                                                } ?>
                                                </a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="documents-li" class="lock">
                                                <a id="documents-tab" href="#" data-target="#documents"><i class="icon-lock"></i>Documents</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Admin or Webmaster
                                    elseif( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                        <li id="documents-li" class="tab">
                                            <a id="documents-tab" href="/startup-page/documents/?id=<?php echo $post_id; ?>" data-target="#documents"><i class="icon-visibility-off"></i>Documents
                                            <?php if ( $documents_count > 0 ) {
                                                echo '<span>' . $documents_count . '</span>';
                                            } ?>
                                            </a>
                                        </li>

                                    <?php endif; ?>

                                    <!-- /Doncument tab menu -->


                                    <!-- Group tab menu -->
                                    <?php if ( $dealflow && in_array('wls', $dealflow) && (get_field('statut_wls_process') == 'closing' || get_field('statut_wls_process') == 'funded') ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="groups-li" class="tab">
                                                <a id="groups-tab" href="/startup-page/groupes/?id=<?php echo $post_id; ?>" data-target="#groupes">Groupes
                                                <?php if ( $groups_count > 0 ) {
                                                    echo '<span>' . $groups_count . '</span>';
                                                } ?>
                                                </a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="groups-li" class="lock">
                                                <a id="groups-tab" href="#" data-target="#groupes"><i class="icon-lock"></i>Groupes</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Admin or Webmaster
                                    elseif( array_intersect($allowed_roles, $current_user->roles ) ) :  ?>
                                        <li id="groups-li" class="tab">
                                            <a id="groups-tab" href="/startup-page/groupes/?id=<?php echo $post_id; ?>" data-target="#groupes"><i class="icon-visibility-off"></i>Groupes
                                            <?php if ( $groups_count > 0 ) {
                                                echo '<span>' . $groups_count . '</span>';
                                            } ?>
                                            </a>
                                        </li>

                                    <?php endif; ?>

                                    <!-- /Group tab menu -->


                                    <!-- Intention tab menu -->

                                    <?php // IF Deal flow WLS
                                    if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'closing' ) :
                                    
                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="intentions-li" class="tab">
                                                <a id="intention-tab" href="/startup-page/intentions/?id=<?php echo $post_id; ?>" data-target="#intentions">Intentions
                                                <?php if ( $intentions_count > 0 ) {
                                                    echo '<span>' . $intentions_count . '</span>';
                                                } ?>
                                                </a>
                                            </li>

                                        <?php else : // LOCK ?>
                                            <li id="intentions-li" class="lock">
                                                <a id="intention-tab" href="#" data-target="#intentions"><i class="icon-lock"></i>Intentions</a>
                                            </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Admin or Webmaster
                                    elseif( array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                        <li id="intentions-li" class="tab">
                                            <a id="intention-tab" href="/startup-page/intentions/?id=<?php echo $post_id; ?>" data-target="#intentions"><i class="icon-visibility-off"></i>Intentions
                                            <?php if ( $intentions_count > 0 ) {
                                                echo '<span>' . $intentions_count . '</span>';
                                            } ?>
                                            </a>
                                        </li>

                                    <?php endif; ?>

                                    <!-- /Intention tab menu -->


                                    <!-- Liquidity tab menu -->

                                    <?php // IF Deal flow WLS
                                    if ( $dealflow && in_array('wls', $dealflow) && get_field('statut_wls_process') == 'funded' ) :

                                        // IF total access
                                        if ( $totalaccess && in_multi_array($current_user->ID, $totalaccess) || array_intersect($allowed_roles, $current_user->roles ) ) : ?>
                                            <li id="liquidities-li" class="tab">
                                                <a id="liquidity-tab" href="/startup-page/liquidites/?id=<?php echo $post_id; ?>" data-target="#liquidites">Liquidités
                                                <?php if ( $liquidities_count > 0 ) {
                                                    echo '<span>' . $liquidities_count . '</span>';
                                                } ?>
                                                </a>
                                            </li>

                                        <?php else : // LOCK ?>
                                        <li id="liquidities-li" class="lock">
                                            <a id="liquidity-tab" href="#" data-target="#liquidites"><i class="icon-lock"></i>Liquidités</a>
                                        </li>

                                        <?php endif; ?>

                                    <?php // ELSEIF Admin or Webmaster
                                    elseif( array_intersect($allowed_roles, $current_user->roles ) ) :  ?>
                                    <li id="liquidities-li" class="tab">
                                        <a id="liquidity-tab" href="/startup-page/liquidites/?id=<?php echo $post_id; ?>" data-target="#liquidites"><i class="icon-visibility-off"></i>Liquidités
                                        <?php if ( $liquidities_count > 0 ) {
                                            echo '<span>' . $liquidities_count . '</span>';
                                        } ?>
                                        </a>
                                    </li>

                                    <?php endif; ?>

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


                    <!-- TAB Pitch -->
                    <div id="pitch" class="item-tab"></div>
                    <!-- /TAB Pitch -->

                    <!-- TAB News -->
                    <div id="actualites" class="item-tab"></div>
                    <!-- /TAB News -->

                    <!-- TAB Comments -->
                    <div id="commentaires" class="item-tab"></div>
                    <!-- /TAB Comments -->

                    <!-- TAB Project -->
                    <div id="projet" class="item-tab"></div>
                    <!-- /TAB Project -->

                    <!-- TAB Team -->
                    <div id="equipe" class="item-tab"></div>
                    <!-- /TAB Team -->

                    <!-- TAB Documents -->
                    <div id="documents" class="item-tab"></div>
                    <!-- /TAB Documents -->

                    <!-- TAB Groups -->
                    <div id="groupes" class="item-tab"></div>
                    <!-- /TAB Groups -->

                    <!-- TAB Intentions -->
                    <div id="intentions" class="item-tab"></div>
                    <!-- /TAB Intentions -->

                    <!-- TAB Liquidites -->
                    <div id="liquidites" class="item-tab"></div>
                    <!-- /TAB Liquidites -->


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
          transitionIn: 'fadeIn',
          transitionOut: 'fadeOut',
          tabActiveClass: 'current'
        })
        .bind('easytabs:ajax:complete', function(e, $clicked, $targetPanel, settings) {
          if ( $targetPanel.get(0).id === 'actualites' ) {
            $.scrollTo($targetPanel, 800);
          }
          if ( $targetPanel.get(0).id === 'commentaires' ) {
            $.scrollTo($targetPanel, 800);
          }
          if ( $targetPanel.get(0).id === 'projet' ) {
            $.scrollTo($targetPanel, 800);
          }
          if ( $targetPanel.get(0).id === 'equipe' ) {
            $.scrollTo($targetPanel, 800);
          }
          if ( $targetPanel.get(0).id === 'documents' ) {
            $.scrollTo($targetPanel, 800);
          }
          if ( $targetPanel.get(0).id === 'groupes' ) {
            $.scrollTo($targetPanel, 800);
          }
          if ( $targetPanel.get(0).id === 'intentions' ) {
            $.scrollTo($targetPanel, 800);
          }
          if ( $targetPanel.get(0).id === 'liquidites' ) {
            $.scrollTo($targetPanel, 800);
          }
        });

    })(jQuery);
</script>


<?php get_footer(); ?>