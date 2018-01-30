<?php
/**
 * Camera Slideshow for Joomla! Module
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Camera Slideshow By Manuel Masia: http://www.pixedelic.com/plugins/camera/ & Articles Newsflash standard module
 * 
 */

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$app 	  = JFactory::getApplication();	
$doc = JFactory::getDocument();
$document =& $doc;
$template = $app->getTemplate();

if($params->get('load_jquery_mobile') == 'true'){
	$document->addScript('modules/mod_image_swoop/js/jquery.mobile.customized.min.js');
}

$list = modImageSwoopHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_image_swoop', $params->get('layout', 'default'));
