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

/**
 * Main Menu Tree Class.
 *
 * @package		Joomla
 * @subpackage	Menus
 * @since		1.5
 */
class IceModuleHelper
{
	var $_type = "";
	public function __construct($type = "modules")
	{
		$this->_type = $type;
	}
	
	public function getContentByModule($modules = "", $cols=1, $colWidth='auto', $width=400, $title='')
	{

		$content = "";
		if(!empty($modules))
		{
			if(!is_array($modules)) $modules = explode("|", $modules);
			
			$modules 	= implode(",", $modules);
			$list 		= $this->_getModules($modules);
			$content 	= $this->_renderModule($list , $cols, $colWidth, $width, $title);
		}
		return $content;
	}
	
	public function getContentByPosition($position = "", $cols=1, $colWidth='auto', $width=400, $title='')
	{
		$content = "";
		if(!empty($position))
		{
			if(!is_array($position)) $position = explode("|", $position);
			
			$position 	= implode("','", $position);
			$position 	= "'".$position."'";
			$list 		= $this->_getModules("", $position);

			$content = $this->_renderModule($list, $cols, $colWidth, $width, $title);
		}
		return $content;
	}
	
	function _renderModule($list_modules = array(), $cols=1, $colWidth='auto', $width=400, $title='')
	{
		$content="";
		if(!empty($list_modules))
		{   
			$doc	= JFactory::getDocument();
			$document	= &$doc;
			$renderer	= $document->loadRenderer('module'); 
			ob_start();     
            if(!empty($list_modules))
            {               
                if($colWidth!='auto')
                {                  
                    $cols_width = explode(",",$colWidth) ;  
                    if(!(is_array($cols_width) && count($cols_width)>1))
					{
                        $cols_width = intval($colWidth);
                        if($cols_width==0) 
                        {
                             if($cols>=1) $cols_width = round($width/$cols); 
                             else $cols_width = $width;
                        }
                    }       
                }
				else
				{
					$cols_width = 'auto';
				}
                    
                echo '<div class="icemega_cover_module" style="width:'.$width.'">';
                    for($i=0; $i<$cols; $i++)
                    {
						
                        if(isset($list_modules[$i]))
                        {  
                            if(is_array($cols_width) && isset($cols_width[$i])) 
                            {
                                $style = "width:".$cols_width[$i]."px;"; 
                            }
							else
                            {       
                                if(intval($cols_width)>0) $style = "width:".intval($cols_width)."px;"; 
                                else $style = "width:auto; ";      
                            } 
                                    
                            if(count($list_modules)==1) $style = "width:auto; "; 
                            
                            if($cols>1) $style .= "float:left"; 
                                             
                            $module = $list_modules[$i];       
						
                            if(isset($module) && @$module->id)
							{
                                 echo '<div class="icemega_modulewrap '.json_decode($module->params)->moduleclass_sfx.'" style="'.$style.'">';                                
                                 if($module->showtitle)
                                 {
                                    echo '<span class="iceModuleTile">'.$module->title.'</span>';
                                 }
                                 echo $renderer->render($module,array("style"=>""));
                                 echo '</div>';
                            }
                        }
			        }
                echo '</div>';
            }    
			$content = ob_get_clean();
			ob_start();
		}
		return $content;
	}
	/**
	 * Load published modules
	 *
	 * @access	private
	 * @return	array
	 */
	function _getModules($module_ids = null, $module_pos = "")
	{
		global $mainframe;

		$user_temp	= JFactory::getUser();
		$user	=& $user_temp;
		$db_temp		= JFactory::getDBO();
		$db		=& $db_temp;

		$aid	= $user->get('aid', 0);

		$modules	= array();

		$wheremenu = "";
		if(!empty($module_ids))
		{
			$wheremenu = " m.id in(".$module_ids.")";
		}
		if(!empty($module_pos))
		{
			$wheremenu = " m.position in(".$module_pos.")";
		}
		
        $query = 'SELECT distinct(m.id), title, module, position, content, showtitle, params'
            . ' FROM #__modules AS m'
            . ' LEFT JOIN #__modules_menu AS mm ON mm.moduleid = m.id'
            . ' WHERE '
            . $wheremenu
            . ' AND m.published > 0'
            . ' ORDER BY position, ordering';
 
		$db->setQuery($query);

		if(null ===($modules = $db->loadObjectList()))
		{
			JError::raiseWarning('SOME_ERROR_CODE', JText::_('Error Loading Modules') . $db->getErrorMsg());
			return false;
		}
        
		$total = count($modules);
		for($i = 0; $i < $total; $i++)
		{
			//determine if this is a custom module
			$file					= $modules[$i]->module;
			$custom 				= substr($file, 0, 4) == 'mod_' ?  0 : 1;
			$modules[$i]->user  	= $custom;
			// CHECK: custom module name is given by the title field, otherwise it's just 'om' ??
			$modules[$i]->name		= $custom ? $modules[$i]->title : substr($file, 4);
			$modules[$i]->style		= null;
			$modules[$i]->position	= strtolower($modules[$i]->position);
		}
		return $modules;
	}
}