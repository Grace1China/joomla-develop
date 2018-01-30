<?php
/*------------------------------------------------------------------------
# mod_sw_pinterestDisplay - SW Pinterest Display
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
$select = $params->get('select');
$pinterest = $params->get('pinterest');
$width = trim($params->get('width'));
$height = trim($params->get('height'));
$scale = $params->get('scale');
if($select=="profile"){
$pin = "embedUser";
$pinURL = $pinterest;
$linkbody = "Pinterest's profile on Pinterest";}
else{
$pin = "embedBoard";
$pinURL = $pinterest;
$linkbody = "Follow Pin pets by Pinterest on Pinterest";}
$print_pinterest = '';
$print_pinterest .= "<a data-pin-do='$pin' href='http://www.pinterest.com/$pinURL/' data-pin-scale-height='$height' data-pin-board-width='$width' data-pin-scale-width='$scale'>$linkbody</a>";
?>
<script type="text/javascript">
(function(d){
  var f = d.getElementsByTagName('SCRIPT')[0], p = d.createElement('SCRIPT');
  p.type = 'text/javascript';
  p.async = true;
  p.src = '//assets.pinterest.com/js/pinit.js';
  f.parentNode.insertBefore(p, f);
}(document));
</script>
<div id="sw_pinterest_display" class="<?php echo $params->get('moduleclass_sfx');?>">
	<?php echo $print_pinterest; ?>
</div>