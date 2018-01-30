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

jimport( 'joomla.filter.filteroutput' );
 
class modSocialLoginAndSocialShareHelper
{
	
    static function getReturnURL($params, $type)
	{
		$app	= JFactory::getApplication();
		$router = $app->getRouter();
		$url = null;
		if ($itemid =  $params->get($type))
		{
			$db		= JFactory::getDbo();
			$query	= $db->getQuery(true);

			$query->select($db->nameQuote('link'));
			$query->from($db->nameQuote('#__menu'));
			$query->where($db->nameQuote('published') . '=1');
			$query->where($db->nameQuote('id') . '=' . $db->quote($itemid));

			$db->setQuery($query);
			if ($link = $db->loadResult()) {
				if ($router->getMode() == JROUTER_MODE_SEF) {
					$url = 'index.php?Itemid='.$itemid;
				}
				else {
					$url = $link.'&Itemid='.$itemid;
				}
			}
		}
		if (!$url)
		{
			// stay on the same page
			$uri = clone JFactory::getURI();
			$vars = $router->parse($uri);
			unset($vars['lang']);
			if ($router->getMode() == JROUTER_MODE_SEF)
			{
				if (isset($vars['Itemid']))
				{
					$itemid = $vars['Itemid'];
					$menu = $app->getMenu();
					$item = $menu->getItem($itemid);
					unset($vars['Itemid']);
					if (isset($item) && $vars == $item->query) {
						$url = 'index.php?Itemid='.$itemid;
					}
					else {
						$url = 'index.php?'.JURI::buildQuery($vars).'&Itemid='.$itemid;
					}
				}
				else
				{
					$url = 'index.php?'.JURI::buildQuery($vars);
				}
			}
			else
			{
				$url = 'index.php?'.JURI::buildQuery($vars);
			}
		}

		return base64_encode($url);
	}
 	
	static function getType()
	{
		$user = JFactory::getUser();
		
		return (!$user->get('guest')) ? 'logout' : 'login';
	}
	
	/*
	 * Get the databse settings.
	 */
	 static function sociallogin_getsettings () {
      $lr_settings = array ();
      $db = JFactory::getDBO ();
	  $sql = "SELECT * FROM #__loginradius_settings";
      $db->setQuery ($sql);
      $rows = $db->LoadAssocList ();
      if (is_array ($rows)) {
        foreach ($rows AS $key => $data) {
          $lr_settings [$data ['setting']] = $data ['value'];
        }
      }
      return $lr_settings;
    }
	/*
	 * Get facebook login settings.
	 */
	 static function social_url ($lr_settings) { 
		$document = JFactory::getDocument();
		$document->addStyleSheet(JURI::root().'modules/mod_socialloginandsocialshare/lrstyle.css');
		$redirect = JURI::root();
		$sociallogintitle = (!empty($lr_settings['logintitle']) ? $lr_settings['logintitle'] : "");
		$sociallink = $sociallogintitle;
		$sociallink .= '<div class="lr_social_login_basic_150">
		<div class="lr_providers">
		<div class="lr_icons_box">';
		if(isset($lr_settings['fbenable']) && $lr_settings['fbenable'] == "1"){
			$fbparams = array(
				'client_id=' . $lr_settings['fbapikey'],
				'redirect_uri=' . ($redirect.'?provider=facebook'),
				'display=popup',
				'scope=email,user_photos,user_about_me,user_hometown,user_photos'
			);
			$fbparams = implode('&', $fbparams);
			$fburl = 'http://www.facebook.com/dialog/oauth?' . $fbparams;
			$sociallink .= '<div>
			<a class="lr_providericons lr_facebook" href="javascript:void(0);" onclick="javascript:window.open(\''.$fburl.'\',\'Facebook\',\'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=400px,height=400px\');" rel="nofollow" title="Login with Facebook">Login with Facebook</a>
			</div>';?>
<?php }
if(isset($lr_settings['genable']) && $lr_settings['genable'] == "1"){
		$gscope = urlencode('https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email');
		$gparams = array(
			'response_type=code',
			'redirect_uri=' . ($redirect.'?provider=google'),
			'client_id=' . $lr_settings['gapikey'],
			'scope=' . $gscope
		);
		$gparams = implode('&', $gparams);		
		$gurl = 'https://accounts.google.com/o/oauth2/auth?'.$gparams;	
			$sociallink .= '<div>
			<a class="lr_providericons lr_google" href="javascript:void(0);" onclick="javascript:window.open(\''.$gurl.'\',\'Google\',\'toolbar=0,scrollbars=0,location=0,statusbar=0,menubar=0,resizable=0,width=400px,height=400px\');" rel="nofollow" title="Login with Google +">Login with Google +</a>
			</div>';
		}	
		$sociallink .= '</div>
		</div>
		</div>';
		 
		return JFilterOutput::ampReplace($sociallink);
		}
}
?>