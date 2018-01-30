<?php
/**b2
 * @package		mod_ohanahcategoryinfo
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahcategoryinfoHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }

	public function display()
	{
		if (KRequest::get('get.option', 'string') == 'com_ohanah') {
			$this->getTemplate()->renderHelper('com://site/ohanah.template.helper.behavior.custom_css');

			$pageparameters =& JFactory::getApplication()->getPageParameters();

			$ohanah_category_id = $pageparameters->get('ohanah_category_id');
			if (KRequest::get('get.ohanah_category_id', 'int')) {
				$ohanah_category_id = KRequest::get('get.ohanah_category_id', 'int');
			} elseif (KRequest::get('get.id', 'int')){
				$ohanah_category_id = $this->getService('com://admin/ohanah.model.events')->id(KRequest::get('get.id', 'int'))->getItem()->ohanah_category_id;
			}

			if ($ohanah_category_id) {
                          $category = $this->getService('com://admin/ohanah.model.categories')->id($ohanah_category_id)->getItem();
                          $this->assign('category', $category);
                          $this->assign('params', $this->params);
                          return parent::display();
                   }
		}
	}
}
