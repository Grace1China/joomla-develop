<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_camera_slideshow
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
JHtml::addIncludePath(JPATH_BASE.'/components/com_content/helpers');

?>
<div class="mod_caroufredsel mod_caroufredsel__<?php echo $moduleclass_sfx; ?>" id="module_<?php echo $module->id; ?>">
	<div id="list_carousel_<?php echo $module->id; ?>" class="list_carousel">

		<ul id="caroufredsel_<?php echo $module->id; ?>">
			<?php
			foreach ($list as $key => $item) : ?>
				<li class="item" id="item_<?php echo $item->id; ?>">
					<div class="item_content"><?php require JModuleHelper::getLayoutPath('mod_caroufredsel', '_item'); ?></div>
				</li>
			<?php endforeach;	?>
		</ul>

		<?php if ($params->get('navigation') && $key>0): ?>
			<div id="carousel_<?php echo $module->id; ?>_prev" class="caroufredsel_prev"><span>&lt;</span></div>
			<div id="carousel_<?php echo $module->id; ?>_next" class="caroufredsel_next"><span>&gt;</span></div>
		<?php endif; ?>

		<div id="carousel_<?php echo $module->id; ?>_pag" class="caroufredsel_pagination"></div>
		<div class="clearfix"></div>
	</div>
	<?php if($params->get('mod_button') == 1): ?>   
    <div class="mod-newsflash-adv_custom-link">
      <?php 
        $menuLink = $menu->getItem($params->get('custom_link_menu'));

          switch ($params->get('custom_link_route')) 
          {
            case 0:
              $link_url = $params->get('custom_link_url');
              break;
            case 1:
              $link_url = JRoute::_($menuLink->link.'&Itemid='.$menuLink->id);
              break;            
            default:
              $link_url = "#";
              break;
          }
          echo '<a href="'. $link_url .'">'. $params->get('custom_link_title') .'</a>';
      ?>
    </div>
<?php endif; ?>
</div>

<script>
jQuery(function($) {
	var carousel = $("#caroufredsel_<?php echo $module->id; ?>")
	carousel.carouFredSel({
		responsive	: true,
		width: '100%',
		items		: {
			width : <?php echo $params->get('max_width'); ?>,
			height: 'variable',
			visible		: {
				min			: <?php echo $params->get('min_items');?>,
				max			: <?php echo $params->get('max_items');?>
			},
			minimum: 1
		},
		scroll: {
			items: 1,
			fx: "<?php echo $params->get('fx'); ?>",
			easing: "<?php echo $params->get('easing'); ?>",
			duration: <?php echo $params->get('duration'); ?>,
			queue: true
		},
		auto: false,
		<?php if ($params->get('navigation')): ?>
			next: "#carousel_<?php echo $module->id; ?>_next",
			prev: "#carousel_<?php echo $module->id; ?>_prev",
		<?php endif; ?>
		<?php if ($params->get('pagination')): ?>
			pagination: "#carousel_<?php echo $module->id; ?>_pag",
		<?php endif; ?>
		swipe:{
			onTouch: true
		}
	});
	$(window).load(function(){
		setTimeout(function(){
			carousel.trigger('configuration', {reInit: true})
		}, 100);
	});
});
</script>
