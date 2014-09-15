<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function sendMail($to, $subject, $message ,$formmalid = 'acumen.testmail01@gmail.com', $formname = 'ACS', $attachment='', $cc='', $bcc='')
{
    global $CI;	
	
    $CI->load->model('site_setting_model','mod_site_setting');

	$info = $CI->mod_site_setting->fetch_this("NULL");
	
	$config['mailtype'] = 'html';
    $config['charset'] = 'utf-8';
    
    /*$config['protocol'] = 'smtp';
    $config['smtp_host'] = $info["s_smtp_host"];
    $config['smtp_user'] = $info["s_smtp_userid"];
    $config['smtp_pass'] = $info["s_smtp_password"];*/
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
	
    if (empty($formmalid))
    {
        $formmalid = $CI->config->item('CONF_EMAIL_ID');
        $formname  = $CI->config->item('MAIL_FROM_NAME');
    }
	
    $CI->load->library('email');
	$CI->email->initialize($config);
    $CI->email->clear();
    $CI->email->from($formmalid, $formname);
    $CI->email->to($to);
    
    $CI->email->subject($subject);
    $CI->email->message($message);
	if(!empty($attachment))
		{
			$CI->email->attach($attachment);
		}
	if(!empty($cc))
		{
			$CI->email->cc($cc);
		}	
    if(!empty($bcc))
		{
			$CI->email->bcc($bcc);
		}	
	#if( TRUE || SITE_FOR_LIVE)///For live site
    if( SITE_FOR_LIVE )///For live site
	{	
		if ($CI->email->send())
		{
			return true;
		}
		else
		{
		    /*echo 'hi';
            echo $CI->email->print_debugger();
			exit;*/
			return false;
		}
	}
	else{
	
		return true;		
	}
}
?>
