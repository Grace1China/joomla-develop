<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '&Itemid='.KRequest::get('get.Itemid', 'int'); ?>

	<? if (JVersion::isCompatible('3.0')) : ?>
		<? JHtml::_('jquery.framework'); ?>
	<? else : ?>
		<? if ((JComponentHelper::getParams('com_ohanah')->get('loadJQuery') != 0) && (!JFactory::getApplication()->get('jquery'))) : ?>
			<? JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.min.js');?>
			<? JFactory::getApplication()->set('jquery', true); ?>
		<? endif; ?>
	<? endif; ?>
	<? if (count($events) > 0 ) { ?>
		<? if ($displayStyle == 'ul_list') : ?>
			<ul>
				<? foreach ($events as $event) : ?>
					<li><a href="<?=@route('option=com_ohanah&view=event&id='.$event->id.$itemid)?>"><?=$this->getService('com://admin/ohanah.template.helper.thirdpartysupport')->easyLanguagePlugin(array('text' => $event->title))?></a></li>
				<? endforeach; ?>
			</ul>
		<? else : ?>
			<? foreach ($events as $event) : ?>
				<?= @template('com://site/ohanah.view.event.default_header', array('event' => $event, 'format' => 'html', 'module' => 1)); ?>
			<? endforeach; ?>
		<? endif; ?>
	<? } else {	// no events to show, display message
		$str = 'OHANAH_NO_EVENTS'; $text = @text($str); echo ($text == "" || $text == $str) ? 'Sorry, no events.' : $text;
	} ?>

</div>
