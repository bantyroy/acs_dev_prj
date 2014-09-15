<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');	
   
/*
+-------------------------------------------------------+
| Send email 											|
+-------------------------------------------------------+
| @params $to emial , $subject, $message, $from eamil	|
+-------------------------------------------------------+
| @returns TRUE if the email send other wise FALSE		|
+-------------------------------------------------------+
| Added by Jagannath Samanta on 17 April 2012			|
+-------------------------------------------------------+
*/

function sendSmtpEmail()
{
	
}
function sendEmail($to, $subject, $message, $from)
{
	try
	{
		$CI = &get_instance();
		
		
		if(SITE_FOR_LIVE)
		{
			$CI->load->library('email');
			$config['protocol'] = 'sendmail';
			$config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
		}
		else // Send email from localhost
		{
			// ACS
			$config = array(
								'protocol' 		=> 'smtp',
								'smtp_host' 	=> 'mail.acumencs.com',
								'smtp_user' 	=> 'smtp@acumencs.com',
								'smtp_pass' 	=> 'smtp1234',
								'mailpath' 		=> '/usr/sbin/sendmail',
								'charset' 		=> 'iso-8859-1',
								'wordwrap' 		=> TRUE,
								'mailtype' 		=> 'html',
								'smtp_timeout' 	=> 20
							);
			
			// Gmail				
			$config = array(
								'protocol' 		=> 'smtp',
								'smtp_host' 	=> 'smtp.gmail.com',
								'smtp_user' 	=> 'cynthiagreenw@gmail.com',
								'smtp_pass' 	=> '123testing',
								'smtp_port' 	=> '465',
								'smtp_crypto'	=> 'ssl',
								'mailpath' 		=> '/usr/sbin/sendmail',
								'charset' 		=> 'iso-8859-1',
								'wordwrap' 		=> TRUE,
								'mailtype' 		=> 'html',
								'smtp_timeout' 	=> 20
							);
			
			$CI->load->library('email', $config);
			$CI->email->set_newline("\r\n");	
		}
		
			
		$CI->email->initialize($config);					
		$CI->email->clear();                    
		
		$CI->email->from($from);					
		$CI->email->to($to);
		$CI->email->subject($subject);
		$CI->email->message($message);
		
		return $CI->email->send();
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
/* End of file email_helper.php */
/* Location: ./system/application/helpers/email_helper.php */