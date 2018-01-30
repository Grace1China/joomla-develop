<?php
/**
 * Random articles module
 */

defined('_JEXEC') or die;

require_once __DIR__ . '/helper.php';

$articles = ModArticlesRandomHelper::getArticles($params);

require JModuleHelper::getLayoutPath('mod_articles_random', $params->get('layout', 'default'));