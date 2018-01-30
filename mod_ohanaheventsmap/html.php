<?php
/**
 * @package		mod_sidebar
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanaheventsmapHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }

	public function display()
	{
		$this->getTemplate()->renderHelper('com://site/ohanah.template.helper.behavior.custom_css');

		JFactory::getLanguage()->load('com_ohanah');

		$model = $this->getService('com://site/ohanah.model.events');

		if ($this->params->get('hidePastEvents') == '1') {
			$model->set('filterEvents', 'notpast');
		}

		$pageParameters = JFactory::getApplication()->getPageParameters();
		$joomlaVersion = JVersion::isCompatible('1.6.0') ? '1.6' : '1.5';

		if (KRequest::get('get.view', 'string') == 'events') {

			if ($this->params->get('adaptive') == '1') {
				if ($ohanah_category_id = KRequest::get('get.ohanah_category_id', 'int')) {
					$model->set('ohanah_category_id', $ohanah_category_id);
				} else {
					if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACategory')) {
						if ($ohanah_category_id = $pageParameters->get('ohanah_category_id')) {
							$model->set('ohanah_category_id', $ohanah_category_id);
						}
					}
				}

				if ($ohanah_venue_id = KRequest::get('get.ohanah_venue_id', 'int')) {
					$model->set('ohanah_venue_id', $ohanah_venue_id);
				} else {
					if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyAVenue')) {
						if ($ohanah_venue_id = $pageParameters->get('ohanah_venue_id')) {
							$model->set('ohanah_venue_id', $ohanah_venue_id);
						}
					}
				}

				if ($created_by = KRequest::get('get.created_by', 'int')) {
					$model->set('created_by', $created_by);
				} else {
					if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyAnAuthor')) {
						if ($created_by = $pageParameters->get('created_by')) {
							$model->set('created_by', $created_by);
						}
					}
				}

				if ($filterEvents = KRequest::get('get.filterEvents', 'string')) {
					$model->set('filterEvents', $filterEvents);
				} else {
					if ($filterEvents = $pageParameters->get('list_type')) {
						$model->set('filterEvents', $filterEvents);
					}
				}

				if ($geolocated_country = KRequest::get('get.geolocated_country', 'string')) {
					$model->set('geolocated_country', $geolocated_country);
				} else {
					if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACountry')) {
						if ($geolocated_country = $pageParameters->get('geolocated_country')) {
							$model->set('geolocated_country', $geolocated_country);
						}
					}
				}

				if ($geolocated_state = KRequest::get('get.geolocated_state', 'string')) {
					$model->set('geolocated_state', $geolocated_state);
				} else {
					if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyAState')) {
						if ($geolocated_state = $pageParameters->get('geolocated_state')) {
							$model->set('geolocated_state', $geolocated_state);
						}
					}
				}

				if ($geolocated_city = KRequest::get('get.geolocated_city', 'string')) {
					$model->set('geolocated_city', $geolocated_city);
				} else {
					if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyACity')) {
						if ($geolocated_city = $pageParameters->get('geolocated_city')) {
							$model->set('geolocated_city', $geolocated_city);
						}
					}
				}

				if ($recurringParent = KRequest::get('get.recurringParent', 'int')) {
					$model->set('recurringParent', $recurringParent);
				} else {
					if ($joomlaVersion != '1.5' || $pageParameters->get('showOnlyARecurringSerie')) {
						if ($recurringParent = $pageParameters->get('recurringParent')) {
							$model->set('recurringParent', $recurringParent);
						}
					}
				}
			}
		}

		$model->set('featured', $this->params->get('showOnlyFeatured'));

		$model->set('limit', $this->params->get('limit'));

		$model->set('enabled', 1);

		$this->assign('events', $model->getList());
		$this->assign('params', $this->params);

		return parent::display();
	}
}
