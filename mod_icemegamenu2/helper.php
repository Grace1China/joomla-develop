<?php 
/**
 * IceMegaMenu Extension for Joomla 3.0 By IceTheme
 * 
 * 
 * @copyright	Copyright (C) 2008 - 2012 IceTheme.com. All rights reserved.
 * @license		GNU General Public License version 2
 * 
 * @Website 	http://www.icetheme.com/Joomla-Extensions/icemegamenu.html
 * @Support 	http://www.icetheme.com/Forums/IceMegaMenu/
 *
 */
 
 
/* no direct access*/
defined('_JEXEC') or die('Restricted access');


require_once JPATH_SITE.DS.'components'.DS.'com_content'.DS.'helpers'.DS.'route.php';

jimport('joomla.base.tree');
jimport('joomla.utilities.simplexml');
require_once("libs/menucore.php");

class modIceMegamenuHelper
{
	
	var $_params 	= null;
	var $moduleid	= 0;
	var $_module 	= null;
	
	public function __construct($module = null, $params = array())
	{
		if(!empty($module))
		{
			$this->_module = $module;
			$this->moduleid = $module->id;
			$this->loadMediaFiles($params, $module);
		}
		$this->_params = $params;
	}
	
	public static function buildXML($params)
	{
		$menu 	= new IceMenuTree($params);
		$app = JFactory::getApplication();
		$items = $app->getMenu();
        $start  = $params->get('startLevel');
        $end    = $params->get('endLevel');
        $sChild = $params->get('showAllChildren');         
        
        if($end<$start && $end!=0){ return ""; }
            
        if(!$sChild){ $end = $start;}  
          
		// Get Menu Items
		$rows = $items->getItems('menutype', $params->get('menutype'));
        foreach($rows as $key=>$val)
        {             
            if(!(($end!=0 && $rows[$key]->level>=$start && $rows[$key]->level<=$end) ||($end==0 && $rows[$key]->level>=$start)))
            {
                unset($rows[$key]);
            }
        }         
		$maxdepth = $params->get('maxdepth',10);
		
		// Build Menu Tree root down(orphan proof - child might have lower id than parent)
		$user_temp 	= JFactory::getUser();
		$user 	= &$user_temp;
		$ids 	= array();
		$ids[1] = true;
		$last 	= null;
		$unresolved = array();
		$vertical_direction = $params->get("vertical_direction", "left");
		
		// pop the first item until the array is empty if there is any item		
		if(is_array($rows))
		{
			while(count($rows) && !is_null($row = array_shift($rows)))
			{
				if(array_key_exists($row->parent_id, $ids))
				{
					$row->ionly = $params->get('menu_images_link');
					$menu->addNode($params, $row);
					// record loaded parents
					$ids[$row->id] = true;
				}
				else
				{
					// no parent yet so push item to back of list
					// SAM: But if the key isn't in the list and we dont _add_ this is infinite, so check the unresolved queue
					if(!array_key_exists($row->id, $unresolved) || $unresolved[$row->id] < $maxdepth)
					{
						array_push($rows, $row);
						// so let us do max $maxdepth passes
						// TODO: Put a time check in this loop in case we get too close to the PHP timeout
						if(!isset($unresolved[$row->id])) $unresolved[$row->id] = 1;
						else $unresolved[$row->id]++;
					}
				}
			}
		}
		return $menu->toXML($vertical_direction);
	}

	function &getXML($type, &$params, $decorator)
	{
		static $xmls;

		if(!isset($xmls[$type]))
		{
			$cache_temp 			= JFactory::getCache('mod_icemegamenu');
			$cache 			= &$cache_temp;
			$string 		= $cache->call(array('modIceMegamenuHelper', 'buildXML'), $params);
			$xmls[$type] 	= $string;
		}
		// Get document
		require_once(JPATH_BASE.DS."modules".DS."mod_icemegamenu".DS."libs".DS."simplexml.php");
		$xml = new JSimpleXML;
		$xml->loadString($xmls[$type]);
		$doc = &$xml->document;
		$app = JFactory::getApplication();
		$menu = $app->getMenu();
		$active = ($menu->getActive()) ? $menu->getActive() : $menu->getDefault();
		$start	= $params->get('startLevel');
		$end	= $params->get('endLevel');
		$sChild	= $params->get('showAllChildren');
		$path	= array();
		
		// Get subtree
		if($doc && is_callable($decorator))
		{
			$doc->map($decorator, array('end'=>$end, 'children'=>$sChild));
		}
		return $doc;
	}

	function render(&$params, $callback)
	{				
		switch($params->get('menu_style', 'list'))
		{
			case 'list_flat' :
				break;
				
			case 'horiz_flat' :
				break;

			case 'vert_indent' :
				break;

			default :
				// Include the new menu class
				$xml = modIceMegamenuHelper::getXML($params->get('menutype'), $params, $callback);
				if($xml)
				{
					$class = $params->get('class_sfx');
					$xml->addAttribute('class', 'icemegamenu'.$class);
					
					if($tagId = $params->get('tag_id'))
					{
						$xml->addAttribute('id', $tagId);
					}
					$result = JFilterOutput::ampReplace($xml->toString((bool)$params->get('show_whitespace')));
					$result = str_replace(array('&gt;','&lt;','&quot;'), array('>','<','"'), $result);
					$result = str_replace(array('<ul/>', '<ul />'), '', $result);
					echo $result;
				}
				break;
		}
	}
	
	/**
	 * check K2 Existed ?
	 */
	public static function isK2Existed()
	{
		return is_file(JPATH_SITE.DS.  "components" . DS . "com_k2" . DS . "k2.php");	
	}
	/**
	 *  check the folder is existed, if not make a directory and set permission is 755
	 *
	 *
	 * @param array $path
	 * @access public,
	 * @return boolean.
	 */
	public static function makeDir($path)
	{
		$folders = explode('/', ($path));
		$tmppath =  JPATH_SITE.DS.'images'.DS.'icethumbs'.DS;
		
		if(!file_exists($tmppath))
		{
			JFolder::create($tmppath, 0755);
		} 
		for($i = 0; $i < count($folders) - 1; $i ++)
		{
			if(! file_exists($tmppath . $folders [$i]) && ! JFolder::create($tmppath . $folders [$i], 0755))
			{
				return false;
			}	
			$tmppath = $tmppath . $folders [$i] . DS;
		}		
		return true;
	}	
	/**
	 *  check the folder is existed, if not make a directory and set permission is 755
	 *
	 *
	 * @param array $path
	 * @access public,
	 * @return boolean.
	 */
	public static function renderThumb($path, $width=100, $height=100, $title='', $isThumb=true)
	{
		
		if($isThumb&& $path)
		{
			$path 		= str_replace(JURI::base(), '', $path);
			$imagSource = JPATH_SITE.DS. str_replace('/', DS,  $path);
			
			if(file_exists($imagSource))
			{
				$path =  $width."x".$height.'/'.$path;
				$thumbPath = JPATH_SITE.DS.'images'.DS.'icethumbs'.DS. str_replace('/', DS,  $path);
				
				if(!file_exists($thumbPath))
				{
					$thumb = PhpThumbFactory::create($imagSource);  
					if(!self::makeDir($path))
					{
							return '';
					}		
					$thumb->adaptiveResize($width, $height);
					$thumb->save($thumbPath); 
				}
				$path = JURI::base().'images/icethumbs/'.$path;
			} 
		}
		return $path;
	}
	/**
	 * Load Modules Joomla By position's name
	 */
	public function loadModulesByPosition($position='')
	{
		$modules = JModuleHelper::getModules($position);
		if($modules)
		{
			$document = &JFactory::getDocument();
			$renderer = $document->loadRenderer('module');
			$output='';
			foreach($modules  as $module)
			{
				$output .= '<div class="lof-module">'.$renderer->render($module, array('style' => 'raw')).'</div>';
			}
			return $output;
		}
		return ;
	}
	/**
	 * load css - javascript file.
	 * 
	 * @param JParameter $params;
	 * @param JModule $module
	 * @return void.
	 */
	public function loadMediaFiles($params, $module)
	{
		global $app;
		$app 			= JFactory::getApplication();
		$theme_style 	= $params->get("theme_style","default");
		
		$enable_bootrap = $params->get("enable_bootrap", 0);
		$resizable_menu = $params->get("resizable_menu", 0);
		
		$doc = JFactory::getDocument();
		$document = &$doc;
		if($enable_bootrap == 1){
			$document->addStyleSheet(JURI::base()."media/jui/css/bootstrap.css");
				$document->addStyleSheet(JURI::base()."media/jui/css/bootstrap-responsive.css");
			$document->addScript(JURI::base()."media/jui/js/bootstrap.min.js");
		}
		
		
		if (
			(!file_exists(JPATH_ROOT.'/templates/'.$app->getTemplate().'/less/iceslideshow.less'))
			|| ( $app->getTemplate() == "it_therestaurant2")
			|| ( $app->getTemplate() == "it_planeterath")
			|| ( $app->getTemplate() == "it_blackwhite2")
			|| ( $app->getTemplate() == "it_trendyshop")
			|| ( $app->getTemplate() == "it_cinema3")
			)
		 {
			
			if(!defined("MOD_ICEMEGAMENU"))
			{
	
				$css = "templates/".$app->getTemplate()."/html/".$module->module."/css/".$theme_style."_icemegamenu.css";
				$css2 = "templates/".$app->getTemplate()."/html/".$module->module."/css/".$theme_style."_icemegamenu-ie.css";
				if($resizable_menu == 1){
					$css3 = "templates/".$app->getTemplate()."/html/".$module->module."/css/".$theme_style."_icemegamenu-reponsive.css";
				}	
				if(is_file($css)) {
					$document->addStyleSheet($css);
				} else {
					$css = JURI::base().'modules/'.$module->module.'/themes/'.$params->get('theme_style','default').'/css/'.$theme_style.'_icemegamenu.css';
					$document->addStyleSheet($css);
				}
				if(is_file($css3)) {
					$document->addStyleSheet($css3);
				} else {
					if($resizable_menu == 1){
						$css3 = JURI::base().'modules/'.$module->module.'/themes/'.$params->get('theme_style','default').'/css/'.$theme_style.'_icemegamenu-reponsive.css';
					}	
					$document->addStyleSheet($css3);
				}
				define("MOD_ICEMEGAMENU", 1);
			}
		}
	}

	/**
	 * get a subtring with the max length setting.
	 * 
	 * @param string $text;
	 * @param int $length limit characters showing;
	 * @param string $replacer;
	 * @return tring;
	 */
	public static function substring($text, $length = 100, $isStripedTags=true,  $replacer='...')
	{
		$string = $isStripedTags? strip_tags($text):$text;
		return JString::strlen($string) > $length ? JString::substr($string, 0, $length).$replacer: $string;
	}
}

if(!defined('modIceMegaMenuXMLCallbackDefined'))
{
	function modIceMegaMenuXMLCallbackDefinedXMLCallback(&$node, $args)
	{
		$user	= &JFactory::getUser();
		$menu	= &JSite::getMenu();
		$active	= $menu->getActive();
		$path	= isset($active) ? array_reverse($active->tree) : null;
	
		if(($args['end']) &&($node->attributes('level') >= $args['end']))
		{
			$children = $node->children();
			foreach($node->children() as $child)
			{
				if($child->name() == 'ul')
				{
					$node->removeChild($child);
				}
			}
		}

		if($node->name() == 'ul')
		{
			foreach($node->children() as $child)
			{
				if($child->attributes('access') > $user->get('aid', 0))
				{
					$node->removeChild($child);
				}
			}
		}
	
		if(($node->name() == 'li') && isset($node->ul))
		{
			$node->addAttribute('class', 'parent');
		}
	
		if(isset($path) &&(in_array($node->attributes('id'), $path) || in_array($node->attributes('rel'), $path)))
		{
			if($node->attributes('class'))
			{
				$node->addAttribute('class', $node->attributes('class').' active');
			}
			else
			{
				$node->addAttribute('class', 'active');
			}
		}
		else
		{
			if(isset($args['children']) && !$args['children'])
			{
				$children = $node->children();
				foreach($node->children() as $child)
				{
					if($child->name() == 'ul')
					{
						$node->removeChild($child);
					}
				}
			}
		}
	
		if(($node->name() == 'li') &&($id = $node->attributes('id')))
		{
			if($node->attributes('class'))
			{
				$node->addAttribute('class', $node->attributes('class').' item'.$id);
			}
			else
			{
				$node->addAttribute('class', 'item'.$id);
			}
		}
	
		if(isset($path) && $node->attributes('id') == $path[0])
		{
			$node->addAttribute('id', 'current');
		}
		else
		{
			$node->removeAttribute('id');
		}
		$node->removeAttribute('rel');
		$node->removeAttribute('level');
		$node->removeAttribute('access');
	}
	define('modIceMegaMenuXMLCallbackDefined', true);
}
?>