<?php defined( '_JEXEC' ) or die( 'Restricted access' );
$item = $params->get('menuid');
?>
<div class="piseries<?php echo $moduleclass_sfx; ?> modsdefault">
<ul>
<?php 

foreach ($list as $series) {
	
	?>
		<?php require(JModuleHelper::getLayoutPath('mod_piseries', '_series')); ?>
				
	<li>
		<?php echo $image; ?>
		<?php echo $title;?>
		<?php echo $description;?>
		<div class="clr"></div>
	</li>
	<?php
}?>
</ul>
<?php if ($params->get('showall', 0) == 1) {
$showurl = PreachitHelperRoute::getSeryRoute();	
?>
<div class="showall"><a href="<?php echo JRoute::_($showurl);?>" title="<?php echo JText::_('MOD_PREACHIT_SHOW_ALL');?>"><?php echo JText::_('MOD_PREACHIT_SHOW_ALL');?></a></div>
<?php }?>
</div>