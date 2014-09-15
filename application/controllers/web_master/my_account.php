<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 03 July 2012
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Admin My_account. "i_user_type_id"=0 is for super admin
* 
* @package General
* @subpackage My account
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/my_account_model.php
* @link views/admin/my_account/
*/

class My_account extends MY_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->cls_msg=array();
          $this->cls_msg["no_result"]	= addslashes(t("No information found about user."));
          $this->cls_msg["save_err"]	= addslashes(t("Information about user failed to save."));
          $this->cls_msg["save_succ"]	= addslashes(t("Information about user saved successfully."));
          $this->cls_msg["delete_err"]	= addslashes(t("Information about user failed to remove."));
          ////////end Define Errors Here//////
		  $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
          $this->load->model("my_account_model","mod_rect");
		  $this->load->model('user_model');
		  $this->load->model("common_model","mod_common");
		  
		  // for employee
		 
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
			
		
			
			$this->data['title']=addslashes(t("My Account"));////Browser Title
			
			// $this->data['admin_loggedin']
            $this->data['heading']=addslashes(t("My Account of Admin Panel"));
			
			
			
			$loggedin = $this->session->userdata('admin_loggedin');
			
			$user_type = decrypt($loggedin["user_type_id"]);
			$user_id = decrypt($loggedin["user_id"]);
		
				//redirect($this->pathtoclass."account_information/".$loggedin["user_id"]);
				
				redirect($this->pathtoclass."modify_information/");
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
    public function show_list()
    {
        try
        {
          
          ////Put the select statement here
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
        try
        {
          
          ////Put the select statement here
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

			$this->data['title']=addslashes(t("My Account"));////Browser Title
			
			$this->data['BREADCRUMB']	=	array(addslashes(t('My Account')));
			
			$loggedin = $this->data['admin_loggedin'];
			if(decrypt($loggedin["user_type_id"])>1)
			{
				$this->data['heading']="My Account of ".$loggedin["user_name"]." ";
			}
			else			
            	$this->data['heading']="My Account of Admin Panel";
			
            $this->data['pathtoclass']=$this->pathtoclass;
           
           
			$mix_data = $this->session->userdata('admin_loggedin');
			
            ////////////Submitted Form///////////
            if($_POST)
            {

				$posted=array();
				$posted["h_id"] 				= $mix_data['user_id'];
				
				$posted["txt_user_name"]		= trim($this->input->post("txt_user_name"));
				$posted["txt_password"]			= trim($this->input->post("txt_password"));
                $posted["txt_new_password"]		= trim($this->input->post("txt_new_password"));
                $posted["txt_confirm_password"]	= trim($this->input->post("txt_confirm_password"));
				$posted["s_avatar"]				= trim($this->input->post("s_avatar"));
				$posted["s_email"]				= trim($this->input->post("s_email"));
				$posted["s_contact_number"]		= trim($this->input->post("s_contact_number"));
				$posted["s_chat_im"]			= trim($this->input->post("s_chat_im"));
              
                $this->form_validation->set_rules('txt_user_name', addslashes(t('Username')), 'required');
				
				if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
				{
					$this->form_validation->set_rules('txt_password', addslashes(t('Old password')), 'required|callback_authentication_check');
					$this->form_validation->set_rules('txt_new_password', addslashes(t('New password')), 'required|matches[txt_confirm_password]');
					$this->form_validation->set_rules('txt_confirm_password', addslashes(t('Confirm password')), 'required');
				}
             
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
				
                else///validated, now save into DB
                {
                    $info	=	array();
					
					
					/*if(decrypt($mix_data['user_id'])==0)*/
					
						$info["s_user_name"]	= $posted["txt_user_name"];
					
						if(!empty($posted["txt_password"]) && !empty($posted["txt_new_password"]))
						{
							$info["s_password"]	=$posted["txt_new_password"];
						}
						//echo '==>'.md5(trim($info["s_password"]).$this->conf["security_salt"]);
						//exit;
						$info["s_avatar"]			=	$posted["s_avatar"];
						$info["s_email"]			=	$posted["s_email"];
						$info["s_contact_number"]	=	$posted["s_contact_number"];
						$info["s_chat_im"]			=	$posted["s_chat_im"];
						
	                    $i_aff = $this->mod_rect->edit_info($info,decrypt($mix_data['user_id']));                    
					
                    if($i_aff)////saved successfully
                    {
                        set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."modify_information");
                    }
                    else///Not saved, show the form again
                    {
                        $this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted);
                    
                }
            }
            else
            {                
				
				$info=$this->mod_rect->fetch_this(decrypt($mix_data['user_id']));
	                
				$posted=array();
				$posted["txt_first_name"]	= trim($info["s_first_name"]);
				$posted["txt_last_name"]	= trim($info["s_last_name"]);
				$posted["txt_user_name"]	= trim($info["s_user_name"]);
				$posted["txt_password"]		= trim($info["s_password"]);
				$posted["s_avatar"]			= trim($info["s_avatar"]);
				$posted["s_email"]			= trim($info["s_email"]);
				$posted["s_contact_number"]	= trim($info["s_contact_number"]);
				$posted["s_chat_im"]		= trim($info["s_chat_im"]);
				
				$posted["h_id"]= trim(encrypt($info["id"]));   
				
                $this->data["posted"]=$posted;       
                unset($info,$posted);      
                
            }
		  	$this->render('my_account/my_account');
          ////Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	
	/*public function authentication_check($pass)
	{
		
		$mix_data = $this->session->userdata('admin_loggedin');
		
					
		if(decrypt($mix_data['user_type_id'])==0)
		{
			$i_res  = $this->mod_rect->auth_pass($pass);
		}
		else
		{			
			//$i_res  = $this->user_model->ckeck_password($pass);
		}
		
		if ($i_res == 0)
		{
			$this->form_validation->set_message('authentication_check', 'You have typed incorrect password! Please type again..');
			return FALSE;
		}
		else
		{
			return TRUE;
		}		
	}
	*/
	/* manage user employee account */
	public function account_information($i_id)
    {
          
        try
        {
            $this->data['title']=addslashes(t("Edit Account Details"));
            $this->data['heading']=addslashes(t("Edit Account"));
            $this->data['pathtoclass']=$this->pathtoclass;
            $loggedin = $this->session->userdata('admin_loggedin');
			
			// check if the user only can edit his information or super admin can do it
			
			
				 redirect($this->pathtoclass);
			
			
			$arr_where = array('i_id'=>decrypt($i_id));
			
			
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
              
				$posted["s_first_name"]	  = trim($this->input->post("s_first_name"));
				$posted["s_last_name"]	   = trim($this->input->post("s_last_name"));
				$posted["s_email"]	 	   = trim($this->input->post("s_email"));
				$posted["s_address"]	 	   = trim($this->input->post("s_address"));
				$posted["s_contact_number"]   = trim($this->input->post("s_contact_number"));
				
                $this->form_validation->set_rules('s_first_name', addslashes(t('first name')), 'required');
				$this->form_validation->set_rules('s_last_name', addslashes(t('last name')), 'required');
				$this->form_validation->set_rules('s_email', addslashes(t('Email')), 'required');
				
				
				
                if($this->form_validation->run() == FALSE)/////invalid
                {
					
                    ////////Display the add form with posted values within it////
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
                    $info	=	array();
					$info["s_first_name"]	=	$posted["s_first_name"];
					
					$info["s_last_name"]	 =	$posted["s_last_name"];
					$info["s_email"]		 =	$posted["s_email"];
					
					$info["s_address"]		 =	$posted["s_address"];
					$info["s_contact_number"]   =	$posted["s_contact_number"];
					
					
					
                    //print_r($info); exit; 
                    //$i_aff=$this->mod_rect->edit_info($info,decrypt($posted["h_id"]));
					
					$user_table = $this->db->USER;
					$arr_where = array('i_id'=>decrypt($posted["h_id"]));
					$i_aff=$this->mod_common->common_edit_info($user_table,$info,$arr_where );
                    if($i_aff)////saved successfully
                    {
						set_success_msg($this->cls_msg["save_succ"]);
                        redirect($this->pathtoclass."account_information/".$i_id);
                    }
                    else///Not saved, show the form again
                    {
                       
						$this->data["posted"]=$posted;
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                    unset($info,$posted, $i_aff);
                    
                }
            }
            else
            {
				$info=$this->user_model->fetch_this(decrypt($i_id));				
                $posted=array();				
				
				//$posted["txt_country"]  = trim($info["s_country"]);
				$posted = $info;
				$posted["h_id"]        = $i_id;
				$posted["i_id"]		= decrypt($i_id);
				
                $this->data["posted"]  = $posted;       
                unset($info,$posted);      
                
            }
            ////////////end Submitted Form///////////
            $this->render("my_account/account-edit");
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
          
          ////Put the select statement here
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

			////Put the select statement here
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }   
	
	 /***
    * Checks duplicate value using ajax call
    */
   /* public function ajax_checkduplicate()
    {
        try
        {
            $posted=array();
            ///is the primary key,used for checking duplicate in edit mode
            $posted["id"]				= decrypt($this->input->post("h_id"));/*don't change
            $posted["duplicate_value"]	= trim($this->input->post("h_duplicate_value"));
			
					
            if($posted["duplicate_value"]!="")
            {
                $qry=" WHERE ".(intval($posted["id"])>0 ? " n.id!=".intval($posted["id"])." And " : "" )
                    ." n.email='".$posted["duplicate_value"]."'" ;
					
					
                //$info=$this->mod_rect->fetch_multi($qry,$start,$limit); /*don't change
				$info=$this->user_model->fetch_multi($qry); /*don't change
				
                if(!empty($info))/////Duplicate eists
                {
                    echo "Duplicate exists";
                }
                else
                {
                    echo "valid";/*don't change
                }
                unset($qry,$info);
            }   
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }   */
    
	public function __destruct()
    {}
}