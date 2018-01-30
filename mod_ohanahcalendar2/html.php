<?php
/**
 * @package		mod_ohanahcalendar
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahcalendar2Html extends ModDefaultHtml
{
	public function __construct(KConfig $config)
	{
		parent::__construct($config);
		$this->params  = $config->params;
	}

	public function display()
	{
		$calendar_header	= array('left' => 'prev', 'center' => 'title', 'right' => 'next');
		$calendar_url		= 'option=com_ohanah&view=events&format=json&layout=calendar&preset=calendar&Itemid=';

		if(!$this->params->get('allevents') && $this->params->get('eventcatid')) {
			$calendar_url .= '&ohanah_category_id='.$this->params->get('eventcatid');
		}

		$calendar_first_day = $this->params->get('firstDay');

		$this->assign('calendar_header'		, json_encode($calendar_header));
		$this->assign('calendar_url'		, $calendar_url);
		$this->assign('calendar_first_day'	, $calendar_first_day);

		return parent::display();
	}
}