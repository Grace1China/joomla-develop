<?php
/**
 * @package Module TM Ajax Contact Form for Joomla! 3.x
 * @version 1.0.0: mod_tm_ajax_contact_form.php
 * @author TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2014 Jetimpex, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
**/

defined('_JEXEC') or die;

require_once('recaptchalib.php');

require_once __DIR__ . '/helper.php';

$document = JFactory::getDocument();

$document->addStylesheet(JURI::base(true).'/modules/mod_tm_ajax_contact_form/css/style.css');

JHtml::_('jquery.framework');

$document->addScript(JURI::base(true) . '/modules/mod_tm_ajax_contact_form/js/jquery.validate.min.js');
$document->addScript(JURI::base(true) . '/modules/mod_tm_ajax_contact_form/js/additional-methods.min.js');
$document->addScript(JURI::base(true) . '/modules/mod_tm_ajax_contact_form/js/ajaxcaptcha.js');
$document->addScript(JURI::base(true) . '/modules/mod_tm_ajax_contact_form/js/ajaxsendmail.js');

require JModuleHelper::getLayoutPath('mod_tm_ajax_contact_form', $params->get('layout', 'default'));

?>