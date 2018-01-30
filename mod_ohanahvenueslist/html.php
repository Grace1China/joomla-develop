<?php
/**
 * @package		mod_sidebar
 * @copyright	Copyright (C) 2012 Beyounic SA. All rights reserved.
 * @license		GNU GPLv3 <http://www.gnu.org/licenses/gpl.html>
 * @link        http://www.beyounic.com
 */

defined( '_JEXEC' ) or die( 'Restricted access' );

class ModOhanahvenueslistHtml extends ModDefaultHtml
{
	public function __construct(KConfig $config)
    {
        parent::__construct($config);
        $this->params  = $config->params;
    }

	public function display()
	{
		$this->getTemplate()->renderHelper('com://site/ohanah.template.helper.behavior.custom_css');

		JFactory::getLanguage()->load('com_ohanah');
      	JFactory::getDocument()->addStyleSheet(JURI::root(1).'/media/com_ohanah/css/screen.css');

		$sort = 'title';
		$direction = 'asc';

		$model = $this->getService('com://admin/ohanah.model.venues');

		$model
			->set('sort', $sort)
			->set('enabled', 1)
			->set('direction', $direction);

		$this->assign('venues', $model->getList());

		return parent::display();
	}
}
