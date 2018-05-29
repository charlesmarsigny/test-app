<?php
/**
 * Template Name: Create startup
 *
 * Description: Template for form add startup
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

/* remove sidemenu */
remove_action( 'kleo_after_body', 'kleo_show_side_menu' );

/* remove header */
remove_action( 'kleo_header', 'kleo_show_header', 12 );

acf_form_head();

get_header();
?>

    <?php
    if ( have_posts() ) :
        // Start the Loop.
        while ( have_posts() ) : the_post();
        ?>

            <div class="empty-form">

                <?php get_template_part( 'content','page' ); ?>

                <!-- multistep form -->
                <form id="msform" class="acf-form" action="" method="post">
                  <!-- progressbar -->
                  <ul id="progressbar">
                    <li class="active">Les bases</li>
                    <li>Le pitch</li>
                    <li>Le projet</li>
                    <li>L'équipe</li>
                    <li>Soumettre</li>
                  </ul>
                  <!-- fieldsets -->
                
                <!-- Les bases -->
                  <fieldset>
                    <h2 class="fs-title">C'est parti.</h2>
                    <h3 class="fs-subtitle">Faites bonne impression avec le logo, la couverture et la description de votre projet.<br>Définissez le classement de votre projet avec la catégorie et les mots-clés.<br>Ciblez avec le secteur et type d'activité.</h3>
                    <input type="button" name="next" class="next action-button" value="Suivant" />
                    <?php acf_form(array(
                        'post_id'       => 'new_post',
                        'new_post'      => array(
                                'post_type'     => 'startup',
                                'post_status'   => 'pending'
                            ),
                        'uploader' => 'wp', // 'wp' or 'basic'
                        'instruction_placement' => 'field', // 'label' (Below labels) or 'field' (Below fields)
                        'post_title' => true,
                        'honeypot'      => true,
                        'fields'        => array(
                                'logo_startup',
                                'cover_startup',
                                'excerpt_startup',
                                'category_startup',
                                'tag_startup',
                                'sector_startup',
                                'type_startup'
                            ),
                        'form' => false,
                    )); ?>
                    <input type="button" name="next" class="next action-button" value="Suivant" />
                  </fieldset>

                  <fieldset>
                    <h2 class="fs-title">Donnez envie.</h2>
                    <h3 class="fs-subtitle">Présentez votre projet en images et beaux discourts.<br>Ajutez des vidéos, du contenu et toutes les intégrations qui vous sont nécessaires.</h3>
                    <input type="button" name="previous" class="previous action-button" value="Précédent" />
                    <input type="button" name="next" class="next action-button" value="Suivant" />

                    <?php acf_form(array(
                        'uploader' => 'wp', // 'wp' or 'basic'
                        'instruction_placement' => 'field', // 'label' (Below labels) or 'field' (Below fields)
                        'honeypot'      => true,
                        'fields'        => array(
                                'header_pitch',
                                'video_pitch',
                                'gallery_pitch',
                                'image_pitch',
                                'content_pitch'
                            ),
                        'form' => false,
                    )); ?>

                    <input type="button" name="previous" class="previous action-button" value="Précédent" />
                    <input type="button" name="next" class="next action-button" value="Suivant" />
                  </fieldset>

                  <fieldset>
                    <h2 class="fs-title">C'est du sérieux.</h2>
                    <h3 class="fs-subtitle">L'executive summary de votre projet.<br>Destiné aux investiseurs, cette partie exprime l'essentiel de votre activité.</h3>
                    <input type="button" name="previous" class="previous action-button" value="Précédent" />
                    <input type="button" name="next" class="next action-button" value="Suivant" />
                    
                    <h4>La société</h4>
                    <?php acf_form(array(
                        'uploader' => 'wp', // 'wp' or 'basic'
                        'instruction_placement' => 'field', // 'label' (Below labels) or 'field' (Below fields)
                        'honeypot'      => true,
                        'fields'        => array(
                                'if_company',
                                'name_company',
                                'website_company',
                                'siren_company',
                                'ape_company',
                                'legalform_company',
                                'date_company',
                                'capital_company',
                                'jei_company',
                                'eip_company',
                                'address_headquarters_company',
                                'address_company'
                            ),
                        'form' => false,
                    )); ?>

                    <h4>En résumé</h4>
                    <?php acf_form(array(
                        'uploader' => 'wp', // 'wp' or 'basic'
                        'instruction_placement' => 'field', // 'label' (Below labels) or 'field' (Below fields)
                        'honeypot'      => true,
                        'fields'        => array(
                                'project_resume',
                                'businessmodel_resume',
                                'market_resume',
                                'competitor_resume',
                                'currentstate_resume'
                            ),
                        'form' => false,
                    )); ?>

                    <input type="button" name="previous" class="previous action-button" value="Précédent" />
                    <input type="button" name="next" class="next action-button" value="Suivant" />
                  </fieldset>

                  <fieldset>
                    <h2 class="fs-title">Vous.</h2>
                    <h3 class="fs-subtitle">Ajoutez les différents membres de votre équipe.<br>Sélectionnez un utilisateur ou ajoutez quelqu'un qui n'est pas encore inscrit.</h3>
                    <input type="button" name="previous" class="previous action-button" value="Précédent" />
                    <input type="button" name="next" class="next action-button" value="Suivant" />

                    <?php acf_form(array(
                        'uploader' => 'wp', // 'wp' or 'basic'
                        'instruction_placement' => 'field', // 'label' (Below labels) or 'field' (Below fields)
                        'honeypot'      => true,
                        'fields'        => array('members_team'),
                        'form' => false,
                    )); ?>

                    <input type="button" name="previous" class="previous action-button" value="Précédent" />
                    <input type="button" name="next" class="next action-button" value="Suivant" />
                  </fieldset>

                  <fieldset>
                    <h2 class="fs-title">Dans nos mains.</h2>
                    <h3 class="fs-subtitle">Publiez votre projet pour que nos équipes l'approuvent.</h3>

                    <!-- Fields -->

                    <input type="button" name="previous" class="previous action-button" value="Précédent" />
                    <div class="acf-form-submit">
                        <input type="submit" name="submit" class="acf-button button button-primary button-large submit action-button" value="Soumettre le projet">
                        <span class="acf-spinner"></span>
                    </div>
                  </fieldset>

                </form>

            </div>

        <?php
        endwhile;

    endif;
    ?>

<script type="text/javascript">
    (function($) {
        //jQuery time
        var current_fs, next_fs, previous_fs; //fieldsets
        var left, opacity, scale; //fieldset properties which we will animate
        var animating; //flag to prevent quick multi-click glitches

        $(".next").click(function(){
            if(animating) return false;
            animating = true;
            
            current_fs = $(this).parent();
            next_fs = $(this).parent().next();
            
            //activate next step on progressbar using the index of next_fs
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
            
            //show the next fieldset
            next_fs.show(); 
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale current_fs down to 80%
                    scale = 1 - (1 - now) * 0.2;
                    //2. bring next_fs from the right(50%)
                    left = (now * 50)+"%";
                    //3. increase opacity of next_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({
                'transform': 'scale('+scale+')',
                'position': 'absolute'
              });
                    next_fs.css({'left': left, 'opacity': opacity});
                }, 
                duration: 800, 
                complete: function(){
                    current_fs.hide();
                    animating = false;
                }, 
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".previous").click(function(){
            if(animating) return false;
            animating = true;
            
            current_fs = $(this).parent();
            previous_fs = $(this).parent().prev();
            
            //de-activate current step on progressbar
            $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
            
            //show the previous fieldset
            previous_fs.show(); 
            //hide the current fieldset with style
            current_fs.animate({opacity: 0}, {
                step: function(now, mx) {
                    //as the opacity of current_fs reduces to 0 - stored in "now"
                    //1. scale previous_fs from 80% to 100%
                    scale = 0.8 + (1 - now) * 0.2;
                    //2. take current_fs to the right(50%) - from 0%
                    left = ((1-now) * 50)+"%";
                    //3. increase opacity of previous_fs to 1 as it moves in
                    opacity = 1 - now;
                    current_fs.css({'left': left});
                    previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity, 'position': 'relative'});
                }, 
                duration: 800, 
                complete: function(){
                    current_fs.hide();
                    animating = false;
                }, 
                //this comes from the custom easing plugin
                easing: 'easeInOutBack'
            });
        });

        $(".submit").click(function(){
            return false;
        })
    })(jQuery);
</script>

<?php
get_footer();
?>