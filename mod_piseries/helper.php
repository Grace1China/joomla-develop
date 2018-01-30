<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
require_once ($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/route.php');

class modpiseriesHelper
{  
    /**
     * Method to get series info for message module
     * @param unknown_type $params module parameters
     * @return    array
     */
     
	public static function getSeries($params)
	{
		$items = $params->get('items', 2);
        $user    = JFactory::getUser();
		$sort = $params->get('orderby');
		$selection = $params->get('selection', 0);
		$language = JFactory::getLanguage()->getTag();
		$db = JFactory::getDBO();
		
		if ($sort == '0') {$orderby = ' ORDER BY ordering ASC';}
 		if ($sort == '1') {$orderby = ' ORDER BY ordering DESC';}
 		if ($sort == '2') {$orderby = ' ORDER BY series_name';}
 		if ($sort == '3') {$orderby = ' ORDER BY id DESC';}
 		if ($sort == '4') {$orderby = ' ORDER BY id ASC';}
 		if ($sort == '5') {$orderby = '';}
 		$selcondition = '';

 		if ($selection == '1' || $selection == 2)
 		{
 			$selids = $params->get('selids');
            if (count($selids) > 1)
            {
                if ($selection == 1)
                {$sign = '=';}
                else {$sign = '!=';}
                foreach ($selids AS $sl)
                {
                    $slist[] = 'id '.$sign.' '.$sl;
                }
            if ($selection == 1)
            {$where[] = '('. ( count( $slist ) ? implode( ' OR ', $slist ) : '' ) .')';}
            else {$where[] = '('. ( count( $slist ) ? implode( ' AND ', $slist ) : '' ) .')';}
            }
            elseif ($selection == 1)
            {
                $where[] = 'id = '.PIHelperadditional::getwherevalue($selids);
            }
            elseif ($selection == 2)
            {
                $where[] = 'id != '.PIHelperadditional::getwherevalue($selids);
            }
		}
		
        $groups = implode(',', $user->getAuthorisedViewLevels());
        $where[] = ' (access IN ('.$groups.') OR access = 0)';
		$where[] = ' language IN ('.$db->quote($language).','.$db->quote('*').')';
		$where[] = ' published = 1';
		
		$where 		= ( count( $where ) ? ' WHERE '. implode( ' AND ', $where ) : '' );
		
		$query = "SELECT * FROM #__piseries ".$where
		.$orderby;
		
		if ($sort == '5')
		{$db->setQuery( $query );}
		else {		
		$db->setQuery( $query, 0, $items );}
		
		$rows = $db->loadObjectList();
		
		if ($sort == '5')
		{shuffle($rows);
		$rows = array_slice($rows, 0, $items );}
		
		foreach ($rows as &$row) {
			
		$seriesslug = $row->id.':'.$row->series_alias;			
		$url = PreachitHelperRoute::getSeriesRoute($seriesslug);
		
		$row->link = '<a href = "' .JRoute::_($url). '" >';}
		
		return $rows;
	}
	
}