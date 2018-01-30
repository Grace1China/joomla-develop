<?php defined('_JEXEC') or die('Restricted access'); ?>
<? $pageParameters = JFactory::getApplication()->getPageParameters(); ?>
<? $ohanahParameters = JComponentHelper::getParams('com_ohanah'); ?>


<style src="media://com_ohanah/v2/filter-module.css" />

<div class="panelContent ohanah module <?php echo $params->get( 'moduleclass_sfx' ) ?>">

    <? if (KRequest::get('get.option', 'string') == 'com_ohanah' && KRequest::get('get.Itemid', 'int')) $itemid = KRequest::get('get.Itemid', 'int'); else $itemid = JComponentHelper::getParams('com_ohanah')->get('itemid', '');  ?>
	<form method="get" action="<?=@route('option=com_ohanah&view=events&layout=default&Itemid='.$itemid)?>" id="filterForm" class="box short style">

		<input type="hidden" name="option" value="com_ohanah" />
		<input type="hidden" name="view" value="events" />
		<input type="hidden" name="Itemid" value="<?=$itemid?>" />

		<div>
			<? if ($params->get('showFilters')) : ?>

				<? if (JVersion::isCompatible('3.0')) : ?>
					<? JHtml::_('jquery.framework'); ?>
				<? else : ?>
					<? if (($ohanahParameters->get('loadJQuery') != '0') && (!JFactory::getApplication()->get('jquery'))) : ?>
						<? JFactory::getDocument()->addScript(JURI::root(1).'/media/com_ohanah/js/jquery.min.js');?>
						<? JFactory::getApplication()->set('jquery', true); ?>
					<? endif; ?>
				<? endif; ?>

				<script>
					var $jq = jQuery.noConflict();
					$jq(function() {
						$jq('select[name="filterEvents"]').change(function(){
							$jq('#filterForm').submit();
						});
						$jq('select[name="ohanah_venue_id"]').change(function(){
							$jq('#filterForm').submit();
						});
						$jq('.ohanah-filter-category select[name="ohanah_category_id"]').change(function(){
							$jq('#filterForm').submit();
						});
						$jq('select[name="geolocated_country"]').change(function(){
							$jq('select[name="geolocated_city"]').find('option:selected').removeAttr("selected");
							$jq('#filterForm').submit();
						});
						$jq('select[name="geolocated_state"]').change(function(){
							$jq('#filterForm').submit();
						});
						$jq('select[name="geolocated_city"]').change(function(){
							$jq('#filterForm').submit();
						});
						$jq('select[name="direction"]').change(function(){
							$jq('#filterForm').submit();
						});
						$jq('select[name="recurringParent"]').change(function(){
							$jq('#filterForm').submit();
						});
					});
				</script>

				<? if ($params->get('is_vertical')) : ?><br /><? endif ?>

				<? $joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5'; ?>

				<? if ($params->get('enableFilterVenue')) : ?>
					<? $selected = ''; if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyAVenue')) { $selected = $pageParameters->get('ohanah_venue_id'); } else { $selected = ''; } ?>
					<div class="ohanah-filter-venue">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4">
								<? if (KRequest::get('get.ohanah_venue_id', 'int') >= '0') $selected = KRequest::get('get.ohanah_venue_id', 'int') ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.venues', array('name' => 'ohanah_venue_id', 'selected' => $selected, 'prompt' => 'OHANAH_VENUE', 'published' => 1, 'hideEmptyVenues' =>$params->get('hideEmptyVenues'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ($params->get('enableFilterCategory')) : ?>
					<? $selected = ''; if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACategory')) { $selected = $pageParameters->get('ohanah_category_id'); } else { $selected = ''; } ?>
					<div class="ohanah-filter-category">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4">
								<? if (KRequest::get('get.ohanah_category_id', 'int') >= '0') $selected = KRequest::get('get.ohanah_category_id', 'int') ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.categories', array('name' => 'ohanah_category_id', 'selected' => $selected, 'prompt' => 'OHANAH_CATEGORY', 'published' => 1, 'hideEmptyCategories' => $params->get('hideEmptyCategories'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ($params->get('enableFilterEventdate')) : ?>
					<div class="ohanah-filter-event-date">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4" >
								<? $selected = ''; KRequest::get('get.filterEvents', 'string') ? $selected = KRequest::get('get.filterEvents', 'string') : $selected = $pageParameters->get('list_type'); ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.filterevents', array('selected' => $selected, 'prompt' => @text('OHANAH_EVENTS'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ($params->get('enableFilterCountry')) : ?>
					<? $selected = ''; if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACountry')) { $selected = $pageParameters->get('geolocated_country'); } else { $selected = ''; } ?>
					<div class="ohanah-filter-country">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4" >
								<? if (KRequest::get('get.geolocated_country', 'string')) $selected = KRequest::get('get.geolocated_country', 'string') ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.countries', array('selected' => $selected, 'prompt' => @text('OHANAH_COUNTRY'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ($params->get('enableFilterState')) : ?>
					<? $selected = ''; if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyAState')) { $selected = $pageParameters->get('geolocated_state'); } else { $selected = ''; } ?>
					<div class="ohanah-filter-state">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4" >
								<? if (KRequest::get('get.geolocated_state', 'string')) $selected = KRequest::get('get.geolocated_state', 'string') ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.states', array('selected' => $selected, 'prompt' => @text('OHANAH_STATE'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ($params->get('enableFilterCity')) : ?>
					<? $selected = ''; if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACity')) { $selected = $pageParameters->get('geolocated_city'); } else { $selected = ''; } ?>
					<div class="ohanah-filter-city">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4" >
								<? if (KRequest::get('get.geolocated_city', 'string')) $selected = KRequest::get('get.geolocated_city', 'string') ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.cities', array('selected' => $selected, 'prompt' => @text('OHANAH_CITY'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ($params->get('enableFilterDirection')) : ?>
					<div class="ohanah-filter-direction">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4" >
								<? $selected = ''; KRequest::get('get.direction', 'string') ? $selected = KRequest::get('get.direction', 'string') : $selected = $pageParameters->get('direction'); ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.direction', array('selected' => $selected, 'prompt' => @text('OHANAH_DIRECTION'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
				<? if ($params->get('enableFilterRecurring')) : ?>
					<? $selected = ''; if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyARecurringSerie')) { $selected = $pageParameters->get('recurringParent'); } else { $selected = ''; } ?>
					<div class="ohanah-filter-recurring">
						<div class="dropdownWrapper" style="float:left; margin-right:10px">
							<div class="dropdown size4" >
								<? if (KRequest::get('get.ohanah_category_id', 'string') >= '0') $selected = KRequest::get('get.recurringParent', 'string') ?>
								<?=@helper('com://admin/ohanah.template.helper.listbox.recurring', array('selected' => $selected, 'prompt' => @text('OHANAH_RECURRING_SET'))) ?>
							</div>
						</div>
					</div>
				<? endif ?>
			<? endif; ?>
			<? if ($params->get('showTextSearch')) : ?>
				<div style="float:left; margin-right:10px" class="ohanah-filter-text">
					<input type="text" id="textToSearch" name="textToSearch" class="text" style="width:60%;" value="<?=KRequest::get('get.textToSearch', 'string')?>" />
				</div>
				<div style="float:left; margin-right:10px" class="ohanah-filter-button">
					<?= @helper('com://site/ohanah.template.helper.button.button', array('type' => 'input', 'text' => @text('OHANAH_SEARCH'))); ?>
				</div>
			<? endif; ?>
		</div>
	</form>
</div>
