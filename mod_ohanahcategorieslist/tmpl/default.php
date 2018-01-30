<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '&Itemid='.KRequest::get('get.Itemid', 'int'); ?>
	<ul>
		<? foreach ($categories as $category) : ?>
			<? if ($category->enabled && $category->countEvents()) : ?>
			<li><a href="<?=@route('option=com_ohanah&view=events&ohanah_category_id='.$category->id.$itemid)?>"><?=$category->title?></a></li>
			<? endif; ?>
		<? endforeach; ?>
	</ul>
</div>
