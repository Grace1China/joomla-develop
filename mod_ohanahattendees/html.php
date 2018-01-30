<?php
/**
 * @package		mod_sidebar
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahattendeesHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }

	public function display()
	{
		$this->getTemplate()->renderHelper('com://site/ohanah.template.helper.behavior.custom_css');

		$id = KRequest::get('get.id', 'int');

		if (!$id) $id = JFactory::getApplication()->getPageParameters()->get('id');

    	if (!$id) $id = KRequest::get('get.ohanah_event_id', 'int');

    	if (!$id) $id = JFactory::getApplication()->getPageParameters()->get('ohanah_event_id');

		if ((KRequest::get('get.option', 'string') == 'com_ohanah') && (KRequest::get('get.view', 'string') == 'event' || KRequest::get('get.view', 'string') == 'registration') && $id) {
			$event = $this->getService('com://admin/ohanah.model.events')->id($id)->getItem();

			$date = new KDate();
			// hide module only if needed and only in Joomla3. In J2.5 it depends on template if this trick would work or not, so we are not appliying it
			if (JVersion::isCompatible('3.0')) {
					if($event->who_can_register == 2 || $event->isPast() || (($event->close_registration_day != '0000-00-00') && ($event->close_registration_day != '1970-01-01') && ($date->format('%Y-%m-%d') > $event->close_registration_day))) {
						return null;
					}
			}

			$this->assign('event', $event);
			$this->assign('listStyle', $this->params->get('listStyle'));
			$this->assign('must_pay_to_be_listed_as_attendee_in_paid_events', $this->params->get('must_pay_to_be_listed_as_attendee_in_paid_events'));
			$this->assign('showNumOfTickets', $this->params->get('showNumOfTickets'));

			return parent::display();
		}
	}
}
