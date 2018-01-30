<?php // no direct access
defined('_JEXEC') or die('Restricted access'); ?>

<div class="ohanah module<?php echo $params->get( 'moduleclass_sfx' ) ?>">

	<? if ($params->get('showVenueDescription')) : ?>
		<p><?=$venue['description']?></p>
	<? endif; ?>

	<? if ($venue['latitude'] && $venue['longitude']) : ?>

		<? if ($params->get('showPanoramio')) : ?>
			<?
			$numberOfPicturesFromPanoramio = $params->get('numberOfPicturesFromPanoramio');
			if ($numberOfPicturesFromPanoramio == '') $numberOfPicturesFromPanoramio = 9;
			?>

			<? if ($numberOfPicturesFromPanoramio) : ?>
				<div class="panoramio">
					<a target="blank" class="link" href="http://www.panoramio.com/map/#lt=<?=$venue['latitude'] ?>&ln=<?=$venue['longitude'] ?>&z=4&k=2"><?=@text('OHANAH_SEE_ON_PANORAMIO')?>:</a>
					<?php
					$latitude = $venue['latitude'] ;
					$longitude = $venue['longitude'];
					$radius = 5 * 0.621371192; // convertiti in miles ( in pratica prendo foto nell arco di 5km dalla location dell'evento, quindi sono contestualizzate)

					$lng_min = $longitude - $radius / abs(cos(deg2rad((double)$latitude)) * 69);
					$lng_max = $longitude + $radius / abs(cos(deg2rad((double)$latitude)) * 69);
					$lat_min = $latitude - ($radius / 69);
					$lat_max = $latitude + ($radius / 69);


					$panoramioParams = array(
						# possibili valori: popularity, upload_date
						'order' => 'popularity',
						# possibili valori: public (popular photos), full (all photos)
						'set' => 'public',
						# intervallo numerico che individua le fotografie da prelevare
						'from' => '0',
						'to' => $numberOfPicturesFromPanoramio,
						# minimum longitude
						'minx' => $lng_min,
						# minimum latitude
						'miny' => $lat_min,
						# maximum longitude
						'maxx' => $lng_max,
						# maximum latitude
						'maxy' => $lat_max,
						# dimensioni: original, medium (default value), small,
						# thumbnail (100px di larghezza), square, mini_square
						'size' => 'square',
					);

					$encoded_params = array();

					foreach ($panoramioParams as $k => $v)
					{
						$encoded_params[] = urlencode($k).'='.urlencode($v);
					}

					$url = "http://www.panoramio.com/map/get_panoramas.php?".implode("&", $encoded_params);
					$rsp = file_get_contents($url);
					?>

					<? if ($rsp) : ?>
						<? $res = json_decode($rsp); ?>
						<div class="photocontainer">

							<? foreach ($res->{'photos'} as $photo) : ?>
								<a class="ohanah_modal" href="<?=str_replace('square', 'medium', $photo->photo_file_url)?>" title="<?=$photo->photo_title?>">
									<img src="<?=$photo->photo_file_url?>" title="<?=$photo->photo_title?>" class="locationphoto"/>
								</a>
							<? endforeach; ?>
						</div>
					<? endif; ?>
				</div>
			<? endif; ?>
		<? endif; ?>
	<? endif; ?>

</div>
