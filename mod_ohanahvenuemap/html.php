<?php
/**
 * @package		mod_sidebar
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahvenuemapHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }

	public function display()
	{
		if (KRequest::get('get.option', 'string') == 'com_ohanah') {
			$this->getTemplate()->renderHelper('com://site/ohanah.template.helper.behavior.custom_css');

			// is it page (menu item) that has venue info?
			$pageparameters =& JFactory::getApplication()->getPageParameters();
			$ohanah_venue_id = $pageparameters->get('ohanah_venue_id');

			// or it's in the URL
			if (KRequest::get('get.ohanah_venue_id', 'int')) {
				$ohanah_venue_id = KRequest::get('get.ohanah_venue_id', 'int');
			}

			// or there is event id in the URL (event or registration)
			if (KRequest::get('get.view', 'string') == 'event') $id = KRequest::get('get.id', 'int');
        	if (KRequest::get('get.view', 'string') == 'registration') $id = KRequest::get('get.ohanah_event_id', 'int');

			// if we have id of the event, extract venue id
			if ($id) {
				$event = $this->getService('com://site/ohanah.model.events')->id($id)->getItem();
				$ohanah_venue_id = $event->ohanah_venue_id;
			}

			// anyway, if we have venue id, display!
			if ($ohanah_venue_id) {
				$venue = $this->getService('com://admin/ohanah.model.venues')->id($ohanah_venue_id)->getItem();
				$this->assign('venue', $venue);
				$this->assign('params', $this->params);
				return parent::display();
			}
		}
	}
}
