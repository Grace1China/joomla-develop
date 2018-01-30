<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">
	<? if (count($events)) : ?>
		<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '&Itemid='.KRequest::get('get.Itemid', 'int'); ?>

		<? if (JVersion::isCompatible('3.0')) : ?>
			<? JHtml::_('jquery.framework'); ?>
		<? else : ?>
			<? if ((JComponentHelper::getParams('com_ohanah')->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
				<? JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.min.js');?>
				<? JFactory::getApplication()->set('jquery', true); ?>
			<? endif; ?>
		<? endif; ?>

		<style>
			#map-container {
				padding: 6px;
				border-width: 1px;
				border-style: solid;
				border-color: #ccc #ccc #999 #ccc;
				-webkit-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
				-moz-box-shadow: rgba(64, 64, 64, 0.5) 0 2px 5px;
				box-shadow: rgba(64, 64, 64, 0.1) 0 2px 5px;
			}
			#map img {
				max-width: none;
			}
		</style>

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
		<script src="media://com_ohanah/js/markerclustererV3.js" />
		<? $componentParams = JComponentHelper::getParams('com_ohanah') ?>
		<? if ($componentParams->get('itemid')) $itemid = '&Itemid='.$componentParams->get('itemid'); else $itemid = '&Itemid='.KRequest::get('get.Itemid', 'int'); ?>

	    <script>
			jQuery(document).ready(function(){

		        var map = new google.maps.Map(document.getElementById('map'), {
			      	scrollwheel: false,
	        		mapTypeId: google.maps.MapTypeId.ROADMAP
		        });

				<? $count = 0 ?>

		        var markers = [];

				var latlngbounds = new google.maps.LatLngBounds();
				var infowindow = new google.maps.InfoWindow();

				function ohAddMarker(latitude, longitude, eventId, eventDate, eventTitle, eventURL) {
					window['latLng'+eventId] = new google.maps.LatLng(latitude, longitude);

		          	window['marker'+eventId] = new google.maps.Marker({icon: 'http://<?=$_SERVER['HTTP_HOST'].KRequest::base()?>/media/com_ohanah/images/ohapp_mapmarker.png', position: window['latLng'+eventId], value: eventId, title: eventTitle, url: eventURL, date: eventDate});

					latlngbounds.extend(window['latLng'+eventId]);

		          	markers.push(window['marker'+eventId]);

		          	latlngbounds.extend(window['latLng'+eventId]);

					window['contentString'+eventId] = '<div id="content"><a href="'+window['marker'+eventId].url+'">'+window['marker'+eventId].title+' ('+window['marker'+eventId].date+')</a></div>';

					google.maps.event.addListener(window['marker'+eventId], 'click', function() {
						map.panTo(window['latLng'+eventId]);
				   		if (infowindow) infowindow.close();
				      	infowindow.setContent(window['contentString'+eventId]);
					  	infowindow.open(map, window['marker'+eventId]);
					});
				}

				<? $i = 0 ?>
				<? foreach ($events as $event) : ?>

					<? if ($event->latitude) : ?>
			          	ohAddMarker(<?=$event->latitude?>, <?=$event->longitude?>, <?=$event->id?>, <?='"'.@helper('com://admin/ohanah.template.helper.datetime.formatDate', array('date' => $event->date, 'shortMonth' => false));?>", "<?=addslashes($event->title)?>", "<?=@route('option=com_ohanah&view=event&id='.$event->id.$itemid)?>");
					<? endif ?>
				<? endforeach ?>

				var clusterOptions = {
					'zoomOnClick': false
				}

				google.maps.event.addListener(map, 'zoom_changed', function() {
					if (infowindow) infowindow.close();
				});

		        var markerCluster = new MarkerClusterer(map, markers, clusterOptions);
				// Listen for a cluster to be clicked
				google.maps.event.addListener(markerCluster, 'clusterclick', function(cluster) {

					map.panTo(cluster.center_);

					if (map.getZoom() < 9) {
						map.setZoom(map.getZoom() + 2);
					} else {

						var content = '';

				   		// Convert lat/long from cluster object to a usable MVCObject
				   		var info = new google.maps.MVCObject;
				   		info.set('position', cluster.center_);

				   		var markers = cluster.getMarkers();
				   		var content = '<div id="content">';
				   		for (var i = 0; i < markers.length; i++) {
				   			//console.log(markers[i]);
							content += '<a href="'+markers[i].url+'">'+markers[i].title+' ('+markers[i].date+')</a><br />';
				   		}
				   		content += '</div>';

						if (infowindow) infowindow.close();
						infowindow.setContent(content);
				 		infowindow.open(map, info);
					}
				});

				map.setCenter(latlngbounds.getCenter());
				<? if ($params->get('zoom') && $params->get('zoom') != '0') : ?>
					map.setZoom(<?=$params->get('zoom')?>);
				<? else : ?>
					<? if (count($events) == 1 && $params->get('max_zoom')) : ?>
						map.setZoom(<?=$params->get('max_zoom')?>);
					<? else : ?>
						map.fitBounds(latlngbounds);
					<? endif ?>
				<? endif ?>

			});
	    </script>

		<? $width = $params->get('mapWidth'); if (!$width) $width = 500; ?>
		<? $height = $params->get('mapHeight'); if (!$height) $height = 260; ?>
		<?
		 // calculate width/height aspect ration so we can convert it to percentage
		 $ratio = $height / $width * 100;
		 ?>
		<div id="container" style="position:relative; padding-bottom:<?=$ratio?>%; height: 0;">
			<div id="map" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"></div>
		</div>

	<? endif; ?>
</div>
