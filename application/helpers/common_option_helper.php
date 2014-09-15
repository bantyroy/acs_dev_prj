<?php

/*********
* Author: Acumen CS
* Date  : 24 Jan 2014
* Modified By:
* Modified Date:
* Purpose:
*  Custom Helpers 
* Includes all necessary files and common functions
*/

/**
* For selectbox option making
* 
* @param string $s_img_path, $s_new_path, $s_file_name
* @param int $i_new_height, $i_new_width 
* @param mix $configArr
* @return string
*/

function makeOption($mix_value = array(),$s_id = '')
{
    try
	{
		$s_option = '';
		
		if($mix_value)
		{
			foreach ($mix_value as $key=>$txt)
			{
				$s_select = '';
				if(encrypt($key) == $s_id)
					$s_select = " selected ";
				$s_option     .="<option $s_select value='".encrypt($key)."'>$txt</option>";
			}
		}
		
		unset($mix_value, $s_select);
		return $s_option;
		
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


function makeOptionCategory($s_id='')
{
    try
	{
		$CI = & get_instance();		
		$CI->load->model('task_model');
		$info=$CI->task_model->fetch_category();
		$s_option = '';
		
			if($info)
			{
			
				foreach ($info as $res)
				{
					$s_select = '';
					if($res["i_id"] == $s_id)
						$s_select = " selected ";
					$s_option     .="<option $s_select value='".$res["i_id"]."'>".($res[db_field_wrtcl("s_category_name")]==""?$res[db_field_wrtol("s_category_name")] : $res[db_field_wrtcl("s_category_name")])."</option>";
					
				}
			}
		
		unset($info, $s_select);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function makeOptionParentCategory($s_id='',$where='')
{
    try
	{
		$CI = & get_instance();		
		$CI->load->model('category_model');
		$info=$CI->category_model->fetch_multi($where);
		$s_option = '';
		
			if($info)
			{
			
				foreach ($info as $res)
				{
					$s_select = '';
					if($res["i_id"] == $s_id)
						$s_select = " selected ";
					$s_option     .="<option $s_select value='".$res["i_id"]."'>".($res["cat"]==""?$res["cat"] : $res["cat"])."</option>";					
				}
			}
		
		unset($info, $s_select);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function makeOptionWithoutEncryption($mix_value = array(),$s_id = '')
	{
		try
		{
			$s_option = '';
			
			if($mix_value)
			{
				foreach ($mix_value as $key=>$txt)
				{
					$s_select = '';
					if($key==$s_id)
						$s_select = " selected ";
					$s_option     .='<option '.$s_select.' value="'.$key.'">'.$txt.'</option>';				
				}
			}
			
			unset($mix_value, $s_select);
			return $s_option;			
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}



/* dropdown for time 1 am to 12 pm */
 function makeOptionTimetable($s_id)
    {
        try
        {
            $s_option   =   '';
            for($i=1;$i<=24;$i++)
            {
                if($i<12)
                {
                    $str1 =  ' AM ';
                }
				else if($i>23)
				{
					$str1 =  ' AM ';
				}
                else
                {
                    $str1 =  ' PM '; 
                }
                $str    =   '';
                $str    =   str_pad(($i%12==0)?"12":$i%12, 2, "0", STR_PAD_LEFT);
                $str    .=   '.00'.$str1; 
				
				$s_select = '';
				if($i == $s_id)
					$s_select = " selected ";
               
                $s_option   .=   '<option '.$s_select.' value="'.$i.'">'.$str.'</option>';
            }
            //echo '<select><option>Select</option>'.$s_option.'</select>';
            return $s_option;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

 function match_words($s_heystack,$s_search) 
    {
        if( preg_match('#(^|\s)'.$s_search.'($|\s)#', $s_heystack) ) {
         return TRUE;
        }
        else {
         return FALSE;
        }
    }    
    
    
     
  function search_words() {
        $words = $this->_mtmx->getWords();
        //print_r($words);
        return $words;
    }

/**
* Send a array it create a option month and year from current month to next 10 month
*     
* @param mixed $s_id
*/
    
function makeOptionMonthYear($s_id = '')
{
    try
    {
        
        
         /************************ START MONTH ******************/
        $month  =   array(1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',
                        5=>'May',6=>'Jun',7=>'Jul',8=>'Aug',
                        9=>'Sep',10=>'Oct',11=>'Nov',12=>'Dec');
        
        $arr_current    =   explode('-',date('m-Y'));
        
        $i_month    =   (int)$arr_current[0] ;
        $i_year     =   (int)$arr_current[1] ;
        $s_option   =   '';
            for($i=1;$i<=10;$i++)
            {
                $s_select = '';
                $s_value    =   $i_month.'_'.$i_year ;  
                if($s_value == $s_id)
                $s_select = " selected ";
                $s_option   .=   "<option $s_select value='".$s_value."'>".$month[$i_month]."  ".$i_year."</option>";
                
                $i_month++ ;
                if($i_month%13==0)
                {
                    $i_month    =   1;
                    $i_year    +=   1;     
                }
                   
            }
       
        return $s_option;
        
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

function makeOptionNoEncrypt($mix_value = array(),$s_id = '')
{
    try
    {
        $s_option = '';
        
        if($mix_value)
        {
            foreach ($mix_value as $key=>$txt)
            {
                $s_select = '';
                if($key == $s_id)
                    $s_select = " selected ";
                $s_option     .="<option $s_select value='".$key."'>$txt</option>";
                
            }
        }
        
        unset($mix_value, $s_select);
        return $s_option;
        
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

function get_current_lang()
{
	$CI = &get_instance();
	$lang_prefix	= $CI->s_current_lang_prefix;
	
	return $lang_prefix;
}


    


function makeOptionContentType($mix_where = '', $s_id = '')
{
    try
	{
		
		$CI = & get_instance();		
		$CI->load->model('cms_model','mod_cms');	
		$mix_value = $CI->mod_cms->fetch_multi() ;
        
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["s_title"]."</option>";
			}
		}
		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
} 



function makeOptionUserRole($s_id = '')
{
    try
	{
		
		$CI = & get_instance();	
		//$mix_value = $CI->db->USERROLE;		
		
		$s_table = $CI->db->USER_TYPE;
		$s_where = " WHERE id!=1 ";  // not taking sub admin
		$CI->load->model('common_model');
		$mix_value = $CI->common_model->common_fetch_multi($s_table,$s_where);
		
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
				if($val['id'] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val['id']."' >".$val['s_user_type']."</option>";
			}
		}
		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


function makeOptionUserManager($s_id = '',$user_id='')
{
    try
	{
		
		$CI = & get_instance();	
		$CI->load->model('common_model');	
		if($user_id!='')	
			$s_where = " WHERE id!= '".$user_id."' ORDER BY first_name ASC ";
		else
			$s_where = " WHERE id!= 0 ORDER BY first_name ASC ";
			
			
		$mix_value = $CI->common_model->common_fetch_multi($CI->db->EMPLOYEE,$s_where);
	
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
				if($val['id'] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val['id']."' >".$val['first_name'].' '.$val['last_name']."</option>";
			}
		}
		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}



function makeOptionStatus($s_id='')
{
    try
	{
		$CI = & get_instance();		
		$CI->load->model('task_model');
		$info=$CI->task_model->fetch_status();
		$s_option = '';
		
			if($info)
			{
			
				foreach ($info as $res)
				{
					$s_select = '';
					if($res["i_id"] == $s_id)
						$s_select = " selected ";
					$s_option     .="<option $s_select value='".$res["i_id"]."'>".($res["s_status"])."</option>";
					
				}
			}
		
		unset($info, $s_select);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}



function makeOptionUserType($mix_value = array(),$s_id = '')
{
	try
    {
        $s_option = '';
        
        if($mix_value)
        {
			
            foreach ($mix_value as $key=>$txt)
            {
                $s_select = '';
                if($key == $s_id)
				{ // added __ because 0 in the key 
                    $s_select = " selected ";
				}
                $s_option     .="<option $s_select value='".$key."'>$txt</option>";
                
            }
        }
        
        unset($mix_value, $s_select);
        return $s_option;
        
    }
    catch(Exception $err_obj)
    {
        show_error($err_obj->getMessage());
    }
}

function makeOptionAdminUser($s_id='',$user_id='')
{
    try
	{
		
		$CI = & get_instance();	
		$CI->load->model('common_model');	
		if($user_id!='')	
			$s_where = " WHERE i_id!= '".$user_id."' AND i_id!=0 ORDER BY s_first_name ASC ";
		else
			$s_where = " WHERE i_id!= 0 ORDER BY s_first_name ASC ";
			
			
		$mix_value = $CI->common_model->common_fetch_multi($CI->db->USER,$s_where);
	
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $key=>$val)
			{
				$s_select = '';
				if($val['i_id'] == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".$val['i_id']."' >".$val['s_first_name'].' '.$val['s_last_name']."</option>";
			}
		}
		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


/* below functions created on 19 Dec */
function getUserFullName($user_id='')
{
	$CI = & get_instance();	
	$name = '';
	if($user_id.'a'!='a')
	{
		$sql = " SELECT s_first_name,s_last_name FROM ".$CI->db->USER." WHERE i_id = '".intval($user_id)."' ";
		$rs	= $CI->db->query($sql);
		$res = $rs->row_array();
		
		if($res)
		{
			$name .= $res["s_first_name"];
			if($res["s_last_name"]!="")
				$name .= ' '.$res["s_last_name"];
		}
	}
	
	return $name;
}

function getTaskStartDate($task_id='')
{
	$CI = & get_instance();	
	$date = 'N/A';
	if($task_id.'a'!='a')
	{
		$sql = " SELECT dt_created_on FROM ".$CI->db->TASK_MANAGEMENT." WHERE i_task_id = '".intval($task_id)."' ORDER BY i_id DESC ";
		$rs	= $CI->db->query($sql);
		$res = $rs->result_array();
		
		if($res)
		{
			//$date = get_date_required_format($res[0]["dt_created_on"]);
			$date = get_date_time_proper_format($res[0]["dt_created_on"]);
			
		}
	}
	
	return $date;
}

function getOptionCountry($s_id = 0)
{
	$CI =  &get_instance();
	$opt = '';
	$res = $CI->db->select('i_id, s_country')->get_where($CI->db->COUNTRY, array('i_status'=>1))->result_array();
	for($i = 0; $i<count($res); $i++)
	{
		$selected = $s_id == $res[$i]['i_id'] ? 'selected="selected"' : '';
		$opt .= '<option value="'.$res[$i]['i_id'].'" '.$selected.'>'.$res[$i]['s_country'].'</option>';
	}
	unset($CI, $res, $selected);
	return $opt;
}

function getOptionCurrency($s_id = 0)
{
	$CI =  &get_instance();
	$opt = '';
	$res = $CI->db->select('i_id, s_currency')->get_where($CI->db->CURRENCY, array('i_status'=>1))->result_array();
	for($i = 0; $i<count($res); $i++)
	{
		$selected = $s_id == $res[$i]['i_id'] ? 'selected="selected"' : '';
		$opt .= '<option value="'.$res[$i]['i_id'].'" '.$selected.'>'.$res[$i]['s_currency'].'</option>';
	}
	unset($CI, $res, $selected);
	return $opt;
}
//getOptionCategory('', '', '', '1', encrypt($opt_cat),2);
function getOptionCategory($option_results='', $current_cat_id=0, $count=0, $show_child=-1, $selected_cat_id=-1, $depth=-1)
{
	$CI = &get_instance();
	if (!isset($current_cat_id))
		$current_cat_id = 0;
	$prefix = $CI->s_current_lang_prefix.'_';
	$current_cat_id = $current_cat_id == '' ? 0 : $current_cat_id;
	
	$sub_cond   = '';
	$count = $count+1;
	
	$sql = "SELECT i_id, {$prefix}s_category_name 
				FROM ".$CI->db->CATEGORY." 
				WHERE i_parent_id = {$current_cat_id} AND i_status = 1 ORDER BY {$prefix}s_category_name ASC ";
	$get_options_obj = $CI->db->query($sql);
	$get_options_arr = $get_options_obj->result_array();
	
	if(count($get_options_arr))
	{
		foreach($get_options_arr as $key => $value)
		{
			if($current_cat_id != 0)
			{
				$indent_flag = "";
				for ($x = 2; $x <= $count; $x++)
					$indent_flag .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			}
			$cat_name = isset($indent_flag) ? $indent_flag : '';
			$cat_name .= $value[$prefix.'s_category_name'];
			$select = '';
			if($selected_cat_id == encrypt($value['i_id']))
				$select = 'selected="selected"';
			$option_results .= '<option '.$select.' value="'.encrypt($value['i_id']).'">&nbsp;'.$cat_name.'</option>';
			if($show_child > 0 && ($depth <0 ||($depth > 0 && $count <= $depth)))
			{
				$option_results = getOptionCategory($option_results, $value['i_id'], $count, $show_child , $selected_cat_id, $depth);
			}
		}
	}
	return $option_results;	
}

function makeAddressOption($where ='', $s_id = '')
{
	$CI = & get_instance(); $opt = '';
	if($where!='')
		$CI->db->where($where,NULL,FALSE);
	$tmp = $CI->db->select('ab.*, c.s_country')->join($CI->db->COUNTRY.' AS c', 'c.i_id=ab.i_country_id','left')->get($CI->db->ADDRESS_BOOK.' AS ab')->result_array();
	if(count($tmp) > 0)
	{
		for($i = 0; $i < count($tmp); $i++)
		{
			$add = array();
			$selected = $tmp[$i]['i_id'] == $s_id ? 'selected="selected"' : '';
			$add[] = $tmp[$i]['s_company_name'];
			$add[] = $tmp[$i]['s_address'];
			$add[] = $tmp[$i]['s_city'];
			$add[] = $tmp[$i]['s_post_code'];
			$add[] = $tmp[$i]['s_country'];
			$add = !empty($add) ? implode(', ', $add) : '';
			$opt .= "<option {$selected} value=\"{$tmp[$i]['i_id']}\">{$add}</option>";
		}
	}
	return $opt;
}

function makeOptionFaqCategory($s_id='')
{
    try
	{
		$CI = & get_instance();		
		$CI->load->model('faq_model');
		$info=$CI->faq_model->fetch_multi_faq_type();
		$s_option = '';
		
			if($info)
			{			
				foreach ($info as $res)
				{
					$s_select = '';
					if($res["i_id"] == $s_id)
						$s_select = " selected ";
					$s_option     .="<option $s_select value='".$res["i_id"]."'>".($res["s_type_name"]==""?$res["s_type_name"] : $res["s_type_name"])."</option>";
					
				}
			}
		
		unset($info, $s_select);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}


# ===============================================================================
#           NEW FUNCTION DEFINITION(S) - BEGIN
# ===============================================================================

    //// function to create options for "How did you hear about us?" drop-down...
    function make_hear_about_options($s_id='')
    {
        try
        {
            $CI = & get_instance();        
            $info=$CI->config->item('hear_about_arr');
            $s_option = '';
            
            if($info)
            {
                foreach ($info as $key=>$val)
                {
                    $s_select = '';
                    if($key == $s_id)
                        $s_select = " selected ";
                    $s_option .="<option {$s_select} value='{$key}'>{$val}</option>";
                    
                }
            }
        
            unset($info, $s_select);
            
            return $s_option;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

# ===============================================================================
#           NEW FUNCTION DEFINITION(S) - END
# ===============================================================================

	 function make_refer_to_options($s_id='')
    {
        try
        {
            $CI = & get_instance();        
            $info=$CI->config->item('refer_to_arr');
            $s_option = '';
            
            if($info)
            {
                foreach ($info as $key=>$val)
                {
                    $s_select = '';
                    if($key == $s_id)
                        $s_select = " selected ";
                    $s_option .="<option {$s_select} value='{$key}'>{$val}</option>";
                    
                }
            }
        
            unset($info, $s_select);
            
            return $s_option;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }


# ===============================================================================
#           COUNTRY FUNCTION(S) - START
# ===============================================================================
function makeOptionCountry($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		$cond = ' WHERE id !=0';	
		$res = $CI->db->query("select id, name from {$CI->db->ALLCOUNTRY} {$cond} ORDER BY name");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
					
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["name"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
# ===============================================================================
#           COUNTRY FUNCTION(S) - END
# ===============================================================================
	
# ===============================================================================
#           STATE FUNCTION(S) - START
# ===============================================================================
function makeOptionState($mix_where = '', $s_id = '')
{
  	try
	{
		$CI = &get_instance();
		//$cond = ' WHERE id !=0';		
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';
		$res = $CI->db->query("select id, name, country_id from {$CI->db->ALLSTATES} {$cond} ORDER BY name ");	
		
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["name"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
# ===============================================================================
#           STATE FUNCTION(S) - END
# ===============================================================================

# ===============================================================================
#           CITY FUNCTION(S) - START
# ===============================================================================
function makeOptionCity($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		//$cond = ' WHERE id !=0';		
		$cond = (trim($mix_where)) ? "WHERE id!=0 AND ".$mix_where : ' WHERE id!=0';		
		$res = $CI->db->query("select id, name, state_id from {$CI->db->ALLCITY} {$cond} ORDER BY name");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["id"]) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["id"])."' >".$val["name"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}
# ===============================================================================
#           CITY FUNCTION(S) - END
# ===============================================================================

function makeOptionDropdowns($mix_where = '', $s_id = '')
{
    try
	{
		$CI = &get_instance();
		//$cond = ' WHERE id !=0';		
		$cond = (trim($mix_where)) ? "WHERE i_id!=0 AND ".$mix_where : ' WHERE i_id!=0';		
		$res = $CI->db->query("select i_id, s_lable from {$CI->db->MANAGE_DROP_DOWNS} {$cond} ORDER BY s_lable ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(encrypt($val["i_id"]) == $s_id)
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["s_lable"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function makeOptionDropdownsMultiple($mix_where = '', $s_id = array())
{
    try
	{
		$CI = &get_instance();
		//$cond = ' WHERE id !=0';		
		$cond = (trim($mix_where)) ? "WHERE i_id!=0 AND ".$mix_where : ' WHERE i_id!=0';		
		$res = $CI->db->query("select i_id, s_lable from {$CI->db->MANAGE_DROP_DOWNS} {$cond} ORDER BY s_lable ");	
		$mix_value = $res->result_array();
		$s_option = '';
		if($mix_value)
		{
			foreach ($mix_value as $val)
			{
				$s_select = '';
				if(in_array($val['i_id'],$s_id))
					$s_select = " selected ";
				$s_option .= "<option $s_select value='".encrypt($val["i_id"])."' >".$val["s_lable"]."</option>";
			}
		}

		unset($res, $mix_value, $s_select, $mix_where, $s_id);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

function makeOptionDropdown($mix_value = array(),$s_id = '')
{
    try
	{
		$s_option = '';
		
		if($mix_value)
		{
			foreach ($mix_value as $key=>$txt)
			{
				$s_select = '';
				if($key == $s_id)
					$s_select = " selected ";
				$s_option     .="<option $s_select value='".$key."'>$txt</option>";
			}
		}
		unset($mix_value, $s_select);
		return $s_option;
	}
	catch(Exception $err_obj)
	{
		show_error($err_obj->getMessage());
	}
}

