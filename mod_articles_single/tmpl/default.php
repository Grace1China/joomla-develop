<?php
defined('_JEXEC') or die;
require_once (JPATH_BASE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'icon.php');
if($layout!='edit'){
	$canEdit = $item->params->get('access-edit');
}
?>
<div class="mod-article-single mod-article-single__<?php echo $moduleclass_sfx; ?>" id="module_<?php echo $module->id; ?>">
	<div class="item__module" id="item_<?php echo $item->id; ?>">
		<?php if($layout!='edit') :
		if ($canEdit) : ?>
		<!-- Icons -->
		<?php if ($canEdit || $item->params->get('show_print_icon') || $item->params->get('show_email_icon')) : ?>
			<?php echo html_entity_decode(JLayoutHelper::render('joomla.content.icons', array('params' => $item->params, 'item' => $item, 'print' => false))); ?>
		<?php endif;
		endif;
		endif;
		if ($params->get('item_title')) : ?>
		<!-- Item Title -->
		<<?php echo $item_heading; ?> class="item-title">
			<?php if ($params->get('link_titles') && isset($item->link)) : ?>
			<a href="<?php echo $item->link;?>"><?php echo $item->title;?></a>
			<?php else :
			echo $item->title;
			endif; ?>
		</<?php echo $item_heading; ?>>
		<?php endif;

		if ($params->get('published_on')) : ?>
		<!-- Publish Date -->
		<time datetime="<?php echo JHtml::_('date', $item->publish_up, 'Y-m-d H:i'); ?>" class="item_published">
			<?php echo JText::sprintf(JHtml::_('date', $item->publish_up, JText::_('DATE_FORMAT_LC3'))); ?>
		</time>
		<?php endif;

		if ($params->get('show_intro_image')) :
		if (isset($item_images->image_intro) and !empty($item_images->image_intro)) :
		$imgfloat = (empty($item_images->float_intro)) ? $params->get('float_intro') : $item_images->float_intro; ?>
		<!-- Intro Image -->
		<figure class="item_img img-intro img-intro__<?php echo htmlspecialchars($imgfloat); ?>">
			<?php if ((($params->get('item_title') && $params->get('link_titles')) || $params->get('readmore')) && isset($item->link)) : ?>
			<a href="<?php echo $item->link;?>">
			<?php endif; ?>
				<img src="<?php echo htmlspecialchars($item_images->image_intro); ?>" alt="<?php echo htmlspecialchars($item_images->image_intro_alt); ?>">
				<?php if ($item_images->image_intro_caption): ?>
				<figcaption><?php echo htmlspecialchars($item_images->image_intro_caption); ?></figcaption>
				<?php endif;
			if ((($params->get('item_title') && $params->get('link_titles')) || $params->get('readmore')) && isset($item->link)) : ?>
			</a>
			<?php endif; ?>
		</figure>
		<?php endif;
		endif; ?>

		<!-- Intro Text -->
		<div class="item_introtext">
			<?php echo $item->introtext;
				if (isset($item->link) && $params->get('readmore')) :	

            if($view == "form"){
              if($item->attribs['alternative_readmore']){
                $readMoreText = $item->attribs['alternative_readmore'];
              } else {
                $readMoreText = JText::_('TPL_COM_CONTENT_READ_MORE');
              }
            } else {
              if ($item->params->get('alternative_readmore')){
                $readMoreText = $item->params->get('alternative_readmore');
              } else {
                $readMoreText = JText::_('TPL_COM_CONTENT_READ_MORE');
              }
            }
					echo '<a class="btn btn-info readmore" href="'.$item->link.'"><span>'. $readMoreText .'</span></a>';
				endif; ?>
		</div>	
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