<?php
/**
 * Camera Slideshow for Joomla! Module
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Camera Slideshow By Manuel Masia: http://www.pixedelic.com/plugins/camera/ & Articles Newsflash standard module
 * 
 */

defined('_JEXEC') or die;

$app 	  = JFactory::getApplication();	
$template = $app->getTemplate();

//Add script
$document->addScript('modules/mod_image_swoop/js/camera.min.js');

//Add stylesheet
$document->addStyleSheet('modules/mod_image_swoop/css/camera.css');

 ?>
<div id="camera-slideshow_<?php echo $module->id; ?>" class="<?php echo $moduleclass_sfx; ?> camera_wrap pattern_<?php echo $params->get('pattern'); ?>">
<?php
	// Item URL
	if($params->get('item_url')){
		$itemURLs = explode(';', $params->get('item_url'));
	}	

	// Item width
	$item_width = floor(100 / count($list));


	$i=0;	
	foreach ($list as $item) :		
		require JModuleHelper::getLayoutPath('mod_image_swoop', '_item');
		$i++;
	endforeach;
?>
</div>
<script>
	jQuery(function(){
		jQuery('#camera-slideshow_<?php echo $module->id; ?>').camera({
			alignment			: "<?php echo $params->get('alignment'); ?>", //topLeft, topCenter, topRight, centerLeft, center, centerRight, bottomLeft, bottomCenter, bottomRight
			autoAdvance				: <?php echo $params->get('autoAdvance'); ?>,	//true, false
			mobileAutoAdvance	: <?php echo $params->get('mobileAutoAdvance'); ?>, //true, false. Auto-advancing for mobile devices
			barDirection			: "<?php echo $params->get('barDirection'); ?>",	//'leftToRight', 'rightToLeft', 'topToBottom', 'bottomToTop'
			barPosition				: "<?php echo $params->get('barPosition'); ?>",	//'bottom', 'left', 'top', 'right'
			cols							: <?php echo $params->get('cols'); ?>,
			easing						: "<?php echo $params->get('easing'); ?>",	//for the complete list http://jqueryui.com/demos/effect/easing.html
			mobileEasing			: "<?php echo $params->get('mobileEasing'); ?>",	//leave empty if you want to display the same easing on mobile devices and on desktop etc.
			fx								: "<?php echo $params->get('fx'); ?>",	
			mobileFx					: "<?php echo $params->get('mobileFx'); ?>",		//leave empty if you want to display the same effect on mobile devices and on desktop etc.
			gridDifference		: <?php echo $params->get('gridDifference'); ?>,	//to make the grid blocks slower than the slices, this value must be smaller than transPeriod
			height						: "<?php echo $params->get('height'); ?>",	//here you can type pixels (for instance '300px'), a percentage (relative to the width of the slideshow, for instance '50%') or 'auto'
			imagePath					: '<?php echo JURI::base() . "templates/".$template; ?>/images/',	//the path to the image folder (it serves for the blank.gif, when you want to display videos)
			hover							: <?php echo $params->get('hover'); ?>,	//true, false. Puase on state hover. Not available for mobile devices
			loader						: "<?php echo $params->get('loader'); ?>",	//pie, bar, none (even if you choose "pie", old browsers like IE8- can't display it... they will display always a loading bar)
			loaderColor				: "<?php echo $params->get('loaderColor'); ?>", 
			loaderBgColor			: "<?php echo $params->get('loaderBgColor'); ?>", 
			loaderOpacity			: <?php echo $params->get('loaderOpacity'); ?>,	//0, .1, .2, .3, .4, .5, .6, .7, .8, .9, 1
			loaderPadding			: <?php echo $params->get('loaderPadding'); ?>,	//how many empty pixels you want to display between the loader and its background
			loaderStroke			: <?php echo $params->get('loaderStroke'); ?>,	//the thickness both of the pie loader and of the bar loader. Remember: for the pie, the loader thickness must be less than a half of the pie diameter
			minHeight					: "<?php echo $params->get('minHeight'); ?>",	//you can also leave it blank
			navigation				: <?php echo $params->get('navigation'); ?>,	//true or false, to display or not the navigation buttons
			navigationHover		: <?php echo $params->get('navigationHover'); ?>,	//if true the navigation button (prev, next and play/stop buttons) will be visible on hover state only, if false they will be 	visible always
			mobileNavHover		: <?php echo $params->get('mobileNavHover'); ?>,	//same as above, but only for mobile devices
			opacityOnGrid			: <?php echo $params->get('opacityOnGrid'); ?>,	//true, false. Decide to apply a fade effect to blocks and slices: if your slideshow is fullscreen or simply big, I recommend to set it false to have a smoother effect 
			overlayer					: <?php echo $params->get('overlayer'); ?>,	//a layer on the images to prevent the users grab them simply by clicking the right button of their mouse (.camera_overlayer)
			pagination				: <?php echo $params->get('pagination'); ?>,
			playPause					: <?php echo $params->get('playPause'); ?>,	//true or false, to display or not the play/pause buttons
			pauseOnClick			: <?php echo $params->get('pauseOnClick'); ?>,	//true, false. It stops the slideshow when you click the sliders.
			pieDiameter				: <?php echo $params->get('pieDiameter'); ?>,
			piePosition				: "<?php echo $params->get('piePosition'); ?>",	//'rightTop', 'leftTop', 'leftBottom', 'rightBottom'
			portrait					: <?php echo $params->get('portrait'); ?>, //true, false. Select true if you don't want that your images are cropped
			rows							: <?php echo $params->get('rows'); ?>,
			slicedCols				: <?php echo $params->get('slicedCols'); ?>,	//if 0 the same value of cols
			slicedRows				: <?php echo $params->get('slicedRows'); ?>,	//if 0 the same value of rows
			// slideOn				: "<?php echo $params->get('slideOn'); ?>",	//next, prev, random: decide if the transition effect will be applied to the current (prev) or the next slide
			thumbnails				: <?php echo $params->get('thumbnails'); ?>,
			time							: <?php echo $params->get('time'); ?>,	//milliseconds between the end of the sliding effect and the start of the nex one
			transPeriod				: <?php echo $params->get('transperiod'); ?>	//lenght of the sliding effect in milliseconds
			// onEndTransition		: function() {  },	//this callback is invoked when the transition effect ends
			// onLoaded					: function() {  },	//this callback is invoked when the image on a slide has completely loaded
			// onStartLoading		: function() {  },	//this callback is invoked when the image on a slide start loading
			// onStartTransition	: function() {  }	//this callback is invoked when the transition effect starts
		});
	});
</script>