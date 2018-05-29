<?php

// Get variables

$gallery_pitch = get_sub_field('gallery_field_pitch');
$nb_gallery = get_query_var('nb_gallery');
$autoplay = get_sub_field('gallery_autoplay_field_pitch');
$modal_gallery = get_sub_field('gallery_extend_field_pitch');
$nbimagethumb = get_sub_field('nbimagethumb_carrousel_field_pitch');
?>

<?php

if ($nb_gallery && $gallery_pitch && count($gallery_pitch) > 1) : ?>		

	<?php
	// variable conversion

	$play = 0;

	if ( $autoplay == true ){

		$play = 1;

	} ?>

	<?php

	if ($nbimagethumb==3) {

	  	$SlideWidth = 326;

	  	$SlideHeight = 217;

	  	$Align = 0;

	  }

	  elseif ($nbimagethumb==4) {

	    	$SlideWidth = 243;

	    	$SlideHeight = 162;

	    	$Align = 0;

	    }

	    elseif ($nbimagethumb==5) {

	      	$SlideWidth = 200;

	      	$SlideHeight = 133;

	      	$Align = 0;

	      }  

	?>

	

	<!-- SCRIPTS -->

	<script type="text/javascript"> 

	(function($) {

		

	  $(document).ready(function () {



			// JSSOR CARROUSEL

			var jssor_options = {

			  $AutoPlay: <?php echo $play; ?>,

			  $SlideDuration: 160,

			  $SlideWidth: <?php echo $SlideWidth ; ?>,

			  $SlideHeight: <?php echo $SlideHeight ; ?>,

			  $SlideSpacing: 3,

			  $FillMode: 2,

			  $Cols: <?php echo $nbimagethumb ; ?>,

			  $Align: <?php echo $Align ; ?>,

			  $ArrowNavigatorOptions: {

				$Class: $JssorArrowNavigator$,

				$Steps: 5

			  },

			$BulletNavigatorOptions: {

			$Class: $JssorBulletNavigator$,

			$ChanceToShow : 0,

			 }                 

			};



			var jssor_<?php echo $nb_gallery ?>_slider = new $JssorSlider$("jssor-<?php echo $nb_gallery ?>", jssor_options);



			/*#region responsive code begin*/

			var MAX_WIDTH = 980;


			function ScaleSlider() {

				var containerElement = jssor_<?php echo $nb_gallery ?>_slider.$Elmt.parentNode;

				var containerWidth = containerElement.clientWidth;


				if (containerWidth) {

					var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);



					jssor_<?php echo $nb_gallery ?>_slider.$ScaleWidth(expectedWidth);
				}

				else {

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

	<div id="lightgallery-<?php echo $nb_gallery ?>">

		<div id="jssor-<?php echo $nb_gallery ?>" class="jssor gallery-slider-pitch">



			<!-- Gallery images -->

			<div data-u="slides" class="sld">
				<?php

				$count_thumb=0;

				foreach ($gallery_pitch as $key => $value): ?> 

				<?php $count_thumb++; ?>                

					<div >
						<!-- /*lightgallery*/ -->
						<div class="demo-gallery">
							<?php if ( $modal_gallery == true ) {
							echo '<li class="col-lg-3 col-md-4 col-xs-6 item" data-responsive="'.$value['url'].'" data-src="'.$value['url'].'" data-sub-html=""><a href="" class="d-block mb-4 h-100">';
							} else {
								echo '<div>';
							}

								/*data-sub-html="sub title img"*/

							echo '<img data-u="image" class="the-img img-responsive" src="'.$value['url'].'" alt="'.$value['alt'].'" title="'.$value['title'].'" description="'.$value['description'].'" style="background-image: url('.$img.');"/></a></li>';?>
						</div>
					<!-- /*end lightgallery*/ -->
					</div> 

				<?php endforeach; ?>  

			</div>

			<!-- Bullet Navigator -->

			<div data-u="navigator" class="jssorb057 nav" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">

				<div data-u="prototype" class="i b">

					<svg viewBox="0 0 16000 16000" class="svgBullet" >

						<circle class="b" cx="8000" cy="8000" r="5000"></circle>

					</svg>

				</div>

			</div>



			<!-- Arrow Navigator -->

			<?php if ($count_thumb>$nbimagethumb): ?>

			<div data-u="arrowleft" class="jssora073 left svgNav" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">

				<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1" class="sNav" >

					<path class="arrows" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/>

				</svg>

			</div>

			<div data-u="arrowright" class="jssora073 right svgNav" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">

				<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1" class="sNav">

					<path class="arrows" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/>

				</svg>

			</div>

			<?php endif; ?>

	  </div>

	</div>

	<!-- /GALLERY -->

<?php endif; ?>