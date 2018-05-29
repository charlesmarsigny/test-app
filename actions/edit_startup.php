<?php
/**
 * Template Name: edit startup
 *
 * Description: Page template for edit startup
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

?>
<?php
if ( have_posts() ) :
	// Start the Loop.
	while ( have_posts() ) : the_post(); ?>

		<div class="startup-form edit-startup">
			<?php
			// The variables
			$post_type = 'startup';
			if( isset($_GET['id']) ) {
				$startup_id = $_GET['id'];
			}
			$startup_link = get_permalink( $startup_id );

			acf_form(array(
				'post_id'		=> $startup_id,
				'new_post'		=> array(
						'post_type'		=> $post_type
					),
				'uploader' => 'wp', // 'wp' or 'basic'
				'instruction_placement' => 'labels', // 'label' (Below labels) or 'field' (Below fields)
				'honeypot' 		=> true,
				'return' => $startup_link . '?edit=updated',
				'submit_value'	=> 'Enregistrer les modifications',
				'field_groups' => array(10669),
				'fields'        => array(
				        'startup_name',
				        'project_name',
				        'logo_startup',
				        'cover_startup',
				        'excerpt_startup',
				        'category_startup',
				        'tag_startup',
				        'sector_startup',
				        'type_startup',

				        // social
				        'facebook_startup',
				        'twitter_startup',
				        'linkedin_startup',
				        'google_startup',
				        'pinterest_startup',
				        'instagram_startup',
				        'youtube_startup',
				        'vimeo_startup',

				        // pith
				        'header_pitch',
				        'video_pitch',
				        'gallery_pitch',
				        'image_pitch',
				        'content_pitch',

				        // company
				        'if_company',
				        'name_company',
				        'contact_company',
				        'email_company',
				        'phone_company',
				        'website_company',
				        'siren_company',
				        'ape_company',
				        'legalform_company',
				        'date_company',
				        'capital_company',
				        'jei_company',
				        'eip_company',
				        'address_headquarters_company',
				        'address_company',

				        // project
				        'project_resume',
				        'businessmodel_resume',
				        'market_resume',
				        'competitor_resume',
				        'currentstate_resume',

				        // team
				        'members_team',

				        // funds
				        'wantedfunds_rusume',
				        'datefunds_rusume',
				        'postmoneyvalue_rusume',
				        'estimationmethod_rusume',
				        'breakdownfunds_rusume',
				        'ratebreakdownfunds_rusume',
				        'unbreakdownfunds_rusume',
				        'otherapplication_rusume',
				        'outputstrategy_rusume',

				        // finance
				        'shareholders_resume',
				        'fundraising_resume',
				        'field_59df7a720a3f2',
				        'field_587fb53a7393a',
				        'field_587fb55e7393b',
				        'date_financial_n-1',
				        'turnover_financial_n-1',
				        'netprofit_financial_n-1',
				        'employees_fte_financial_n-1',
				        'field_587fb6b473940',
				        'field_587fb72473941',
				        'date_financial_n',
				        'turnover_financial_n',
				        'netprofit_financial_n',
				        'employees_fte_financial_n',
				        'field_587fb77c73946',
				        'field_587fb78973947',
				        'date_financial_n+1',
				        'turnover_financial_n+1',
				        'netprofit_financial_n+1',
				        'employees_fte_financial_n+1',
				        'field_587fb7ca7394c',
				        'field_587fb7d47394d',
				        'date_financial_n+2',
				        'turnover_financial_n+2',
				        'netprofit_financial_n+2',
				        'employees_fte_financial_n+2',
				        'field_5880d00cda8ef', // Reset column
				    )
			));

			?>
		</div>
		
	<?php endwhile; ?>

<?php endif; ?>