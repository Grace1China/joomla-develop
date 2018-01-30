<?php
/*------------------------------------------------------------------------
# mod_sw_facebookDisplay - SW FACEBOOK DISPLAY
# ------------------------------------------------------------------------
# @author - Social Widgets
# copyright - All rights reserved by Social Widgets
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://socialwidgets.net/
# Technical Support:  admin@socialwidgets.net
-------------------------------------------------------------------------*/
// no direct access
defined( '_JEXEC' ) or die;
//all parameters
$pageURL = $params->get('pageURL');
$connections = $params->get('connections');
$width = $params->get('width');
$height = $params->get('height');
$streams = $params->get('streams');
$color_scheme = $params->get('color_scheme');
$show_faces = $params->get('show_faces');
$header = $params->get('header');
$border = $params->get('border');
$print_facebook = '';
$print_facebook .= '<iframe src="http://www.facebook.com/plugins/likebox.php?href='.$pageURL.'&amp;width='.$width.'&amp;colorscheme='.$color_scheme.'&amp;show_faces='.$show_faces.'&amp;connections='.$connections.'&amp;stream='.$streams.'&amp;show_border='.$border.'&amp;header='.$header.'&amp;height='.$height.'" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:'.$width.'px; height: '.$height.'px; " allowTransparency="true"></iframe>';
?>
<div id="sw_facebook_display" class="<?php echo $params->get('moduleclass_sfx');?>">
	<?php echo $print_facebook; ?>
</div>