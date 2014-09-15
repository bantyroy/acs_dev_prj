<?php
/*********
* Author: koushik
* Date  : 21 June 2013
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Controller For Admin Dashboard. "i_user_type_id"=0 is for super admin
* 
* @package Admin
* @subpackage 
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/dashboard_model.php
* @link views/admin/dashboard/
*/

class Dashboard extends MY_Controller 
{
    public $cls_msg;//////All defined error messages. 
    public $indian_symbol;
	public $user_type;
	public $user_id;
     
    public function __construct()
    {            
        try
        {
			  parent::__construct();
			  ////////Define Errors Here//////
			  $this->cls_msg=array();
	
			  ////////end Define Errors Here//////
			  $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
			  $this->load->model("dashboard_model","mod_rect");
			  $this->load->model("user_model","mod_user");
			  //$this->load->model("task_model","mod_task");
			  $this->load->model("common_model","mod_common");
			 
			 $logged_in 		= 	$this->session->userdata("admin_loggedin");
			 $this->user_type	=	decrypt($logged_in["user_type_id"]);
			 $this->user_id 	= 	decrypt($logged_in["user_id"]);		  
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
			$this->data['BREADCRUMB']	=	array(addslashes(t('Dashboard')));
			
            $this->data['title']        =   addslashes(t("Dashboard"));////Browser Title
            $this->data['heading']      =   addslashes(t("Dashboard of Admin Panel"));
            $admin_loggedin             =   $this->session->userdata('admin_loggedin');            
			
			$s_where = "WHERE i_id!=0 ";
			$this->data["total_users"] = 0;
			
			$s_where = "";
			$this->data["total_tasks"] = 0;			
			
			$s_where = "WHERE i_id>2 AND i_id!=".$this->user_id."";
			$order_name = "i_id";
			$order_by = "DESC";
			$this->data["latest_users"] = $this->mod_user->fetch_multi_sorted_list($s_where,$order_name,$order_by,0,4);			
			
			$s_where= "WHERE i_created_by=".decrypt($admin_loggedin["user_id"])."";
			$order_name = "i_id";
			$order_by = "DESC";
			$this->data["latest_tasks"] = '';	
			
			unset($admin_loggedin);
			$this->render('dashboard/dashboard');  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	    
    }
	
	public function set_menu_session()
	{
		$this->session->unset_userdata('parent_menu_id');
		$this->session->unset_userdata('child_menu_id');
	
		$this->session->set_userdata('parent_menu_id',$this->input->post('parent_id'));
		$this->session->set_userdata('child_menu_id',$this->input->post('child_id'));		
	}	

	public function __destruct()
    {}
}