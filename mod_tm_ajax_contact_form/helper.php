<?php
/**
 * @package Module TM Ajax Contact Form for Joomla! 3.x
 * @version 1.0.0: mod_tm_ajax_contact_form.php
 * @author TemplateMonster http://www.templatemonster.com
 * @copyright Copyright (C) 2012 - 2014 Jetimpex, Inc.
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 
**/

defined('_JEXEC') or die;

class modTmAjaxContactFormHelper
{
	public static function recaptchaAjax()
	{
		jimport('joomla.application.module.helper');
		require_once JPATH_BASE.'/modules/mod_tm_ajax_contact_form/recaptchalib.php';
		$input  		= JFactory::getApplication()->input;
		$module 		= JModuleHelper::getModule('tm_ajax_contact_form');
		$params 		= new JRegistry();
		$params->loadString($module->params);
		$inputs 		= $input->get('data', array(), 'ARRAY');
		foreach ($inputs as $input) {
			
			if( $input['name'] == 'recaptcha_challenge_field' )
			{
				$recaptcha_challenge_field 			= $input['value'];
			}

			if( $input['name'] == 'recaptcha_response_field' )
			{
				$recaptcha_response_field 			= $input['value'];
			}

		}
		$resp = recaptcha_check_answer ($params->get('private_key'), $_SERVER["REMOTE_ADDR"], $recaptcha_challenge_field, $recaptcha_response_field);
		if (!$resp->is_valid) {
		    //Captcha was entered incorrectly
			$result = "captcha_error";
		  } else {
		    //Captcha was entered correctly
		    $result = "success";
		}
		return $result;
	}

	public static function getAjax()
	{
		jimport('joomla.application.module.helper');
		$input  		= JFactory::getApplication()->input;
		$module 		= JModuleHelper::getModule('tm_ajax_contact_form');
		$params 		= new JRegistry();
		$params->loadString($module->params);

		$mail 			= JFactory::getMailer();

		$success 		= $params->get('success_notify');
		$failed 		= $params->get('failure_notify');
		$recipient 		= $params->get('admin_email');
		$cc_email 		= $params->get('cc_email');
		$bcc_email 		= $params->get('bcc_email');

		//inputs
		$inputs 		= $input->get('data', array(), 'ARRAY');

		foreach ($inputs as $input) {
			
			if( $input['name'] == 'email' )
			{
				$email 			= $input['value'];
			}

			if( $input['name'] == 'name' )
			{
				$name 			= $input['value'];
			}

			if( $input['name'] == 'lastname' )
			{
				$lastname 			= $input['value'];
			}

			if( $input['name'] == 'age' )
			{
				$age 			= $input['value'];
			}

			if( $input['name'] == 'city' )
			{
				$city 			= $input['value'];
			}

			if( $input['name'] == 'position' )
			{
				$position 			= $input['value'];
			}

			if( $input['name'] == 'salary' )
			{
				$salary 			= $input['value'];
			}

			if( $input['name'] == 'date' )
			{
				$date 			= $input['value'];
			}

			if( $input['name'] == 'phone' )
			{
				$phone 			= $input['value'];
			}

			if( $input['name'] == 'website' )
			{
				$website		= $input['value'];
			}

			if( $input['name'] == 'type' )
			{
				$type 			= $input['value'];
			}

			if( $input['name'] == 'experience' )
			{
				$experience 		= nl2br( $input['value'] );
			}

			if( $input['name'] == 'application' )
			{
				$application 		= nl2br( $input['value'] );
			}

		}

		$name_name	= $params->get('name_name');
		$email_name	= $params->get('email_name');
		$phone_name	= $params->get('phone_name');
		$website_name	= $params->get('website_name');
		$subject_name	= $params->get('subject_name');
		$message_name	= $params->get('message_name');

		// Building Mail Content
		$formcontent = "<strong>".$name_name.": ". $name;
		if(isset($lastname)){
			$formcontent .= "<br /><br /><strong>Last Name:</strong> ". $lastname;
		}
		if(isset($email)){
			$formcontent .= "<br /><br /><strong>".$email_name.":</strong> ". $email;
		}
		if(isset($age)){
			$formcontent .= "<br /><br /><strong>Age:</strong> ". $age;
		}
		if(isset($city)){
			$formcontent .= "<br /><br /><strong>City:</strong> ". $city;
		}
		if(isset($position)){
			$formcontent .= "<br /><br /><strong>Position:</strong> ". $position;
		}
		if(isset($salary)){
			$formcontent .= "<br /><br /><strong>Expected Salary:</strong> ". $salary;
		}
		if(isset($date)){
			$formcontent .= "<br /><br /><strong>Start Date:</strong> ". $date;
		}
		if(isset($phone)){
			$formcontent .= "<br /><br /><strong>".$phone_name.":</strong> ". $phone;
		}
		if(isset($website)){
			$formcontent .= "<br /><br /><strong>".$website_name.":</strong> ". $website;
		}
		if(isset($type)){
			$formcontent .= "<br /><br /><strong>".$subject_name.":</strong> ". $type;
		}
		if(isset($experience)){
			$formcontent .= "<br /><br /><strong>Experience:</strong> ". $experience;
		}
		if(isset($application)){
			$formcontent .= "<br /><br /><strong>Application:</strong> ". $application;
		}

		$subject = $name.", ".$_SERVER['HTTP_HOST'];
		if(isset($type)){
			$subject .= " for $type";
		}
		if(isset($_POST['email']) && isset($_POST['lastname']))
			$sender = array($email, $name, $lastname);	
		else
			$sender = $name;
		$mail->setSender($sender);
		$mail->addRecipient($recipient);
		if(isset($cc_email))
			$mail->addCC($cc_email);
		if(isset($bcc_email))
			$mail->addBCC($bcc_email);
		$mail->setSubject($subject);
		$mail->isHTML(true);
		$mail->Encoding = 'base64';	
		$mail->setBody($formcontent);
		 
		if ($mail->Send() === true) {
		  	return $success;
		} else {
		   	return '<span>'.$failed . "<br>" . $mail->Send()->__toString().'</span>';
		}
	}
}