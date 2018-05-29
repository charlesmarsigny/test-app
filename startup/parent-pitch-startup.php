<?php
/**
 * Template Name: Parent pitch startup
 *
 * Description: Page template for parent AJAX sub startup page
 *
 *
 * @package WordPress
 * @subpackage BuddyApp
 * @author Charles Marsigny <charles.marsigny@welikestartup.com>
 * @since AppLike 1.0
 */

// Get variable
if ( isset($_GET['id']) ) :
	$startup_id = $_GET['id'];
?>

<div class="body-submenu">
    <nav id="object-subnav">
        <ul class="left-body-sub">
            <li>test</li>
            <li>test</li>
        </ul>
        <ul class="center-body-sub">
            <li class="has-submenu-child">test parent
                <ul class="body-child-sub">
                    <li>test</li>
                    <li>test</li>
                    <li>test</li>
                </ul>
            </li>
            <li>test</li>
        </ul>
        <ul class="etab right-body-sub" role="navigation">
            <li>test</li>
            <li id="show-pitch-li" class="tab primary-button">
                <a id="pitch-tab" href="/startup-page/pitch/show-pitch/?id=<?php echo $startup_id; ?>" data-target="#show-pitch">Afficher</a>
            </li>
            <li id="edit-pitch-li" class="tab primary-button">
                <a id="pitch-tab" href="/startup-page/pitch/edit-pitch/?id=<?php echo $startup_id; ?>" data-target="#edit-pitch">Éditer</a>
            </li>
        </ul>
    </nav>
</div>

<!-- TAB Liquidites -->
<div id="show-pitch" class="item-tab"></div>
<!-- /TAB Liquidites -->

<!-- TAB Liquidites -->
<div id="edit-pitch" class="item-tab"></div>
<!-- /TAB Liquidites -->

<script type="text/javascript">
    (function($) {

      $('#object-subnav')
        .easytabs({
          panelContext: $(document),
          transitionIn: 'fadeIn',
          transitionOut: 'fadeOut',
          tabActiveClass: 'current'
        })
        .bind('easytabs:ajax:complete', function(e, $clicked, $targetPanel, settings) {
          if ( $targetPanel.get(0).id === 'edit-pitch' ) {
            $.scrollTo($targetPanel, 800);
          }
        });

    })(jQuery);
</script>

<?php else: ?>
	<div class="item-content"><p>Aucun post sélectionné</p></div>

<?php endif; ?>