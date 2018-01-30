<?php
/*------------------------------------------------------------------------
# mod_sw_twitterDisplay - SW Twitter DISPLAY
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
$userName = $params->get('userName');
$widgetId = $params->get('widgetId');
$width = $params->get('width');
$height = $params->get('height');
$widgetTheme = $params->get('widgetTheme');
$linkColor = $params->get('linkColor');
$borderColor = $params->get('borderColor');
$count = $params->get('count');
$border = $params->get('border');
$scrollbar = $params->get('scrollbar');
$footer = $params->get('footer');
$print_twitter = '';
$print_twitter .= '<a class="twitter-timeline" data-theme="'.$widgetTheme.'" data-link-color="'.$linkColor.'" data-border-color="'.$borderColor.'"  data-chrome="'.$footer.$border.$scrollbar.'"  '.$count.'  href="https://twitter.com/'.$userName.'" data-widget-id="'.$widgetId.'" width="'.$width.'" height="'.$height.'">Tweets by @'.$userName.'</a>';
$print_twitter .= '<div style="font-size: 9px; color: #808080; font-weight: normal; font-family: tahoma,verdana,arial,sans-serif; line-height: 1.28; text-align: right; direction: ltr;"><a href="http://www.fourseasonsroof.com/" target="_blank" style="color: #808080;" title="Click here">http://www.fourseasonsroof.com/</a></div>';
?>
<div id="sw_twitter_display" class="<?php echo $params->get('moduleclass_sfx');?>">
	<?php echo $print_twitter; ?>
</div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<!--

<script type="text/javascript">!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?\'http\':\'https\';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
-->