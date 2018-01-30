<?php
/*------------------------------------------------------------------------
# mod_SocialLoginandSocialShare
# ------------------------------------------------------------------------
# author    LoginRadius inc.
# copyright Copyright (C) 2013 loginradius.com. All Rights Reserved.
# @license - http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Websites: http://www.loginradius.com
# Technical Support:  Forum - http://community.loginradius.com/
-------------------------------------------------------------------------*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );
// Include the syndicate functions only once
require_once dirname(__FILE__).'/helper.php';
require_once JPATH_BASE.DS.'modules'.DS.'mod_login'.DS.'helper.php';
$params->def('greeting', 1);
$type = modSocialLoginAndSocialShareHelper::getType();
$lr_settings = modSocialLoginAndSocialShareHelper::sociallogin_getSettings();
$sociallogin = modSocialLoginAndSocialShareHelper::social_url($lr_settings);
$return = modSocialLoginAndSocialShareHelper::getReturnURL($params, $type);
$user = JFactory::getUser();
$twofactormethods = ModLoginHelper::getTwoFactorMethods();
require JModuleHelper::getLayoutPath('mod_socialloginandsocialshare', $params->get('layout', 'default'));