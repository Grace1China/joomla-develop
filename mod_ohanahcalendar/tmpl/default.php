<?
if(!function_exists('getDaysBetweenDates')) {
	function getDaysBetweenDates($event) {
		// put start date, it's sure thing
		$days[] = substr($event->date,0,10);

		$endDate = $event->end_date;
		$endTime = $event->end_time;
		// if end time is earlier than 6AM, then event is actually some party or something, so for those guys
		// it's the same day as it started so no need to display it
		$hour = intval(substr($endTime,0,2));
		if ($endTime != "00:00:00" && $hour < 6) {
			$endDate = gmdate("Y-m-d", strtotime("-1 days", strtotime($endDate)));
		}

		// if we have end date and it's different than start date (event span 2 days)
		if ($event->end_time_enabled && (substr($event->date,0,10) != substr($endDate,0,10))) {
			// put pointer on start date
			$sCurrentDate = $event->date;
			// while we didn't reached near end date
			while(substr($sCurrentDate,0,10) < substr($endDate,0,10)){

				$oldCurrentDate = $sCurrentDate;

				if ($oldCurrentDate == gmdate("Y-m-d", strtotime("+1 days", strtotime($sCurrentDate)))) {
					$sCurrentDate = gmdate("Y-m-d", strtotime("+2 days", strtotime($sCurrentDate)));
				}	else {
		  		$sCurrentDate = gmdate("Y-m-d", strtotime("+1 days", strtotime($sCurrentDate)));
				}

			  $days[] = $sCurrentDate;
			}
		}
		return $days;
	}
}
?>

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

<style src="media://com_ohanah/css/calendartheme.css" />
<style src="media://com_ohanah/css/jquery-ui.css" />

<script src="media://com_ohanah/js/jquery-ui-1.9.2/js/jquery-ui-1.9.2.custom.min.js" />

<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '&Itemid='.KRequest::get('get.Itemid', 'int'); ?>

<? $uniqueModuleId = (rand()%9999);?>
<style>
	<? if ($activecalbgcolor = $params->get('activecalbgcolor', '#1D9D73')) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> a.ui-state-hover,
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .markedDay a.ui-state-default {
		background: <?=$activecalbgcolor?> !important;
		<? endif; ?>
		<? if ($activecaltextcolor = $params->get('activecaltextcolor', '#ffffff')) : ?>
		color: <?=$activecaltextcolor?> !important ;
		text-shadow:none !important;

	}
	<? endif; ?>

	<? if ($activecaltextcolor = $params->get('activecaltextcolor', '#ffffff')) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .markedDay a.ui-state-hover,
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .markedDay a.ui-state-default {
		color: <?=$activecaltextcolor?> !important ;

		text-shadow:none !important;
	}
	<? endif; ?>

	<? if ($params->get('showheader') == 0) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker .ui-datepicker-header {
	 display: none;
	}
	<? endif; ?>

	<? if ($params->get('prevnext') == 0) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker-prev,
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker-next {
		display: none;
	}
	<? endif; ?>

	<? if ($width = $params->get('width')) : ?>
	#ohanah-module-calendar-date-<?=$uniqueModuleId?> .ui-datepicker {
		width: <?=$width?>px !important;
	}
	<? endif; ?>

	/* fix header width when in registration page */
	.ui-datepicker-header {
		width: auto !important;
	}

</style>

<?
$date = new KDate();
$year = $date->getDate('%Y');
if ($params->get('year'))
	$year = $params->get('year');

$month = $date->getDate('%m');
if ($params->get('month'))
	$month = $params->get('month');
?>

<?
$config =& JFactory::getConfig();
$language = $config->get('language');

$orig_language = $language;
$languagesSupportedByjQueryUI = array('af', 'ar', 'az', 'bg', 'bs', 'ca', 'cs', 'da', 'de-CH', 'de', 'el', 'en-GB', 'eo', 'es', 'et', 'eu', 'fa', 'fi', 'fo', 'fr-CH', 'fr', 'he', 'hr', 'hu', 'hy', 'id', 'is', 'it', 'ja', 'ko', 'lt', 'lv', 'ms', 'nl-BE', 'nl', 'no', 'pl', 'pt-BR', 'ro', 'ru', 'sk', 'sl', 'sq', 'sr-SR', 'sr', 'sv', 'ta', 'th', 'tr', 'uk', 'vi', 'zh-CN', 'zh-HK', 'zh-TW');

if (in_array($orig_language, $languagesSupportedByjQueryUI)) {
	$language = $orig_language;
}
else {

	if (in_array(strtolower(substr($orig_language, -2, 2)), $languagesSupportedByjQueryUI)) {
		$language = strtolower(substr($orig_language, -2, 2));
	} else {
		if (in_array(substr($orig_language, 0, 2), $languagesSupportedByjQueryUI))
			$language = substr($orig_language, 0, 2);
		else
			$language = 'en-GB';
	}
}

// sometimes, method above produce unexpected results. These are exceptions that are fixed manually
if ($orig_language == "pt-PT") {$language = "pt-BR";} // for this mater, they are same
if ($orig_language == "ca-ES") {$language = "ca";} // wrongly interpreted as ES
if ($orig_language == "eu-ES") {$language = "eu";} // wrongly interpreted as ES

?>

<script src="media://com_ohanah/js/datepicker-locale/jquery.ui.datepicker-<?=$language?>.js" />

<script>
var $jq = jQuery.noConflict();
$jq(function() {

	$jq.datepicker.setDefaults( $jq.datepicker.regional[ "<?=$language?>" ] );
	<?
		$defaultDate = null;
		if ($params->get("month") != "" || $params->get("year") != "") { // we need to make default date
			$year = $params->get("year");
			if ($year == "") $year = strftime("%Y"); // setting default
			$month = $params->get("month");
			if ($month == "") $month = strftime("%m"); // settinf default
			$defaultDate = $year."-".$month."-01";
		}
	?>
	$jq("#ohanah-module-calendar-date-<?=$uniqueModuleId?>").datepicker({
        dateFormat: 'yy-mm-dd',
        firstDay: '<?=$params->get('firstDay')?>',
        showOtherMonths: 'true',
        beforeShowDay: daysToMark,
   		onSelect: daySelected<?=$uniqueModuleId?>,
		changeMonth: false,
		changeYear: false,
		defaultDate: '<?=$defaultDate?>'

	});

	<?
	$daysWithEvents = array();

	if (($params->get('allevents')) == 0 && $params->get('eventcatid'))
		foreach (@service('com://site/ohanah.model.events')->set('enabled', 1)->set('ohanah_category_id', $params->get('eventcatid'))->getList() as $event)
			$daysWithEvents = array_merge($daysWithEvents, getDaysBetweenDates($event));
	else
		foreach (@service('com://site/ohanah.model.events')->set('enabled', 1)->getList() as $event)
			$daysWithEvents = array_merge($daysWithEvents, getDaysBetweenDates($event));


	$daysWithEvents = array_unique($daysWithEvents);

	?>

	function daySelected<?=$uniqueModuleId?>(dateText, inst) {

		var formattedDate = dateText;
		var arrayOfDates = [<?$first = true; foreach ($daysWithEvents as $day) { if (!$first) echo ','; echo "'".$day."'"; $first = false;}?>];

		if ($jq.inArray(formattedDate, arrayOfDates) != -1) {
			var link =
				'http://<?=$_SERVER["HTTP_HOST"].KRequest::root()?>' +
				'/index.php?option=com_ohanah&view=events&calendar_start_date='+dateText+'&calendar_end_date='+dateText+'<?=$itemid?>&filterEvents=';
				<?if (($params->get('allevents')) == 0 && $params->get('eventcatid')) :?>
					link = link + "&ohanah_category_id=<?=$params->get('eventcatid')?>";
				<?endif;?>
			window.location = link;
		}
	}

	function daysToMark(date) {
		var dayDate = date.getDate();
		if (dayDate < 10) dayDate = '0'+dayDate;
		var monthDate = date.getMonth() + 1;
		if (monthDate < 10) monthDate = '0'+monthDate;

		var formattedDate = (date.getFullYear() + '-'+monthDate+'-' + dayDate);
		var arrayOfDates = [<?$first = true; foreach ($daysWithEvents as $day) { if (!$first) echo ','; echo "'".$day."'"; $first = false;}?>];

		if ($jq.inArray(formattedDate, arrayOfDates) != -1) {
		    return [true, 'markedDay', ""];
		} else return [true, '', ""]; //return false to disable the box if the day is not marked
	}
});
</script>

<div id='ohanah-module-calendar-date-<?=$uniqueModuleId?>'></div>
<div id='ohanah-module-calendar-after-calendar-<?=$uniqueModuleId?>'></div>
