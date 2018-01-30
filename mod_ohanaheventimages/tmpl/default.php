<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">

  <? if ($params->get('whichImages') == 'flyer') : ?>
    <img class="ohanah_flyer" src="media://com_ohanah/attachments/<?=$event->picture?>" />
  <? else : ?>
  	<? $images = @service('com://admin/ohanah.model.attachments')->set('target_type', 'event')->set('target_id', $event->id)->getList() ?>
    <? $onlyOne = false; ?>
   	<? if (count($images)) : ?>
      <? if (count($images) == 1) $onlyOne = true; ?>
     		<? foreach ($images as $image) : ?>
    			<? if ($image->name != $event->picture) : ?>
    				<a class="ohanah_modal" href="media://com_ohanah/attachments/<?=$image->name?>"><div class="event-photos" style="background: url('media://com_ohanah/attachments_thumbs/<?=$image->name?>'); background-size: 100% 100%; -webkit-background-size: cover; -moz-background-size: cover; -o-background-size: cover; background-size: cover; float: left;"></div></a>
          <? else : ?>
          <? // we encountered event picture. If this is only one picture, then there are no event images ?>
            <? if ($onlyOne) : ?>
              <? $str = 'OHANAH_NO_IMAGES_AVAILABLE'; $text = @text($str); echo ($text == "" || $text == $str) ? 'Sorry, no event images available.' : $text; ?>
            <? endif ?>
    			<? endif ?>
    		<? endforeach ?>
  	<? else : ?>
  		<? $str = 'OHANAH_NO_IMAGES_AVAILABLE'; $text = @text($str); echo ($text == "" || $text == $str) ? 'Sorry, no event images available.' : $text; ?>
  	<? endif ?>
  <? endif ?>
  <div style="clear: both;"></div>
</div>
