<?php
/**
 * Template Name: new startup
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

            <?php get_template_part( 'content','page' ); ?>

            <div class="startup-form">

                <?php
                $step_form = get_field('step_form_startup');
                $laststep_name_form = get_field('laststep_name_form_startup');
                $laststep_message_form = get_field('laststep_message_form_startup');
                $laststep_button_form = get_field('laststep_button_form_startup');
                $status_form = get_field('status_form_startup');
                $post_link = get_permalink();
                // Class startup ID
                $class_startup = get_field('class_startup');
                // Recover class key
                $class = get_field_object('class_startup');
                $class_key = $class['key'];
                // Array 1 dimension : Dealflow process
                $dealflow_process = get_field('dealflow_process');
                // Recover Deal Flow key
                $dealflow = get_field_object('dealflow_process');
                $dealflow_key = $dealflow['key'];
                // Array 2 dimensions : All fields about dealflow
                $group_fields = acf_get_fields('group_584ec5683dd8e');


                /****  Create checkbox to return the dealflow process form this template form  ****/
                function create_checkbox_dealflow($dealflow_process, $dealflow_key) {
                    foreach ( $dealflow_process as $process ) {
                        $checkbox .= '<input type="checkbox" class="dealflow-process" name="acf['. $dealflow_key .'][]" value='. $process .' checked>';
                    }
                    return $checkbox;
                }


                /****  Automatic creation of hidden inputs for ACF group fields  ****/
                // Create simple associative array from a 2 dimensional array with regex and specific key search
                function array_2d_specific_search($array_research, $regex_research, $key_research, $key_return, $value_return)
                {
                    $array_result = array();
                    if ( $array_research && is_array($array_research) ) {
                        foreach ($array_research as $sub_array_research)
                        {
                            if( preg_match($regex_research, $sub_array_research[$key_research]) ){
                                foreach ($sub_array_research as $key => $value)
                                {
                                    if ( $key == $key_return ){
                                        $array_result[$value] = $value_return;
                                    }
                                }
                            }
                        }
                        return $array_result;
                    } else {
                        return $array_result;
                    }
                }
                // Create hidden inputs with a variable name and value from a simple array
                function create_hidden_inputs($array_fields) {
                    $result = '';
                    if ( $array_fields && is_array($array_fields) ) {
                        foreach ($array_fields as $key_field => $value_field) {
                            $result .= '<input type="hidden" class="dealflow-statut" name="acf['. $key_field .']" value='. $value_field .'>';
                        }
                    }
                    return $result;
                }
                $array_statut = array_2d_specific_search($group_fields, '#^statut_#', "name", "key", "new");
                $array_roundtable = array_2d_specific_search($group_fields, '#^roundtable_#', "name", "key", 1);


                if($step_form) : ?>

                    <form id="post" class="acf-form" action="" method="post">

                        <div>

                            <?php // Before count
                            $step_count = 0;
                            ?>

                            <?php foreach($step_form as $field) : ?>

                                <?php
                                $instruction_placement = get_field('instruction_placement_form_startup');
                                ?>

                                <?php echo '<h2>' . $field['step_name_form_startup'] . '</h2>'; ?>
                                <section>
                                    <?php
                                    echo '<h3>' . $field['head_title_form_startup'] . '</h3>';
                                    echo '<p class="excerpt-form">' . $field['excerpt_form_startup'] . '</p>';
                                    ?>
                                    <?php acf_form(array(
                                        'post_id'       => 'new_post',
                                        'new_post'      => array(
                                                'post_type'     => 'startup',
                                                'post_status'   => $status_form
                                            ),
                                        'uploader' => 'wp', // 'wp' or 'basic'
                                        'instruction_placement' => $instruction_placement, // 'label' (Below labels) or 'field' (Below fields)
                                        'honeypot'      => true,
                                        'return' => $post_link . '?new=true',
                                        'field_groups' => array(10669),
                                        'fields'        => array(
                                                // base
                                                ( $field['startup_name_field_form'] ? 'startup_name' : ',' ),
                                                ( $field['project_name_field_form'] ? 'project_name' : ',' ),
                                                ( $field['logo_field_form_startup'] ? 'logo_startup' : ',' ),
                                                ( $field['cover_field_form_startup'] ? 'cover_startup' : ',' ),
                                                ( $field['slogan_field_form_startup'] ? 'slogan_startup' : ',' ),
                                                ( $field['excerpt_field_form_startup'] ? 'excerpt_startup' : ',' ),
                                                ( $field['category_field_form_startup'] ? 'indexing_startup' : ',' ),
                                                ( $field['tag_field_form_startup'] ? 'tag_startup' : ',' ),
                                                ( $field['sector_field_form_startup'] ? 'sector_startup' : ',' ),
                                                ( $field['type_field_form_startup'] ? 'type_startup' : ',' ),

                                                // social
                                                ( $field['facebook_field_form_startup'] ? 'facebook_startup' : ',' ),
                                                ( $field['twitter_field_form_startup'] ? 'twitter_startup' : ',' ),
                                                ( $field['linkedin_field_form_startup'] ? 'linkedin_startup' : ',' ),
                                                ( $field['google_field_form_startup'] ? 'google_startup' : ',' ),
                                                ( $field['pinterest_field_form_startup'] ? 'pinterest_startup' : ',' ),
                                                ( $field['instagram_field_form_startup'] ? 'instagram_startup' : ',' ),
                                                ( $field['youtube_field_form_startup'] ? 'youtube_startup' : ',' ),
                                                ( $field['vimeo_field_form_startup'] ? 'vimeo_startup' : ',' ),

                                                // pith
                                                ( $field['headerpitch_field_form_startup'] ? 'header_pitch' : ',' ),
                                                ( $field['headerpitch_field_form_startup'] ? 'video_pitch' : ',' ),
                                                ( $field['headerpitch_field_form_startup'] ? 'gallery_pitch' : ',' ),
                                                ( $field['headerpitch_field_form_startup'] ? 'image_pitch' : ',' ),
                                                ( $field['content_field_form_startup'] ? 'content_pitch' : ',' ),

                                                // company
                                                ( $field['createstartup_field_form_startup'] ? 'if_company' : ',' ),
                                                ( $field['namecompany_field_form_startup'] ? 'name_company' : ',' ),
                                                ( $field['contact_field_form_startup'] ? 'contact_company' : ',' ),
                                                ( $field['email_field_form_startup'] ? 'email_company' : ',' ),
                                                ( $field['phone_field_form_startup'] ? 'phone_company' : ',' ),
                                                ( $field['website_field_form_startup'] ? 'website_company' : ',' ),
                                                ( $field['siren_field_form_startup'] ? 'siren_company' : ',' ),
                                                ( $field['ape_field_form_startup'] ? 'ape_company' : ',' ),
                                                ( $field['legalform_field_form_startup'] ? 'legalform_company' : ',' ),
                                                ( $field['datecompany_field_form_startup'] ? 'date_company' : ',' ),
                                                ( $field['capital_field_form_startup'] ? 'capital_company' : ',' ),
                                                ( $field['jei_field_form_startup'] ? 'jei_company' : ',' ),
                                                ( $field['eip_field_form_startup'] ? 'eip_company' : ',' ),
                                                ( $field['addresshead_field_form_startup'] ? 'address_headquarters_company' : ',' ),
                                                ( $field['address_field_form_startup'] ? 'address_company' : ',' ),

                                                // project
                                                ( $field['resume_field_form_startup'] ? 'project_resume' : ',' ),
                                                ( $field['offer_field_form_startup'] ? 'businessmodel_resume' : ',' ),
                                                ( $field['market_field_form_startup'] ? 'market_resume' : ',' ),
                                                ( $field['competitor_field_form_startup'] ? 'competitor_resume' : ',' ),
                                                ( $field['currentstate_field_form_startup'] ? 'currentstate_resume' : ',' ),
                                                ( $field['ambition_field_form_startup'] ? 'ambition_resume' : ',' ),
                                                ( $field['comment_field_form_startup'] ? 'comment_resume' : ',' ),

                                                // team
                                                ( $field['team_field_form_startup'] ? 'members_team' : ',' ),

                                                // funds
                                                ( $field['wantedfunds_field_form_startup'] ? 'wantedfunds_rusume' : ',' ),
                                                ( $field['datefunds_field_form_startup'] ? 'datefunds_rusume' : ',' ),
                                                ( $field['postmoneyvalue_field_form_startup'] ? 'postmoneyvalue_rusume' : ',' ),
                                                ( $field['estimationmethod_field_form_startup'] ? 'estimationmethod_rusume' : ',' ),
                                                ( $field['breakdownfunds_field_form_startup'] ? 'breakdownfunds_rusume' : ',' ),
                                                ( $field['breakdownfunds_field_form_startup'] ? 'ratebreakdownfunds_rusume' : ',' ),
                                                ( $field['breakdownfunds_field_form_startup'] ? 'unbreakdownfunds_rusume' : ',' ),
                                                ( $field['otherapplication_field_form_startup'] ? 'otherapplication_rusume' : ',' ),
                                                ( $field['outputstrategy_field_form_startup'] ? 'outputstrategy_rusume' : ',' ),

                                                // finance
                                                ( $field['shareholders_field_form_startup'] ? 'shareholders_resume' : ',' ),
                                                ( $field['fundraising_field_form_startup'] ? 'fundraising_resume' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'field_59df7a720a3f2' : ',' ), // title
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb53a7393a' : ',' ), // column 1
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb55e7393b' : ',' ), // N-1
                                                ( $field['fundtable_field_form_startup'] ? 'date_financial_n-1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'turnover_financial_n-1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'netprofit_financial_n-1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'employees_fte_financial_n-1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb6b473940' : ',' ), // Column 2
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb72473941' : ',' ), // N
                                                ( $field['fundtable_field_form_startup'] ? 'date_financial_n' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'turnover_financial_n' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'netprofit_financial_n' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'employees_fte_financial_n' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb77c73946' : ',' ), // Column 3
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb78973947' : ',' ), // N+1
                                                ( $field['fundtable_field_form_startup'] ? 'date_financial_n+1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'turnover_financial_n+1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'netprofit_financial_n+1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'employees_fte_financial_n+1' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb7ca7394c' : ',' ), // Column 4
                                                ( $field['fundtable_field_form_startup'] ? 'field_587fb7d47394d' : ',' ), // N+2
                                                ( $field['fundtable_field_form_startup'] ? 'date_financial_n+2' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'turnover_financial_n+2' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'netprofit_financial_n+2' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'employees_fte_financial_n+2' : ',' ),
                                                ( $field['fundtable_field_form_startup'] ? 'field_5880d00cda8ef' : ',' ), // Reset column

                                                // preferences
                                                ( $field['primarycolor_field_form_startup'] ? 'primary_color_startup' : ',' ),
                                                ( $field['secondarycolor_field_form_startup'] ? 'secondary_color_startup' : ',' ),
                                                ( $field['source_field_form_startup'] ? 'source_startup' : ',' ),
                                            ),
                                        'form' => false
                                    )); ?>
                                </section>

                                <?php
                                $step_count++;
                                ?>
                            <?php endforeach; ?>

                            <h2><?php echo $laststep_name_form; ?></h2>
                            <section>
                                <div class="hidden-input-dealflow">
                                    <?php echo create_hidden_inputs($array_statut); ?>
                                    <?php echo create_hidden_inputs($array_roundtable); ?>
                                </div>
                                <div class="hidden get-dealflow get-class">
                                    <?php
                                        if ( $dealflow_process && $dealflow_key ) {
                                            echo create_checkbox_dealflow($dealflow_process, $dealflow_key);
                                        }
                                        // if ( $class_startup && $class_key ) {
                                        //     echo '<input type="hidden" class="startup-class" name="acf['. $class_key .']" value="'. $class_startup .'"">';
                                        // }
                                        echo '<pre>'.var_dump($class_startup).'</pre>';
                                        echo '<pre>'.var_dump($class_key).'</pre>';
                                    ?>
                                    <input type="hidden" name="after-submit" value="true">
                                    <pre>
                                        <?php
                                            var_dump($dealflow_process);
                                            var_dump($dealflow_key);
                                        ?>
                                    </pre>
                                </div>

                                 <div class="partner-form-fields">
                                    <?php // acf_form(array(
                                       // 'fields' => array('linking_partners'),
                                       // 'form' => false
                                    // )); ?>
                                 </div>


                                <div class="message-laststep-form"><?php echo $laststep_message_form; ?></div>

                                <?php
                                // Variables
                                if( isset($_GET['new']) ) {
                                    $new_startup = $_GET['new'];
                                }
                                if ( $new_startup == 'true' ) : // IF form submited ?>
                                    <div class="acf-form-submit form-submited">
                                        <?php
                                        $comfirme_message = get_field( 'comfirme_message_form_startup' );
                                        if( $comfirme_message ) {
                                            echo $confirme_message;
                                        } else {
                                            echo '<p>Formulaire envoyé</p>';
                                        } ?>
                                    </div>
                                <?php else : // IF new form (submit button) ?>
                                    <div class="acf-form-submit">
                                        <input type="submit" class="acf-button button button-primary button-large" value="<?php echo $laststep_button_form; ?>">
                                        <span class="acf-spinner"></span>
                                    </div>
                                <?php endif; ?>
                            </section>

                        </div>

                    </form>

                <?php endif; ?>

            </div>

        <?php
        endwhile;

    endif;
    ?>

<style>
    <?php if ( $step_count == 1 ) : ?>
        .startup-form .steps li {
            width: 50%;
        }
    <?php elseif ( $step_count == 2 ) : ?>
        .startup-form .steps li {
            width: 33.33%;
        }
    <?php elseif ( $step_count == 3 ) : ?>
        .startup-form .steps li {
            width: 25%;
        }
    <?php elseif ( $step_count == 4 ) : ?>
        .startup-form .steps li {
            width: 20%;
        }
    <?php elseif ( $step_count == 5 ) : ?>
        .startup-form .steps li {
            width: 16.66%;
        }
    <?php elseif ( $step_count == 6 ) : ?>
        .startup-form .steps li {
            width: 14.28%;
        }
    <?php elseif ( $step_count == 7 ) : ?>
        .startup-form .steps li {
            width: 12.5%;
        }
    <?php elseif ( $step_count == 8 ) : ?>
        .startup-form .steps li {
            width: 11.11%;
        }
    <?php endif; ?>
</style>

<script type="text/javascript">
    (function($) {
        var form = $("#post");
        form.children("div").steps({
            headerTag: "h2",
            bodyTag: "section",
            transitionEffect: "slideLeft",
            enableAllSteps: true, // Enables all steps from the begining if true (all steps are clickable). (default : false)
            enablePagination: true, // Enables pagination (next, previous and finish button) if true. (default : true)
            showFinishButtonAlways: false, // Shows the finish button always (on each step; right beside the next button) if true. Otherwise the next button will be replaced by the finish button if the last step becomes active. (default : false)
            saveState: true, // Saves the current state (step position) to a cookie. By coming next time the last active step becomes activated. (default : false)
            enableFinishButton: false,
            /* Labels */
            labels: {
                cancel: "Annuler",
                current: "Étape actuelle :",
                pagination: "Pagination",
                next: "Suivant <i class=\"icon-arrow-right7\"></i>",
                previous: "<i class=\"icon-arrow-left7\"></i> Précédent",
                loading: "Chargement..."
            }
        });

        // $( ".acf-button").click(function() {
        //     $(this).autosize($('textarea'));
        // });
    })(jQuery);

    /* Reload the function autosize for textarea after a click on acf-button */

    function reloadAutosize() {
        var interval = setInterval(function(){ autosize(document.querySelectorAll('textarea')) }, 1000);
        setTimeout(function(){clearInterval(interval)}, 60000);
    }

    var button_textarea = document.getElementsByClassName("acf-button");
    for (var i=0, c=button_textarea.length; i<c; i++) {
        button_textarea[i].onclick = function() { reloadAutosize() };
        // button_textarea[i].onclick = function() {setTimeout(function(){autosize(document.querySelectorAll('textarea'))}, 5000)};
    }

</script>

<?php
get_footer();
?>
