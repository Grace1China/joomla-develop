<?php defined( '_JEXEC' ) or die( 'Restricted access' );

?>
<div class="pimessages<?php echo $moduleclass_sfx; ?> moddefault">
<ul>
<?php 


foreach ($list as $study) {
	
	?>
		<?php require(JModuleHelper::getLayoutPath('mod_preachit', '_study')); ?>
		
		<?php 

$studyslug = $study->id.':'.$study->study_alias;


//video link
$linkvideo = '<span class="videolink"><a href = "' . JRoute::_(PreachitHelperRoute::getStudyRoute($studyslug).'&mode=watch') . '" >'. JText::_('MOD_PREACHIT_WATCH').'</a></span>';

if ($study->video_link != '') {
$link = $linkvideo;
}
else {
$link = '';
}

//audio link
$linkaudio = '<span class="audiolink"><a href = "' . JRoute::_(PreachitHelperRoute::getStudyRoute($studyslug).'&mode=listen') . '" >'. JText::_('MOD_PREACHIT_LISTEN').'</a></span>';

if ($study->audio_link != '') {
$link2 = $linkaudio;
}
else {
$link2 = '';
} 

if ($study->study_text != '') {
$link6 = '<span class="textlink"><a href = "' . JRoute::_(PreachitHelperRoute::getStudyRoute($studyslug).'&mode=read') . '" >'. JText::_('MOD_PREACHIT_READ').'</a></span>';
}
else {
$link6 = '';
} 
		
		if ($m == '1')
			{$medialinks = '<div class="medialinks">' . $link . $link2 . $link6 . '</div>';}
			else {$medialinks = '';}
	
		if ($s == '1')
			{$script = '<div class="scripture">' . $scripture . '</div>';}
			else {$script = '';}
	
		if ($t == '1')
			{$teacher = '<div class="teacher">' . $teacher_name . '</div>';}
			else {$teacher = '';}
		
		if ($ser == '1')
			{$series = '<div class="series">' . $series_name . '</div>';}
			else {$series = '';}
		
		if ($d == '1')
			{$date = '<div class="date">' . JHTML::Date($study->study_date, $dateformat) . '</div>';}
			else {$date = '';}?>			
	<li>
        <?php echo $image; ?>
        <div class="studyname"><?php echo $title;?></div>    
        <?php echo $script;?>
        <?php echo $date;?>
        <?php echo $teacher;?>
        <?php echo $series;?>
        <?php echo $medialinks;?>
        <div class="clr"></div>
    </li>

	<?php
}
?>
</ul>
<?php if ($params->get('showall', 0) == 1) {
$showurl = PreachitHelperRoute::getStudiesRoute();	
?>
<div class="showall"><a href="<?php echo JRoute::_($showurl);?>" title="<?php echo JText::_('MOD_PREACHIT_SHOW_ALL');?>"><?php echo JText::_('MOD_PREACHIT_SHOW_ALL');?></a></div>
<?php }?>
</div>