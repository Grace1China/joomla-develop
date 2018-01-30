<?php
/**
 * @package     Joomla.Site
 * @subpackage  mod_articles_news
 *
 * @copyright   Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$app 	  = JFactory::getApplication();	
$doc = JFactory::getDocument();
$document =& $doc;
$template = $app->getTemplate();
$layout   = $app->input->getCmd('layout', '');

// Include Camera Slideshow styles
switch($params->get('theme')){
	case 0:
		$document->addStyleSheet('modules/mod_caroufredsel/css/caroufredsel.css');
		break;
	case 1:
		$document->addStyleSheet('templates/'.$template.'/css/caroufredsel.css');
		break;
}

// Include Camera Slideshow scripts
switch($params->get('script')){
	case 0:
		$document->addScript('modules/mod_caroufredsel/js/jquery.caroufredsel.js');
		break;
	case 1:
		$document->addScript('templates/'.$template.'/js/jquery.caroufredsel.js');
		break;	
}


$list = modCarouFredSelHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_caroufredsel', $params->get('layout', 'default'));
