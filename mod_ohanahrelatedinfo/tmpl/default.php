<?php defined('_JEXEC') or die('Restricted access'); ?>

<?
if (!function_exists('curl_get_contents')) {
	function curl_get_contents ($url) {
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_URL, $url);
		$html = curl_exec($curl);
		curl_close($curl);
		return $html;
	}
}
?>

<div class="ohanah_module">

	<? if ($event->latitude && $event->longitude) : ?>

		<? if ($params->get('showWikipedia')) : ?>
			<span class="related-info"><a target="blank" class="link wikipedia" href="http://wikipedia.org/wiki/<?=$event->geolocated_city ?>"><?=@text('ON_WIKIPEDIA')?></a></span>
		<? endif ?>

		<? if ($params->get('showTripadvisor')) : ?>
			<span class="related-info"><a target="blank" class="link tripadvisor" href="http://www.tripadvisor.com/<?=$event->geolocated_city ?>"><?=@text('GET_TRIP_ADVICE')?></a></span>
		<? endif ?>

		<? if ($params->get('showPanoramio')) : ?>
			<span class="related-info"><a target="blank" class="link panoramio" href="http://www.panoramio.com/map/#lt=<?=$event->latitude ?>&ln=<?=$event->longitude ?>&z=4&k=2"><?=@text('OHANAH_SEE_ON_PANORAMIO')?></a></span>
		<? endif ?>

		<? if ($params->get('showPanoramioImages')) : ?>
			<?
			$numberOfPicturesFromPanoramio = $params->get('numberOfPicturesFromPanoramio');
			if ($numberOfPicturesFromPanoramio == '') $numberOfPicturesFromPanoramio = 9;
			?>

			<? if ($numberOfPicturesFromPanoramio) : ?>
				<div class="panoramio">
					<?php
					$latitude = $event->latitude ;
					$longitude = $event->longitude;
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
					$rsp = curl_get_contents($url);
					?>

					<? if ($rsp) : ?>
						<? $res = json_decode($rsp); ?>
						<div class="photocontainer">
							<? if ($res) foreach ($res->{'photos'} as $photo) : ?>
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
