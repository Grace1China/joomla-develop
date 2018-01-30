<?php
/**
 * @package Module TM Ajax Contact Form for Joomla! 3.x
 * @version 1.0.0: mod_tm_ajax_contact_form.php
 * @author TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2014 Jetimpex, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
**/

defined('_JEXEC') or die;

$labels_pos = $params->get('labels_pos');

?>
<section id="contact">
	<script>
	<?php if( $params->get('captcha_req')==1 ) { ?>
		var RecaptchaOptions = {
			theme : "<?php echo $params->get('captcha_theme');?>"
		};
	<?php } ?>
		jQuery(function($){
		 	var success = "<?php echo $params->get('success_notify'); ?>",
			error = "<?php echo $params->get('failure_notify'); ?>",
			recaptcha_error = "<?php echo $params->get('recaptcha_failure_notify'); ?>",
			id = "<?php echo $module->id; ?>",
		 	validator = $('#contact-form_<?php echo $module->id; ?>').validate({
		 		wrapper: "mark",
				rules: {
					phone: {
						number: true
					}<?php if( $params->get('captcha_req')==1 ) { ?>,
					recaptcha_response_field : {
						required : true
					}
					<?php } ?>
				},
				submitHandler: function(form) {
					$("#message_<?php echo $module->id; ?>")
					.removeClass("success")
					.removeClass("error")
					.addClass("loader")
					.html("Sending message")
					.fadeIn("slow");
					<?php if( $params->get('captcha_req')==1 ) { ?>
					$(form).ajaxcaptcha(validator, success, error, recaptcha_error, id);
					<?php }
					else { ?>
					$(form).ajaxsendmail(validator, success, id);
					<?php } ?>
					return false;
				}
			});
			<?php if($labels_pos) { ?>
	        $.support.placeholder = ('placeholder' in document.createElement('input'));
	        <?php } ?>
	        $('#clear_<?php echo $module->id; ?>').click(function(){
	            $('#contact-form_<?php echo $module->id; ?>').trigger('reset');
	            validator.resetForm();
	            <?php if($labels_pos) { ?>
	            if (!$.support.placeholder) {
		            $('.mod_tm_ajax_contact_form *[placeholder]').each(function(n){
		        		$(this)
		        		.parent('.controls')
                        .find('>.mod_tm_ajax_contact_form_placeholder')
                        .show();
			        })
		        }
		        <?php } ?>
            	<?php if( $params->get('captcha_req')==1 ) { ?>
                Recaptcha.reload();
                <?php } ?>
	            return false;
	        })
	        <?php if($labels_pos) { ?>
	        if (!$.support.placeholder) {
	        	$('.mod_tm_ajax_contact_form *[placeholder]').each(function(n){
	        		$(this)
	        		.attr('autocomplete','off')
	        		.addClass('ie_placeholder')
	        		.bind('keydown keyup click blur focus change paste cut', function(e){
	        			$(this).delay(10)
	                    .queue(function(n){
	                        if($(this).val() != ''){
		        				$(this)
				        		.parent('.controls')
				        		.find('>.mod_tm_ajax_contact_form_placeholder')
				        		.hide();
		        			}
		        			else{
		        				$(this)
				        		.parent('.controls')
				        		.find('>.mod_tm_ajax_contact_form_placeholder')
				        		.show();
		        			}
	                        n();
	                    });
	        		})
	        		.before('<label class="mod_tm_ajax_contact_form_placeholder"/>')
	        		.parent('.controls')
	        		.addClass('ie_placeholder_controls')
	        		.find('>.mod_tm_ajax_contact_form_placeholder')
	        		.attr('for',$(this).parent('.controls').find('>*[placeholder]').attr('id'))
	        		.text($(this).parent('.controls').find('>*[placeholder]').attr('placeholder'))
	        		.css({
	        			paddingTop: $(this).parent('.controls').find('>*[placeholder]').css('paddingTop'),
	        			paddingBottom: $(this).parent('.controls').find('>*[placeholder]').css('paddingBottom'),
	        			paddingLeft: $(this).parent('.controls').find('>*[placeholder]').css('paddingLeft'),
	        			paddingRight: $(this).parent('.controls').find('>*[placeholder]').css('paddingRight'),
	        			borderTopWidth: $(this).parent('.controls').find('>*[placeholder]').css('borderTopWidth'),
	        			borderBottomWidth: $(this).parent('.controls').find('>*[placeholder]').css('borderBottomWidth'),
	        			borderLeftWidth: $(this).parent('.controls').find('>*[placeholder]').css('borderLeftWidth'),
	        			borderRightWidth: $(this).parent('.controls').find('>*[placeholder]').css('borderRightWidth'),
	        			fontSize: $(this).parent('.controls').find('>*[placeholder]').css('fontSize'),
	        			color: $(this).parent('.controls').find('>*[placeholder]').css('color')
	        		})
	        	})
	        }
	        <?php } ?>
		})
	</script>
	<form class="mod_tm_ajax_contact_form" id="contact-form_<?php echo $module->id; ?>" novalidate>
    <div class="mod_tm_ajax_contact_form_message" id="message_<?php echo $module->id; ?>">

	</div>
	  <fieldset>
		
		<!-- Name Field -->
		  <div class="control-group control-group-input <?php echo $params->get('errors_position');?>">
			<?php if(!$labels_pos) { ?>
			<label for="inputName_<?php echo $module->id; ?>"><?php echo $params->get('name_name'); ?></label>
			<?php } ?>
			<div class="controls">
			  <input name="name" type="text" class="mod_tm_ajax_contact_form_input" id="inputName_<?php echo $module->id; ?>"<?php if($labels_pos) { ?> placeholder="<?php echo $params->get('name_name'); ?>"<?php } ?> required>
			</div>
		  </div>
		 
		 <!-- E-mail Field -->
		  <?php if($params->get('email_publish')) {?>			  
		  <div class="control-group control-group-input <?php echo $params->get('errors_position');?>">
			<?php if(!$labels_pos) { ?>
			<label for="inputEmail_<?php echo $module->id; ?>"><?php echo $params->get('email_name'); ?></label>
			<?php } ?>
			<div class="controls">
			  <input name="email" type="email" class="mod_tm_ajax_contact_form_input" id="inputEmail_<?php echo $module->id; ?>"<?php if($labels_pos) { ?> placeholder="<?php echo $params->get('email_name'); ?>"<?php } ?> <?php echo $params->get('email_req'); ?>>
			</div>
		  </div>
		  <?php }
				if($params->get('phone_publish'))
				{
		  ?>
		  
		  <!-- Phone Field -->
		  <div class="control-group control-group-input <?php echo $params->get('errors_position');?>">
			<?php if(!$labels_pos) { ?>
			<label for="inputEmail_<?php echo $module->id; ?>"><?php echo $params->get('phone_name'); ?></label>
			<?php } ?>
			<div class="controls">
			  <input name="phone" type="text" class="mod_tm_ajax_contact_form_input" id="inputPhone_<?php echo $module->id; ?>"<?php if($labels_pos) { ?> placeholder="<?php echo $params->get('phone_name'); ?>"<?php } ?> <?php echo $params->get('phone_req'); ?>>
			</div>
		  </div>
		  <?php
				}
				if($params->get('subject_publish'))
				{
		  ?>
		 
		 <!-- Subject Field -->
		  <div class="control-group control-group-input <?php echo $params->get('errors_position');?>">
			<?php if(!$labels_pos) { ?>
			<label for="selectSubject_<?php echo $module->id; ?>"><?php echo $params->get('subject_name'); ?></label>
			<?php } ?>
			<div class="controls">
				<?php if( $params->get('subject_type') == 1){ ?>
				<select name="type" class="mod_tm_ajax_contact_form_select" id="selectSubject_<?php echo $module->id; ?>" required>
				  <?php if($labels_pos) { ?><option disabled selected value=""><?php echo $params->get('subject_name'); ?></option><?php } ?>
				  <option value="question"><?php echo JText::_('MOD_TM_AJAX_CONTACT_FORM_QUESTION'); ?></option>
				  <option value="support"><?php echo JText::_('MOD_TM_AJAX_CONTACT_FORM_COMMENTS'); ?></option>
				  <option value="misc"><?php echo JText::_('MOD_TM_AJAX_CONTACT_FORM_OTHER'); ?></option>
				</select>
				<?php
					}
					else
					{
				?>
						<input name="type" type="text" class="mod_tm_ajax_contact_form_input" id="selectSubject_<?php echo $module->id; ?>"<?php if($labels_pos) { ?> placeholder="<?php echo $params->get('subject_name'); ?>"<?php } ?> required>
				<?php
					}
				?>
			</div>
		  </div>
		  <?php
				}
		  ?>
		 
		 <!-- Message Field -->
		  <div class="control-group control-group-textarea <?php echo $params->get('errors_position');?>">
		  	<?php if(!$labels_pos) { ?>
			<label for="inputMessage_<?php echo $module->id; ?>"><?php echo $params->get('message_name'); ?></label>
			<?php } ?>
			<div class="controls">
			  <textarea name="message" class="mod_tm_ajax_contact_form_textarea" id="inputMessage_<?php echo $module->id; ?>"<?php if($labels_pos) { ?> placeholder="<?php echo $params->get('message_name'); ?>"<?php } ?> minlength="<?php echo $params->get('msg_minlength'); ?>" required></textarea>
			</div>
		  </div>
		  <?php
				if( $params->get('captcha_req')==1 )
				{
		  ?>
		 
		 <!-- Captcha Field -->
		  <div class="control-group control-group-recaptcha <?php echo $params->get('errors_position');?>">
			<div class="controls" id="recaptcha_<?php echo $module->id; ?>">
				<?php
				  $publickey = $params->get('public_key');
				  echo recaptcha_get_html($publickey);
				?>
				<div class="mod_tm_ajax_contact_form_recaptcha_message" id="recaptcha_message_<?php echo $module->id; ?>">
			</div>
		  </div> 
		  <?php
				}				
				if($params->get('admin_email'))
				{
		  ?>
		 
		 <!-- Submit Button -->
		  <div class="control-group control-group-button">
			<div class="controls">
			<?php			
				if($params->get('reset_publish'))
				{
		  	?>
			  <button type="reset" name="button" id="clear_<?php echo $module->id; ?>" value="Clear" class="btn btn-primary mod_tm_ajax_contact_form_btn"><?php echo $params->get('br_name');?></button>
			<?php
				}
		  	?>  
			  <button type="submit" name="button" value="Send" class="btn btn-primary mod_tm_ajax_contact_form_btn"><?php echo $params->get('bs_name');?></button>
			</div>
		  </div>
		  <?php
				}
				else
				{
		  ?>
			<p><?php echo JText::_('MOD_TM_AJAX_CONTACT_FORM_ENTER_ADMIN_EMAIL'); ?></p>
		  <?php
				}
		  ?>
		</fieldset>
	</form>
</section>