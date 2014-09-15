<?php

/*********
* Author: Acumen CS
* Date  : 8 Apr 2014 
* Purpose:
*  Controller For Employee list
* 
* @package General
* @subpackage Supplier list
* 
* @link InfController.php 
* @link My_Controller.php
* @link model/user_model.php
* @link views/admin/Employee_list/
*/

class Generate_mvc extends MY_Controller
{
    public $cls_msg;//All defined error messages. 
    public $pathtoclass, $tbl;   
    protected $field_type = 'text', $field_label, $required = false, $enum_drop_down = array(), $folder_name, $file_name,
     $mvc_title, $controller_path, $model_path, $view_path, $admin_folder_name = 'web_master/', $con_form_validation, $vw_form_validation, $search_field_added = false, $reference_field = false, $reference_table = '';
    
    public function __construct()
    {            
        try
        {
			parent::__construct();

			$this->data['title']			= addslashes(t("Generate MVC"));//Browser Title			

			//Define Errors Here//

			$this->cls_msg = array();

			$this->cls_msg["no_result"]		= get_message('no_result');
			$this->cls_msg["save_err"]		= get_message('save_failed');
			$this->cls_msg["save_succ"]		= get_message('save_success');
			$this->cls_msg["delete_err"]	= get_message('del_failed');
			$this->cls_msg["delete_succ"]	= get_message('del_success');
			//end Define Errors Here//			

			$this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";			
            $this->load->helper('basic_text_template');
			$this->data['BREADCRUMB'] = array(addslashes(t('Generate MVC Depending on Database Table')));
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
            redirect($this->pathtoclass."generate");
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  

    }	
    
    public function generate()
    {
        try
        {
            // Get the database array 
            require(APPPATH.'config/database.php');
            $existing_tables = array_slice($db['default'], 16);
            
            //$my_file = FCPATH.'application/config/database.php';
            //$handle = fopen($my_file, 'a');
            
            /*if ($handle) {
                $i = 1;
                while (($buffer = fgets($handle, 4096)) !== false) {
                    echo '<pre>'.$i++.$buffer.'</pre>';
                }
                if (!feof($handle)) {
                    echo "Error: unexpected fgets() fail\n";
                }
                fclose($handle);
            }*/
            //$filecontents = fgets($handle, 4096);
            
            //fseek($handle, 100);
            //fwrite($handle, "echo \"Yeah!\";\n");
            //fclose($handle);
            
            //$data = fread($handle, filesize($my_file));
            //pr($data);
            
            // Read the MySQL database
            $tables = $this->db->list_tables();
            $this->data['table_to_mvc'] = @array_diff($tables,$existing_tables); // Calulate the rest table to mvc
            
            if($_POST)
            {
                $table_to_mvc = $this->input->post('opt_table',true);
                if($table_to_mvc != '') // Process the MVC Generation
                {
                    $this->get_file_name($table_to_mvc);
                    
                    $table_schema = $this->db->query("DESCRIBE {$table_to_mvc}")->result_array();
                    
                   // pr($table_schema,1);
                    
                    $con_c_field = ''; $con_c_validation = ''; $vw_c_field = ''; $vw_c_validation = '';
                    
                    $width_percentage = ceil(100/count($table_schema));
                    
                    // As first field is autoincremented and primary field so escape it
                    for($i = 1; $i < count($table_schema); $i++) 
                    {
                        // Define the field type and rest setting
                        $this->get_field_type($table_schema[$i]['Field'], $table_schema[$i]['Type']);
                        
                        // Generate create/insert section  section for controller fields
                        if($this->field_type == 'image_upload')
                        {
                            $file_folder_name = FCPATH.'uploaded/'.$this->folder_name;
                            if (!file_exists($file_folder_name)) {
                                mkdir($file_folder_name, 0777, true);
                                mkdir($file_folder_name.'/thumb', 0777, true);
                            }
                            $con_c_field .="\n
            if(isset(\$_FILES['{$table_schema[$i]['Field']}']) && !empty(\$_FILES['{$table_schema[$i]['Field']}']['name']))
            {
                \$s_uploaded = get_file_uploaded(FCPATH.'uploaded/{$this->folder_name}/','{$table_schema[$i]['Field']}','','','$this->allowedExt');        
                \$arr_upload = explode('|',\$s_uploaded);    
            }
            if(\$arr_upload[0] == 'ok')
                \$posted[\"{$table_schema[$i]['Field']}\"] = \$arr_upload[2];
            ";
                    
                        } 
                        else
                        {
                            $con_c_field .= "\n\t\t\t\$posted[\"{$table_schema[$i]['Field']}\"] = \$this->input->post(\"{$table_schema[$i]['Field']}\", true);";
                        }
                        // Generate view field
                        $req_symbol = $this->required ? '*' : '';
                        $class = $i%2 == 0 ? ' col-md-offset-2':'';
                        if($i%2!=0 && $i > 1){
                            $vw_c_field .= "\n</div>\n<div class=\"row\">";
                        }
                        $display = '';
                        if($this->field_type == 'image_upload')
                        {
                            $display = "
                            <?php  
                                if(!empty(\$posted[\"s_image\"]))
                                {
                                    echo \"<img src='\".base_url('uploaded/".$this->folder_name."').'/'.\$posted[\"{$table_schema[$i]['Field']}\"].\"'  style='max-width:100px;max-height:100px;border:none;'/><br><br>\";
                                    echo \"<input type='hidden' name='h_{$table_schema[$i]['Field']}' value='\".\$posted[\"{$table_schema[$i]['Field']}\"].\"' />\";
                                }
                            ?>";   
                        }
                        $vw_c_field .= "\n\t".sprintf(text_template($this->field_type), $class, $this->field_label, $req_symbol, $display, $table_schema[$i]['Field'], $table_schema[$i]['Field'], $table_schema[$i]['Field']);
                        
                        if($this->field_type == 'image_upload')
                        {
                            $vw_details_field .= "\n\t\t\t<label class=\"col-md-4\"><?php echo addslashes(t('{$table_schema[$i]['Field']}'));?> : </label>\n\t\t\t<div class=\"col-md-8\"><p><img src=\"<?php echo base_url('uploaded/{$this->folder_name}').'/'.\$info[0]['{$table_schema[$i]['Field']}'];?>\" style=\"max-width:100px;max-height:100px;border:none\"/></p></div>\n\t\t\t<div class=\"clearfix\"></div>";
                        }
                        else
                        {
                            $vw_details_field .= "\n\t\t\t<label class=\"col-md-4\"><?php echo addslashes(t('{$table_schema[$i]['Field']}'));?> : </label>\n\t\t\t<div class=\"col-md-8\"><p><?php echo \$info[0]['{$table_schema[$i]['Field']}']; ?></p></div>\n\t\t\t<div class=\"clearfix\"></div>";
                        }
                        
                        // Generate the form validation rule
                        if($this->required)
                        {
                            $this->con_form_validation .= "\n\t\t\t\$this->form_validation->set_rules('{$table_schema[$i]['Field']}', addslashes(t('".strtolower($this->field_label)."')), 'required|xss_clean');";
                            
                            $this->vw_form_validation .= "\n\t\tif(\$(\"#{$table_schema[$i]['Field']}\").val()=='')\n\t\t{\n\t\t\tmarkAsError(\$(\"#{$table_schema[$i]['Field']}\"),'<?php echo addslashes(t(\"Please provide ".strtolower($this->field_label)."\"))?>');\n\t\t\tb_valid = false;\n\t\t}";    
                        }
                        
                        // Generate search field
                        if($this->field_type == 'text' && $this->search_field_added == false)
                        {
                            $con_search_field = "\n\t\t\t\$search_variable[\"{$table_schema[$i]['Field']}\"] = (\$this->input->post(\"h_search\")?\$this->input->post(\"{$table_schema[$i]['Field']}\"):\$arr_session_data[\"{$table_schema[$i]['Field']}\"]);";
                            $con_search_inner_field = "\n\t\t\t\tif(\$search_variable[\"{$table_schema[$i]['Field']}\"]!=\"\")\n\t\t\t\t{\n\t\t\t\t\t\$s_where .= \" AND n.{$table_schema[$i]['Field']} LIKE '%\".addslashes(\$search_variable[\"{$table_schema[$i]['Field']}\"]).\"%' \";\n\t\t\t\t}\n\t\t\t\t\$arr_session[\"{$table_schema[$i]['Field']}\"] = \$search_variable[\"{$table_schema[$i]['Field']}\"];\n\t\t\t\t\$this->data[\"{$table_schema[$i]['Field']}\"] = \$search_variable[\"{$table_schema[$i]['Field']}\"];";
                            
                            $vw_search_field = "\t\t\t\t\t\t\t\t<div class=\"form-group\">\n\t\t\t\t\t\t\t\t\t<label class=\"\"><?php echo addslashes(t(\"{$this->field_label}\"))?></label>\n\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"{$table_schema[$i]['Field']}\" id=\"{$table_schema[$i]['Field']}\" value=\"<?php echo \${$table_schema[$i]['Field']}?>\" class=\"form-control\" />\n\t\t\t\t\t\t\t\t</div>";
                            $search_field = $table_schema[$i]['Field'];
                            $this->search_field_added = true;
                        }
                        
                        // Generate show list view
                        $con_show_list_header .= "\n\t\t\t\$table_view[\"headers\"][++\$j][\"width\"] = \"{$width_percentage}%\";\n\t\t\t\$table_view[\"headers\"][\$j][\"align\"] = \"left\";\n\t\t\t\$table_view[\"headers\"][\$j][\"val\"] = addslashes(t(\"{$this->field_label}\"));";
                        
                        if($this->field_type == 'image_upload')
                        {
                            $con_show_list_view .= "\n\t\t\t\t\$table_view[\"tablerows\"][\$i][\$i_col++] = \"<img src='\".base_url('uploaded/{$this->folder_name}').\"/\".\$info[\$i][\"{$table_schema[$i]['Field']}\"].\"' style='max-width:80px; max-height:80px;' alt='{$this->field_label}'/>\";";
                        }
                        else
                        {
                            $con_show_list_view .= "\n\t\t\t\t\$table_view[\"tablerows\"][\$i][\$i_col++] = \$info[\$i][\"{$table_schema[$i]['Field']}\"];";
                        }
                        unset($this->required, $class, $this->field_type, $req_symbol,$this->field_label);
                    }
                    
                    // Write on file
##--------------------------------------------------------------------------------------##                    
##  Write script to the controller                                                      ##
##--------------------------------------------------------------------------------------##  

// Generate the controller file (Path to controller)
$this->controller_file = FCPATH.'application/controllers/'.$this->admin_folder_name.$this->file_name.'.php';
$controller ="<?php \n\n/***\n";
$controller .= $this->generate_file_info($this->file_name.'.php');
$controller .= "class ".ucfirst($this->file_name)." extends MY_Controller \n{";// Add class name
$controller .= $this->generate_contruct($table_to_mvc);  

// Generate show_list method
$controller .= "\n
    /****
    * Display the list of records 
    */
    public function show_list(\$start = NULL, \$limit = NULL)
    {
        try
        {
            \$this->data['heading'] = addslashes(t(\"{$this->mvc_title}\")); //Package Name[@package] Panel Heading
            
            //generating search query//
            \$arr_session_data = \$this->session->userdata(\"arr_session\");
            if(\$arr_session_data['searching_name'] != \$this->data['heading'])
            {
                \$this->session->unset_userdata(\"arr_session\");
                \$arr_session_data = array();
            }
            
            \$search_variable = array();
            //Getting Posted or session values for search//        
            \$s_search = (isset(\$_POST[\"h_search\"])?\$this->input->post(\"h_search\"):\$this->session->userdata(\"h_search\"));{$con_search_field}
            //end Getting Posted or session values for search//            
            
            \$s_where = \" n.i_id != 0 \";
            if(\$s_search == \"advanced\")
            {
                \$arr_session = array();
                \$arr_session[\"searching_name\"] = \$this->data['heading'];
                {$con_search_inner_field}
                \$this->session->set_userdata(\"arr_session\",\$arr_session);
                \$this->session->set_userdata(\"h_search\",\$s_search);
                \$this->data[\"h_search\"] = \$s_search;                            
            }
            else //List all records, **not done
            {
                //Releasing search values from session//
                \$this->session->unset_userdata(\"arr_session\");
                \$this->session->unset_userdata(\"h_search\");
                
                \$this->data[\"h_search\"] = \$s_search;
                \$this->data[\"{$search_field}\"] = ''; 
                //end Storing search values into session//                 
            }
            unset(\$s_search,\$arr_session,\$search_variable);
            
            //Setting Limits, If searched then start from 0//
            \$start = \$this->input->post(\"h_search\") ? 0 : \$this->uri->segment(\$this->i_uri_seg);
            //end generating search query//
            
            \$limit = \$this->i_admin_page_limit;
            \$info = \$this->acs_model->fetch_data(\$this->tbl.' AS n', \$s_where, '', intval(\$start), \$limit);
            
            //Creating List view for displaying//
            \$table_view = array();  
            
            //Table Headers, with width,alignment//
            \$table_view[\"caption\"]                 = addslashes(t(\"{$this->mvc_title}\"));
            \$table_view[\"total_rows\"]              = count(\$info);
            \$table_view[\"total_db_records\"]        = \$this->acs_model->count_info(\$this->tbl.' AS n', \$s_where, 'n.');
            \$table_view[\"detail_view\"]             = false;  // to disable show details. 
            \$j = -1;
            {$con_show_list_header}
            //end Table Headers, with width,alignment//
            
            //Table Data//
            for(\$i = 0; \$i< \$table_view[\"total_rows\"]; \$i++)
            {
                \$i_col = 0;
                \$table_view[\"tablerows\"][\$i][\$i_col++] = encrypt(\$info[\$i][\"i_id\"]);                
                {$con_show_list_view}
            } 
            //end Table Data//
            unset(\$i, \$i_col, \$start, \$limit, \$s_where); 
            
            \$this->data[\"table_view\"] = \$this->admin_showin_table(\$table_view,TRUE);
   
            //Creating List view for displaying//
            \$this->data[\"search_action\"] = \$this->pathtoclass.\$this->router->fetch_method();//used for search form action
            
            \$this->render();          
            unset(\$table_view, \$info);
        }
        catch(Exception \$err_obj)
        {
            show_error(\$err_obj->getMessage());
        }          
    }
";

// Generate add_information method              
$controller .= "\n 
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
        \$this->data['heading'] = (t(\"Add Information\"));
        \$this->data['pathtoclass'] = \$this->pathtoclass;
        \$this->data['BREADCRUMB'] = array(addslashes(t('Add Information')));
        \$this->data['mode'] = 'add';
        
        if(\$_POST)
        {
            \$posted = array();
            ".$con_c_field." ";
            if($this->con_form_validation != '') // Generate the CI form validation
            {
                $controller .= $this->con_form_validation;
                $controller .= "
            if(\$this->form_validation->run() == FALSE /*|| \$arr_upload[0]==='err'*/)//invalid
            {
                /*if(\$arr_upload[0]==='err')
                    set_error_msg(\$arr_upload[2]);
                else
                    get_file_deleted(\$this->uploaddir,\$arr_upload[2]);
                */
                //Display the add form with posted values within it//
                \$this->data[\"posted\"] = \$posted;
            }
            else//validated, now save into DB
            {
                ";
            }
            
            $controller .="
                \$i_newid = \$this->acs_model->add_data(\$this->tbl, \$posted);
                if(\$i_newid)//saved successfully
                {
                    /*
                    if(\$arr_upload[0]==='ok')
                    {
                        get_image_thumb(\$this->uploaddir.\$posted[\"s_image\"], \$this->thumbdir, 'thumb_'.\$posted[\"s_image\"],\$this->thumbHt,\$this->thumbWd);
                    }
                    */
                    set_success_msg(\$this->cls_msg[\"save_succ\"]);
                    redirect(\$this->pathtoclass.\"show_list\");
                }
                else//Not saved, show the form again
                {
                    set_error_msg(\$this->cls_msg[\"save_err\"]);
                }";
                if($this->con_form_validation != '')
                {
                    $controller .= "\n\t\t\t}";
                }
                $controller .="
        }
        //end Submitted Form//
        
        \$this->render(\"{$this->folder_name}/add-edit\");
    }";
    
// Generate modify_information method
$controller .= "\n
    /***
    * Method to Display and Save Updated information
    * This have to sections: 
    *  >>Displaying Values in Form for modifying entry.
    *  >>Saving the new information into DB    
    * After Posting the form, the posted values must be
    * shown in the form if any error occurs to avoid re-entry of the form.
    * 
    * On Success redirect to the showList interface else display error here. 
    * @param int \$i_id, id of the record to be modified.
    */
    public function modify_information(\$i_id=0)
    {
        \$this->data['heading'] = (t(\"Edit Information\"));
        \$this->data['pathtoclass'] = \$this->pathtoclass;
        \$this->data['BREADCRUMB'] = array(addslashes(t('Edit Information')));
        \$this->data['mode'] = 'edit';
        
        if(\$_POST)
        {
            \$posted = array();
        ".$con_c_field;
        $controller .="\n
            \$posted[\"h_id\"] = \$this->input->post(\"h_id\", true);";
        if($this->con_form_validation != '') // Generate the CI form validation
        {
            $controller .= $this->con_form_validation;
            $controller .= "
            if(\$this->form_validation->run() == FALSE /*|| \$arr_upload[0]==='err'*/)//invalid
            {
                /*if(\$arr_upload[0]==='err')
                    set_error_msg(\$arr_upload[2]);
                else
                    get_file_deleted(\$this->uploaddir,\$arr_upload[2]);
                */
                //Display the add form with posted values within it//
                \$this->data[\"posted\"] = \$posted;
            }
            else//validated, now save into DB
            {
                ";
        }
        
        $controller .="
                \$i_id = decrypt(\$posted[\"h_id\"]);
                unset(\$posted[\"h_id\"]);
                \$i_aff = \$this->acs_model->edit_data(\$this->tbl,\$posted, array('i_id'=>\$i_id));
                if(\$i_aff)//saved successfully
                {
                    /*
                    if(\$arr_upload[0]==='ok')
                    {
                        get_image_thumb(\$this->uploaddir.\$posted[\"s_image\"], \$this->thumbdir, 'thumb_'.\$posted[\"s_image\"],\$this->thumbHt,\$this->thumbWd);
                    }
                    */
                    set_success_msg(\$this->cls_msg[\"save_succ\"]);
                    redirect(\$this->pathtoclass.\"show_list\");
                }
                else//Not saved, show the form again
                {
                    set_error_msg(\$this->cls_msg[\"save_err\"]);
                }";
            if($this->con_form_validation != '')
            {
                $controller .= "\n\t\t\t}";
            }
            $controller .="
        }//end Submitted Form//
        else
        {
            // Fetch all the data
            \$tmp = \$this->acs_model->fetch_data(\$this->tbl,array('i_id'=>decrypt(\$i_id)));
            \$posted = \$tmp[0];
            \$posted['h_id'] = \$i_id;
            \$this->data['posted'] = \$posted;
            \$posted['h_mode'] = \$this->data['mode'];
        }
        
        \$this->render(\"{$this->folder_name}/add-edit\");
    }";

// Generate view_detail method
$controller .="\n
    /***
    * Shows details of a single record.
    * 
    * @param int \$i_id, Primary key
    */
    public function view_detail(\$i_id = 0)
    {
        try
        {
            if(!empty(\$i_id))
            {
                \$this->data[\"info\"] = \$this->acs_model->fetch_data(\$this->tbl,array('i_id'=>\$i_id));
            }
            \$this->load->view('{$this->admin_folder_name}{$this->folder_name}/show_detail.tpl.php', \$this->data); 
        }
        catch(Exception \$err_obj)
        {
            show_error(\$err_obj->getMessage());
        }         
    }";

// Generate ajax_remove_information method
$controller .="\n
    /***
    * Method to Delete information
    * This have no interface but db operation 
    * will be done here.
    * 
    * On Success redirect to the showList interface else display error in showList interface. 
    * @param int \$i_id, id of the record to be modified.
    */  
    public function ajax_remove_information()
    {
        try
        {
            \$i_id = decrypt(\$this->input->post(\"temp_id\"));
            echo \$this->acs_model->delete_data(\$this->tbl, array('i_id'=>\$i_id)) ? 'ok' : 'error';
            unset(\$i_id);
        }
        catch(Exception \$err_obj)
        {
            show_error(\$err_obj->getMessage());
        }         
    }";
    
$controller .= $this->generate_destruct();
$controller .= "\n}";
file_put_contents($this->controller_file, $controller);
##--------------------------------------------------------------------------------------##                    
##  End COntroller section                                                              ##
##--------------------------------------------------------------------------------------##                        
                       
##--------------------------------------------------------------------------------------##                    
##  Write script to the view                                                            ##
##--------------------------------------------------------------------------------------## 
mkdir(FCPATH.'application/views/'.$this->admin_folder_name.$this->folder_name);
// Generate the view file for show_list.tpl.php  (Path to view)
$this->show_list_view_file = FCPATH.'application/views/'.$this->admin_folder_name.$this->folder_name.'/show_list.tpl.php';
$show_list_view ="<?php \n\n/***\n";
$show_list_view .= $this->generate_file_info($this->file_name." show_list.tpl.php")."\n?>";
$show_list_view .= "\n<script>var g_controller=\"<?php echo \$pathtoclass;?>\", search_action = '<?php echo \$search_action;?>';// Controller Path </script>";
$show_list_view .= "\n<script src=\"<?php echo base_url()?>resource/admin/js/custom_js/add_edit_view.js\" type=\"text/javascript\"></script>";
$show_list_view .= "\n
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-md-10 col-md-offset-1\">
            <div class=\"row\">
                <div class=\"col-md-8 col-md-offset-2\">
        
                    <div class=\"box-header well\">
                        <h2><?php echo addslashes(t(\"Search\"))?></h2>             
                    </div>
    
                    <?php show_all_messages(); ?>
                    <form class=\"form-horizontal\" id=\"frm_search_3\" name=\"frm_search_3\" method=\"post\" action=\"<?php echo \$search_action?>\" >
                        <input type=\"hidden\" id=\"h_search\" name=\"h_search\" value=\"\" />    
                    </form>
            
                    <form class=\"\" id=\"frm_search_2\" name=\"frm_search_2\" method=\"post\" action=\"\" >
                        <input type=\"hidden\" id=\"h_search\" name=\"h_search\" value=\"advanced\" />        
                        <div id=\"div_err_2\"></div>        
                        <div class=\"row\">
                            <div class=\"col-md-5\">
                            {$vw_search_field}
                            </div>
                        </div>
                        <div class=\"form-group\">
                            <button type=\"button\" search=\"2\" id=\"btn_submit\" name=\"btn_submit\" class=\"btn btn-primary\"><?php echo addslashes(t(\"Search\"))?></button>                 
                            <button type=\"button\" id=\"btn_srchall\" name=\"btn_srchall\" class=\"btn\"><?php echo addslashes(t(\"Show All\"))?></button>
                        </div>
                    </form>  
                </div>
            </div>

            <?php echo \$table_view;?><!-- content ends -->
        </div>
    </div>
</div>
";
file_put_contents($this->show_list_view_file, $show_list_view); // Write add-edit.tpl.php

// Generate the view file for add-edit.tpl.php  (Path to view)
$this->view_file = FCPATH.'application/views/'.$this->admin_folder_name.$this->folder_name.'/add-edit.tpl.php';
$view ="<?php \n\n/***\n";
$view .= $this->generate_file_info($this->file_name." add-edit.tpl.php")."\n?>";
$view .= "\n<script>var g_controller=\"<?php echo \$pathtoclass;?>\", search_action = '<?php echo \$search_action;?>';// Controller Path </script>";
$view .= "\n<script src=\"<?php echo base_url()?>resource/admin/js/custom_js/add_edit_view.js\" type=\"text/javascript\"></script>";

// Generate the javascript form validation
if($this->vw_form_validation != '') 
{
    /*$view_javascript_file = FCPATH.'resource/admin/js/custom_js/'.$this->file_name.'.js';
    $view .= "\n<script src=\"<?php echo base_url()?>resource/admin/js/custom_js/{$this->file_name}.js\" type=\"text/javascript\"></script>\n";*/
    $view .="
<script type\"text/javascript\">
\$(document).ready(function(){
    //Submitting the form//
    \$(\"#frm_add_edit\").submit(function(){
        var b_valid=true;
        var s_err='';
        \$(\"#div_err\").hide(\"slow\");
        {$this->vw_form_validation}
        //validating//
        if(!b_valid)
        {        
            \$(\"#div_err\").html('<div id=\"err_msg\" class=\"error_massage\">'+s_err+'</div>').show(\"slow\");
        }
    
        return b_valid;
    });
});
</script>";
//file_put_contents($view_javascript_file, $js);     
}

$view .= "
<div class=\"container-fluid\">
    <div class=\"row\">
        <div class=\"col-md-10 col-md-offset-1\">
            <div class=\"box-header\">
                <h3 class=\"box-title\"><?php echo \$heading;?></h3>
            </div><!-- /.box-header -->
            
            <!-- form start -->
            <?php show_all_messages();?>
            <form role=\"form\" id=\"frm_add_edit\" name=\"frm_add_edit\" action=\"\" method=\"post\" autocomplete=\"off\"  enctype=\"multipart/form-data\">
                <input type=\"hidden\" id=\"h_id\" name=\"h_id\" value=\"<?php echo \$posted[\"h_id\"];?>\">
                <div class=\"row\">
                ".$vw_c_field."
                </div>
                
                <div class=\"form-group\">
                    <input type=\"button\" id=\"btn_save\" name=\"btn_save\" class=\"btn btn-primary\" value=\"<?php echo addslashes(t(\"Save changes\"))?>\">
                    <input type=\"button\" id=\"btn_cancel\" name=\"btn_cancel\" class=\"btn\" value=\"<?php echo addslashes(t(\"Cancel\"))?>\">
                </div>
            </form>
        </div>
    </div><!--/row-->
</div><!-- content ends -->
";
file_put_contents($this->view_file, $view); // Write add-edit.tpl.php

// Generate view for view_detail.tpl.php
$view_detail_view_file = FCPATH.'application/views/'.$this->admin_folder_name.$this->folder_name.'/view_detail.tpl.php';
$view_detail_view ="<?php \n\n/***\n";
$view_detail_view .= $this->generate_file_info($this->file_name." view_detail.tpl.php")."\n?>";
$view_detail_view .= "\n
<div id=\"content\" class=\"\" style=\"max-height:500px; width:700px;overflow-x:hidden; overflow-y:scroll;\">
   <div class=\"container-fluid\">
      <h2><?php echo addslashes(t('View Detail'))?></h2>    
              
      <div class=\"row\">
      {$vw_details_field}
      </div>
   </div>
</div>
";
file_put_contents($view_detail_view_file, $view_detail_view); // Write view_detail.tpl.php file

##--------------------------------------------------------------------------------------##                    
##  End View Section                                                                    ##
##--------------------------------------------------------------------------------------##
                   
                   
                    // Update the table name to the config/database.php file
                    
                    
                    set_success_msg('MVC has been generated successfully');
                    
                    unset($this->con_form_validation, $this->vw_form_validation);
                }
            }
           
            $this->render();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  

    } 
    
    /*    
    * Helper function starts from here. Please do not change any of them  
    */
    protected function get_existing_tables()
    {
        // Get the database array 
        require(APPPATH.'config/database.php');
        $existing_tables = array_slice($db['default'], 16);
        return $existing_tables;
    }
    
    protected function get_field_type_($type)
    {
        if(preg_match('/^int/', $type))
            return 'text';
        //else if
    }
    
    protected function get_field_type($name, $type)
    {
        // Define field type
        if(preg_match('/^s_/', $name) || preg_match('/^i_/', $name) || preg_match('/^f_/', $name) || 
        preg_match('/^d_/', $name) || preg_match('/^dt_/', $name))
        {
            $this->field_type = 'text'; 
        }
        
        // Define drop down field    
        if(preg_match('/^e_/', $name))
        {
            $this->field_type = 'select'; 
            eval('$this->enum_drop_down = '.str_replace('enum','array',$type).';');
        }   
           
        // Define require
        if(preg_match('/_req$/', $name))
        {
            $this->required = true;
        }
            
        if(preg_match('/^i_/', $name) && preg_match('/^tinyint/', $type))
        {
            $this->field_type = 'checkbox';
        } 
        
        // Check for image file upload
        if(preg_match('/_image$/', $name))
        {
            $this->field_type = 'image_upload';
        }
        
        // Check for file upload
        if(preg_match('/_file$/'))
        {
            $this->field_type = 'file_upload';
        }
        if(preg_match('/^i_/', $name) && preg_match('/_id$/', $name) && $name != 'i_id')
        {
            $this->reference_field = true;
            $tmp = explode('_', $name);
            array_pop($tmp);
            unset($tmp[0]);
            $this->reference_table = 'acs_'.implode('_',$tmp);
            unset($tmp);
        }
        $replace = array('s_','i_', 'e_', 'f_', 'dt_', 'd_', '_req');
        $this->field_label = str_replace($replace, '', $name);
        $this->field_label = ucwords(str_replace('_', ' ',  $this->field_label));
    }
    
    // Generate the file name, folder name, tile
    protected function get_file_name($table_name)
    {
        $tmp = explode('_', $table_name);
        unset($tmp[0]);
        $this->folder_name = $this->file_name = implode('_', $tmp);
        $this->mvc_title = ucwords(implode(' ', $tmp));
    }
    
    // File info
    protected function generate_file_info($file_name, $author_name = 'ACS Dev')
    {
        return sprintf(text_template('file_info'),$file_name, $author_name, date('F d, Y'), 'CURD for '.$this->mvc_title)."\n*/\n\n";    
    }
    
    /*    
    +-------------------------------------------------------------------------------------------+
    | Controller section generation                                                             |
    +-------------------------------------------------------------------------------------------+
    */
    // Constructor
    protected function generate_contruct($table_name = '')
    {
        return "\n\tpublic \$patchtoclass, \$cls_msg, \$tbl;\n\tpublic function __construct(){\n\t\tparent::__construct();\n\t\t\$this->data[\"title\"] = addslashes(t('".$this->mvc_title."'));//Browser Title \n\t\t\$this->pathtoclass = admin_base_url().\$this->router->fetch_class().\"/\";\n\t\t\$this->tbl = '{$table_name}';// Default Table \n\t}\n\n\t//Default method (index)\n\tpublic function index()\n\t{\n\t\tredirect(\$this->pathtoclass.'show_list');\n\t}"; 
    }
    
    // Destructor
    protected function generate_destruct()
    {
        return "\n\n\tpublic function __destruct(){}";
    }
    
    /* End */
    
	public function __destruct()
    {}
    
    public function select_table_()
    {
        // Get the database array 
        require(APPPATH.'config/database.php');
        $existing_tables = array_slice($db['default'], 16);
        
        // Read the MySQL database
        $tables = $this->db->list_tables();
        $this->data['table_to_mvc'] = @array_diff($tables,$existing_tables); // Calulate the rest table to mvc
        
        if($_POST)
        {
            $table_to_mvc = $this->input->post('opt_table',true);
            if($table_to_mvc != '') // Process the MVC Generation
            {
                $this->get_file_name($table_to_mvc);
                $table_schema = $this->db->query("DESCRIBE {$table_to_mvc}")->result_array();
                // As first field is autoincremented and primary field so escape it
                for($i = 1; $i < count($table_schema); $i++) 
                {
                    // Define the field type and rest setting
                    $this->get_field_type($table_schema[$i]['Field'], $table_schema[$i]['Type']);
                }
            }
        }
                
        $this->render('generate_mvc/generate');
    } 
    
    

}