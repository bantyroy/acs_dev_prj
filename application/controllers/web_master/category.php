<?php 

/***

File Name: category.php 
Created By: ACS Dev 
Created On: August 08, 2014 
Purpose: CURD for Category 

*/

class Category extends MY_Controller 
{
	public $patchtoclass, $cls_msg, $tbl;
	public function __construct(){
		parent::__construct();
		$this->data["title"] = addslashes(t('Category'));//Browser Title 
		$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";
		$this->tbl = 'acs_category';// Default Table
		
	}

	//Default method (index)
	public function index()
	{
		redirect($this->pathtoclass.'show_list');
	}

    /****
    * Display the list of records 
    */
    public function show_list($order_by = '', $sort_type = 'desc',$start = NULL, $limit = NULL)
    {
        try
        {
            $this->data['heading'] = addslashes(t("Category")); //Package Name[@package] Panel Heading
            
            //generating search query//
            $arr_session_data = $this->session->userdata("arr_session");
            if($arr_session_data['searching_name'] != $this->data['heading'])
            {
                $this->session->unset_userdata("arr_session");
                $arr_session_data = array();
            }
            
            $search_variable = array();
            //Getting Posted or session values for search//        
            $s_search = (isset($_POST["h_search"])?$this->input->post("h_search"):$this->session->userdata("h_search"));
			$search_variable["s_category"] = ($this->input->post("h_search")?$this->input->post("s_category"):$arr_session_data["s_category"]);
            //end Getting Posted or session values for search//            
            
            $s_where = " n.i_id != 0 ";
            if($s_search == "advanced")
            {
                $arr_session = array();
                $arr_session["searching_name"] = $this->data['heading'];
                
				if($search_variable["s_category"]!="")
				{
					$s_where .= " AND n.s_category LIKE '%".addslashes($search_variable["s_category"])."%' ";
				}
				$arr_session["s_category"] = $search_variable["s_category"];
				$this->data["s_category"] = $search_variable["s_category"];
                $this->session->set_userdata("arr_session",$arr_session);
                $this->session->set_userdata("h_search",$s_search);
                $this->data["h_search"] = $s_search;                            
            }
            else //List all records, **not done
            {
                //Releasing search values from session//
                $this->session->unset_userdata("arr_session");
                $this->session->unset_userdata("h_search");
                
                $this->data["h_search"] = $s_search;
                $this->data["Array"] = ''; 
                //end Storing search values into session//                 
            }
            
            unset($s_search,$arr_session,$search_variable);
              
            //Setting Limits, If searched then start from 0//
            $i_uri_seg = 6;
            $start = $this->input->post("h_search") ? 0 : $this->uri->segment($i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            $arr_sort = array('0'=>'n.s_category', '3'=>'n.s_date');   
            $order_by = !empty($order_by)?in_array(decrypt($order_by),$arr_sort)?decrypt($order_by):$arr_sort[0]:$arr_sort[0];
            
            $limit = $this->i_admin_page_limit;

            $s_where .= " ORDER BY $order_by $sort_type"; 
            $info = $this->acs_model->fetch_data($this->tbl.' AS n', $s_where, '', intval($start), $limit);
            $total = $this->acs_model->count_info($this->tbl.' AS n', $s_where, 'n.');
                  
            //Creating List view for displaying//
            $table_view = array();  
            
            //Table Headers, with width,alignment//
            $table_view["caption"]                 = addslashes(t("Category"));
            $table_view["total_rows"]              = count($info);
            $table_view["total_db_records"]        = $total;
            $table_view["detail_view"]             = false;  // to disable show details. 
            $table_view["order_name"]              = encrypt($order_by);
            $table_view["order_by"]                = $sort_type;
            $table_view["src_action"]              = $this->pathtoclass.$this->router->fetch_method();
            
            $j = -1;
            
			$table_view["headers"][++$j]["width"] = "34%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Category"));
			$table_view["headers"][$j]["sort"] = array('field_name'=>encrypt($arr_sort[0]));
			$table_view["headers"][++$j]["width"] = "34%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Category Description"));
			$table_view["headers"][++$j]["width"] = "34%";
			$table_view["headers"][$j]["align"] = "left";
			$table_view["headers"][$j]["val"] = addslashes(t("Date"));
			$table_view["headers"][$j]["sort"] = array('field_name'=>encrypt($arr_sort[3]));
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for($i = 0; $i< $table_view["total_rows"]; $i++)
            {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["i_id"]);                
                
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_category"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_category_description"];
				$table_view["tablerows"][$i][$i_col++] = $info[$i]["s_date"];
            } 
            //end Table Data//
            unset($i, $i_col, $start, $limit, $s_where); 
            
            //$this->data["table_view"] = $this->admin_showin_table($table_view,TRUE);
            $this->data['total_record'] = $table_view["total_db_records"];
            $this->data["table_view"] = $this->admin_showin_order_table($table_view,TRUE);
            
            //Creating List view for displaying//
            $this->data["search_action"] = $this->pathtoclass.$this->router->fetch_method();//used for search form action
            
            $this->render();          
            unset($table_view, $info);
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
        $this->data['heading'] = (t("Add Information"));
        $this->data['pathtoclass'] = $this->pathtoclass;
        $this->data['BREADCRUMB'] = array(addslashes(t('Add Information')));
        $this->data['mode'] = 'add';
        
        
        if($_POST)
        {
            $posted = array();
            
			$posted["s_category"] = $this->input->post("s_category", true);
			$posted["s_category_description"] = $this->input->post("s_category_description", true);

            if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
            {
                $s_uploaded = get_file_uploaded(FCPATH.'uploaded/category/','s_image','','','jpeg|jpg|png|doc|docx|csv|xls|xlsx|pdf|txt');        
                $arr_upload = explode('|',$s_uploaded);    
            }
            if($arr_upload[0] == 'ok')
                $posted["s_image"] = $arr_upload[2];
            
			$posted["s_date"] = $this->input->post("s_date", true); 
			$this->form_validation->set_rules('s_category', addslashes(t('category')), 'required|xss_clean');
            if($this->form_validation->run() == FALSE /*|| $arr_upload[0]==='err'*/)//invalid
            {
                /*if($arr_upload[0]==='err')
                    set_error_msg($arr_upload[2]);
                else
                    get_file_deleted($this->uploaddir,$arr_upload[2]);
                */
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                
                $i_newid = $this->acs_model->add_data($this->tbl, $posted);
                if($i_newid)//saved successfully
                {
                    /*
                    if($arr_upload[0]==='ok')
                    {
                        get_image_thumb($this->uploaddir.$posted["s_image"], $this->thumbdir, 'thumb_'.$posted["s_image"],$this->thumbHt,$this->thumbWd);
                    }
                    */
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
        
        $this->render("category/add-edit");
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
        $this->data['heading'] = (t("Edit Information"));
        $this->data['pathtoclass'] = $this->pathtoclass;
        $this->data['BREADCRUMB'] = array(addslashes(t('Edit Information')));
        $this->data['mode'] = 'edit';
        
        
        if($_POST)
        {
            $posted = array();
        
			$posted["s_category"] = $this->input->post("s_category", true);
			$posted["s_category_description"] = $this->input->post("s_category_description", true);

            if(isset($_FILES['s_image']) && !empty($_FILES['s_image']['name']))
            {
                $s_uploaded = get_file_uploaded(FCPATH.'uploaded/category/','s_image','','','jpeg|jpg|png|doc|docx|csv|xls|xlsx|pdf|txt');        
                $arr_upload = explode('|',$s_uploaded);    
            }
            if($arr_upload[0] == 'ok')
                $posted["s_image"] = $arr_upload[2];
            
			$posted["s_date"] = $this->input->post("s_date", true);

            $posted["h_id"] = $this->input->post("h_id", true);
			$this->form_validation->set_rules('s_category', addslashes(t('category')), 'required|xss_clean');
            if($this->form_validation->run() == FALSE /*|| $arr_upload[0]==='err'*/)//invalid
            {
                /*if($arr_upload[0]==='err')
                    set_error_msg($arr_upload[2]);
                else
                    get_file_deleted($this->uploaddir,$arr_upload[2]);
                */
                //Display the add form with posted values within it//
                $this->data["posted"] = $posted;
            }
            else//validated, now save into DB
            {
                
                $i_id = decrypt($posted["h_id"]);
                unset($posted["h_id"]);
                $i_aff = $this->acs_model->edit_data($this->tbl,$posted, array('i_id'=>$i_id));
                if($i_aff)//saved successfully
                {
                    /*
                    if($arr_upload[0]==='ok')
                    {
                        get_image_thumb($this->uploaddir.$posted["s_image"], $this->thumbdir, 'thumb_'.$posted["s_image"],$this->thumbHt,$this->thumbWd);
                    }
                    */
                    set_success_msg($this->cls_msg["save_succ"]);
                    redirect($this->pathtoclass."show_list");
                }
                else//Not saved, show the form again
                {
                    set_error_msg($this->cls_msg["save_err"]);
                }
			}
        }//end Submitted Form//
        else
        {
            // Fetch all the data
            $tmp = $this->acs_model->fetch_data($this->tbl,array('i_id'=>decrypt($i_id)));
            $posted = $tmp[0];
            $posted['h_id'] = $i_id;
            $this->data['posted'] = $posted;
            $posted['h_mode'] = $this->data['mode'];
        }
        
        $this->render("category/add-edit");
    }

    /***
    * Shows details of a single record.
    * 
    * @param int $i_id, Primary key
    */
    public function view_detail($i_id = 0)
    {
        try
        {
            if(!empty($i_id))
            {
                $this->data["info"] = $this->acs_model->fetch_data($this->tbl,array('i_id'=>$i_id));
            }
            $this->load->view('web_master/category/show_detail.tpl.php', $this->data); 
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
    public function ajax_remove_information()
    {
        try
        {
            $i_id = decrypt($this->input->post("temp_id"));
            echo $this->acs_model->delete_data($this->tbl, array('i_id'=>$i_id)) ? 'ok' : 'error';
            unset($i_id);
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }

	public function __destruct(){}
}