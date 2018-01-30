<? if (!JVersion::isCompatible('3.0')) : ?>
	<? if (($params->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
		<? JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.min.js');?>
		<? JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery-migrate-1.2.1.min.js');?>
		<? JFactory::getApplication()->set('jquery', true); ?>
	<? endif; ?>
<? else : ?>
	<? JHtml::_('jquery.framework'); ?>
<? endif ?>

<? if (JComponentHelper::getParams('com_ohanah')->get('itemid')) $itemid = '&Itemid='.JComponentHelper::getParams('com_ohanah')->get('itemid'); else $itemid = '&Itemid='.JRequest::getVar('Itemid'); ?>
<? $random_id = rand(1000, 9999); ?>
<?= @helper('com://site/ohanah.template.helper.behavior.fullcalendar'); ?>

<script src="media://com_ohanah/js/spin.min.js" />
<script src="media://com_ohanah/js/jquery.spin.js" />

<style>
	td.hint, td[data-hint],
	.td.hint, .td[data-hint] {
		display: table-cell;
	}

	.hint:after, [data-hint]:after {
		white-space: pre;
	}

	.do-open-event {
		cursor: pointer;
	}
</style>

<script>
	jQuery.noConflict()(function($) {
		$('#mod-calendar-loading-<?=$random_id?>').spin({
			lines: 13, // The number of lines to draw
			length: 20, // The length of each line
			width: 10, // The line thickness
			radius: 30, // The radius of the inner circle
			corners: 1, // Corner roundness (0..1)
			rotate: 0, // The rotation offset
			direction: 1, // 1: clockwise, -1: counterclockwise
			color: '#000', // #rgb or #rrggbb or array of colors
			speed: 1, // Rounds per second
			trail: 60, // Afterglow percentage
			shadow: false, // Whether to render a shadow
			hwaccel: false, // Whether to use hardware acceleration
			className: 'spinner', // The CSS class to assign to the spinner
			zIndex: 2e9, // The z-index (defaults to 2000000000)
			top: '50%', // Top position relative to parent
			left: '50%' // Left position relative to parent
		});

		var previous = null;

		$('#mod-calendar-<?=$random_id?>').fullCalendar({
			header: <?= $calendar_header; ?>,
			events: "<?= htmlspecialchars_decode(@route($calendar_url)); ?>",
			loading: function(bool) {
				$('#mod-calendar-loading-<?=$random_id?>').toggle(bool);
			},
			height: 'auto',
			columnFormat: {
				month: 'dd'
			},
			firstDay: '<?= $calendar_first_day; ?>',
			eventRender: function (event, element, view) {
				if(event === previous) {
					return false;
				}

				if (view.name == 'month') {
					var between = [];

                    // we need to find out all dates between start and end date
                    var currentPointer = new moment(event.start); // start at the start date
                    // we use momentjs function for that. "day" at the end tells moment to ignore time
                    // http://momentjs.com/docs/#/query/is-between/ - apparently this is renamed to inWithing at some point

                    while (currentPointer.isSame(event.start, 'day') || currentPointer.isBefore(event.end, 'day') || currentPointer.isSame(event.end, 'day')) {
						between.push(new moment(currentPointer));
                        currentPointer.add(1, 'days'); // move to next day
					}

					$.each(between, function( index, value ) {
						var $data_selector = $("#mod-calendar-<?=$random_id?> td[data-date*='" + value.format('YYYY-MM-DD') + "']");
						$data_selector
						<? if ($params->get('activecaltextcolor')) : ?>
							.css('color', '<?= $params->get('activecaltextcolor'); ?>')
						<? endif; ?>
						<? if ($params->get('activecalbgcolor')) : ?>
							.css('background-color', '<?= $params->get('activecalbgcolor'); ?>')
						<? else: ?>
							.addClass('active-day')
						<? endif; ?>
							.addClass('do-open-event')
							.addClass('hint--top')
							.attr('data-hint', ($data_selector.attr('data-hint') ? $data_selector.attr('data-hint') + '\u000A' : '') + event.title)
						;
					});
				}

				previous = event;
				return false;

			},
			dayClick: function(date, allDay, jsEvent, view) {
				if($("td[data-date*='" + moment(date).format('YYYY-MM-DD') + "']").hasClass('do-open-event')) {
					var count = 0,
						events = [];

					$('#mod-calendar-<?=$random_id?>').fullCalendar('clientEvents', function(event) {
						if(event.start.format('YYYY-MM-DD') <= date.format('YYYY-MM-DD') && event.end.format('YYYY-MM-DD') >= date.format('YYYY-MM-DD')) {
							events.push(event);
							count++;
						}
					});

					if(count == 1) {
						location.href = events[0].url;
					} else {
						var start_date = moment(date).format('YYYY-MM-DD');
						var end_date = moment(date).format('YYYY-MM-DD');

						location.href = "index.php?option=com_ohanah&view=events&ohanah_category_id=<?=$params->get('eventcatid')?>&starting_date=" + start_date + '&ending_date=' + end_date + '<?=$itemid;?>';
					}
				}
			}
		});
	});
</script>

<div id="mod-calendar-<?=$random_id?>" style="position: relative;">
	<div id="mod-calendar-loading-<?=$random_id?>" ></div>
</div>
