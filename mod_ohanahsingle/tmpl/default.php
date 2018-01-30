<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<? if (JVersion::isCompatible('3.0')) : ?>
	<? JHtml::_('jquery.framework'); ?>
<? else : ?>
	<? if ((JComponentHelper::getParams('com_ohanah')->get('loadJQuery') != '0')) :
		if (!JFactory::getApplication()->get('jquery'))  {
        JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.min.js');
        JFactory::getApplication()->set('jquery', true);
    }
		endif; ?>
<? endif; ?>

<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if ($event->enabled) : ?>
		<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '&Itemid='.KRequest::get('get.Itemid', 'int'); ?>

		<? if ($displayStyle == 'flyer') : ?>
			<div class="event_flyer">
				<? if ($event->picture) :?>
				<a class="ohanah_modal" href="<? if (!(substr($event->picture, 0, 7) == "http://")) : ?>http://<?=$_SERVER["HTTP_HOST"].KRequest::root()?>/media/com_ohanah/attachments/<? endif; ?><?=$event->picture?>">
					<img id="event_flyer" src="<? if (!(substr($event->picture, 0, 7) == "http://")) : ?>http://<?=$_SERVER["HTTP_HOST"].KRequest::root()?>/media/com_ohanah/attachments_thumbs/<? endif; ?><?=$event->picture?>" />
				</a>
				<? endif; ?>
			</div>
		<? else : ?>
			<?= @template('com://site/ohanah.view.event.default_header', array('event' => $event, 'module' => 1)); ?>
		<? endif; ?>
	<? endif; ?>
</div>
