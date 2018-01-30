<?php
/**
 * Bootstrap Collapse
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * Parts of this software are based on Articles Newsflash standard module
 * 
*/

defined('_JEXEC') or die;
?>
<div class="mod-bootstrap-collapse mod-bootstrap-collapse__<?php echo $moduleclass_sfx; ?>">

  <?php if ($params->get('pretext')): ?>
    <div class="pretext">
      <?php echo $params->get('pretext') ?>
    </div>
  <?php endif; ?>

  <div class="accordion" id="accordion<?php echo $module->id; ?>"> 

  <?php for ($i = 0, $n = count($list); $i < $n; $i ++) :
    $item = $list[$i]; 

    $class="";
    if($i == $n-1){
      $class="lastItem";
    } ?>

    <div class="accordion-group">
      <?php require JModuleHelper::getLayoutPath('mod_bootstrap_collapse', '_item'); ?>
    </div>
  <?php endfor; ?>

  </div>

  <?php if($params->get('mod_button') == 1): ?>   
    <div class="mod-bootstrap-collapse_custom-link">
      <?php 
        $menuLink = $menu->getItem($params->get('custom_link_menu'));

          switch ($params->get('custom_link_route')) 
          {
            case 0:
              $link_url = $params->get('custom_link_url');
              break;
            case 1:
              $link_url = JRoute::_($menuLink->link.'&Itemid='.$menuLink->id);
              break;            
            default:
              $link_url = "#";
              break;
          }
          echo '<a class="btn btn-info" href="'. $link_url .'">'. $params->get('custom_link_title') .'</a>';
      ?>
    </div>
  <?php endif; ?>
</div>