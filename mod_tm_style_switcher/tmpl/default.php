<?php
/**
 * @package Module TM Ajax Contact Form for Joomla! 3.x
 * @version 1.0.0: mod_tm_ajax_contact_form.php
 * @author TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2014 Jetimpex, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
**/

defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$user = JFactory::getUser();
$template = $app->getTemplate();
$color_schemes = JPATH_SITE.'/templates/'.$template.'/color_schemes/css';

if(realpath($color_schemes)){

$getColorScheme = $app->getTemplate(true)->params->get('color_scheme');
if($getColorScheme==''){
    $getColorScheme = 'color_scheme_1';
}

//$host='cms.devoffice.com';
//$host='192.168.9.17';
$host='livedemo00.template-help.com';

if($user->authorise('core.edit', 'com_templates') || $_SERVER['HTTP_HOST']==$host){
    $color_schemes_array = array();
    $key = 0;
    foreach (new DirectoryIterator($color_schemes) as $file){
    if($file->isDot()) continue;
        if($file->getExtension()=='css'){
            $color_schemes_array[$key] = $file->getBasename('.css');
            $key++;
        }
    }
    sort($color_schemes_array);
    $doc->addStyleSheet('modules/mod_tm_style_switcher/css/style.css');
    $doc->addScriptDeclaration('jQuery(function($){
        $("#style_switcher .toggler").click(function(){
           $("#style_switcher").toggleClass("hidden"); 
        })
        $("#style_switcher").style_switcher("'.JURI::base(true).'/templates/'.$template.'/color_schemes/css/","' .JURI::base(true).'");
    })
    '); ?>

<div id="style_switcher" class="hidden">
    <div class="toggler"></div>
    <p><?php echo JText::_('MOD_TM_STYLE_SWITCHER_BOX_LABEL'); ?></p>
    <ul id="color-box">
<?php }

if ($user->authorise('core.edit', 'com_templates')) {
    $doc->addScript('modules/mod_tm_style_switcher/js/jquery.cookies.js');
    $doc->addScript('modules/mod_tm_style_switcher/js/style_switcher.js'); ?>
<?php foreach ($color_schemes_array as $file){ ?>
            <li<?php if($getColorScheme==$file) echo ' class="active"'; ?>><div class="color_scheme <?php echo $file; ?>" data-scheme="<?php echo $file; ?>">&nbsp;</div></li>
        <?php
    } ?>
    </ul>
    <p><span><?php echo JText::_('MOD_TM_STYLE_SWITCHER_BOX_DESC'); ?></span></p>
    <form id="style_switcher_form">
    <input type="hidden" name="color_scheme" id="style_switcher_input">
    <button class="button btn" id="style_switcher_button" disabled><?php echo JText::_('JSAVE'); ?></button>
    </form>
</div>
<?php }

else if($_SERVER['HTTP_HOST']==$host){
    if(isset($_COOKIE['color_scheme']) && $_COOKIE['color_scheme']!=''){
        $getColorScheme = $_COOKIE['color_scheme'];
    }
    $doc->addScript('modules/mod_tm_style_switcher/js/jquery.cookies.js');
    $doc->addScript('modules/mod_tm_style_switcher/js/style_switcher_demo.js'); ?>
<?php foreach ($color_schemes_array as $file){ ?>
            <li<?php if($getColorScheme==$file) echo ' class="active"'; ?>><div class="color_scheme <?php echo $file; ?>" data-scheme="<?php echo $file; ?>">&nbsp;</div></li>
        <?php
    } ?>
    </ul>
   </div>
<?php }
$doc->addStyleSheet('templates/'.$template.'/color_schemes/css/'.$getColorScheme.'.css', 'text/css', null, array('id'=>'color_scheme'));
}
?>