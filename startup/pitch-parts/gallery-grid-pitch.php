<?php
// Get variables
$gallery_pitch = get_sub_field('gallery_field_pitch');
$nb_gallery = get_query_var('nb_gallery');
$modal_gallery = get_sub_field('gallery_extend_field_pitch');
?>

<?php
if ($nb_gallery && $gallery_pitch && count($gallery_pitch)>1) :

	if ( $modal_gallery == true ) : ?>
		<!-- SCRIPTS -->
		<script type="text/javascript">
		(function($) {
			$(document).ready(function () {

				// LIGHTGALLERY
				$('#lightgallery').lightGallery({
					share: false,
					download: false,
					autoplay: false,
					currentPagerPosition: 'middle',
					nextHtml: '<svg viewBox="0 0 11 20" version="1.1"><path class="arrows" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>',
					prevHtml: '<svg viewBox="0 0 11 20" version="1.1"><path class="arrows" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>'
				})			    
			})
		})(jQuery);		
		</script>
		<!-- /SCRIPT -->
	<?php endif; ?>

	<!-- GALLERY -->
	<div class="content">
		<!-- /*lightgallery*/ -->          
		<div class="demo-gallery">
			<ul id="lightgallery-<?php echo $nb_gallery ?>" class="list-unstyled row">
				<?php
				foreach ($gallery_pitch as $key => $value) {

					if ( $modal_gallery == true ) {
						echo '<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="'.$value['url'].'" data-src="'.$value['url'].'" data-sub-html="">';
					} else {
						echo '<li>';
					}
					echo '<a class="elem">';
					echo '<img class="img-responsive" src="'.$value['url'].'" alt="'.$value['alt'].'" title="'.$value['title'].'" description="'.$value['description'].'" style="background-image: url('.$value['url'].');"/>';
					echo '</a></li>';
				} 
				?>   
			</ul>
		</div>
		<!-- /*end lightgallery*/ -->
	</div>

<?php endif;?>


