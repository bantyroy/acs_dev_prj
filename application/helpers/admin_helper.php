<?php

/*********
* Author: Acumen CS 
* Date  : 05 Feb 2014
* Modified By:  
* Modified Date: 
* Purpose:
*  Custom Helpers 
* Includes all necessary files and common functions
*/

//Encryption and Decryption//

/***
* Encryption double ways.
* @param string $s_var
* @return string

* $arr_breadcrumb like array(array('text'=>'Manage Category','link'=>'http://xxx.com'),array('text'=>'show list','link'=>'http://yyy.com'));

*/

function admin_breadcrumb($arr_breadcrumb=null)
{
	$divider	=	'';
	$str_breadcrumb	=	'<ol class="breadcrumb"><li><a href="'.admin_base_url().'"><i class="fa fa-dashboard"></i>'.addslashes(t("Home")).'</a></li>' ;
	
	if(!empty($arr_breadcrumb))
	{
		$str_breadcrumb	.= $divider ;
		foreach($arr_breadcrumb as $key=>$val)
		{
			if(!is_array($val))
			{
				$str_breadcrumb .= '<li><a  class="active" href="javascript:void(0);">'.$val.'</a></li>';
			}
			else{
				$str_breadcrumb .= '<li><a href="'.$val['link'].'">'.$val['text'].'</a></li>';
			}
			
			if($arr_breadcrumb[$key+1])
				$str_breadcrumb	.= $divider ;
		}

	}
	$str_breadcrumb	.=	'</ol>';
	return $str_breadcrumb ;
}


/**
* Saves the error messages into session.
* @param string $s_msg
* @return void
*/

function set_error_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_=$o_ci->session->userdata('error_msg');
			
			if(empty($ret_))
				$ret_	=	array();
				
			array_push($ret_,$s_msg);
			
            $o_ci->session->set_userdata('error_msg',$ret_);
        }

        unset($s_msg,$ret_);

    }

    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }     

}

/**
* Saves the error messages into session.
* @param string $s_msg
* @return void
*/

function set_success_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_ = $o_ci->session->userdata('success_msg');
			
			
			if(empty($ret_))
				$ret_	=	array();
				
			array_push($ret_,$s_msg);
			
            $o_ci->session->set_userdata('success_msg',$ret_);
            //echo $o_ci->session->userdata('success_msg');
        }
        unset($s_msg,$ret_);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }     

}


/**
* Displays the success or error or both messages.
* And removes the messages from session
* @param string $s_msgtype, "error","success","both" 
* @return void
*/

function show_all_messages($s_msgtype="both")
{
    try
    {
		echo validation_errors();
        $o_ci=&get_instance();
        switch($s_msgtype)
        {
            case "error":
                $ret_	=	$o_ci->session->userdata('error_msg');
				
				if(!empty($ret_))
				{
					foreach($ret_ as $itt_)
						echo show_error_alert($itt_);
				}

                $o_ci->session->unset_userdata('error_msg');
            break;    

            case "success":
                $ret_	=	$o_ci->session->userdata('error_msg');
				
				if(!empty($ret_))
				{
					foreach($ret_ as $itt_)
						echo show_success_alert($itt_);
				}
                $o_ci->session->unset_userdata('success_msg');
            break;    

            default:
                $ret_	=	$o_ci->session->userdata('success_msg');
				
				if(!empty($ret_))
				{
					foreach($ret_ as $itt_)
						echo show_success_alert($itt_);
				}
				$ret_	=	$o_ci->session->userdata('error_msg');
				
				if(!empty($ret_))
				{
					foreach($ret_ as $itt_)
						echo show_error_alert($itt_);
				}
                $array_items = array('success_msg' => null, 'error_msg' => null);
                $o_ci->session->unset_userdata($array_items);
                unset($array_items);
            break;
			
			$o_ci->session->unset_userdata('success_msg');            
			$o_ci->session->unset_userdata('error_msg');            

        }        
        unset($s_msgtype);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }
}


/**
* Show error message
**/
function show_error_alert($s_message)
{
	return '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button> '.$s_message.'</div>';
	
}

/**
* Show success message
**/
function show_success_alert($s_message)
{
	return '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button> '.$s_message.'</div>';
	
}


/**
* Show info message
**/
function show_success_info($s_message)
{
	return '<div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$s_message.'</div>';
	
}

/**
* Fetch menu and show the left site menu..
**/

function create_left_menus()
{
	$CI =& get_instance();
	$admin_loggedin = $CI->session->userdata("admin_loggedin");
	
	$CI->load->model('menu_model');
	$s_where = " WHERE i_parent_id = 0 ";
	$top_menu = $CI->menu_model->fetch_menus_navigation($s_where,decrypt($admin_loggedin['user_type_id']));
	
	if(!empty($top_menu))
	{
		$menu_link	=	'';
		foreach($top_menu as $val1)
		{
			 $s_wh_cl = " WHERE i_parent_id = ".$val1['id']." AND i_main_id!=-99 ";  
			 $sub_menu = $CI->menu_model->fetch_menus_navigation($s_wh_cl,decrypt($admin_loggedin['user_type_id']),' ORDER BY s_name ASC '); 
			 
			 $permitted = false;
			 if(!empty($sub_menu))
			 {
				foreach($sub_menu as $k=>$v)
				{
					$permitted = menu_permitted_or_not($v['id']); // Below written
					if($permitted)
						break;
				}
			 }
				
			 if((!empty($sub_menu) || $val1['i_total_controls']>0) && $permitted)
			 {
			 	$parent_menu	= $CI->session->userdata('parent_menu_id');
				
				if(!empty($parent_menu) && ($parent_menu==$val1['id']))
					$parent_cls	= 'active';
				else
					$parent_cls	= '';
				
				$menu_link	.= '<li class="treeview '.$parent_cls.'" ><a href="#"><i class="fa fa-'.$val1['s_icon_class'].'"></i><span>'.$val1['t_name'].'</span><i class="fa fa-angle-left pull-right"></i></a><ul class="treeview-menu">';
			 }
			 
			 if(!empty($sub_menu))
			 {
			 	foreach($sub_menu as $val2)
				{
					if($val2['i_total_controls']>0)
					{
						$child_menu	= $CI->session->userdata('child_menu_id');
						
						if(!empty($child_menu) && ($child_menu==$val2['id']))
							$child_cls	= 'class=active';
						else
							$child_cls	= '';
						
						$menu_link	.= '<li '.$child_cls.'><a onclick="set_menu_sessions('.$val1['id'].','.$val2['id'].',\''.$val2['s_link'].'\')" ><i class="fa fa-angle-double-right"></i>&nbsp;'.$val2['t_name'].'</a></li>' ;
						
						/*$lnk= trim($val2['s_link'],'/');						
						$menu_link	.= '<li><a onclick="open_menu_link($(this),\''.$lnk.'\')" href="javascript:void(0);"><i class="fa fa-angle-double-right"></i>&nbsp;'.$val2['t_name'].'</a></li>' href='".admin_base_url().$val2['s_link']."';  href='".admin_base_url().$val2['s_link']."' href='".admin_base_url().$val2['s_link']."'*/
						
					}
				}
			 } 
			$menu_link	.= '</ul>'; 
		}
		$menu_link	.= '</li>'; 
	}
	echo $menu_link ;
}

function menu_permitted_or_not($i_menu_id)
{
	$CI =& get_instance();
	$admin_loggedin = $CI->session->userdata("admin_loggedin");
	
	$CI->load->model('menu_model');
	$s_where = " WHERE i_menu_id = {$i_menu_id} ";
	$top_menu = $CI->menu_model->fetch_menu_permission_of_user_type($s_where,decrypt($admin_loggedin['user_type_id']));
	
	$permit_cnt = 0;
	if(!empty($top_menu))
	{
		foreach($top_menu as $ck=>$cr)
		{
			$permit_cnt = $cr['i_total_controls'];
			if($permit_cnt)
				break;			
		}
	}
	
	if((!empty($top_menu) && $permit_cnt) || decrypt($admin_loggedin['user_type_id'])==0)  // for super admin
		return true;
	else
		return false;	
}



/*
* GET THE FIELD NAME WITH RESPECT TO CURRENT LANGUAGE. 
* s_name -> en_s_name
*/

function db_field_wrtcl($str)
{
	$CI	=	& get_instance();
	return $CI->s_current_lang_prefix.'_'.$str ;
}

/*
* GET THE FIELD NAME WITH RESPECT TO OTHER LANGUAGE. 
* s_name -> en_s_name
* If current language is english it will display arabic language data
*/
function db_field_wrtol($str)
{
	$CI	=	& get_instance();
	$languages	=	$CI->config->item('languages');	
	$index	=	array_search($CI->s_current_lang_prefix,$languages);
	if($index==0)
		return $languages[1].'_'.$str ;
	else
		return $languages[0].'_'.$str ;
}

/** This function to create label useing color
*	$text string 
*	$type Type of color want to show (for success green)
*	$option is a array ina array send all option
*/

function make_label($text,$type='success',$option=array())
{
	if(!empty($option))
	{
		return "<span class='label label-".$type."' >".$text.'</span>';
	}
	else
	{
		$id	= "";	
		if(isset($option['id']))
		{
			$id	= "id=\'".$option['id']."\'";	
		}
		return "<span class='label label-".$type."' ".$id."'>".$text.'</span>';
	}
}

function make_button($value_id,$type='success',$text)
{
	$new_text=addslashes(t('make '.$text));
	return '<a class="btn btn-mini btn-'.$type.'" id="approve_img_id_'.$value_id.'_'.$text.'" href="javascript:void(0);"><i class="icon-refresh icon-white"></i>'.$new_text.'</a>';
}