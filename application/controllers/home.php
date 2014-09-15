<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 23 dec 2013
* Modified By: 
* Modified Date: 
* 
* @includes My_Controller.php
* @implements InfControllerFe.php
*/

class Home extends MY_Controller
{

    public $cls_msg;//////All defined error messages. 
    public $pathtoclass;
    
    # constructor definition...
    public function __construct()
    {
        try
        { 
          
		  parent::__construct(); 
          $this->data['title'] = "iSubTech - Home"; ////Browser Title
		  $this->data['ctrlr'] = "home";
		  
		  $this->cls_msg["subcribe_succ"] 			= addslashes(t("Newletter subscribed successfully"));
		  $this->cls_msg["subcribe_err"] 			= addslashes(t("Newletter not subscribed successfully"));
		  $this->cls_msg["subcribe_duplicate_err"]	= addslashes(t("Email address already subscribed."));
          		
		  $this->load->model('user_master_model','mod_user'); 
		  $this->load->model('cms_model','mod_cms');
		  $this->load->model("jobs_model","mod_job");     
		  
		  $this->thumbDisplayPath = $this->config->item('banner_image_diaplay_path');     
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    
    # index function definition...
    public function index()
    {
        try
        {	
			$this->data['home_page'] = TRUE;
			
			$info = $this->mod_site_setting->fetch_this("NULL");
			
			if($info['i_auto_slide_control'])
				$this->data['banner_auto_slide']	= 1;
			else
				$this->data['banner_auto_slide']	= 0;
				
			$this->data['banner_slider_speed']		= $info['i_banner_speed'];
			
			$this->load->model('banner_model');
			
			$s_where	= ' WHERE n.i_status=1';
			
			$this->data['slider_banners']			= $this->banner_model->fetch_multi($s_where);
			
			$this->data['display_path']				= $this->thumbDisplayPath;
			
			$this->data['for_customer']				= $this->mod_cms->fetch_multi(" s_key='home_page_for_customer' ");
			$this->data['for_provider']				= $this->mod_cms->fetch_multi(" s_key='home_page_for_provider' ");
			$this->data['nutshell']					= $this->mod_cms->fetch_multi(" s_key='nutshell' ");
			$this->data['have_a_project']			= $this->mod_cms->fetch_multi(" s_key='have_a_project' ");
			
			/*** FOR TESTIMONIALS ***/
			$this->load->model('testimonials_model','mod_rect');
			
			$s_where = " WHERE n.i_status=1 AND n.i_type=0";			
			$this->data['customer_testimonial_list'] 	= $this->mod_rect->fetch_multi($s_where, intval($start), 10); 
			
			/*** FOR FEATURED PROJECTS STARTS ***/
			
			//PROPERTIES
			if($info['i_featured_project_auto_slide_control'])
				$this->data['featured_auto_slide']	= 1;
			else
				$this->data['featured_auto_slide']	= 0;
				
			$this->data['featured_slider_speed']	= $info['i_featured_slider_speed'];			
			
			
			$this->load->model("jobs_model","mod_job");
			$s_where 	= ' WHERE  n.i_is_deleted=0 AND n.i_is_featured=1 AND n.i_status=1';
			$this->data['featured_proj_list']	= $this->mod_job->fetch_featured_proj_list($s_where,0, 5, ' ORDER BY dt_posted_date DESC');
			//PROPERTIES
			/*** FOR FEATURED PROJECTS ENDS ***/
			
			/***** Active Provider Count ******/
			
			$this->data['active_providers']	= $this->mod_user->gettotal_info(' WHERE i_role=2 AND i_is_active=1');
			
			# loading view part...            
			$this->render();
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	/*
	+-------------------------------------------------------+
	| Function Name : Join mailing list 					|
	+-------------------------------------------------------+
	| @params null											|
	+-------------------------------------------------------+
	| @returns status message								|
	+-------------------------------------------------------+
	| Added by 			|
	+-------------------------------------------------------+
	*/
	public function join_mailing_list()
	{
		try
		{
			if($_POST)
			{
				$this->load->model("newsletter_subscribers_model", "mod_ns");
				$email_pattern = '/^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/';
				$valid = TRUE;
				
				$info = array();
				
				$info["s_email"] 		= trim($this->input->post("txt_email"));
				
				if(isset($_SESSION['user_role']) && !empty($_SESSION['user_role']))
					$info["i_user_type"] 	= $_SESSION['user_role'];
				else
					$info["i_user_type"] 	= 5;
				$info["dt_entry_date"] 	= time();
				
				// Validation
				if( !preg_match($email_pattern, $info["s_email"]))
				{
					echo "err*Please provid valid email address.";
					$valid = FALSE;
				}
				
				if($valid)
				{
					// Check existence
					$where = " WHERE n.s_email = '".$info["s_email"]."' AND n.i_del_status = 1 ";
					$existence = $this->mod_ns->gettotal_info($where);
					if($existence <= 0)
					{
						// Insert to database
						$status = $this->mod_ns->insert_info($info);
						if($status)
						{
							echo "succ*".$this->cls_msg["subcribe_succ"];
						}
						else
						{
							echo "err*".$this->cls_msg["subcribe_err"];	
						}
					}
					else
					{
						echo "exist*".$this->cls_msg["subcribe_duplicate_err"];	
					}
				}
				
			}
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
	
	public function message()
	{
		$this->data['breadcrumb'] = array('Message'=>'');
		$this->render('home/message');
	}	
	
	public function logout()
    {
        try
        { 
            $this->session->destroy();  
            redirect(base_url().'home/');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   

    }
	
    public function __destruct()
    {}          

}

/* End of file home.php */

