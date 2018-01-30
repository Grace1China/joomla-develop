<?php
/**
 * @package     ohanah
 * @copyright   Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license     GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanaheventsHtml extends ModDefaultHtml
{
    public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }

    public function shouldDisplay($params) {
        // are we in Joomla 2.5?
        if (JVersion::isCompatible('3.0')) {
            // are we in ohanah
            if (KRequest::get('get.option', 'string') == 'com_ohanah') {

                // are we in events view
                if (KRequest::get('get.view', 'string') == 'events') {
                    // are we in category view
                    if (KRequest::get('get.ohanah_category_id', 'int')) {
                        return $params->get('show_in_category_view', 1);
                    }
                    // are we in venue view
                    if (KRequest::get('get.ohanah_venue_id', 'int')) {
                        return $params->get('show_in_venue_view', 1);
                    }
                    // we are not in category nor in venue view, so maybe we are in calendar view
                    if (KRequest::get('get.layout', 'string') == 'calendar') {
                        return $params->get('show_in_calendar', 1);
                    }
                    // no venue, no category, no calendar... plain simple event list
                    return $params->get('show_in_events_view', 1);
                }
                // are we in single event view
                if (KRequest::get('get.view', 'string') == 'event') {
                    return $params->get('show_in_event_view', 1);
                }
                // only other option is registration form
                if (KRequest::get('get.view', 'string') == 'registration') {
                    return $params->get('show_in_registration_view', 1);
                }
            }
            // if we are not in ohanah just return true, let menu item options sort things out
            return true;
        } else { // we are in Joomla 2.5, this will not work, we should always display everything regardless of the settings
            return true;
        }
    }

    public function display()
    {
		$this->getTemplate()->renderHelper('com://site/ohanah.template.helper.behavior.custom_css');

        JFactory::getLanguage()->load('com_ohanah');
        JFactory::getDocument()->addStyleSheet(JURI::root(1).'/media/com_ohanah/css/screen.css');

        $filterEvents = 'all';

        if ($this->params->get('list_type') == 'notpast')
            $filterEvents = 'notpast';
        else if ($this->params->get('list_type') == 'past')
            $filterEvents = 'past';

        $direction = $this->params->get('direction');

        $model = $this->getService('com://site/ohanah.model.events');

        if ($this->params->get('showOnlyACategory') == '1') {
            $model->set('ohanah_category_id', $this->params->get('showOnlyCategoryId'));
        }
        if ($this->params->get('ohanah_venue_id') != '') {
            $model->set('ohanah_venue_id', $this->params->get('ohanah_venue_id'));
        }
        // check if this module is adaptive
        // this works only if module is on ohanah-single-event-1, 2, 3 positions so we first check that
        if ($this->params->get('adaptTo') != '0') {  // add this check
            $eventID = KRequest::get('get.id', 'int');
            if ($eventID) {
                $event = $this->getService('com://site/ohanah.model.events')->set('id', $eventID)->getItem();

                if ($this->params->get('adaptTo') == '1') {
                    $model->set('ohanah_category_id', $event->get('ohanah_category_id'));
                }

                if ($this->params->get('adaptTo') == '2') {
                    $model->set('ohanah_venue_id', $event->get('ohanah_venue_id'));
                }

                $model->set('excludeEventID', $eventID);
            }
        }

        $model->set('filterEvents', $filterEvents)
            ->set('enabled', 1)
            ->set('direction', $direction)
            ->set('limit', $this->params->get('list_max_number'));

        $model->set('featured', $this->params->get('showOnlyFeatured'));

        $this->assign('events', $model->getList());
        $this->assign('displayStyle', $this->params->get('displayStyle'));
        $this->assign('user', JFactory::getUser());

        return parent::display();
    }
}
