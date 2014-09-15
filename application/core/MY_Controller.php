<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*********
* Author: Kooushik Rout
* Date  : 24 June 2013
* Modified By: Mrinmoy Mondal
* Modified Date: 19 June 2013
* Purpose:
*  Custom Controller 
*  Common Language conversion template wise
* 
* @include infController.php
*/


//included here so that we can directly implement it into models without inclusion
include_once INFPATH."InfController.php";
include_once INFPATH."InfControllerFe.php";

class MY_Controller extends CI_Controller
{
  
    protected $data = array();
    protected $s_controller_name;
    protected $s_action_name;
	
	public $i_admin_page_limit=10;
    public $i_fe_page_limit = 4;
    public $i_default_language;
    public $s_admin_email;
    public $dt_india_time  = '';    
    public $i_uri_seg;
	public $i_turn_sms=1;  // 1->on and 2->off  from site setting

    /*private $controller_admin=array();*/
	public $admin_datepicker_format = 'mm/dd/yy';
    public $s_default_lang_prefix	=	'en';
    public $s_current_lang_prefix	=	'en';
	public $admin_loggedin = '';
	public $fe_loggedin = '';
	public $is_fe_loggedin = false;
	public $reffer_url = 'home';
	public $tax_rate;
    public $allowedExt = 'jpeg|jpg|png|doc|docx|csv|xls|xlsx|pdf|txt';
	
	
    
    /*****
    *  Failsafe loading parent constructor
    */
    public function __construct()
    {
        try
		{
            parent::__construct();	
		   	header("Cache-Control: no-store, no-cache, must-revalidate");
			header("Pragma: no-cache");
            
			// Set tax rate from the config
			$this->tax_rate = $this->config->item('tax_rate'); 
			
           /* global $CI;
			if(empty($CI))  
				$CI =   get_instance();
            else 
				echo 'Some error occurred';*/
			
			if (preg_match("~index\.php~", $_SERVER['REQUEST_URI'])) {
			    redirect(current_url());
			    exit;
			}
			
            //Assign Selected Menu//
            $this->data['h_menu'] = ($this->session->userdata("s_menu")?$this->session->userdata("s_menu"):"mnu_0");

            //loading session loggedin user data//
            $this->data['fe_loggedin'] = $this->session->userdata("fe_loggedin");		
				//pr($this->data['fe_loggedin']);		
			if(!empty($this->data['fe_loggedin'])) $this->is_fe_loggedin = true;
				  
			$this->data['admin_loggedin'] = $this->admin_loggedin= $this->session->userdata("admin_loggedin");
			
			
			/**************** FRONT END USER PROFILE PIC *****************/
			if(!empty($this->data['fe_loggedin']))
			{
				$this->load->model('common_model');
				
				$this->data['fe_user_details']	= $this->common_model->common_fetch_this($this->db->USER_DETAILS,' WHERE i_user_id='.$this->data['fe_loggedin']['user_id'].'');
			}
			
			/************************************************************/
					
			
			/**************** ADMIN AVATAR *******************************/
			$this->load->model('my_account_model');
			
			$this->data['admin_details']	= $this->my_account_model->fetch_this(decrypt($this->data['admin_loggedin']['user_id']));
			
			$this->data['admin_avatar']	= $this->data['admin_details']['s_avatar'];
						
			/************************************************************/
			
			
			$s_router_directory = $this->router->fetch_directory();
			/****** check admin login to access language section *******/
			if($s_router_directory == "language/")
			{
				if(empty($this->data['admin_loggedin']) || decrypt($this->data['admin_loggedin']['user_type_id'])!=0)
				{					
					redirect(admin_base_url());
				}
			}
			
			if($s_router_directory=="web_master/" && empty($this->data['admin_loggedin']) && $this->router->fetch_class() != 'home')
			{
				redirect(admin_base_url());
			}


            //if no Directory Found then, Set folder "fe" for views only//
		    if($s_router_directory!="" && $s_router_directory!="language/")//For forntend views
			{         		
				//Checking Access Control//
            	$this->chk_access_control();
            	//end Checking Access Control//
            }  
          
            $this->load_defaults();
           
            $this->load->helper('my_language_helper');
            $this->_set_timezone();
            
            $o_ci = &get_config();
            if($this->router->fetch_directory() == '') // for front_end
			{
				$this->i_uri_seg = $o_ci["fe_uri_seg"]; //Number of segments to cutoff for pagination
			}
			else // for admin and others
			{
				$this->i_uri_seg=$o_ci["uri_seg"];//Number of segments to cutoff for pagination
			}				
            
			unset($o_ci);
            
            //Managing Validators//
            $this->load->library('form_validation') ;
        	if($this->router->fetch_directory() == '') // for front_end
			{
				$this->form_validation->set_error_delimiters('<div class="error_message">','</div>');
			}	
			else
			{
				$this->form_validation->set_error_delimiters('<div id="err_msg" class="alert alert-error"><button data-dismiss="alert" class="close" type="button">×</button>', '</div>');	
				$this->form_validation->set_message('required', 'Please provide %s');
				$this->form_validation->set_message('matches', 'Please check fields, %s has not matched');
				$this->form_validation->set_message('is_unique', 'Please check fields, %s value already exist ');
			}
            //end Managing Validators//
			 
			/*=====================  FETCH SITE SETTINGS DETAILS [BEGIN] ======================= */
			    $this->load->model('site_setting_model','mod_site_setting');
			    $info = $this->mod_site_setting->fetch_this("NULL");			
			    $this->s_admin_email  		= $info["s_admin_email"];
			    $this->i_admin_page_limit   = $info['i_records_per_page'];
			    $this->i_turn_sms 			= $info['i_sms'];
			    $this->config->set_item('CONF_EMAIL_ID', $info["s_admin_email"]);
                
                # FB APP & Secret Key from config...
                $_SESSION['fb_app_id'] = $this->config->item('FB_APP_ID'); // FB App ID/API Key
                $_SESSION['fb_app_secret'] = $this->config->item('FB_APP_SECRET'); // FB App Secret
			/*=====================  FETCH SITE SETTING DETAILS [END] ======================= */
						
			/*added by mrinmoy to show error message*/
			if($this->session->userdata('message'))
			{
				$this->message = $this->session->userdata('message');
				$this->session->unset_userdata(array('message' => ''));
			}
	
			if($this->session->userdata('message_type'))
			{
				$this->message_type = $this->session->userdata('message_type');
				$this->session->unset_userdata(array('message_type' => ''));
			}
			
			
			$this->_set_language($this->i_default_language);
			//$this->_set_translations();
			
			$this->i_default_language = 1;
			$this->s_default_lang_prefix;
			$this->s_current_lang_prefix = ($this->session->userdata('current_language')) ? $this->session->userdata('current_language') : $this->site_default_lang_prefix;
            
            # NEW - check if HP [Begin]
                $this->data['home_page'] = FALSE;
            # NEW - check if HP [End]
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
    }
    
    /**
    * Method Format
    * 
    * @param string $s_logmsg
    */
    public function load_defaults()
    {
        try
        {
            
            $this->data['heading'] = 'Page Heading';
            $this->data['content'] = '';
            $this->data['css'] = '';
            $this->data['js'] = '';
            $this->data['php'] = '';
            $this->data['title'] = 'Page Title';

            $this->s_controller_name = $this->router->fetch_directory() . $this->router->fetch_class();
			
			//This line is added by Jagannath Samanta on 22 June 2011 
			//Only for product_image module path. Note don't modify it.
			$this->s_controller_name_pro_img = $this->router->fetch_directory() . "product_image";
			
            $this->s_action_name = $this->router->fetch_method();
            
            //$this->india_time   = time()-19800;
            $this->dt_india_time   = time();
			
            
        }
        catch(Exception $err_obj)
        {
          show_error($err_obj->getMessage());
        }        
    }
	
	/*
	* Set meta realted tags here 
	*/
	public function set_meta()
	{
		try
		{
			
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
    
    /****
    * put your comment there...
    * 
    * @param array $files
    */
    protected function set_include_files($files=array())
    {
        try
        {
            $this->include_files    = $files;
            unset($files);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
        
    }

    /***
    * Rendering default template and others.
    * Default : application/views/admin/controller_name/method_name.tpl.php
    * For Popup window needs to include the main css and jquery exclusively.
    * 
    * @param string $s_template, ex- dashboard/report then looks like application/views/admin/.$s_template.tpl.php
    * @param boolean $b_popup, ex- true if displaying popup, false to render within the main template
    */
    protected function render($s_template='', $b_popup=FALSE)
    {
        try
        {
			$this->set_meta(); // to create dynamic meta tags during rendering the page
		
            $s_view_path = $this->s_controller_name . '/' . $this->s_action_name . '.tpl.php';
			
            
            $s_router_directory=$this->router->fetch_directory();
            //if no Directory Found then, Set folder "fe" for views only//
            if($s_router_directory=="")//For forntend views
            {
                $s_router_directory="fe/";
				$s_view_path=$s_router_directory.$s_view_path;
				
            }
            //end if no Directory Found then, Set folder "fe" for views only//
            if (file_exists(APPPATH . 'views/'.$s_router_directory.$s_template.'.tpl.php'))
            {
			
                $this->data['content'] .= $this->load->view($s_router_directory. '/'.$s_template.'.tpl.php', $this->data, true);
				
            } 
            elseif(file_exists(APPPATH . 'views/'.$s_view_path))
            {
                $this->data['content'] .= $this->load->view($s_view_path, $this->data, true);
            }    
			
            //rendering the Main Tpl//
            if(!$b_popup)//If not opening in popup window
            {  
                $locallang=$this->load->view($s_router_directory . '/'."main.tpl.php", $this->data,TRUE);
                
                //Displaying the converted language//
                echo $this->parse_lang($locallang);
                unset($locallang);
                //end Displaying the converted language//
            }
            else//Rendering for popup window
            {
				//echo 'here';
                echo $this->parse_lang($this->data['content']);
            }
            //end rendering the Main Tpl//
            unset($s_template,$s_view_path,$s_router_directory);    
		
		}
        catch(Exception $err_obj)
        {
          show_error($err_obj->getMessage());
        }         

    }

    /***
    * put your comment there...
    * 
    * @param string $s_filename, ex- css/admin/style.css
    */
    protected function add_css($s_filename)
    {
        try
        {
            $this->data['css'] .= $this->load->view("css.tpl.php", array('filename' => $s_filename), true);
            unset($s_filename);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    /***
    * put your comment there...
    * 
    * @param string $s_filename
    */
    protected function add_php($s_filename)
    {
        try
        {
            $this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            unset($s_filename);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
    /***
    * put your comment there...
    * 
    * @param string $s_filename, ex- js/jquery/jquery-1.4.2.js
    */
    protected function add_js($s_filename)
    {
        try
        {
            $this->data['js'] .= $this->load->view("js.tpl.php", array('filename' => $s_filename), true);
            unset($s_filename);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
    }

    /***
    * put your comment there...
    * 
    */
    public function _set_timezone()
    {
        try
        {
            date_default_timezone_set('Europe/London');    
			header('Content-Type: text/html; charset=utf-8'); 
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    /***
    * Display records in the template table 
    * 
    * @param array $tbldata 
    * $tbldata["headers"][0]["width"]="20%" or "30px"
    *   $tbldata["headers"][0]["align"]="left"
    *   $tbldata["headers"][0]["val"]="Account Name"  
    * 
    * $tbldata["tablerows"][i_row][i_col]=Value
    * $tbldata["tablerows"][i_row][0]=Value of primary key, Col Index 0 must be the encrypted PK
    * 
    * $tbldata["caption"]="Accounts"
    * $tbldata["total_rows"]=200 //used for pagination
    * 
    */
    protected function admin_showin_table($tbldata,$no_action= FALSE)
    {
        try
        {	
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {				
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit);
                                                                   
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($this->i_uri_seg);//current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                //Access control for Insert, Edit, Delete//
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
	 protected function admin_showin_order_table($tbldata,$no_action= FALSE,$i_uri_seg=6)
	 {
        try
        {	
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {
				
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
				if(isset($tbldata['order_name']))
				{
					 $s_pageurl=  $s_pageurl.'/'.$tbldata['order_name'];
					 if(isset($tbldata['order_by']))
					 {
					 	 $s_pageurl=  $s_pageurl.'/'.$tbldata['order_by'];
					 }
					 
				}
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit,$i_uri_seg);
														   
                                                                   
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($i_uri_seg);//current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                //Access control for Insert, Edit, Delete//
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
	}      
    
	
    /***
    * $rq_url is the redirect pagination url ex. http://localhost/tamanna/php/admin/user/user_list.
    * $total_no is the total number of records in database. 
    * $per_page is the number of records shown in page.
    * $uri_seg to be changed in live.
    */
    public function get_admin_pagination_old($s_rq_url, $i_total_no, $i_per_page=10, $i_uri_seg=NULL)
    {
        try
        {
			$this->load->library('pagination');
			
			$org_enable_query_strings = $this->config->item('enable_query_strings');
			$this->config->set_item('enable_query_strings',FALSE);
			
			
            $config['base_url'] = $s_rq_url;

            $config['total_rows'] = $i_total_no;
            $config['per_page'] = $i_per_page;

            $config['uri_segment'] = ($i_uri_seg?$i_uri_seg:$this->i_uri_seg);

            $config['num_links'] = 2;
            $config['page_query_string'] = false;
			
			
			$config['first_link'] = '&lsaquo;'.addslashes(t('First'));
            $config['last_link'] = addslashes(t('Last')).' &rsaquo;';

            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
			
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            //$config['prev_tag_open'] = '<li class="previous-off">';
			$config['prev_tag_open'] = '<li class="previous">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo;'.addslashes(t('Previous'));
            $config['next_link'] = addslashes(t('Next')).'&raquo;';
			
			

            $config['cur_tag_open'] = ' <li class="active">';
            $config['cur_tag_close'] = '</li>';
			//pr($config);
            $this->pagination->initialize($config);
            unset($s_rq_url,$i_total_no,$i_per_page,$i_uri_seg,$config);
            
			$return  = $this->pagination->create_links();
			$this->config->set_item('enable_query_strings',$org_enable_query_strings);
			return $return;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }       
	
	public function get_admin_pagination($s_rq_url, $i_total_no, $i_per_page=10, $i_uri_seg=NULL)
    {
        try
        {
			$this->load->library('pagination');
			
			$org_enable_query_strings = $this->config->item('enable_query_strings');
			$this->config->set_item('enable_query_strings',FALSE);
			
			
            $config['base_url'] = $s_rq_url;

            $config['total_rows'] = $i_total_no;
            $config['per_page'] = $i_per_page;

            $config['uri_segment'] = ($i_uri_seg?$i_uri_seg:$this->i_uri_seg);

            $config['num_links'] = 2;
            $config['page_query_string'] = false;
			
			
			$config['first_link'] = '&lsaquo;'.addslashes(t('First'));
            $config['last_link'] = addslashes(t('Last')).' &rsaquo;';

            $config['first_tag_open'] = '<li>';
            $config['first_tag_close'] = '</li>';
            $config['last_tag_open'] = '<li>';
            $config['last_tag_close'] = '</li>';
			
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            //$config['prev_tag_open'] = '<li class="previous-off">';
			$config['prev_tag_open'] = '<li class="prev">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo;'.addslashes(t("Previous"));
            $config['next_link'] = addslashes(t('Next')).'&raquo;';
			
			

            $config['cur_tag_open'] = ' <li class="active"><a href="javascript:void(0);">';
            $config['cur_tag_close'] = '</a></li>';
			//pr($config);
            $this->pagination->initialize($config);
            unset($s_rq_url,$i_total_no,$i_per_page,$i_uri_seg,$config);
            
			$return  = $this->pagination->create_links();
			$this->config->set_item('enable_query_strings',$org_enable_query_strings);
			return $return;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }  
    
	/* function require for extra parameter along with $start and $limit */
    protected function admin_showin_param_table($tbldata,$no_action= FALSE)
    {
        try
        {	
			//var_dump($tbldata);exit;
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {
				
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.$tbldata['param_type'];
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit);
                                                                   
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($this->i_uri_seg);//current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                //Access control for Insert, Edit, Delete//
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }	
	
	
	
	
	
	
	
     /***
    * $rq_url is the redirect pagination url ex. http://localhost/tamanna/php/fe/news.html 
    * $total_no is the total number of records in database. 
    * $per_page is the number of records shown in page.
    * $uri_seg to be changed in live.
    */
 	public function get_fe_pagination($s_rq_url, $i_total_no, $i_per_page = NULL, $i_uri_seg=NULL)
    {
        try
        {
            
			$this->load->library('pagination');
			//$s_rq_url= base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
			
            $config['base_url'] = $s_rq_url;

            $config['total_rows'] = $i_total_no;
            $config['per_page'] = ($i_per_page?$i_per_page:$this->i_fe_page_limit) ;
            $config['uri_segment'] = ($i_uri_seg?$i_uri_seg:$this->i_uri_seg);

            $config['num_links'] = 2;
            $config['page_query_string'] = false;

            //$config['first_tag_open'] = '<a>';
            //$config['first_tag_close'] = '</a>';
            //$config['last_tag_open'] = '<a>';
            //$config['last_tag_close'] = '</a>';
			/***sh***
            $config['num_tag_open'] = '<li>';
            $config['num_tag_close'] = '</li>';
            $config['next_tag_open'] = '<li class="next">';
            $config['next_tag_close'] = '</li>';
            $config['prev_tag_open'] = '<li class="previous-off">';
            $config['prev_tag_close'] = '</li>';
            $config['prev_link'] = '&laquo;Previous';
            $config['next_link'] = 'Next&raquo;';

            $config['cur_tag_open'] = ' <li class="active">';
            $config['cur_tag_close'] = '</li>';
			
			***/
	
            $config['prev_link'] = '###FE_PAGE_PREVIOUS###';
            $config['next_link'] = '###FE_PAGE_NEXT###';

			$config['cur_tag_open'] = '<a class="active">';
            $config['cur_tag_close'] = '</a>';
						

            $this->pagination->initialize($config);
            unset($s_rq_url,$i_total_no,$i_per_page,$i_uri_seg,$config);
            return $this->pagination->create_links();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }        
	
	
	
	
    /***
    * Language translation Done Here.
    * In the template all markers like ###LBL_CITY### will be translated into language.
    * If no conversation is found the marker will display like ###LBL_CITY###.
    * Markers in the template must be in uppercase.
    * 
    * @param $raw_content string, 
    * @return string of translated language
    */
    protected function parse_lang($s_raw_content)
    {
        try
        {
            $lng=array();
            $s_locallang=$s_raw_content;
			
            if(SITE_FOR_LIVE)
            {
				$dir	=  ($this->i_default_language==1)?'en':'ar';
                $lng	=	$this->lang->load('common', $dir,TRUE);
            }
            else
            {
                $lng	=	$this->lang->load('common', 'english',TRUE);
            }

            //$this->lang->line('be_invalid_connection_str')
            if(!empty($lng))
            {
                /***
                * ex- in the raw content the language key must be used like :-  ###LBL_CITY###
                */
                foreach($lng as $s_lng_key=>$s_lng_content)
                {
                    $s_locallang	=	str_replace("###".strtoupper($s_lng_key)."###",$s_lng_content,$s_locallang);
                }//end for
            }
            unset($s_raw_content,$lng);
            return $s_locallang;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }   
    }    
	
	protected function _set_translations() {
		$ci = get_instance();
		//$this->load->helper('my_language_helper');
		$this->data['current_language'] = get_current_language();
	
		if( is_readable(BASEPATH.'../'.$ci->config->item('multilanguage_object')) ) {
			$this->translation_container = unserialize(BASEPATH.'../'.$ci->config->item('multilanguage_object'));
		}
		else if( is_readable(BASEPATH.'../'.$ci->config->item('multilanguage_xml')) ) {
			$ci->load->library('multilanguage/TMXParser');
			$ci->tmxparser->setXML(BASEPATH.'../'.$ci->config->item('multilanguage_xml'));
			$ci->tmxparser->setMasterLanguage($ci->config->item('master_language'));
			$tc = $ci->tmxparser->doParse();
	
			$this->translation_container = $tc;
			
		} 
		
	}

	public function get_translations() {
		return $this->translation_container;
	}

	protected function _set_language($lang_id) {
            $this->load->helper('cookie');
          
            $user_pref_lang_default = $this->config->item('default_language');
        
            $user_pref_lang_cookie = $this->input->cookie('seu_lang', TRUE);
            $user_pref_lang_session = $this->session->userdata('current_language');
            
           
            if(trim($user_pref_lang_cookie)==""){
                 
               if(trim($user_pref_lang_session)==""){
                    /*default it is asper config*/
                   $user_pref_lang = $user_pref_lang_default;
               } else {
                   /*setting it is as per session*/
                    $user_pref_lang = $user_pref_lang_session;
               }
                
            } else {
                 /*setting it is as per cookie*/
                $user_pref_lang = $user_pref_lang_cookie;
            }
            
            $this->session->set_userdata('current_language', $user_pref_lang);           
	}	
	
	
    /***
    * Access checking based on user type Done Here.User type fetched from session
    */
	public function chk_access_control()
	{
        try
        {
			//echo $this->uri->uri_string();
			
			$this->load->model("Permission_model","mod_permit");
            $can_access = $this->mod_permit->can_user_access(
																decrypt($this->data['admin_loggedin']["user_type_id"]),
																$this->uri->uri_string()
														   );
			
			/*if(decrypt($this->data['admin_loggedin']["user_type_id"])!=0)
			{
				$can_access	= true;
			}*/
			                           
			if(!$can_access)
			{
				throw new Exception('Public Access Restricted. <a href="'.admin_base_url()."home/".'">Please login.</a>');
			}
			else
			{
				/*echo $this->uri->rsegment(1);
				pr($this->data['admin_loggedin'],1);*/
				
				//checking admin login//
				$allow = array('home', 'forgot_password','send_logged_email');
				
				if(empty($this->data['admin_loggedin']) && !in_array($this->uri->rsegment(1),$allow))
				{
					redirect(admin_base_url());
					return false; 
				}
			}
			
			//now fetching controls within the page.
			// ex. add button, edit button, delete button, etc.
            /**
            * When routes.php is used to re route some controllers.
            * Used to display in menus and access control, but in physical 
            * the controller doesnot exists. It simply redirects to other controller.
            * ex- New_customer_life_insurance controller doesnot exists, 
            *     It is redirected to Customer controller in routes.php  
            */
            $pre_route_controller=$this->uri->segment(2);
            $post_route_controller=$this->uri->rsegment(1);
            
			/*if($pre_route_controller!=$post_route_controller && $pre_route_controller!="")//re-routed
            {
                $load_controller=ucfirst($pre_route_controller);//donot delete this
            }
            else//Not re-routed
            {
                $load_controller=ucfirst($this->router->fetch_class());//donot delete this
            }
            unset($pre_route_controller,$post_route_controller);
			*/			
			
			
			$this->data["action_allowed"] = $this->mod_permit->fetching_access_control(
												array(
													"i_user_type_id"=>decrypt($this->data['admin_loggedin']["user_type_id"]),
													"controller"=>$pre_route_controller,
													"alias_controller"=>$post_route_controller
												));
			//pr($this->data["action_allowed"],1);
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }             
	}
	
	
	
	/** To store search data for jobs **/
    protected function get_session_data($key,$tmpArr=array())
    {
        $arr    = $this->session->userdata('model_session');
        if(isset($arr[$key]))
            return $arr[$key];
        elseif(isset($tmpArr[$key]))
            return $tmpArr[$key];
        else
            return '';
    }
	
	/**** admin report*/
    protected function admin_report_showin_table($tbldata,$no_action= FALSE,$i_uri_seg=6)
    {
        try
        {	
			//echo $this->i_uri_seg;exit;
            //$this->data['php'] .= $this->load->view("php.tpl.php", array('filename' => $s_filename), true);
            $s_ret_="";
            if(!empty($tbldata))
            {
                $s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name.'/'.$tbldata['order_name'].'/'.$tbldata['order_by'];
				//$s_pageurl= admin_base_url().$this->router->fetch_class() . '/' . $this->s_action_name;
				//echo $s_pageurl; exit;
                $tbldata["pagination"]=$this->get_admin_pagination($s_pageurl, 
                                                                   $tbldata["total_db_records"],
                                                                   $this->i_admin_page_limit,
																   $i_uri_seg);
                 //var_dump($tbldata["pagination"]);                                                  
                $tbldata["s_controller_name"]=admin_base_url().$this->router->fetch_class() . '/';
				
				//This line is added by Jagannath Samanta on 22 June 2011 
				//Only for product_image module path. Note don't modify it.
				//$tbldata["s_controller_name_pro_img"]=admin_base_url()."product_image". '/';
				
                $tbldata["i_pageno"]=$this->uri->segment($this->i_uri_seg);//current page number
				$tbldata['no_action'] = $no_action;
                //pr($tbldata);exit;
				
                //Access control for Insert, Edit, Delete//
                $tbldata["action_allowed"]=$this->data["action_allowed"];
				
                $s_ret_=$this->load->view($this->router->fetch_directory() . '/'."list.tpl.php",$tbldata,TRUE);
            }
            unset($tbldata,$s_pageurl);
            return $s_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }	
	
	public function _login_check($url = '')
	{
		try
		{
			if($this->data['fe_loggedin']) return true;
			if($url != '') $this->session->set_userdata('REFERER_URL', $url);
			redirect('home');// login
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessage());
		}
	}
	
	public function _set_current_url()
	{
		$this->session->set_userdata('REFERER_URL', current_url());
	}
	
	# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    #           NEW FUNCTION FOR 'CHECK LOGIN' - [BEGIN]
    # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
        
	 public function _check_login($store_url_session = TRUE) 
        {
             try{
                
                if($this->session->userdata('fe_loggedin')=='' || $this->session->userdata('fe_loggedin')==false )
                {
                 
                    $url = curPageURL();
        
                    if($store_url_session == TRUE) {
                        // Not an ajax request
                        if(empty($_SERVER['HTTP_X_REQUESTED_WITH']) || strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') 
						{
                            $this->session->set_userdata('session_referrer', $url);
                        }
                    }
                                        
                    if($this->session->userdata('fe_loggedin')=='' || $this->session->userdata('fe_loggedin')==false)
                         echo "<script>window.location='". base_url() ."'+window.location.hash</script>";
                    else
                         header("location:".base_url());     
                    
                    exit;
                }
                else 
                   {
                    
                        $this->session->unset_userdata('session_referrer');
                   }
            }
            catch(Exception $err_obj)
            {
                show_error($err_obj->getMessage());
            } 
        }
	
	# ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    #           NEW FUNCTION FOR 'CHECK LOGIN' - [BEGIN]
    # ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
	
	#--------------- To check the customer user -----------------
	
	 public function _check_customer($store_url_session = TRUE) 
     {
         try{
		 		if($this->session->userdata('fe_loggedin')!='' || $this->session->userdata('fe_loggedin')==true )
                {
					$i_role	= $this->data['fe_loggedin']['i_role'];		
					
					if($i_role==1)		
						return true;
					else
					{
						header("location:".base_url());                    
                    	exit;
					}							
				}
		 }
		 catch(Exception $err_obj)
		 {
			show_error($err_obj->getMessage());
		 }
	 }
	 
	 public function _check_provider($store_url_session = TRUE) 
     {
         try{
		 		if($this->session->userdata('fe_loggedin')!='' || $this->session->userdata('fe_loggedin')==true )
                {
					$i_role	= $this->data['fe_loggedin']['i_role'];		
					
					if($i_role==2)		
						return true;
					else
					{
						header("location:".base_url());                    
                    	exit;
					}							
				}
		 }
		 catch(Exception $err_obj)
		 {
			show_error($err_obj->getMessage());
		 }
	 }
			
    public function __destruct()
    {}
    
}
//end of class

