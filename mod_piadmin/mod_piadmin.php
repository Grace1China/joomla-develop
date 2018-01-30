<?php
defined('_JEXEC') or die('Restricted access');
$abspath    = JPATH_SITE;
require_once($abspath.DIRECTORY_SEPARATOR.'components/com_preachit/helpers/additional.php');
$document = JFactory::getDocument();
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));
$document->addStyleSheet('modules/mod_piadmin/assets/modstyle.css');
$link = '<a id="pimessageadd" target="blank" href ="'.JURI::ROOT().'administrator/index.php?option=com_preachit&task=study.add">'.JText::_('MOD_PIADMIN_ADD_A_MESSAGE').'</a>';
$link2 = '<a id="pipodpub" target="blank" href ="'.JURI::ROOT().'administrator/index.php?option=com_preachit&view=podcasts">'.JText::_('MOD_PIADMIN_PUBLISH_A_PODCAST').'</a>';
$link3 = '<a id="piseriesadd" target="blank" href ="'.JURI::ROOT().'administrator/index.php?option=com_preachit&tmpl=component&view=seriesedit&&layout=modal&task=series.add">'.JText::_('MOD_PIADMIN_ADD_A_SERIES').'</a>';
$link4 = '<a id="piteachadd" target="blank" href ="'.JURI::ROOT().'administrator/index.php?option=com_preachit&tmpl=component&view=teacheredit&&layout=modal&task=teacher.add">'.JText::_('MOD_PIADMIN_ADD_A_TEACHER').'</a>';

$layout = $params->get('layout', 'default');
$path = JModuleHelper::getLayoutPath('mod_piadmin', $layout);

if (file_exists($path)) {
    require($path);
}