<?php
/*********
* Author: Acumen CS
* Date  : 31 Jan 2014
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Common Model formats 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_login.php
* @link views/admin/dashboard/
*/

class Home extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass;    

    public function __construct()
    {
        try
        {
			parent::__construct();
			//Define Errors Here//
			$this->cls_msg=array();
			
			$this->cls_msg["invalid_login"] = addslashes(t("Invalid user name or password. Please try again."));
			$this->cls_msg["success_login"] = addslashes(t("Successfully logged in."));
			//end Define Errors Here//
			$this->pathtoclass=admin_base_url().$this->router->fetch_class()."/";//for redirecting from this class
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
    /***
    * Login Admin
    * 
    */

    public function index()
    {
        try
        {
			// If a logged in user type the login url then redirect him to the dashboard page.
			$login_status = $this->session->userdata("admin_loggedin");
			if(!empty($login_status))
			{
				redirect(admin_base_url()."dashboard/");
			}
			//Posted login form//

            if($_POST)
            {
                $posted = array();
                $posted["txt_user_name"] = trim($this->input->post("txt_user_name"));
                $posted["txt_password"] = trim($this->input->post("txt_password"));
                $chk_remember = $this->input->post("chk_remember");
                
                $this->form_validation->set_rules('txt_user_name', 'user name', 'required');
                $this->form_validation->set_rules('txt_password', 'password', 'required');
                
                if($this->form_validation->run() == FALSE)//invalid
                {
                    //Display the add form with posted values within it//
                    $this->data["posted"]=$posted;
                }   
                else//validated, now save into DB
                {
                    $this->load->model("User_login","mod_ul");  
                    $info = array();
                    $info["s_user_name"] = $posted["txt_user_name"];
                    $info["s_password"] = $posted["txt_password"];   
				
					// $loggedin=$this->mod_ul->login($info);	
					$loggedin=$this->mod_ul->backend_user_login($info);	
					
                    if(!empty($loggedin))   //saved successfully
                    {
						$mix_data = $this->session->userdata('admin_loggedin');
						if($chk_remember)
						{								
							setcookie('acs_login_username',$info["s_user_name"], time()+(60*60*24*365), '/', '', '');
							setcookie('acs_login_password',$info["s_password"], time()+(60*60*24*365), '/', '', '');
						}
						else
						{
							setcookie('acs_login_username','', time()+(60*60*24*365), '/', '', '');
							setcookie('acs_login_password','', time()+(60*60*24*365), '/', '', '');
						}
						if(decrypt($mix_data['user_type'])!=0)
						{
							set_success_msg(addslashes(t('Thanks for login ! Please change your current password')));	
						}
                        redirect(admin_base_url()."dashboard/");
                    }
                    else//Not saved, show the form again
                    {
                        set_error_msg($this->cls_msg["invalid_login"]);
                        $this->data["posted"]=$posted;
                    }
                }
            }
            //end Posted login form//
            unset($loggedin);
            $this->render("index",true);            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
    /***
    * Logout Admin
    * 
    */

    public function logout()
    {
        try
        { 
            //log report//
            $this->load->model("User_login","mod_ul");
            $logi["msg"]="Logged out as ".$this->data['loggedin']["user_fullname"]
                        ."[".$this->data['loggedin']["user_name"]."] at ".date("Y-M-d H:i:s") ;

            $this->mod_ul->log_info($logi); 
            unset($logi);  
            //end log report//                

            //$this->session->sess_destroy();  
			$this->session->destroy(); 
            redirect(admin_base_url().'home/');
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }  

    /***
    * Tracking Menu clicked
    * 
    */
    public function ajax_menu_track()
    {
        try
        { 
            if($this->input->post("h_menu"))
            {
				//removing the search and session set messages when new page is called//
                $this->session->set_userdata($this->s_search_var,array());
                $array_items = array('success_msg' => '', 'error_msg' => '');
                $this->session->unset_userdata($array_items);
                unset($array_items);                
                //end removing the search and session set messages //
                $this->session->set_userdata("s_menu",$this->input->post("h_menu"));
                echo "done";
            }
            else
            {
                echo "not done";
            }
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    } 

    public function __destruct()
    {}   
}	// end class