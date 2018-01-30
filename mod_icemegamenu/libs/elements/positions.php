<?php
/**
 * $ModDesc
 * 
 * @version		$Id: helper.php $Revision
 * @package		modules
 * @copyright	Copyright (C).
 * @license		GNU General Public License version 2
 */
// no direct access
defined('_JEXEC') or die ('Restricted access');
/**
 * Radio List Element
 *
 * @since      Class available since Release 1.2.0
 */
class JElementPositions extends JElement
{
	/**
	 * Element name
	 *
	 * @access	protected
	 * @var		string
	 */
	var	$_name = 'Positions';

	function fetchElement( $name, $value, &$node, $control_name ) {
		
		$db =& JFactory::getDBO();
		$query = "SELECT DISTINCT position FROM #__modules WHERE   client_id=1 ORDER BY position ASC";
		$db->setQuery($query);
		$groups = $db->loadObjectList();
		
		$groupHTML = array();	
		if ($groups && count ($groups)) {
			foreach ($groups as $v=>$t){
				$groupHTML[] = JHTML::_('select.option', $t->position, $t->position);
			}
		}
		$lists = JHTML::_('select.genericlist', $groupHTML, "params[".$name."][]", ' multiple="multiple"  size="10" ', 'value', 'text', $value);
		
		return $lists; 
	}
} 