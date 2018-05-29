 <?php
// Get variables
$gallery_pitch = get_sub_field('gallery_field_pitch');
$nb_gallery = get_query_var('nb_gallery');
$autoplay = get_sub_field('gallery_autoplay_field_pitch');
$modal_gallery = get_sub_field('gallery_extend_field_pitch');
// $modal_gallery = false;

// For header gallery pitch -> change fields of gallery pitch
if ( $nb_gallery && $nb_gallery == 'head' ) {
	$gallery_pitch = get_field('gallery_pitch');
	$autoplay = true;
	$modal_gallery = false;
}
?>

<?php
if ( $nb_gallery && $gallery_pitch && count($gallery_pitch) > 1 ) : ?>

	<?php
	//variable conversion
	$play=0;
	if( $autoplay == true ){
		$play=1;
	} ?>
	<!-- SCRIPTS -->
	<script type="text/javascript"> 
	(function($) {

		$(document).ready(function () {

			// JSSOR SLIDER
			var jssor_options = {
				$AutoPlay: <?php echo $play; ?>,
				$PauseOnHover: 3,
				$FillMode: 2,
				$ArrowNavigatorOptions: {
					$Class: $JssorArrowNavigator$
				},
				$ThumbnailNavigatorOptions: {
					$Class: $JssorThumbnailNavigator$,
					$SpacingX: 5,
					$SpacingY: 5,
					$FillMode: 2,
					$ArrowNavigatorOptions: {
						$Class: $JssorArrowNavigator$,
						$ChanceToShow: 2,
						$AutoCenter: 2,
						$Steps: 3
					},
				}
			};

			var jssor_<?php echo $nb_gallery ?>_slider = new $JssorSlider$("jssor-<?php echo $nb_gallery ?>", jssor_options);

			/*#region responsive code begin*/

			var MAX_WIDTH = 700;

			function ScaleSlider() {
				var containerElement = jssor_<?php echo $nb_gallery ?>_slider.$Elmt.parentNode;
				var containerWidth = containerElement.clientWidth;

				if (containerWidth) {
					var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
					jssor_<?php echo $nb_gallery ?>_slider.$ScaleWidth(expectedWidth);
				} else {
					window.setTimeout(ScaleSlider, 30);
				}
			}

			ScaleSlider();

			$(window).bind("load", ScaleSlider);
			$(window).bind("resize", ScaleSlider);
			$(window).bind("orientationchange", ScaleSlider);
			/*#endregion responsive code end*/
		});

	})(jQuery);
	</script>

	<?php if ( $modal_gallery == true ) : ?>
		<script type="text/javascript"> 
		(function($) {

			$(document).ready(function () {
					// LIGHTGALLERY
					$('#lightgallery-<?php echo $nb_gallery ?>').lightGallery({
					  selector: '.item',
					  share: false,
					  download: false,
					  autoplay: false,
					  currentPagerPosition: 'middle',
					  nextHtml: '<svg viewBox="0 0 11 20" version="1.1"><path class="arrows" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>',
					  prevHtml: '<svg viewBox="0 0 11 20" version="1.1"><path class="arrows" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>'
					});
			});

		})(jQuery);
		</script>
	<?php endif; ?>
	<!-- /SCRIPT -->

	<!-- GALLERY -->
	<div id="lightgallery-<?php echo $nb_gallery; ?>">
		<div id="jssor-<?php echo $nb_gallery; ?>" class="gallery-slider-pitch slider">

			<!-- Gallery images -->
			<div data-u="slides" class="start-slides">
				<?php 
				$count_thumb=0;
				foreach ($gallery_pitch as $key => $value): ?> 
				<?php $count_thumb++; ?>                
				<div>
					<?php echo '<div class="bg-img blurred" style="background-image: url('.$value['url'].');"></div>';?>

					<!-- lightgallery -->
					<div class="demo-gallery">
						<?php if ( $modal_gallery == true ) {
							echo '<div class="item" data-responsive="'.$value['url'].'" data-src="'.$value['url'].'" data-sub-html=""><a href="" class="d-block mb-4 h-100">';
						} else {
							echo '<div claa="item">';
						}
						/*data-sub-html="sub title img"*/
						echo '<img class="the-img img-responsive" src="'.$value['url'].'" alt="'.$value['alt'].'" title="'.$value['title'].'" description="'.$value['description'].'"/>';
						if ( $modal_gallery == true ) {
							echo '</a>';
						}
						echo '</div>';
						?>
					</div>
					<!-- /lightgallery -->
					
					<?php echo '<img class="thumbnail-img" data-u="thumb" src="'.$value['url'].'"/>';?>
					</div>   
				<?php endforeach; ?>

			</div>

			<!-- Thumbnail Navigator -->
			<div data-u="thumbnavigator" class="jssort101" data-autocenter="1" data-scale-bottom="0.75">
				<div data-u="slides">
				  <div data-u="prototype" class="proto">
					  <div data-u="thumbnailtemplate" class="t"></div>
					  <svg viewBox="0 0 16000 16000" class="cv"></svg>
				  </div>
				</div>

				<?php if ($count_thumb > 5): ?>
					<div data-u="arrowleft" class="jssora106 left" data-scale="0.75">
						<svg width="100%" height="100%" viewBox="0 0 11 20">
							<path class="arrows" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/>
						</svg>
					</div>

					<div data-u="arrowright" class="jssora106 right" data-scale="0.75">
						<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1">
							<path class="arrows" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>
						</svg>
					</div>
				<?php endif; ?>              

			</div>
			<!-- /Thumbail navigator-->

			<!-- Arrow Navigator -->
			<div data-u="arrowleft" class="jssora106 left" data-scale="0.75">
				<svg class="c" width="100%" height="100%" viewBox="0 0 11 20">
					<path class="arrows" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/>
				</svg>
			</div>
			<div data-u="arrowright" class="jssora106 right" data-scale="0.75">
				<svg class="c" width="100%" height="100%" viewBox="0 0 11 20" version="1.1">
					<path class="arrows" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>
				</svg>
			</div>
			<!--/Arrow navigation-->

		</div>
	</div>
	<!-- /GALLERY -->

<?php endif; ?>