<?php
/**
 * Template Name: Add startup (app/step1)
 *
 * Description: Template for form add startup
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

acf_form_head();
get_header(); ?>

<?php
//create full width template
kleo_switch_layout('full');
?>

<?php get_template_part('page-parts/general-before-wrap'); ?>

<?php get_template_part( 'page-parts/page-title' ); ?>

<div class="main-content <?php echo Kleo::get_config('container_class'); ?>">

	<?php
	if ( have_posts() ) :
		// Start the Loop.
		while ( have_posts() ) : the_post(); ?>

			<div class="form-add-startup">

				<?php acf_form(array(
					'post_id'		=> 'new_post',
					'new_post'		=> array(
							'post_type'		=> 'startup',
							'post_status'	=> 'publish'
						),
					'uploader' => 'wp', // 'wp' or 'basic'
					'instruction_placement' => 'field', // 'label' (Below labels) or 'field' (Below fields)
					'post_title' => true,
					'honeypot' 		=> true,
					'fields' 		=> array(
							'logo_startup',
							'cover_startup',
							'excerpt_startup',
							'category_startup',
							'tag_startup',
							'sector_startup',
							'type_startup'
						),
					'submit_value'	=> 'Crée la startup'
				)); ?>
			
			</div>

		<?php endwhile;

	endif;
	?>

</div>
        
<?php get_template_part('page-parts/general-after-wrap'); ?>

<?php get_footer(); ?>