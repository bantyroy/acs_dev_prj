<?php
/*********
* Author: Mrinmoy MOndal
* Date  : 08 Nov 2013* 
* Purpose:
*  Controller For Manage admin user
* 
* @package General
* @subpackage Manage admin user
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/site_model.php
* @link views/admin/Manage_admin_user/
*/

class Manage_admin_user extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass, $tbl;   
    public function __construct()
    {            
        try
        {
			parent::__construct();
			$this->data['title']=addslashes(t("Admin User Management"));//Browser Title
			
			//Define Errors Here//
			$this->cls_msg = array();
			$this->cls_msg["no_result"]		= addslashes(t("No information found about admin user."));
			$this->cls_msg["save_err"]		= addslashes(t("Information about admin user failed to save."));
			$this->cls_msg["save_succ"]		= addslashes(t("Information about admin user saved successfully."));
			$this->cls_msg["delete_err"]	= addslashes(t("Information about admin user failed to remove."));
			$this->cls_msg["delete_succ"]	= addslashes(t("Information about admin user removed successfully."));
			
			//end Define Errors Here//
			$this->pathtoclass 			= admin_base_url().$this->router->fetch_class()."/";
			
			//table info
			$this->tbl = $this->db->USER;
			
			// loading default model here //
			$this->load->model("user_login","mod_rect");
			//$this->load->model("customer_model","mod_rect");
			$this->load->model("user_type_model","mod_utype");
			// end loading default model here //
			
			$this->tbl = $this->db->USER;
			
			$this->data['BREADCRUMB']	=	array(addslashes(t('Manage Admin User')));

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }

    public function index()
    {
        try
        {
            redirect($this->pathtoclass."show_list");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/****
    * Display the list of records
    * 
    */
    public function show_list($start=NULL,$limit=NULL)
    {
        try
		{
			$this->data['heading'] = addslashes(t("Manage Admin User"));//Package Name[@package] Panel Heading
			
			$this->session->unset_userdata('last_uri');

			//generating search query//
			$arr_session_data    =    $this->session->userdata("arr_session");
			if($arr_session_data['searching_name'] != $this->data['heading'])
			{
				$this->session->unset_userdata("arr_session");
				$arr_session_data   =   array();
			}
			$search_variable     =    array();
			
			//Getting Posted or session values for search//        
			$s_search 	=(isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			$search_variable["s_customer_name"] = ($this->input->post("h_search")?$this->input->post("s_customer_name"):$arr_session_data["s_customer_name"]);
			//end Getting Posted or session values for search//            
			$s_where = " WHERE n.i_user_type > 2  AND n.i_id != 1 ";
			
			if($s_search=="advanced")
			{
				if($search_variable["s_customer_name"]!="")
				{
					$s_where .= " AND CONCAT(n.s_first_name,' ',n.s_last_name) LIKE '%".add_slashes($search_variable["s_customer_name"])."%' ";
				}
				
				$arr_session    =   array();                
				$arr_session["searching_name"] = $this->data['heading'] ;        
				$arr_session["s_customer_name"] = $search_variable["s_customer_name"] ;
				$this->session->set_userdata("arr_session",$arr_session);
				$this->session->set_userdata("h_search",$s_search);
				$this->data["h_search"] = $s_search;
				$this->data["s_customer_name"] 	= $search_variable["s_customer_name"];                
			}
			else//List all records, **not done
			{
				$s_where=" WHERE n.i_user_type > 2 AND n.i_id != 1";//
				//Releasing search values from session//
				$this->session->unset_userdata("arr_session");
				$this->session->unset_userdata("h_search");
				
				$this->data["h_search"]		= $s_search;
				$this->data["s_customer_name"] 	= "";                            
				//end Storing search values into session//                 
			}
			unset($s_search,$arr_session,$search_variable);
			//Setting Limits, If searched then start from 0//
			if($this->input->post("h_search"))
			{
				$start = 0;
			}
			else
			{
				$start = $this->uri->segment($this->i_uri_seg);
			}
			//end generating search query//
			
			//$this->i_admin_page_limit = 1;
			$limit	= $this->i_admin_page_limit;
			$info	= $this->mod_rect->fetch_multi($s_where, intval($start),$limit);
			
			$this->session->set_userdata('last_uri',$start);
			
			//Creating List view for displaying//
			$table_view=array();  
			
			//Table Headers, with width,alignment//
			$table_view["caption"]				= addslashes(t("Manage Admin User"));
			$table_view["total_rows"]		  	= count($info);
			$table_view["total_db_records"]		= $this->mod_rect->gettotal_info($s_where);
			$table_view["detail_view"]         	= false;  //   to disable show details. 
			$j = 0;
			$table_view["headers"][$j]["width"]		="30%";
			$table_view["headers"][$j]["align"]		="left";
			$table_view["headers"][$j]["val"]		= addslashes(t("Name"));
			
			$table_view["headers"][++$j]["val"]		= addslashes(t("Email"));
			$table_view["headers"][$j]["width"]		= "25%";
			$table_view["headers"][$j]["align"]		= "left";
			
			/*$table_view["headers"][++$j]["val"]		= addslashes(t("User Type"));
			$table_view["headers"][$j]["width"]    	="20%";
			$table_view["headers"][$j]["align"]    	="left";*/
			
			$table_view["headers"][++$j]["val"]		= addslashes(t("Status"));
			$table_view["headers"][$j]["width"]		= "10%";
			$table_view["headers"][$j]["align"]		= "left";
			
			//end Table Headers, with width,alignment//
			
			//Table Data//
			for($i=0; $i<$table_view["total_rows"]; $i++)
			{
				$i_col=0;
				$table_view["tablerows"][$i][$i_col++]	= encrypt($info[$i]["i_id"]);
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_first_name"].' '.$info[$i]["s_last_name"].'<br>(Username: '.$info[$i]["s_user_name"].')';
				$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_email"];
				//$table_view["tablerows"][$i][$i_col++]	= $info[$i]["s_user_type"];
				
				if($info[$i]["i_status"] == 1)				
				{
					$table_view["tablerows"][$i][$i_col++] = '<span class="label label-success" id="status_row_id_'.$info[$i]["i_id"].'">Active</span>';
				}
				else
				{
					$table_view["tablerows"][$i][$i_col++] = '<span class="label label-default" id="status_row_id_'.$info[$i]["i_id"].'">Inactive</span>';
				}
				
				$action ='';
				
				if($info[$i]["i_status"] == 1)
				{
					$action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Inactive" class="glyphicon glyphicon-ok" id="approve_img_id_'.$info[$i]["i_id"].'_inactive" href="javascript:void(0);" rel="make_inactive"></a>';
				}
				else
				{                       
					 $action .='<a data-toggle="tooltip" data-placement="bottom" title="Make Active" class="glyphicon glyphicon-ban-circle" id="approve_img_id_'.$info[$i]["i_id"].'_active" href="javascript:void(0);" rel="make_active"></a>';
				}
				
				if($action!='')
				{
					$table_view["rows_action"][$i] = $action;     
				}
			} 
			//end Table Data//
			unset($i,$i_col,$start,$limit); 
			
			$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);
			//Creating List view for displaying//
			$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
			//echo $this->data["search_action"];
			
			$this->render();          
			unset($table_view,$info);
			
		}
        catch(Exception $err_obj)
        {
        	show_error($err_obj->getMessage());
        }          
    }    

    /***
    * Method to Display and Save New information
    * This have to sections: 
    *  >>Displaying Blank Form for new entry.
    *  >>Saving the new information into DB
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here.
    */
    public function add_information()           
    {
       
        //echo $this->router->fetch_method();exit();
		try
        {
            $this->data['title']		= addslashes(t("Manage Admin User"));//Browser Title
            $this->data['heading']		= (t("Add Information"));
            $this->data['pathtoclass']	= $this->pathtoclass;
			$this->data['BREADCRUMB']	= array(addslashes(t('Add Information')));
			$this->data['mode']			= "add";
           
            if($_POST)
            {
				$posted = array();
                $posted["s_first_name"]	= $this->input->post("txt_first_name", true);
				$posted["s_last_name"] = $this->input->post("txt_last_name", true);
				$posted["s_email"] = $this->input->post("txt_email", true);
				$posted["s_user_name"] = $this->input->post("txt_user_name", true);
				$posted["s_password"] = trim($this->input->post("txt_password"));
				$posted["i_user_type"] = decrypt($this->input->post("opt_user_type", true));
				
				$this->form_validation->set_rules('txt_first_name', addslashes(t('admin user first name')), 'required|xss_clean');
				$this->form_validation->set_rules('txt_last_name', addslashes(t('admin user last name')), 'required|xss_clean');
				$this->form_validation->set_rules('txt_email', addslashes(t('admin user email')), 'required|xss_clean|valid_email|is_unique['.$this->tbl.'.s_email]');
				$this->form_validation->set_rules('txt_password', addslashes(t('admin user password')), 'required|xss_clean|matches[txt_con_password]');
				$this->form_validation->set_rules('txt_user_name', addslashes(t('admin user username')), 'required|xss_clean|is_unique['.$this->tbl.'.s_user_name]');
				
                if($this->form_validation->run() == FALSE)//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
					$info = array();
					$info["s_first_name"]	= $posted['s_first_name'];
					$info["s_last_name"]	= $posted['s_last_name'];
					$info["s_email"]		= $posted['s_email'];
					$info["s_user_name"]	= $posted['s_user_name'];
					$info["s_password"]		= md5(trim($posted["s_password"]).$this->config->item("security_salt"));
					$info["i_user_type"]	= $posted['i_user_type'];
					$info["i_created_by"]	= decrypt($this->admin_loggedin['user_id']);
					$info["dt_created_on"]	= now();
					$info["i_status"]		= 1;
					
					$i_newid = $this->dw_model->add_data($this->tbl,$info);
					
					if($i_newid)//saved successfully
                    {
						set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list");
                    }
                    else//Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                }
            }
            //end Submitted Form//
			
			// Get all the user type
			$this->data['user_type'] = $this->mod_utype->get_all_user_type();
            $this->render("manage_admin_user/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    
    }

    /***
    * Method to Display and Save Updated information
    * This have to sections: 
    *  >>Displaying Values in Form for modifying entry.
    *  >>Saving the new information into DB    
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function modify_information($i_id=0)
    {
        try
        {
			$this->data['title']=addslashes(t("Edit Admin User"));//Browser Title
            $this->data['heading']=addslashes(t("Edit Admin User"));
            $this->data['pathtoclass']=$this->pathtoclass;
			$this->data['BREADCRUMB']	=	array(addslashes(t('Edit Information')));
            $this->data['mode']="edit";	
            
            //Submitted Form//
            if($_POST)
            {
				
				$posted = array();
                $posted["s_first_name"]	= $this->input->post("txt_first_name", true);
				$posted["s_last_name"] = $this->input->post("txt_last_name", true);
				$posted["s_email"] = $this->input->post("txt_email", true);
				$posted["s_user_name"] = $this->input->post("txt_user_name", true);
				$posted["i_user_type"] = decrypt($this->input->post("opt_user_type", true));
				$posted["h_id"]	= $this->input->post("h_id", true);
				
				$this->form_validation->set_rules('txt_first_name', addslashes(t('admin user first name')), 'required|xss_clean');
				$this->form_validation->set_rules('txt_last_name', addslashes(t('admin user last name')), 'required|xss_clean');
				$this->form_validation->set_rules('txt_email', addslashes(t('admin user email')), 'required|xss_clean|valid_email');
				
                if($this->form_validation->run() == FALSE)//invalid
                {					
                    //Display the add form with posted values within it//
                    $this->data["posted"] = $posted;
                }
                else//validated, now save into DB
                {
					$info = array();
					$info["s_first_name"]	= $posted['s_first_name'];
					$info["s_last_name"]	= $posted['s_last_name'];
					$info["s_email"]		= $posted['s_email'];
					$info["s_user_name"]	= $posted['s_user_name'];
					$info["i_user_type"]	= $posted['i_user_type'];
					$info["i_created_by"]	= decrypt($this->admin_loggedin['user_id']);
					$info["i_status"]		= 1;
					
                    $i_aff = $this->dw_model->edit_data($this->tbl,$info,array('i_id'=>decrypt($posted["h_id"])));
                    if($i_aff)//saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."show_list/".$this->session->userdata('last_uri'));

                    }
                    else//Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);
                }
            }
            else
            {	
				$info = $this->mod_rect->fetch_this(decrypt($i_id));
				$posted = $info[0];
                $posted['h_mode'] = $this->data['mode'];
				$posted["h_id"] = $i_id;
                $this->data["posted"] = $posted;       
                unset($info,$posted);      
            }
            //end Submitted Form//
			// Get all the user type
			$this->data['user_type'] = $this->mod_utype->get_all_user_type();
            $this->render("manage_admin_user/add-edit");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    

    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int $i_id, id of the record to be modified.
    */      
    public function remove_information($i_id=0)
    {
        try
        {
			echo $i_id;
			exit;
            $i_ret_=0;
            $pageno=$this->input->post("h_pageno");//the pagination page no, to return at the same page
            
            //Deleting What?//
            $s_del_these=$this->input->post("h_list");
            switch($s_del_these)
			{
				case "all":
							$i_ret_=$this->mod_rect->delete_info(-1);
							break;
				default: 		//Deleting selected,page //
							//First consider the posted ids, if found then take $i_id value//
							$id=(!$i_id?$this->input->post("chk_del"):$i_id);//may be an array of IDs or single id
							if(is_array($id) && !empty($id))//Deleting Multi Records
							{
								//Deleting Information//
								$tot=count($id)-1;
								while($tot>=0)
								{
									$i_ret_=$this->mod_rect->delete_info(decrypt($id[$tot]));
									$tot--;
								}
							}
							elseif($id>0)//Deleting single Records
							{
								$i_ret_=$this->mod_rect->delete_info(decrypt($id));
							}                
							break;
			}
            unset($s_del_these, $id, $tot);
            
            if($i_ret_)
            {
                set_success_msg($this->cls_msg["delete_succ"]);
            }
            else
            {
                set_error_msg($this->cls_msg["delete_err"]);
            }
            redirect($this->pathtoclass."show_list".($pageno?"/".$pageno:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    } 
    
    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function show_detail($i_id=0)
    {
        try
        {
           
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
     /***
    * Checks duplicate value using ajax call
    */
    public function ajax_checkduplicate()
    {
        try
        {
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
	 
	public function ajax_remove_information()
    {
        try
        {
			$i_id = decrypt($this->input->post("temp_id"));
			$i_rect	= $this->mod_rect->delete_info($i_id); /*don't change*/  
			              
			if($i_rect)////saved successfully
			{
				set_success_msg($this->cls_msg['delete_succ']);
				echo "ok";                
			}
			else///Not saved, show the form again
			{
				set_error_msg($this->cls_msg['delete_err']);
				echo "error" ;
			}
			unset($info,$i_rect);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    } 
	 
	public function ajax_change_status()
    {
        try
        {
			$posted["id"] = trim($this->input->post("h_id"));
			$posted["i_status"] = trim($this->input->post("i_status"));
			$info = array();
			$info['i_status'] = $posted["i_status"]  ;
			$i_rect = $this->mod_rect->change_status($info,$posted["id"]); /*don't change*/				
			echo $i_rect? 'ok' : 'error';
			unset($info,$i_rect);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }   

	public function __destruct()
    {}

}