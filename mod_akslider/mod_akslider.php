<?php
/**
 * Torbara Maxx-Fitness Template for Joomla, exclusively on Envato Market: http://themeforest.net/user/torbara
 * @encoding     UTF-8
 * @version      1.0
 * @copyright    Copyright (C) 2015 Torbara (http://torbara.com). All rights reserved.
 * @license      GNU General Public License version 2 or later, see http://www.gnu.org/licenses/gpl-2.0.html
 * @author       Alexandr Khmelnytsky (support@torbara.com)
 */

defined('_JEXEC') or die;

// Include the helper functions only once
require_once __DIR__ . '/helper.php';

$input = JFactory::getApplication()->input;

//$idbase = null;
//
//$idbase = $params->get('catid');
//
//$cacheid = md5(serialize(array ($idbase, $module->module)));
//
//$cacheparams               = new stdClass;
//$cacheparams->cachemode    = 'id';
//$cacheparams->class        = 'ModArticlesCategoryHelper';
//$cacheparams->method       = 'getList';
//$cacheparams->methodparams = $params;
//$cacheparams->modeparams   = $cacheid;

//$list = JModuleHelper::moduleCache($module, $params, $cacheparams);
$list = ModAksliderHelper::getList($params);

if (!empty($list)) {
    $grouped                    = false;
    $article_grouping           = 'none';
    $article_grouping_direction = 'ksort';
    $moduleclass_sfx            = htmlspecialchars($params->get('moduleclass_sfx'));
    $item_heading               = $params->get('item_heading');

    require JModuleHelper::getLayoutPath('mod_akslider', $params->get('layout', 'default'));
}