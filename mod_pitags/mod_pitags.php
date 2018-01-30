<?php
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');

//Add required css file
$document = JFactory::getDocument();
$document->addStyleSheet('modules/mod_pitags/assets/modstyle.css');

//Get required data for module output
$tagdata = modPitagsHelper::getTags($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$menuid = $params->get('menuid');
$unit = $params->get('unit', 'px');

//Generate module output
$layout = $params->get('layout', 'default');
$path = JModuleHelper::getLayoutPath('mod_pitags', $layout);
if (file_exists($path)) {
	require_once($path);
}