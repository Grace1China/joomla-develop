<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_camera_slideshow
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;
$item_images = json_decode($item->images);
require_once (JPATH_BASE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'icon.php');
if($layout!='edit'){
	$canEdit = $item->params->get('access-edit');
	if ($canEdit) : ?>
	<!-- Icons -->
	<?php if ($canEdit || $item->params->get('show_print_icon') || $item->params->get('show_email_icon')) : ?>
		<?php echo html_entity_decode(JLayoutHelper::render('joomla.content.icons', array('params' => $item->params, 'item' => $item, 'print' => false))); ?>
	<?php endif;
	endif;
}

$item_heading = $params->get('item_heading', 'h4');
	
if ($params->get('item_title')) : ?>
<<?php echo $item_heading; ?> class="item_title item_title__<?php echo $params->get('moduleclass_sfx'); ?>">
	<?php if ($params->get('link_titles') && $item->link != '') : ?>
	<a href="<?php echo $item->link;?>"><?php echo $item->title;?></a>
	<?php else : ?>
	<?php echo $item->title; ?>
	<?php endif; ?>
</<?php echo $item_heading; ?>>
<?php endif;
	
if (!$params->get('intro_only')) :
	echo $item->afterDisplayTitle;
endif;

if ($params->get('show_tags', 1) && !empty($item->tags)) :
$item->tagLayout = new JLayoutFile('joomla.content.tags');

echo $item->tagLayout->render($item->tags->itemTags);
endif;

if ($params->get('published')) : ?>
	<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
		<?php echo JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_TPL1')); ?>
	</time>
<?php endif;

echo $item->beforeDisplayContent;
	
if ($params->get('intro_image')):
if (isset($item_images->image_intro) and !empty($item_images->image_intro)) :
$imgfloat = (empty($item_images->float_intro)) ? $params->get('float_intro') : $item_images->float_intro; ?>
<!-- Intro Image -->
<figure class="item_img img-intro img-intro__<?php echo htmlspecialchars($params->get('intro_image_align')); ?>"> 
	<?php if ((($params->get('item_title') && $params->get('link_titles')) || $params->get('readmore')) && $item->readmore) : ?>
	<a href="<?php echo $item->link;?>">
	<?php endif; ?>
		<img src="<?php echo htmlspecialchars($item_images->image_intro); ?>" alt="<?php echo htmlspecialchars($item_images->image_intro_alt); ?>">
		<?php if ($item_images->image_intro_caption): ?>
		<figcaption><?php echo htmlspecialchars($item_images->image_intro_caption); ?></figcaption>
		<?php endif;
	if ((($params->get('item_title') && $params->get('link_titles')) || $params->get('readmore')) && $item->readmore) : ?>
	</a>
	<?php endif; ?>
</figure>
<?php endif;
endif;

echo $item->introtext; ?>
	
<!-- Read More link -->
<?php if (isset($item->link) && $item->readmore != 0 && $params->get('readmore')) :
	$readMoreText = JText::_('TPL_COM_CONTENT_READ_MORE');
		if ($item->alternative_readmore){
			$readMoreText = $item->alternative_readmore;
		}
	echo '<a class="btn btn-info readmore" href="'.$item->link.'"><span>'. $readMoreText .'</span></a>';
endif; ?>