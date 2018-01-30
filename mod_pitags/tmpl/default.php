<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
?>
<div class="pitags<?php echo $moduleclass_sfx; ?>">			
	<div class="blocklist">
<?php
foreach ($tagdata->tagarray as &$tag)
{
	$jversion = new JVersion();
	$version = substr($jversion->getShortVersion(), 0, 3);
	if ($version >= 3.2)
	{
		$abspath    = JPATH_SITE;
		require_once($abspath.DIRECTORY_SEPARATOR.'components/com_tags/helpers/route.php');
		$slug = $tag->id.':'.$tag->alias;
		if ($params->get('linktags', 0) == 1)
		{
			$url = TagsHelperRoute::getTagRoute($slug);
		}
		else {
			$url = PreachitHelperRoute::getTagRoute($slug);
		}
		
		echo '<a class="taglink" style="font-size: '.round($tag->size, 3).$unit.';" href="'.JRoute::_($url).'">'.htmlspecialchars($tag->name).'</a> ';
	}
	else {
		echo '<a class="taglink" style="font-size: '.round($tag->size, 3).$unit.';" href="'.JRoute::_('index.php?option=com_preachit&view=studylist&layout=tag&tag='.$tag->name.'&Itemid='.$menuid).'">'.htmlspecialchars($tag->name).'</a> ';
	}
}
?>

	</div>
</div>