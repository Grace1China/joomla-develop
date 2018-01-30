<?php
/**
* @package   mod_sidebar
* @copyright Copyright (C) 2012 Beyounic SA. All rights reserved.
* @license   GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
* @link        http://www.beyounic.com
*/

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahcategoryimagesHtml extends ModDefaultHtml
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

            // if in menu item category is set, use it
            $ohanah_category_id = $pageparameters->get('ohanah_category_id');

            // if it's in the request (filter maybe)
            if (KRequest::get('get.ohanah_category_id', 'int')) {
                $ohanah_category_id = KRequest::get('get.ohanah_category_id', 'int');
            }
            // if this is single event view
            if (KRequest::get('get.view', 'string') == "event" ) {
                // is there id in the URL?
                if (KRequest::get('get.id', 'int')) {
                    // we are in the single event view and we get to here trought list
                    $ohanah_category_id = $this->getService('com://admin/ohanah.model.events')->id(KRequest::get('get.id', 'int'))->getItem()->ohanah_category_id;
                } else {
                    // we are in the single event view, but no ID in the URL. That means that we are in single event MENU ITEM, so we check that
                    $ohanah_category_id = $this->getService('com://admin/ohanah.model.events')->id($pageparameters->get('id'))->getItem()->ohanah_category_id;
                }
            }

            // if we fetched it somehow, use it
            if ($ohanah_category_id) {
                $category = $this->getService('com://admin/ohanah.model.categories')->id($ohanah_category_id)->getItem();
                $this->assign('category', $category);
                $this->assign('params', $this->params);
                return parent::display();
            }
        }
    }
}
