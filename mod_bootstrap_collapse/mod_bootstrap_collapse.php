<?php
/**
 * Bootstrap Collapse
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Articles Newsflash standard module
 * 
*/

defined('_JEXEC') or die;

// Include the syndicate functions only once
require_once __DIR__ . '/helper.php';

$menu = JMenu::getInstance('site');

$app    = JFactory::getApplication(); 
$doc = JFactory::getDocument();
$document =& $doc;
$list = modArticlesNewsAdvHelper::getList($params);
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

require JModuleHelper::getLayoutPath('mod_bootstrap_collapse', $params->get('layout', 'default'));

$document->addStyleSheet(JURI::base() . 'modules/mod_bootstrap_collapse/css/style.css');