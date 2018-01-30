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
$images = json_decode($item->images);

$itemUrl='';
if(!empty($itemURLs)){
	$itemUrl = $itemURLs[$i];
	$itemUrl = preg_replace('/\s+/', '', $itemUrl);
}
?>

<div class="camera-item" data-src="<?php echo JURI::base(true).'/'.htmlspecialchars($images->image_fulltext); ?>"<?php if($images->image_intro!=''): ?> data-thumb="<?php echo JURI::base(true).'/'.htmlspecialchars($images->image_intro); ?>"<?php endif; ?><?php if($itemUrl!=''): ?> data-link="<?php echo $itemUrl; ?>" data-target="<?php echo '_'.$params->get('target'); ?>"<?php endif; ?>>

	<?php if ($params->get('show_caption') == '1'): ?>
		<div class="camera_caption <?php echo $params->get('captionEffect'); ?>">

			<?php $item_heading = $params->get('item_heading', 'h4'); ?>
			<?php if ($params->get('item_title')) : ?>
	
				<<?php echo $item_heading; ?> class="slide-title">
				<?php if ($params->get('link_titles') && $item->link != '') : ?>
					<a href="<?php echo $item->link;?>">
						<?php echo $item->title;?></a>
				<?php else : ?>
					<?php echo $item->title; ?>
				<?php endif; ?>
				</<?php echo $item_heading; ?>>
	
			<?php endif; ?>
	
			<?php if (!$params->get('intro_only')) :
				/* echo $item->afterDisplayTitle; */
			endif; ?>
	
			<?php /* echo $item->beforeDisplayContent; */ ?>
	
			<?php if ($params->get('published')) : ?>
		<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
			<?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC1')); ?>
		</time>
	<?php endif; ?>
			<?php echo $item->introtext; ?>
	
		<!-- Read More link -->
		<?php if ($params->get('readmore')) :
			$readMoreText = JText::_('MOD_IMAGE_SWOOP_READMORE');
				if ($item->alternative_readmore){
					$readMoreText = $item->alternative_readmore;
				}
				if(!empty($itemUrl)){
					echo '<a class="btn btn-info readmore" href="'.$itemUrl.'" target="_'.$params->get('target').'"><span>'. $readMoreText .'</span></a>';
				}
				else if(isset($item->link) && $item->readmore != 0){
					echo '<a class="btn btn-info readmore" href="'.$item->link.'" target="_'.$params->get('target').'"><span>'. $readMoreText .'</span></a>';
				}
		endif; ?>

		</div>
	<?php endif; ?>

</div>
