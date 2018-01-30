<?php
/**
 * IceMegaMenu Extension for Joomla 3.0 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2011 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/icemegamenu.html
 * @Support 	http://www.icetheme.com/Forums/IceMegaMenu/
 *
 */
 

/* no direct access*/
defined('_JEXEC') or die;
if(!defined("DS")){
	define("DS", DIRECTORY_SEPARATOR);
}
/* Include the syndicate functions only once*/
require_once dirname(__FILE__).DS.'helper.php';

/*Menu setting*/
$params->def('menutype', 			'mainmenu');
$params->def('class_sfx', 			'');
$params->def('menu_images', 		0);
$params->def('menu_images_align', 	0);
$params->def('expand_menu', 		0);
$params->def('activate_parent', 	0);
$params->def('indent_image', 		0);
$params->def('indent_image1', 		'indent1.png');
$params->def('indent_image2', 		'indent2.png');
$params->def('indent_image3', 		'indent3.png');
$params->def('indent_image4', 		'indent4.png');
$params->def('indent_image5', 		'indent5.png');
$params->def('indent_image6', 		'indent.png');
$params->def('spacer', 				'');
$params->def('end_spacer', 			'');
$params->def('full_active_id', 		0);

/* Added in 1.5 */
$params->def('startLevel', 			0);
$params->def('endLevel', 			0);
$params->def('showAllChildren', 	0);
$params->def('resizable_menu',   	0);

/*Mega menu settings */
$activate_action 	= $params->get("activate_action", "mouseover");
$deactivate_action 	= $params->get("deactivate_action", "mouseleave");
$js_effect 			= $params->get("js_effect", "slide & fade");

$js_duration 	= $params->get("js_duration", 600);
$js_physics 	= $params->get("js_physics", "Fx.Transitions.Pow.easeOut");
$js_hideDelay 	= $params->get("js_hideDelay", 1000);
$js_opacity 	= $params->get("js_opacity", 95);
$use_js 		= $params->get("use_js", 1);

$vertical_direction = $params->get("vertical_direction", "left");


/*load theme*/

$layoutModulePath 	= JModuleHelper::getLayoutPath($module->module);
$icemegamenu 		= new modIceMegamenuHelper($module, $params);
require($layoutModulePath);
?>


<?php  if($params->get('theme_style') == 'vertical' and $params->get('vertical_direction') == 'left') {  ?>
<style type="text/css">
/* if "left" is choseen to display the dropdown */
.icemegamenu > ul li.parent {
	background: url(<?php echo JURI::base() ?>/modules/mod_icemegamenu/themes/vertical/images/arrow_left.png) no-repeat 5% 45%;}
	
	.icemegamenu > ul > li a.iceMenuTitle {
		padding-left:30px;}


		.icemegamenu ul.icesubMenu {
			left:auto!important;
			right:110%!important}
			
			.icemegamenu ul > li:hover > ul.icesubMenu {
				left:auto!important;
				right:100%!important}
				
				.icemegamenu ul.icesubMenu > li a.iceMenuTitle {
					background:none}
</style>					
<?php } ?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		var browser_width1 = jQuery(window).width();
		jQuery("#icemegamenu").find(".icesubMenu").each(function(index){
			var offset1 = jQuery(this).offset();
			var xwidth1 = offset1.left + jQuery(this).width();
			if(xwidth1 >= browser_width1){
				jQuery(this).addClass("ice_righttoleft");
			}
		});
		
	})
	jQuery(window).resize(function() {
		var browser_width = jQuery(window).width();
		jQuery("#icemegamenu").find(".icesubMenu").removeClass("ice_righttoleft");
		jQuery("#icemegamenu").find(".icesubMenu").each(function(index){
			var offset = jQuery(this).offset();
			var xwidth = offset.left + jQuery(this).width();
			
			if(xwidth >= browser_width){
				jQuery(this).addClass("ice_righttoleft");
			}
		});
	});
</script>