<?php
defined('_JEXEC') or die('Restricted access');

require_once (dirname(__FILE__).DIRECTORY_SEPARATOR.'helper.php');
$document = JFactory::getDocument();

$document->addStyleSheet('modules/mod_preachit/assets/modstyle.css');
$list = modPreachitHelper::getStudy($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$path = JModuleHelper::getLayoutPath('mod_preachit', $params->get('layout', 'default'));

if (file_exists($path)) {
	require($path);
}