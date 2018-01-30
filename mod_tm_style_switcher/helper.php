<?php
/**
 * @package Module TM Ajax Contact Form for Joomla! 3.x
 * @version 1.0.0: mod_tm_ajax_contact_form.php
 * @author TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2014 Jetimpex, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
**/

defined('_JEXEC') or die;

class modTmStyleSwitcherHelper
{
	public static function getAjax()
	{
		jimport('joomla.application.module.helper');
		$input  		= JFactory::getApplication()->input;
		$module 		= JModuleHelper::getModule('tm_style_switcher');
		$params 		= new JRegistry();
		$params->loadString($module->params);

		$success 		= $params->get('success_notify');
		$failed 		= $params->get('failure_notify');

		//inputs
		$inputs 		= $input->get('data', array(), 'ARRAY');

		foreach ($inputs as $input) {
			
			if( $input['name'] == 'color_scheme' )
			{
				$color_scheme = $input['value'];
			}

		}

		$app 		= JFactory::getApplication();
		$template = $app->getTemplate();
		$db = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query
	    	->select(array($db->quoteName('id'), $db->quoteName('params')))
	    	->from($db->quoteName('#__template_styles'))
	    	->where($db->quoteName('template') . ' = '. $db->quote($template));
	    $db->setQuery($query);
	    $rows = $db->loadAssocList();
	    $result = array();
	    $template_record = new stdClass(); 
    	foreach( $rows as $key => $row ) {
    		$template_record->id = $row['id'];
      		$params = json_decode($row['params']);
      		$params->color_scheme = $color_scheme;
		  	$template_record->params = json_encode($params);
			$result[$key] = $db->updateObject('#__template_styles', $template_record,'id');
		}
		 
		if (in_array(false, $result)) {
		  	return 'error';
		} else {
		   	return 'success';
		}
	}
}