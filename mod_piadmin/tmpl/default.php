<?php
defined('_JEXEC') or die('Restricted access');

?>
<div class="piadmin<?php echo $moduleclass_sfx; ?> bulletadmin">
<ul class="ul">
<?php if ($params->get('message', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link;?></span></li>
<?php } ?>
<?php if ($params->get('teacher', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link4;?></span></li>
<?php } ?>
<?php if ($params->get('series', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link3;?></span></li>
<?php } ?>
<?php if ($params->get('podcast', 1) == 1)
{ ?>
<li class="li"><span class="links"><?php echo $link2;?></span></li>
<?php } ?>

</ul>
</div>