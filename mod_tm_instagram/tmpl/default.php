<?php
/**
 * Instagram for Joomla! Module
 *
 * @author    TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2013 Jetimpex, Inc.
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
 * 
 */

defined('_JEXEC') or die;

?>
<div class="mod_tm_instagram" id="module_<?php echo $module->id; ?>">
	<ul>
	</ul>
</div>

<script>
jQuery("#module_<?php echo $module->id; ?> ul").jtminstagram({
  client_id: "<?php echo $CLIENT_ID; ?>",
  user_name: "<?php echo $USER_NAME; ?>",
  count: <?php echo $AdminPhotoCount; ?>,
  afterLoad: function(){
  	
  }
});
</script>