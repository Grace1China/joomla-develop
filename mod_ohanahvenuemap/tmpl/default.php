<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if ($venue['latitude'] && $venue['longitude']) : ?>
		<div id="event_main_map_wrapper">
			<? $width = $params->get('mapWidth'); if (!$width) $width = 500; ?>
			<? $height = $params->get('mapHeight'); if (!$height) $height = 260; ?>
			<div id="event_main_map" style="width: <?=$width?>px; height: <?=$height?>px; background: url(http://maps.google.com/maps/api/staticmap?zoom=13&size=<?=$width?>x<?=$height?><? if (substr($_SERVER['HTTP_HOST'], 0, 9) != 'localhost' && substr($_SERVER['HTTP_HOST'], 0, 9) != '127.0.0.1' ) echo '&markers=icon:http://'.$_SERVER['HTTP_HOST'].KRequest::base().'/media/com_ohanah/images/ohanah.png'; else echo '&markers=color:blue'; ?>|<?=$venue['latitude']?>,<?=$venue['longitude']?>&sensor=false) no-repeat;">
				<div style="padding-top: <?=$height - 30?>px;"></div>
				<div class="getdirections">
					<a target="blank" class="eventregister2-button ui-state-default ui-corner-all" href="http://maps.google.com/maps?f=d&daddr=<?=$venue['latitude'] ?>,<?=$venue['longitude'] ?>(<?=$venue['address']?>)"><?=@text('OHANAH_GET_DIRECTIONS')?></a>
				</div>
			</div>
		</div>
		<div class="event_main_location_description">
			<h3><?=$venue['title']?></h3>
			<p><?=$venue['address']?></p>
		</div>
	<? endif; ?>
</div>
