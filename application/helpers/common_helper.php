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
*/

function encrypt($s_var)
{
    try
    { 
        $ret_=$s_var."#acu";///Hardcodded here for security reasons
        $ret_=base64_encode(base64_encode($ret_));
        unset($s_var);
        return $ret_;
    }

    catch(Exception $err_obj)
    {
		show_error($err_obj->getMessage());
    }  
}

/**
* Decryption double ways.
* 
* @param string $s_var
* @return string
*/

function decrypt($s_var)
{
    try
    {
        $ret_=base64_decode(base64_decode($s_var));
        $ret_=str_replace("#acu","",$ret_);
        unset($s_var);
        return $ret_;
    }

    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }      

}

//end Encryption and Decryption//


/**
 * Admin Base URL *
 * Returns the "admin_base_url" item from your config file *
 * @access    public
 * @return    string
 */

if ( ! function_exists('admin_base_url'))
{
    function admin_base_url()
    {
        try
        {
         	$CI =& get_instance();
			return $CI->config->slash_item('admin_base_url');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }

}

// ------------------------------------------------------------------------


/**
 * Agent Base URL *
 * Returns the "agent_base_url" item from your config file
 * @access    public
 * @return    string
 */

if ( ! function_exists('agent_base_url'))
{
    function agent_base_url()
    {
        try
        {
         	$CI =& get_instance();
			return $CI->config->slash_item('agent_base_url');
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

    }

}

// ------------------------------------------------------------------------
/**
* Saves the error messages into session.
* 
* @param string $s_msg
* @return void
*/
function fe_set_error_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_=$o_ci->session->userdata('error_msg');
            $ret_.='<div id="err_msg" class="error_message">'.$s_msg.'</div>';
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
* 
* @param string $s_msg
* @return void
*/
function fe_set_success_msg($s_msg)
{
    try
    {
        $ret_="";
        if(trim($s_msg)!="")
        {
            $o_ci=&get_instance();
            $ret_=$o_ci->session->userdata('success_msg');
            $ret_.='<div class="success_message">'.$s_msg.'</div>';
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
* 
* @param string $s_msgtype, "error","success","both" 
* @return void
*/
function show_msg($s_msgtype="both")
{
    try
    {
        $o_ci=&get_instance();
        switch($s_msgtype)
        {
            case "error":
                echo $o_ci->session->userdata('error_msg');
                $o_ci->session->unset_userdata('error_msg');
            break;    

            case "success":
                echo $o_ci->session->userdata('success_msg');
                $o_ci->session->unset_userdata('success_msg');
            break;    

            default:
                echo $o_ci->session->userdata('success_msg');
                echo $o_ci->session->userdata('error_msg');
                $array_items = array('success_msg' => '', 'error_msg' => '');
                $o_ci->session->unset_userdata($array_items);
                unset($array_items);
            break;            
        }
        unset($s_msgtype);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }     
}


/**
* Displays the pre-formatted array 
* @param mix $mix_arr
* @param int $i_then_exit
* @return void
*/


function pr($mix_arr = array(), $i_then_exit = 0)
{
	try
        {
         	echo '<pre>';
			print_r($mix_arr);
			echo '</pre>';
			unset($mix_arr);
			if($i_then_exit)
			{
				exit();
			}
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}



/**
* Displays the pre-formatted array with array element type
* @param mix $mix_arr
* @param int $i_then_exit
* @return void
*/

function vr($mix_arr = array(), $i_then_exit = 0)
{

	try
        {
         	echo '<pre>';
			var_dump($mix_arr);
			echo '</pre>';
			unset($mix_arr);
			if($i_then_exit)
			{
				exit();
			}

        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}





/****
* Function to format input string
*
*****/
function get_formatted_string($str)
{
    try
    {  
	    return ($str);
		//return addslashes(htmlentities(trim($str),ENT_QUOTES,'UTF-8'));
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}
/****
* Function to reverse of get_formatted_string
*
*****/
function get_unformatted_string($str)
{
    try
    {    
	    //return htmlspecialchars(stripslashes($str));
		return $str;
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

/****`
* Function to compare string
*
*****/
function my_receive_string($str)
{
    try
    {  
		return addslashes(trim($str));
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}

/****
* Function to show string
*
*****/
function my_show_string($str)
{
    try
    {  
		return htmlspecialchars($str);
    }
    catch(Exception $err_obj)
    {
      show_error($err_obj->getMessage());
    }         
}




/**
* For uploading files, picture etc.
* @param string $s_up_path, $s_fld_name, $s_file_name
* @param int $i_max_file_size
* @param mixture $mix_allowed_types
* @param mixture $mix_configArr
* @return void
*/

function get_file_uploaded(	$s_up_path = '', $s_fld_name = '', $s_file_name = '', $i_max_file_size = '' ,
							$mix_allowed_types = '', $mix_configArr = array()
						  )
{
    try
        {
			$CI = & get_instance();		

			$CI->load->library('upload');
			$i_config_max_file_size = $CI->config->item('admin_file_upload_max_size');
			$s_file_ext	= getExtension(@$_FILES[$s_fld_name]['name']);			

			$mix_config['upload_path'] 	= $s_up_path;
			$mix_config['allowed_types']= (!empty($mix_allowed_types) && !is_numeric($mix_allowed_types))?$mix_allowed_types:'png|jpg|gif';
			$s_filename = (!empty($s_file_name))?$s_file_name:getFilenameWithoutExtension(@$_FILES[$s_fld_name]['name']);
			$mix_config['file_name']= $s_filename.$s_file_ext;
			$mix_config['max_size']	= (!empty($i_max_file_size) && is_numeric($i_max_file_size))?$i_max_file_size:$i_config_max_file_size;			

			if(is_array($mix_configArr) && count($mix_configArr)>0)
			{
				foreach($mix_configArr as $key=>$val)
				$mix_config[$key] = $val;
			}				
			unset($s_up_path, $i_max_file_size , $mix_allowed_types ,$mix_configArr, $i_config_max_file_size);			

			$CI->upload->initialize($mix_config);			
			$s_response 	= ( ! $CI->upload->do_upload($s_fld_name))?('err|@sep@|'.$CI->upload->display_errors('<div>', '</div>')):('ok|@sep@|'.$s_filename.$s_file_ext);

			unset($s_filename, $s_fld_name, $s_file_ext);
			return $s_response;	
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}



/**
* For geting extension of a file
* @param string $s_filename
* @return string
*/

function getExtension($s_filename = '')
{
	try
        {
         	if(empty($s_filename))
			return FALSE;
			$mix_matches = array();
			preg_match('/\.([^\.]*)$/', $s_filename, $mix_matches);
			unset($s_filename);		
			return strtolower($mix_matches[0]);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
}

/**
* For geting filename without extension of a file
* @param string $s_filename
* @return string
*/

function getFilenameWithoutExtension($s_filename = '')
{
	try
        {
         	if(empty($s_filename))
			return FALSE;

			$mix_matches = array();
			preg_match('/(.+?)(\.[^.]*$|$)/', $s_filename, $mix_matches);
			unset($s_filename);
			$entities = array(" ",'.','!', '*', "'","-", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]", "!");
			//$s_new_filename = str_replace($entities,"_",$mix_matches[1]);
			
			$s_new_filename = str_replace($entities,"_",$mix_matches[1]).'_'.time();
			return strtolower($s_new_filename);
			 
        }

        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}

/**
* For deleting of a file from system
* @param string $s_up_path as the path of the file
* @param string $s_filename
* @return string
*/

function get_file_deleted($s_up_path = '', $s_file_name = '')
{
	try
        {
         	if(is_dir($s_up_path) && fileperms($s_up_path)!='0777')
			{
				chmod($s_up_path, 0777);
			}

			if(file_exists($s_up_path.$s_file_name))
			{
				 @unlink($s_up_path.$s_file_name);
				 return TRUE;
			}
			else
			{
				return FALSE;
			}

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }

}



/**
* For image thumbnailing
* @param string $s_img_path, $s_new_path, $s_file_name
* @param int $i_new_height, $i_new_width 
* @param mix $configArr
* @return string
*/



function get_image_thumb($s_img_path = '',$s_new_path = '',	$s_file_name = '', $i_new_height = '', $i_new_width = '',$mix_configArr = array())

{
	try
        {

			$CI = & get_instance();
			$CI->load->library('image_lib');
			$i_new_height = (!empty($i_new_height))?$i_new_height:$CI->config->item('admin_image_upload_thumb_height');
			$i_new_width  = (!empty($i_new_width))?$i_new_width:$CI->config->item('admin_image_upload_thumb_width');		

			$config['image_library'] 	= 'gd2';
			$config['source_image']  	= $s_img_path;
			$config['create_thumb']  	= TRUE;
			$config['maintain_ratio'] 	= TRUE;
			$config['width'] 			= $i_new_width;
			$config['height'] 			= $i_new_height;			
            $config['master_dim'] 		= "width";
			$config['thumb_marker'] 	= '';
			$config['new_image'] 		= $s_new_path.$s_file_name;			

			if(is_array($mix_configArr) && count($mix_configArr)>0)
			{
				foreach($mix_configArr as $s_key=>$mix_val)
					$config[$s_key] = $mix_val;
			}	

			$CI->image_lib->initialize($config); 
			unset($s_img_path, $s_new_path, $s_file_name, $i_new_height, $i_new_width ,$mix_configArr, $config);
			$b_res = $CI->image_lib->resize();
			$CI->image_lib->clear();
			if( !$b_res )
			{
				unset($b_res);
				return $msg	= $CI->image_lib->display_errors('<div class="err">','</div>');
			}
			else
			{
				unset($b_res);
				return 'ok';
			}
        }
        catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}

}

/*======================= START CREATE MENUS AND SUB-MENUS =======================*/

  /*
* Creates the menus and sub menus with respect to access control
* Provided to user type. This echos the formatted menus.
* @returns void
* Dont delete/ change this function
*/
function create_menus()
{
    try
    {
        //$s_active = '';
        $s_str = '';
        $CI =& get_instance();
        $admin_loggedin = $CI->session->userdata("admin_loggedin");
        
        $CI->load->model('menu_model');
        $s_where = " WHERE i_parent_id = 0 ";
        $top_menu = $CI->menu_model->fetch_menus_navigation($s_where,decrypt($admin_loggedin['user_type_id']));
        //print_r($top_menu);exit;
        foreach($top_menu as $key=>$menus)
        {    
            if($key == 0)
            {
                $s_active='class="active"';
            }
            else 
            {    
                $s_active= '';
            }
            
            $tmp = create_sub_menus($menus['id'],$key);
            
            if(trim($tmp)!='' || $menus['i_total_controls']>0)
            {                
                $s_str .= '<li  class="line"><a id="mnu_'.$key.'" href="javascript:void(0);" '.$s_active.'><b>'.$menus['s_name'].'</b></a>';            
                $s_str.= $tmp;            
                $s_str.= '</li>';
                unset($tmp);                
            }
           
        } // end for
        //var_dump($s_str);
        $s_str='<ul class="select">'.$s_str.'</ul>';
        echo $s_str;       
        unset($admin_loggedin,$menus,$key,$top_menu);   
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

/*
* Creates the sub menus at layer 2 with respect to access control
* Provided to user type. This echos the formatted sub sub menus.
* @returns formatted submenu layer 1 as string
* Dont delete/ change this function
*/
function create_sub_menus($parent_id,$i_mnu_id,$i_layer=0)
{
    try
    {
            $s_ret_="";
       
            $CI =& get_instance();            
            $admin_loggedin = $CI->session->userdata("admin_loggedin");
            $CI->load->model('menu_model');
            // Changes made by koushik 27 april
            $s_wh_cl = " WHERE i_parent_id = {$parent_id} AND i_main_id!=-99 ";  
            $sub_menu = $CI->menu_model->fetch_menus_navigation($s_wh_cl,decrypt($admin_loggedin['user_type_id']));        
                
            foreach($sub_menu as $con=>$mnus)
            {
                
                $tmp = create_sub_menus2($mnus['id'],$i_mnu_id,$con);
                if(trim($tmp)!='' || $mnus['i_total_controls']>0)
                {
                    $s_link=($mnus["s_link"]!=""?admin_base_url().$mnus["s_link"]:"javascript:void(0);");
                    $s_ret_.='<li><a id="mnu_'.$i_mnu_id.'_'.$con.'" href="'.$s_link.'">'.$mnus['s_name'].'</a>';
                    $s_ret_.=$tmp;
                    $s_ret_.='</li>';
                    unset($tmp);
                }
                
            }///end for  
                      
            unset($con,$mnus,$s_link,$admin_loggedin);
               
        return ($s_ret_!=""?'<ul class="sub">'.$s_ret_.'</ul>':'');
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

/* sub menus at layer 2 
* Dont delete/ change this function
*/
function create_sub_menus2($parent_id,$i_main_menu,$i_sub_menu)
{
    try
    {
            $s_ret_="";
            $CI =& get_instance();
            $admin_loggedin = $CI->session->userdata("admin_loggedin");
            $CI->load->model('menu_model');
            $s_wh_cl = " WHERE i_parent_id = {$parent_id} AND i_main_id!=-99";  
            $sub_menu = $CI->menu_model->fetch_menus_navigation($s_wh_cl,decrypt($admin_loggedin['user_type_id']));
                        
            foreach($sub_menu as $con=>$mnus)
            {
                if($mnus['i_total_controls']>0)
                {                
                    $s_link=($mnus["s_link"]!=""?admin_base_url().$mnus["s_link"]:"javascript:void(0);");    
                    $s_ret_.='<li><a id="mnu_'.$i_main_menu.'_'.$i_sub_menu.'_'.$con.'" href="'.$s_link.'">'.$mnus['s_name'].'</a>';
                    $s_ret_.='</li>';
                }
                
            }///end for
            ////end Sub sub menu exists i.e layer 2///////
            unset($con,$mnus,$s_link,$admin_loggedin);
       ///end if
       return ($s_ret_!=""?'<ul class="sub2">'.$s_ret_.'</ul>':'');
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}


	/*======================= END CREATE MENUS AND SUB-MENUS =======================*/
	



/* return string which end with a full letter */
function string_part($str, $limit=20)
{
	//$limit=20;
	$str = strip_tags($str);
	if(strlen($str)<$limit)
		return $str;
	
	$n_str =  explode(' ',substr($str,0,$limit));
	if(count($n_str)>1)
	{
		array_pop($n_str);
		$f_str = implode(' ',$n_str).' ...';
	}
	else
	{
		$f_str = implode(' ',$n_str);
	}
	return $f_str;
}




//////sh ajax Jason for any array to use into JS///
function makeArrayJs($mix_php_array = array())
{
    try
    {   
        if(!empty($mix_php_array))
        {
            return  json_encode($mix_php_array);
        }         
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}
//////sh ajax Jason for any array to use into JS///


/**
* This function is image src if image not available it return not avalable image
* 
* @author Koushik Rout
* @access public  
* @param string $image_path              
* @param string $file_name
* @param string $default_image // should be store in default folder
* @param int $width
* @param int $height
* @return string img file
*/

function showThumbImageDefault($image_catagory,$file_name,$image_type='general',$width=110,$height=110,$default_image='no_image.jpg',$extra_class='')
{
	try
	{
		$OBJ_CI = & get_instance();
		$arr_image_detail   =   $OBJ_CI->config->item($image_catagory);
        
		if($file_name=="")
		{
			return '<img src="uploaded/default/'.$default_image.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" alt="image not available">';    
		}
		else
		{
            $file_name  =   getFilenameWithoutExtension($file_name).'_'.$image_type.'.jpg';
			
			if(file_exists($arr_image_detail[$image_type]['upload_path'].$file_name))
			//if(file_exists('./uploaded/question/thumb/thumb_'.$file_name))
			{
                if($extra_class)
                {
                    
                    return '<img src="'.$arr_image_detail[$image_type]['display_path'].$file_name.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" >';    
                }
                else
                {
                    return '<img src="'.$arr_image_detail[$image_type]['display_path'].$file_name.'" width="'.$width.'" height="'.$height.'" >';    
                    
                }
			}
			else
			{
              
				
				return '<img src="uploaded/default/'.$default_image.'" width="'.$width.'" height="'.$height.'" class="'.$extra_class.'" alt="image not available">';    
			}    
		}
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
} //End of showThumbImage
    

function make_my_url($s_string='')
{
    try
        {
            if($s_string=='')
            {
                return false ;
            }
   
   ///////
   $s_string = preg_replace('/([^a-z0-9A-Z])/i','-',$s_string);
   //////
           
            $mix_matches = array();
            preg_match('/(.+?)(\.[^.]*$|$)/', trim($s_string), $mix_matches);
            unset($s_filename);

            $entities = array("^"," ",".","~","!", "*", "'","_", "(", ")", ";", ":", "@","&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
            $s_new_filename = str_replace($entities,"-",$mix_matches[1]);
            $s_new_filename = preg_replace('/[-]{2,}/','-',$s_new_filename);
            
            return mb_strtolower(trim($s_new_filename,'-'),'UTF-8');
            //return (trim($s_new_filename,'-'));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
}

function remove_space($str)
{
	if($str =='')
		return;
	else 
		return strtolower(str_replace(' ', '_', trim($str)));
}

function my_receive($value)
{
    $CI = get_instance();
 	return $CI->db->escape_str(trim($value));
}

function my_receive_like($value)
{
	 $CI = get_instance();
	 return $CI->db->escape_like_str($value);
}

function my_showtext_lebel($value,$width=20)
{
    return htmlspecialchars(wordwrap($value, $width, " ",TRUE));
}

function my_showtext($value)
{
 	return addslashes(htmlspecialchars($value));
}

function now()
{
	$CI	= &get_instance();
	$rslt  =   $CI->db->query("SELECT NOW() AS now")->row_array();
	return $rslt['now'];	
}


function show_priority($p_id)
{
	switch(intval($p_id))
	{
		case 1:
			return "<span class='label label-success'>".addslashes(t('Urgent'))."</span>";
			break;
		case 2: 
			return "<span class='label label-warning'>".addslashes(t('High'))."</span>";
			break;
		case 3: 
			return "<span class='label label-primary'>".addslashes(t('Normal'))."</span>";
			break;
	}
		
	
}




function upload_data_from_file($name,$UploadDir)
{

	$CI = &get_instance();
	$def_val="value not inserted";
	$ext=getExtension($name);
	if($ext == '.xls')
	{
		require_once('excel_reader2.php');
		
		$pathToFile= $UploadDir.$name;
		
		$data = new Spreadsheet_Excel_Reader($pathToFile);
		
		$worksheet = $data->dump_csv($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel');
		
		
		$row =0;
		
		if(!empty($worksheet))
		{
			$number_of_column	=	count($worksheet[0]);
			$all_keys	=	array();	
			
			
			$final_array	=	array();
			
			foreach($worksheet as $key=>$row)
			{
				
				
				for($i=0;$i<$number_of_column;$i++)
				{
					
					$final_array[$key][$i]	=	(base64_decode($row[$i]) == ''? 'value not inserted' : base64_decode($row[$i])) ;
				}	
			}
			
				
		}
		
		//pr($final_array,1);
		
		
		return $final_array;
	}
	elseif($ext == '.csv')
	{
		
		$ret=array();
		$info=fopen($UploadDir.$name, "r");
		
		$i_cnt=0;
		$row =0;
		while (($values = fgetcsv($info)) !== false)
		{
			$ret[]=$values;	
		}
		
	
		return $ret;
	}
	else
	{
		return FALSE;
	}
}


/* below function created by mrinmoy 14Jan 2014 
* @param user_id
* returns user email id
*/

function getUserEmail($user_id='')
{
				
	$CI = & get_instance();
	$s_email = "";	
	if($user_id.'A'!='A')
	{
		$sql = "SELECT s_email FROM {$CI->db->USER} WHERE i_id='".$user_id."'";
		$rs=$CI->db->query($sql);
		$res = $rs->row_array();		
		if($res)
		{
			$s_email = $res["s_email"];		
		}
	}	
	return $s_email;			
}
function add_slashes($str)
{
	return addslashes($str);
}

/* get date format of one type */	
function get_date_required_format($date_time="")
{
	$CI	= &get_instance();
	
	if($date_time!="")
	{
		$date_format = "d-m-Y";
		return date($date_format,strtotime($date_time));
	}
	else
		return false;
}

/* get date format of one type */	
function get_date_time_proper_format($date_time="")
{
	$CI	= &get_instance();
	
	if($date_time!="")
	{
		$date_format = "d-m-Y h:i A";
		return date($date_format,strtotime($date_time));
	}
	else
		return false;
}

function r_path($path = '', $section = 'fe')
{	
	$CI =& get_instance();
	return $CI->config->base_url($uri).'resource/'.$section.'/'.$path;
}

// To generate the navigation path corresponding to array and make it selected
function nav($selected_item = '', $selected_class = '', $items = array())
{
	$CI =& get_instance();
	if(empty($items))
		$items = array('Home','Supplier Auctions', 'Product Auctions', 'Browse Supplier', 'Forum', 'Contact Us');
	$selected_class = $selected_class != '' ? $selected_class : 'active';
	$nav = '<ul>';	
	for($i = 0; $i <count($items); $i++)
	{
		$link = str_replace(' ','-',strtolower($items[$i]));
		$active = str_replace('-','_',$link) == $selected_item ? 'class="'.$selected_class.'"' : '';
		$nav .= '<li><a href="'.$CI->config->base_url($uri).$link.'" '.$active.'>'.$items[$i].'</a></li>';
	}
	$nav .= '</ul>';
	return $nav;
}

function show_text($str = '')
{
	return htmlspecialchars_decode($str);
}

function admin_date($date = '')
{
	if($date == '') return '';
	return date('m/d/Y', strtotime($date));
}
function make_db_date($date = '')
{ 
	if($date == '') return '0000-00-00 00:00:00';
	list($date, $time) = explode(' ', $date);
	list($m, $d, $y) = explode('/', $date);
	return trim($y.'-'.$m.'-'.$d.' '.$time);
}

function footer_testimonial()
{
	$CI =& get_instance();
	$CI->load->model('testimonials_model');
	$tmp = $CI->testimonials_model->fetch_multi(' i_status = 1 ORDER BY i_id DESC',0,1);
	$t['text'] = string_part($tmp[0]['s_description'], 170);
	$t['by'] = $tmp[0]['s_testimonials_by'];
	return $t;
}

function getAddress($address_id = 0)
{
	if(intval($address_id) == 0) return '';
	$CI =& get_instance();
	$CI->load->model('customer_model');
	$tmp = $CI->customer_model->fetch_user_address(" ad.i_id = {$address_id}");
	if($tmp['address_list'][0]['s_address'] != '') $t[] = $tmp['address_list'][0]['s_address'];
	if($tmp['address_list'][0]['s_city'] != '') $t[] = $tmp['address_list'][0]['s_city'];
	if($tmp['address_list'][0]['s_country'] != '') $t[] = $tmp['address_list'][0]['s_country'];
	if($tmp['address_list'][0]['s_post_code'] != '') $t[] = $tmp['address_list'][0]['s_post_code'];
	return @implode(', ',$t);
}

function getCategory($cat_id = 0, $rec = 0, $is_parent = 0, $cat = '')
{
	if(intval($cat_id) > 0)
	{
		$CI =& get_instance();
		$CI->db->select('en_s_category_name,i_parent_id');
		if($is_parent == 1)
			$res = $CI->db->get_where($CI->db->CATEGORY, array('i_parent_id' => $cat_id))->result_array();
		else
			$res = $CI->db->get_where($CI->db->CATEGORY, array('i_id' => $cat_id))->result_array();
		if($rec == 1 && intval($res[0]['i_parent_id']) > 0)
		{
			$cat .= $res[0]['en_s_category_name'].', ';
			$cat .= getCategory($res[0]['i_parent_id'], $rec);
		}
		else
			$cat .= $res[0]['en_s_category_name'];
	}
	return $cat;
}

/*
+-----------------------------------------------+
| Set congfiguration for front end pagination 	|
+-----------------------------------------------+
| Added by JS on 29 Jan 2014					|
+-----------------------------------------------+
*/
function fe_ajax_pagination($ctrl_path = '',$total_rows = 0, $start, $limit = 0, $paging_div = '')
{
	$CI =   &get_instance();
	$CI->load->library('jquery_pagination');
	
	$config['base_url'] 	= $ctrl_path;
	$config['total_rows'] 	= $total_rows;
	$config['per_page'] 	= $limit;
	$config['cur_page'] 	= $start;
	$config['uri_segment'] 	= 0;
	$config['num_links'] 	= 5;
	$config['page_query_string'] = false;	
	$config['full_tag_open'] = '<ul>';
	$config['full_tag_close'] = '</ul>';	
	$config['prev_link'] = '&laquo; ';
	$config['next_link'] = ' &raquo;';
	$config['num_tag_open'] = '';
	$config['num_tag_close'] = '';
	$config['cur_tag_open'] = '<li><a class="select">';
	$config['cur_tag_close'] = '</a></li>';

	$config['next_tag_open'] = '<a class="pagerPre">';
	$config['next_tag_close'] = '</a>';

	$config['prev_tag_open'] = '<a class="pagerPre">';
	$config['prev_tag_close'] = '</a>';
	$config['first_link'] = '';
	$config['last_link'] = '';
	
	$config['div'] = '#'.$paging_div;
	
	$CI->jquery_pagination->initialize($config);
	return $CI->jquery_pagination->create_links();
}


/*
+-------------------------------------------------------+
| Get verification code for front end user registration	|
+-------------------------------------------------------+
| Added by JS on 26 Feb 2014							|
+-------------------------------------------------------+
*/
function genVerificationCode() 
{
	$CI = & get_instance();
	$char = "ABC8D7EF4123497GHIJKL98874KJA798HJHSAS636131MNOPQRS55ASDDFASDFASDFFFASTUVWXYZ23AK465JF4SUYRBJKCJASDYSAF";
	$code = ''; 
	for ($p = 0; $p < 10; $p++) 
		$code .= $char[mt_rand(0, strlen($char))];
	$code .= '-'.time();
	$status = $CI->db->get_where($CI->db->USER, array('s_verification_code'=>$code))->num_rows();
	if($status > 0)
		genVerificationCode();
	else	
		return $code;
}

function fe_date($date =  '', $flag = true)
{
	if(intval($date) == 0) return '';
	return $flag ? date("m/d/Y", strtotime(str_replace('-', '/',$date ))) : date("m-d-Y H:i:s", strtotime($date));
}
function  _price($price = '0', $str = '')
{
	if($price == '') return $str?$str:'0.00';
	else return '&euro;&nbsp;'.number_format($price, 2, '.',',');
}
function get_rendom_code($string = '', $characters = 8)
{
	if(!$string || $string=='')
		$string='123456789ABCDEFGHJKLMNPQRSTUVWXYZ123456789abcdefghijklmnopqrstuvwxyz';
    $code = '';
    $i = 0;
    while ($i < $characters)
    {
    	$code .= substr($string, mt_rand(0, strlen($string)-1), 1);
        $i++;
   	}
    return $code;
}

function get_vat_price($amount = '')
{
	if($amount <= 0) return '';
	$CI = & get_instance();
	$tax_rate = $CI->config->item('tax_rate');
	$ret['price'] = $amount/(1+($tax_rate/100));
	$ret['vat'] = $amount-$ret['price'];
	
	return $ret;	
} 


# ====================================================================================
#           NEW FUNCTIONS - BEGIN
# ====================================================================================

    function get_url_fb($url, $internal_call_count=0)
    {
        //$url = str_replace('access_token=','access_token2=',$url); // for force error testing
        
        log_message('info', basename(__FILE__).' : '.'get_url_fb fetching: '.$url. ' no. of try: '.($internal_call_count+1));

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600); // originally 5 secs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array('Connection: close'));
        $tmp = curl_exec($ch);
        
        $http_ret_code=curl_getinfo($ch, CURLINFO_HTTP_CODE).'';
        
        curl_close($ch);
        
        $zzz=@json_decode($tmp);
        
        if(
            ($http_ret_code!='200') ||
            ($tmp=='') ||
            isset($zzz->error)
        )
        {
            log_message('debug', basename(__FILE__).' : '.'get_url_fb fetching error: '.$tmp.' return status code: '.$http_ret_code.' for url: '.$url);

            $internal_call_count++;
            if($internal_call_count<3)
            {
                sleep(3);
                return get_url_fb($url,$internal_call_count);
            }    
        }
        
        return $tmp;
    }
	
# ====================================================================================
#           NEW FUNCTIONS - END
# ====================================================================================


# ====================================================================================
#           CURRENT PAGE URL
# ====================================================================================
function curPageURL() {
 $pageURL = 'http';
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $pageURL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
 } else {
  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
 }
 return $pageURL;
}

# ====================================================================================
#           CURRENT PAGE URL
# ====================================================================================

function time_ago($assign_time,$current_time='')
{
	try
	{
		if($current_time=='')
		{
			$current_time   =   time();
		}

		$str_left_time      =   '';
		$i_one_month_diff   =   time()-strtotime('-1 month');
		$i_left_time    =   $current_time-$assign_time ;

			if($i_left_time<60)
			{
				$str_left_time  =    ($i_left_time<=1 )?addslashes(t('a second ago')):$i_left_time.addslashes(t(' seconds ago')) ;                   
			}
			else if($i_left_time<3600)
			{
				$i_time         =    floor($i_left_time/60) ;
				$str_left_time  =    ($i_time==1)?addslashes(t('a minute ago')):$i_time.addslashes(t(' minutes ago')) ;
			}
			else if($i_left_time<86400)
			{
				$i_time         =    floor($i_left_time/3600) ;
				$str_left_time  =    ($i_time==1)?addslashes(t('about an hour ago')):$i_time.addslashes(t(' hours ago')) ;    
			}
			else if($i_left_time < $i_one_month_diff)
			{
				$i_time         =    floor($i_left_time/86400) ;
				$str_left_time  =    ($i_time==1)?addslashes(t(' Yesterday')):$i_time.' '.addslashes(t('days ago')) ;
			}
			else
			{
				$str_left_time  =    date('d-m-Y',$assign_time);
			}
		return $str_left_time ;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function get_all_sub_cat_name($sub_cat_ids)
{
	$CI = & get_instance();
	
	$sub_cat_arr	= array();
	
	if(!empty($sub_cat_ids))
	{
		$pos 		= strpos($sub_cat_ids, ',');
		
		if($pos=== false)
		{
			$sub_cat_arr[0]	= $sub_cat_ids;
		}
		else
			$sub_cat_arr	= explode(',',$sub_cat_ids);	
	}
	
	//$sub_cat_arr	= explode(',',$sub_cat_ids);
	
	$all_cat_name	= '';
	
	foreach($sub_cat_arr as $key=>$val)
	{
		$sql	= "SELECT s_label FROM ".$CI->db->CATEGORY." WHERE i_id='".$val."'" ;
		
		$rs		= $CI->db->query($sql);
		$res	= $rs->row_array();
		$all_cat_name.= $res['s_label'].'/';
	}
	
	$all_cat_name	= substr($all_cat_name,0,strlen($all_cat_name)-1);
	
	return $all_cat_name;	
}

function get_category_detail_by_id($sub_cat_ids)
{
	$CI = & get_instance();	
	$CI->load->model('category_model');
	
	$sub_cat_arr	= explode(',',$sub_cat_ids);
	
	$cat_name	= '';
	
	$pcat	=	'';
	$pcat_close	=	'';
	$cat_name_sub	= '';
	
	$i	= 1;
	
	foreach($sub_cat_arr as $key=>$val)
	{	
		$i++;
		$arr		= $CI->category_model->fetch_all_sub_by_parent(' c.i_id="'.$val.'"');
						
		if($arr[0]['i_option_type']==2)
			$cat_name.= '<li>'.$arr[0]['cat'].'</li>';
		else
		{
			if($pcat!=$arr[0]['parent_cat'])
			{	
				$pcat		= $arr[0]['parent_cat'];
					
				if($pcat_close!='' && $pcat != $pcat_close)
					$cat_name.= '</li>';
			
				
				$cat_name.=  '<li>'.$arr[0]['parent_cat'].': <span>'.$arr[0]['cat'].'</span>';
			}
			else
			{
				$cat_name.= '&nbsp;<span>'.$arr[0]['cat'].'</span>';
				$pcat_close	= $arr[0]['parent_cat'];
			}			
		}			
	}	
	
	if(count($sub_cat_arr)== $i)
		$cat_name.= '</li>';
	
	
	return $cat_name;
}

function get_super_user_details_of_user($user_id)
{
	$CI = & get_instance();
	
	$sql	= "SELECT um. i_super_admin_id FROM ".$CI->db->USER_MASTER." AS um
			   WHERE um.i_id='".$user_id."'" ;
			   
	$rs		= $CI->db->query($sql);
	$res	= $rs->row_array();
	
	/*if($res['i_acc_type']==1)
		return $user_id;
	else*/
	return $res;
}

#---------------------------------------------------#
#				FETCH LEFT PANEL MENU  				#
#---------------------------------------------------#

function get_left_menu_items($typeID)
{
	$CI = & get_instance();
	$CI->load->model('left_menu_model');
	$res = $CI->left_menu_model->fetch_all_menus($typeID);
	return $res;
}

function get_left_panel_according_to_user($ID)
{
	$CI = & get_instance();
	$CI->load->model('left_menu_model');
	$res = $CI->left_menu_model->fetch_menus_navigation($ID);
	return $res;
}

# FUNCTION USED IN TEAM MANAGEMENT
function get_left_panel_active_menu($ID, $acc_type)
{
	$CI = & get_instance();
	$CI->load->model('left_menu_model');
	$res = $CI->left_menu_model->fetch_active_menu_option($ID, $acc_type);
	return $res;
}

# FUNCTION TO FETCH FRONTEND LEFT MENU ACCORDING TO USER TYPE
function get_left_panel_menus_according_to_user($ID, $acc_type)
{
	$CI = & get_instance();
	$CI->load->model('left_menu_model');
	$res = $CI->left_menu_model->fetch_all_menus_according_to_user($ID, $acc_type);
	return $res;
}

#PROVIDER
# FUNCTION TO FETCH FRONTEND LEFT MENU ACCORDING TO USER TYPE 
function get_provider_menu_list($ID, $acc_type)
{
	$CI = & get_instance();
	$CI->load->model('left_menu_model');
	$res = $CI->left_menu_model->fetch_provider_menu_list($ID, $acc_type);
	return $res;
}

function _n($n = 1)
{
    $str = '\n'; 
    $n = $n > 1 ? $n : 1;
    for($i = 1; $i <= $n; $i++) $str .= '\t';
    return $str;
}


#---------------------------------------------------#
#				FETCH LEFT PANEL MENU  				#
#---------------------------------------------------#


