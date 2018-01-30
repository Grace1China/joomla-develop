<?php
/**
 * @package		mod_ohanaheventmap
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

// Check if Koowa is active
if(!defined('KOOWA')) {
	JError::raiseWarning(0, JText::_("Koowa wasn't found. Please install the Koowa plugin and enable it."));
	return;
}

if (!KService::get('mod://site/ohanahevents.html')->shouldDisplay($params)) return;

echo KService::get('mod://site/ohanaheventimages.html', array(
	'params'  => $params,
	'module'  => $module,
	'attribs' => $attribs
))->display();
