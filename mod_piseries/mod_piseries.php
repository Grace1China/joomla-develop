<?php
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');
$document = JFactory::getDocument();

$document->addStyleSheet('modules/mod_piseries/assets/modstyle.css');
$list = modPiseriesHelper::getSeries($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$layout = $params->get('layout', 'default');
$path = JModuleHelper::getLayoutPath('mod_piseries', $layout);

if (file_exists($path)) {
	require($path);
}