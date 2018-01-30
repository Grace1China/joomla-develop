<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>
<?
	// make a marker
	$markerIcon = "";
	$marker = "&markers=";
	if (substr($_SERVER['HTTP_HOST'], 0, 9) != 'localhost' && substr($_SERVER['HTTP_HOST'], 0, 9) != '127.0.0.1' ) {
		$markerIcon = 'http://'.$_SERVER['HTTP_HOST'].str_replace('/administrator', '', KRequest::base()).'/media/com_ohanah/images/ohapp_mapmarker.png';
		$marker .= 'icon:'.$markerIcon;
	} else {
		$marker .= 'color:blue';
	}
?>
<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>" itemscope itemtype="http://schema.org/EventVenue">
	<? if ($event->latitude && $event->longitude) : ?>
		<div id="event_main_map_wrapper">
			<? $width = $params->get('mapWidth'); if (!$width) $width = 200; ?>
			<? $height = $params->get('mapHeight'); if (!$height) $height = 150; ?>
			<? $dynamic = $params->get('dynamicMap'); if ($dynamic == 1) $dynamic = true; else $dynamic = false;?>
			<div id="event_main_map">
				<? if (!$dynamic) : ?>
				<img itemprop="maps" style="width: <?=$width?>px; height: <?=$height?>px; border: 1px solid #CCCCCC; border-radius: 3px 3px 3px 3px; margin-bottom:5px" src="http://maps.google.com/maps/api/staticmap?zoom=15&size=<?=$width?>x<?=$height?><? echo $marker?>|<?=$event->latitude?>,<?=$event->longitude?>&sensor=false" />
				<? else: ?>
					<?php
						$config =& JFactory::getConfig();
						$language = $config->get('language');
						$languagesSupportedByGoogleMaps = array('ar', 'bg', 'bn', 'ca', 'cs', 'da', 'de', 'el', 'en', 'en-AU', 'en-GB', 'es', 'eu', 'fa', 'fi', 'fi', 'fr', 'gl', 'gu', 'hi', 'hr', 'hu', 'id', 'it', 'iw', 'ja', 'kn', 'ko', 'lt', 'lv', 'ml', 'mr', 'nl', 'nn', 'no', 'or', 'pl', 'pt', 'pt-BR', 'pt-PT', 'rm', 'ro', 'ru', 'sk', 'sl', 'sr', 'sv', 'tl', 'ta', 'te', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-TW');

						if (!in_array($language, $languagesSupportedByGoogleMaps)) {
							$language = substr($language, 0, 2);
						}

						if (!in_array($language, $languagesSupportedByGoogleMaps)) {
							$language = 'en';
						}
					?>
					<!-- <script src="//maps.google.com/maps/api/js?sensor=false&language=<?=$language?>" />-->
					<script>
						var map;
						function initialize() {

							var myLatlng = new google.maps.LatLng(<?=$event->latitude?>,<?=$event->longitude?>);

						  var mapOptions = {
						    zoom: 15,
						    center: myLatlng,
						    mapTypeId: google.maps.MapTypeId.ROADMAP
						  };

						  map = new google.maps.Map(document.getElementById('map-canvas'),
						      mapOptions);

						  var marker = new google.maps.Marker({
					      position: myLatlng,
					      map: map,
					      title: '<? $event->title ?>',
					      icon: '<? $markerIcon ?>'
						  });
						}
						google.maps.event.addDomListener(window, 'load', initialize);
			    </script>
			    <div id="map-canvas" style="width: <?=$width?>px; height: <?=$height?>px; border: 1px solid #CCCCCC; border-radius: 3px 3px 3px 3px; margin-bottom:5px"></div>
				<? endif; ?>
			</div>
		</div>
		<div class="event_main_location_description">
			<h3 itemprop="name"><?=$this->getService('com://admin/ohanah.model.venues')->id($event->ohanah_venue_id)->getItem()->title?></h3>
			<p itemprop="address"><span class="address"><?=$event->address?></span><a target="blank" href="http://maps.google.com/maps?f=d&daddr=<?=$event->latitude ?>,<?=$event->longitude ?>(<?=$event->address?>)"><?=@text('OHANAH_GET_DIRECTIONS')?></a></p>
		</div>
	<? endif; ?>
</div>
