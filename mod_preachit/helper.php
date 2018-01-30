<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/studylist.php');
require_once ($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/route.php');

class modpreachitHelper
{  
    /**
     * Method to get message info for message module
     * @param unknown_type $params module parameters
     * @return    array
     */
     
	public static function getStudy($params)
	{
		$items = $params->get('items', 2);
		$view = $params->get('linkdesc', 'video');
		$popup = $params->get('popup', 0);
		$sort = $params->get('orderby', 0);
		$user	= JFactory::getUser();
		$language = JFactory::getLanguage()->getTag();
		$now = gmdate ( 'Y-m-d H:i:s' );
		$nullDate = '0000-00-00 00:00:00';
		$db= JFactory::getDBO();
		
		if ($sort == '0') {$orderby = ' ORDER BY study_date desc';}
 		if ($sort == '1') {$orderby = ' ORDER BY id desc';}
 		if ($sort == '2') {$orderby = ' ORDER BY hits desc';}
 		if ($sort == '3') {$orderby = ' ORDER BY downloads desc';}
 		
 		$where = PIHelperstudylist::wherevalue(null, null, null, null, null, null, null, null, $params);
		
		$query = "SELECT * FROM #__pistudies "
		.$where
		.$orderby;
		$db->setQuery( $query, 0, $items );
		
		$rows = $db->loadObjectList();
		
		foreach ($rows as &$row) {
			
		$studyslug = $row->id.':'.$row->study_alias;
        
        $linkdesc = 'study';
		$url = PreachitHelperRoute::getStudyRoute($studyslug);
		$row->link = '<a href = "' .JRoute::_($url). '" >';}
		
		return $rows;
	}
	
}