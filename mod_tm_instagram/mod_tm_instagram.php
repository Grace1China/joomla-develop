<?php
/**
 * Instagram for Joomla! Module
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * 
 */

defined('_JEXEC') or die;

$app 	  = JFactory::getApplication();	
$doc = JFactory::getDocument();
$document =& $doc;
$template = $app->getTemplate();
 
$document->addScript('modules/mod_tm_instagram/js/jtminstagram.min.js');

$AdminPhotoCount = $params->get('AdminPhotoCount');
$CLIENT_ID = $params->get('CLIENT_ID');
$USER_NAME = $params->get('USER_NAME');

require JModuleHelper::getLayoutPath('mod_tm_instagram', $params->get('layout', 'default'));