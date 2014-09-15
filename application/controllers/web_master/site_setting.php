<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 26 June 2013
* Modified By: 
* Modified Date:
* 
* Purpose:
* Controller For Site Setting
* 
* @package Content Management
* @subpackage site_setting
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/site_setting_model.php
* @link views/admin/site_setting/
*/

class Site_setting extends MY_Controller implements InfController
{
    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
   
	
    public function __construct()
    {
            
        try
        {
          parent::__construct();
          ////////Define Errors Here//////
          $this->data['title']=addslashes(t("Admin Site Setting"));////Browser Title

          ////////Define Errors Here//////
          $this->cls_msg = array();
          $this->cls_msg["no_result"]	=	addslashes(t("No information found about admin site setting."));
          $this->cls_msg["save_err"]	=	addslashes(t("Admin site setting failed to save."));
          $this->cls_msg["save_succ"]	=	addslashes(t("Admin site setting saved successfully."));
          $this->cls_msg["delete_err"]	=	addslashes(t("Admin site setting failed to remove."));
          $this->cls_msg["delete_succ"]	=	addslashes(t("Admin site setting removed successfully."));
          ////////end Define Errors Here//////
		  $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
          $this->load->model("site_setting_model","mod_rect");
		  //////// end loading default model here //////////////
		  
		 
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
            $this->data['title']	=	addslashes(t("Admin Site Setting"));////Browser Title
            $this->data['heading']	=	addslashes(t("Admin Site Setting"));
			
            //In case of site setting there no list tpl admin can only edit the data .
            //so modify information function call directly
			$this->modify_information();
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
            $this->data['pathtoclass']	=	$this->pathtoclass;
            $this->data['mode']			=	"edit";
            $this->data['heading']		=	addslashes(t("Admin Site Setting"));
			
			$this->data['BREADCRUMB']	=	array('Site Setting');
            ////////////Submitted Form///////////
            if($_POST)
            {
				$posted=array();
				$posted["h_id"] 									= 	trim($this->input->post("h_id"));
                $posted["txt_admin_email"]          				=   trim($this->input->post("txt_admin_email"));				
                $posted["txt_smtp_host"]            				=   trim($this->input->post("txt_smtp_host"));
                $posted["txt_smtp_password"]        				=   trim($this->input->post("txt_smtp_password"));
                $posted["txt_smtp_userid"]          				=   trim($this->input->post("txt_smtp_userid")); 
				
				$posted["i_records_per_page"]       				=   trim($this->input->post("i_records_per_page"));
				$posted["i_project_posting_approval"]  				=   $this->input->post("i_project_posting_approval");
				$posted["i_banner_speed"]   						=   $this->input->post("i_banner_speed");
				$posted["i_featured_slider_speed"]   				=   $this->input->post("i_featured_slider_speed");
				$posted["i_auto_slide_control"]   					=   $this->input->post("i_auto_slide_control");  
				$posted["i_featured_project_auto_slide_control"]  	=   $this->input->post("i_featured_project_auto_slide_control");       
				$posted["s_facebook_url"]          					=   trim($this->input->post("s_facebook_url"));	
				$posted["s_g_plus_url"]          					=   trim($this->input->post("s_g_plus_url"));	
				$posted["s_linked_in_url"]          				=   trim($this->input->post("s_linked_in_url"));	
				$posted["s_twitter_url"]          					=   trim($this->input->post("s_twitter_url"));	
				$posted["s_rss_feed_url"]          					=   trim($this->input->post("s_rss_feed_url"));	         
               
                $this->form_validation->set_rules('txt_admin_email', addslashes(t('admin email')), 'trim|required|valid_email');  
				$this->form_validation->set_rules('i_records_per_page', addslashes(t('number of records per page')), 'trim|required');             
                /*$this->form_validation->set_rules('txt_smtp_host', 'smtp host', 'required');
                $this->form_validation->set_rules('txt_smtp_password', 'smtp password', 'required');
				$this->form_validation->set_rules('txt_smtp_userid', 'smtp user id', 'required');*/
				
				$info	=	array();
				
                if($this->form_validation->run() == FALSE)/////invalid
                {
                    $this->data["posted"]=$posted;
                }
                else///validated, now save into DB
                {
					$info["s_admin_email"]	  					=   $posted["txt_admin_email"];
                    /*$info["s_smtp_host"]		=   $posted["txt_smtp_host"];
                    $info["s_smtp_password"]	=   $posted["txt_smtp_password"];
                    $info["s_smtp_userid"]	  =   $posted["txt_smtp_userid"];*/
					$info["i_records_per_page"]				 		=   $posted["i_records_per_page"];
					$info["i_project_posting_approval"] 			=   $posted["i_project_posting_approval"];
					$info["i_banner_speed"]   						=   $posted["i_banner_speed"];
					$info["i_featured_slider_speed"]   				=   $posted["i_featured_slider_speed"];
					$info["i_auto_slide_control"]   				=   $posted["i_auto_slide_control"];
					$info["i_featured_project_auto_slide_control"]  =   $posted["i_featured_project_auto_slide_control"];
					
					$info["s_facebook_url"]	  						=   $posted["s_facebook_url"];
					$info["s_g_plus_url"]	  						=   $posted["s_g_plus_url"];
					$info["s_linked_in_url"]	  					=   $posted["s_linked_in_url"];
					$info["s_twitter_url"]	  						=   $posted["s_twitter_url"];
					$info["s_rss_feed_url"]	  						=   $posted["s_rss_feed_url"];
                   
                    $i_aff = $this->mod_rect->edit_info($info,decrypt($posted['h_id']));
					
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
               
				$info=$this->mod_rect->fetch_this("NULL");  // This method id modified by Jagannath Samanta on 24 June 2011
				
                $posted=array();
				
				$posted["i_id"]					 					= 	$info["i_id"];
				$posted["txt_admin_email"]		  					= 	$info["s_admin_email"];				
                $posted["txt_smtp_host"]            				=   $info["s_smtp_host"];
                $posted["txt_smtp_password"]        				=   $info["s_smtp_password"];
                $posted["txt_smtp_userid"]          				=   $info["s_smtp_userid"];
				$posted["i_records_per_page"]       				=   $info["i_records_per_page"];
				$posted["i_project_posting_approval"]   			=   $info["i_project_posting_approval"];
				$posted["i_banner_speed"]   						=   $info["i_banner_speed"];
				$posted["i_featured_slider_speed"]   				=   $info["i_featured_slider_speed"];
				$posted["i_auto_slide_control"]   					=   $info["i_auto_slide_control"];
				$posted["i_featured_project_auto_slide_control"]   	=   $info["i_featured_project_auto_slide_control"];
				
				$posted["s_facebook_url"]		  					= 	$info["s_facebook_url"];		
				$posted["s_g_plus_url"]		  						= 	$info["s_g_plus_url"];		
				$posted["s_linked_in_url"]		  					= 	$info["s_linked_in_url"];		
				$posted["s_twitter_url"]		  					= 	$info["s_twitter_url"];		
				$posted["s_rss_feed_url"]		  					= 	$info["s_rss_feed_url"];		

				$posted["h_id"]										= 	trim(encrypt($info["i_id"]));
				
                $this->data["posted"]								=	$posted;       
                unset($info,$posted);      
                
            }
		  	$this->render('site_setting/site_setting');
          ////Put the select statement here
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
	
	  
    
	public function __destruct()
    {}
}