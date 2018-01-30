<?php
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');
$document = JFactory::getDocument();

$document->addStyleSheet('modules/mod_piteachers/assets/modstyle.css');
$list = modPiteachersHelper::getTeacher($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$layout = $params->get('layout', 'default');
$path = JModuleHelper::getLayoutPath('mod_piteachers', $layout);

if (file_exists($path)) {
	require($path);
}