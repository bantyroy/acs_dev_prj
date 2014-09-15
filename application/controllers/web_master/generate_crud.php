<?php
/***
* File name : generate_crud.php 
* 
*/
class Generate_crud extends MY_Controller
{
    protected $field_type, $required, $field_label, $reference_field, $reference_table, $form_field_type = array(), $tbl_prefix = 'acs_', $enum_drop_down, $ref_tb_list = '';
    
    protected $admin_folder_name = 'web_master/', $file_name, $folder_name, $mvc_title;
    
    public function __construct()
    {            
        try
        {
            parent::__construct();

            $this->data['title'] = addslashes(t("Generate MVC"));//Browser Title            

            //Define Errors Here//

            $this->cls_msg = array();

            $this->cls_msg["no_result"]        = get_message('no_result');
            $this->cls_msg["save_err"]        = get_message('save_failed');
            $this->cls_msg["save_succ"]        = get_message('save_success');
            $this->cls_msg["delete_err"]    = get_message('del_failed');
            $this->cls_msg["delete_succ"]    = get_message('del_success');
            //end Define Errors Here//            

            $this->pathtoclass = admin_base_url().$this->router->fetch_class()."/";            


            $this->load->helper('basic_text_template');
            $this->data['BREADCRUMB'] = array(addslashes(t('Generate MVC Depending on Database Table')));
            
            $this->form_field_type = array(
                'text' => 'Text',
                'password' => 'Password',
                'textarea' => 'Textarea',
                'select' => 'Drop Down',
                'radio' => 'Radio',
                'checkbox' => 'Checkbox',
                'file' => 'File Upload'
            );
            $this->data['form_field_type'] = $this->form_field_type;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    public function index()
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
                $table_schema = $this->get_table_schema($table_to_mvc);
                
                $this->data['selected_table_to_mvc'] =  $table_to_mvc;
                
                $show_list_field = ''; $validation_field = ''; $ref_table_field = ''; 
                // As first field is autoincremented and primary field so escape it
                for($i = 1; $i < count($table_schema); $i++) 
                {
                    
                    // Define the field type and rest setting
                    $this->get_field_type($table_schema[$i]['Field'], $table_schema[$i]['Type']);
                    
                    if($this->reference_field) // Get reference table fields
                    {
                        // Get table schema for reference table
                        $ref_table_schema = $this->get_table_schema($this->reference_table);
                        for($ref = 1; $ref < count($ref_table_schema); $ref++)
                            $ref_table_field[$ref_table_schema[$ref]['Field']] = $this->get_field_label($ref_table_schema[$ref]['Field']);
                    }
                    
                    $field_details[$i] = array(
                        'type' => $this->field_type,
                        'label' => $this->field_label,
                        'is_reference_field' => $this->reference_field,
                        'reference_field' => $ref_table_field,
                        'reference_table' => $this->reference_table
                    );
                    
                    // 1.Section for show list field
                    $show_list_field .= '<div></div>';
                    
                    // 2.Section for validation field
                    
                    
                    // 3.Section for reference table field
                    
                    
                    // Unset all the variables used here
                    unset($this->field_type, $this->required, $this->field_label, $this->reference_field, $this->reference_table, $ref_table_field, $ref_table_schema, $ref);
                }
                $this->data['field_details'] = $field_details;
            }
        }
                
        $this->render('generate_mvc/generate_field');
    } 
    
    // Generate drop down for a reference table
    protected function generate_drodown($table, $field, $s_id = '', $return_type = 'html')
    {
        $tmp = $this->acs_model->fetch_data($table, '',"i_id, {$field}");
        if(!empty($tmp))
        {
            foreach($tmp as $v)
            {
                if($return_type == 'array')
                    $value[$v['i_id']] = $v[$ref_field];
                else
                {
                    $selected = $s_id == $v['i_id'] ? 'selected' : '';
                    $value .= "<option value=\"{$v['i_id']}\" {$selected}>{$v[$ref_field]}</option>";
                }
            }
        }
        unset($tmp, $table, $field, $s_id, $return_type);
        return $value;
    }
    
    // File info
    protected function generate_file_info($file_name, $author_name = 'ACS Dev')
    {
        return sprintf(text_template('file_info'),$file_name, $author_name, date('F d, Y'), 'CURD for '.$this->mvc_title)."\n*/\n\n";    
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
            $this->field_type = 'file';
        }
        
        // Check for file upload
        if(preg_match('/_file$/'))
        {
            $this->field_type = 'file_upload';
            $this->field_type = 'file';
        }
        if(preg_match('/^i_/', $name) && preg_match('/_id$/', $name) && $name != 'i_id')
        {
            $this->reference_field = true;
            $tmp = explode('_', $name);
            array_pop($tmp);
            unset($tmp[0]);
            //$this->reference_table = 'acs_'.implode('_',$tmp);
            $rf_tbl = $this->tbl_prefix.implode('_',$tmp);
            if($this->db->table_exists($tbl)) $this->reference_table = $rf_tbl;
            unset($tmp, $rf_tbl);
        }
        $replace = array('s_','i_', 'e_', 'f_', 'dt_', 'd_', '_req');
        //$this->field_label = str_replace($replace, '', $name);
        $t = explode('_', $name);
        unset($t[0]);
        $t = implode('_', $t);
        $this->field_label = ucwords(str_replace('_',' ',str_replace('_req', '',  $t)));
        
        // Set the dafault label and field type if any thisng not found
        if($this->field_type == '')
            $this->field_type = 'text';
        if($this->field_label == '')
            $this->field_label = $name;
    }
    
    protected function get_field_label($field)
    {
        $replace = array('s_','i_', 'e_', 'f_', 'dt_', 'd_', '_req');
        $t = str_replace($replace, '', $field);
        return ucwords(str_replace('_', ' ',  $t)); 
    }
    
    // Generate the file name, folder name, tile
    protected function get_file_name($table_name)
    {
        $tmp = explode('_', $table_name);
        unset($tmp[0]);
        $this->folder_name = $this->file_name = implode('_', $tmp);
        $this->mvc_title = ucwords(implode(' ', $tmp));
    }
    
    protected function get_table_schema($table_to_mvc = '')
    {
        if($this->db->table_exists($table_to_mvc))
            return $this->db->query("DESCRIBE {$table_to_mvc}")->result_array();
        else
            return array();
    }
    
        // Constructor
    protected function generate_contruct($table_name = '')
    {
        if(!empty($this->ref_tb_list))
        {
            for($i = 0; $i<count($this->ref_tb_list); $i++)
            {
                $var[] =  "\$tbl_ref_{$this->ref_tb_list[$i]['prefix']}";
                $ref_tables .= "\$this->tbl_ref_{$this->ref_tb_list[$i]['prefix']} = '{$this->ref_tb_list[$i]['table_name']}';"; 
            }
            if(count($var) > 0) $var = "\n\tprotected ".implode(', ', $var).';';
           
        }
        return "\n\tpublic \$patchtoclass, \$cls_msg, \$tbl;{$var}\n\tpublic function __construct(){\n\t\tparent::__construct();\n\t\t\$this->data[\"title\"] = addslashes(t('".$this->mvc_title."'));//Browser Title \n\t\t\$this->pathtoclass = admin_base_url().\$this->router->fetch_class().\"/\";\n\t\t\$this->tbl = '{$table_name}';// Default Table\n\t\t{$ref_tables}\n\t}\n\n\t//Default method (index)\n\tpublic function index()\n\t{\n\t\tredirect(\$this->pathtoclass.'show_list');\n\t}"; 
    }
    
    // Destructor
    protected function generate_destruct()
    {
        return "\n\n\tpublic function __destruct(){}";
    }
    
    public function generate()
    {
        if($_POST)
        {   
            //pr($_POST,1);
            $table_name = $this->input->post('table_name');
            $label = $this->input->post('label');
            $show_in_view_page = $this->input->post('listing');
            $search_field = $this->input->post('searching');
            $form_field_type = $this->input->post('type');
            $validation = $this->input->post('validation');
            $sorting = $this->input->post('sorting');
            
            // Get table shema
            $table_schema = $this->get_table_schema($table_name);
            $this->get_file_name($table_name);
            
            $t = array_count_values($show_in_view_page);
            $width_percentage = ceil(100/intval($t['show']));
            $select_field = '';
            for($i = 0; $i < count($label); $i++)
            {
                $field_name = $table_schema[$i+1]['Field'];
                $select_field[] = 'n.'.$field_name;
                
                // Generate create/insert section  section for controller fields
                if($form_field_type[$i] == 'file')
                {
                    // Generate create/insert section  section for controller fields
                    $file_folder_name = FCPATH.'uploaded/'.$this->folder_name;
                    if (!file_exists($file_folder_name)) {
                        mkdir($file_folder_name, 0777, true);
                        mkdir($file_folder_name.'/thumb', 0777, true);
                    }
                    $con_c_field .="\n
            if(isset(\$_FILES['{$field_name}']) && !empty(\$_FILES['{$field_name}']['name']))
            {
                \$s_uploaded = get_file_uploaded(FCPATH.'uploaded/{$this->folder_name}/','{$field_name}','','','$this->allowedExt');        
                \$arr_upload = explode('|',\$s_uploaded);    
            }
            if(\$arr_upload[0] == 'ok')
                \$posted[\"{$field_name}\"] = \$arr_upload[2];
            ";
                    
                } 
                else
                {
                    $con_c_field .= "\n\t\t\t\$posted[\"{$field_name}\"] = \$this->input->post(\"{$field_name}\", true);";
                }
                
                // Generate view field
                $req_symbol = $validation[$i] == 'required' ? '*' : '';
                $class = $i%2 != 0 ? ' col-md-offset-2':'';
                if($i%2==0 && $i > 0){
                    $vw_c_field .= "\n</div>\n<div class=\"row\">";
                }
                $display = '';
                if($form_field_type[$i] == 'file')
                {
                    $display = "
                    <?php  
                        if(!empty(\$posted[\"s_image\"]))
                        {
                            echo \"<img src='\".base_url('uploaded/".$this->folder_name."').'/'.\$posted[\"{$field_name}\"].\"'  style='max-width:100px;max-height:100px;border:none;'/><br><br>\";
                            echo \"<input type='hidden' name='h_{$field_name}' value='\".\$posted[\"{$field_name}\"].\"' />\";
                        }
                    ?>";   
                }
                
                // Check for reference field
                if($this->input->post("ref_field_{$i}") != '')
                {
                    $ref_table = $this->input->post("ref_table_{$i}"); // Ref table 
                    $ref_field = $this->input->post("ref_field_{$i}"); // Ref Field
                    $ref_tb_prefix = substr(str_replace($this->tbl_prefix,'', $ref_table),0, 3); // Ref table prefix
                    $this->ref_tb_list[] = array(
                        'table_name' => $ref_table, 
                        'field' => $ref_field, 
                        'prefix' => $ref_tb_prefix,
                        'main_tb_field' => $field_name
                    );
                    
                    // Generate a method for drop down
                    $con_dd_method = "\n\n
    // Generate a method for drop down
    protected function generate_drodown(\$table, \$field, \$s_id = '', \$return_type = 'html')
    {
        \$tmp = \$this->acs_model->fetch_data(\$table, '',\"i_id, \$field\");
        if(!empty(\$tmp))
        {
            if(\$return_type == 'array')
                \$value[0] = 'Select';
            else
                \$value = '<option value=\"\">Select</option>';
            foreach(\$tmp as \$v)
            {
                if(\$return_type == 'array')
                    \$value[\$v['i_id']] = \$v[\$field];
                else
                {
                    \$selected = \$s_id == \$v['i_id'] ? 'selected' : '';
                    \$value .= '<option value=\"'.\$v['i_id'].'\" '.\$selected.'>'.\$v[\$field].'</option>';
                }
            }
        }
        unset(\$tmp, \$table, \$field, \$s_id, \$return_type);
        return \$value;
    }";
                    // Generate drop down field
                    $tmp = $this->acs_model->fetch_data($ref_table, '',"i_id, {$ref_field}");
                    if(!empty($tmp))
                    {
                        foreach($tmp as $v)
                            $value .= "<option value=\"{$v['i_id']}\">{$v[$ref_field]}</option>";
                    }
                    unset($tmp);
                }
                if($value != ''){
                    $form_field_type[$i] = 'select';
                }
                if($ref_field != '' && $form_field_type[$i] == 'select'){}
                
                $vw_c_field .= "\n\t".$this->generate_form_field($form_field_type[$i], $label[$i], $field_name, $class, $req_symbol, $value);
                
                // Generate sorting fields
                if($sorting[$i] == 'show')
                {
                    if($ref_field != '')
                        $sorting_field[] = "'{$i}'=>'{$ref_tb_prefix}.{$ref_field}'";
                    else
                        $sorting_field[] = "'{$i}'=>'n.{$field_name}'";
                }
                
                // Generate display view
                $vw_details_field .= "\n\t\t\t<label class=\"col-md-4\"><?php echo addslashes(t('{$field_name}'));?> : </label>\n\t\t\t<div class=\"col-md-8\"><p><?php echo \$info[0]['{$field_name}']; ?></p></div>\n\t\t\t<div class=\"clearfix\"></div>";
                // Generate the form validation rule
                if($validation[$i] != '')
                {
                    $con_form_validation .= "\n\t\t\t\$this->form_validation->set_rules('{$field_name}', addslashes(t('".strtolower($label[$i])."')), '{$validation[$i]}|xss_clean');";
                    
                    if($validation[$i] == 'required')
                    {
                        $vw_form_validation .= "\n\t\tif(\$(\"#{$field_name}\").val()=='')\n\t\t{\n\t\t\tmarkAsError(\$(\"#{$field_name}\"),'<?php echo addslashes(t(\"Please provide ".strtolower($label[$i])."\"))?>');\n\t\t\tb_valid = false;\n\t\t}";    
                    }
                    else if($validation[$i] == 'valid_email')
                    {
                        $vw_form_validation .= "\n\t\tif(reg.test(\$.trim(\$(\"\#{$field_name}\").val()))== false)\n\t\t{\n\t\t\tmarkAsError(\$(\"#{$field_name}\"),'<?php echo addslashes(t(\"Please provide valid ".strtolower($label[$i])."\"))?>');\n\t\t\tb_valid = false;\n\t\t}";
                    }
                }
                
                // Generate search field
                if($search_field[$i] == 'show')
                {
                    $con_search_field .= "\n\t\t\t\$search_variable[\"{$field_name}\"] = (\$this->input->post(\"h_search\")?\$this->input->post(\"{$field_name}\"):\$arr_session_data[\"{$field_name}\"]);";
                    
                    if($ref_field != '' && $ref_table != '')
                    {
                        $con_search_inner_field .= "\n\t\t\t\tif(intval(\$search_variable[\"{$field_name}\"])>0)\n\t\t\t\t{\n\t\t\t\t\t\$s_where .= \" AND {$ref_tb_prefix}.i_id = '\".addslashes(\$search_variable[\"{$field_name}\"]).\"' \";\n\t\t\t\t}\n\t\t\t\t\$arr_session[\"{$field_name}\"] = \$search_variable[\"{$field_name}\"];\n\t\t\t\t\$this->data[\"{$field_name}\"] = \$search_variable[\"{$field_name}\"];";
                        
                        $vw_search_field .= "\t\t\t\t\t\t\t\t<div class=\"form-group\">\n\t\t\t\t\t\t\t\t\t<label class=\"\"><?php echo addslashes(t(\"".$this->get_field_label($ref_field)."\"))?></label>\n\t\t\t\t\t\t\t\t\t<?php echo form_dropdown('{$field_name}', \$dd_val, (\$$field_name != ''? array(\$$field_name) : ''), 'class=\"form-control\"')?>\n\t\t\t\t\t\t\t\t</div>";
                        
                        $con_search_additional .= "\n\t\t\t\t\$this->data['dd_val'] = \$this->generate_drodown('{$ref_table}', '{$ref_field}', \$search_variable[\"{$field_name}\"], 'array');\n";
                    }
                    else
                    {
                        $con_search_inner_field .= "\n\t\t\t\tif(\$search_variable[\"{$field_name}\"]!=\"\")\n\t\t\t\t{\n\t\t\t\t\t\$s_where .= \" AND n.{$field_name} LIKE '%\".addslashes(\$search_variable[\"{$field_name}\"]).\"%' \";\n\t\t\t\t}\n\t\t\t\t\$arr_session[\"{$field_name}\"] = \$search_variable[\"{$field_name}\"];\n\t\t\t\t\$this->data[\"{$field_name}\"] = \$search_variable[\"{$field_name}\"];";
                        
                        $vw_search_field .= "\t\t\t\t\t\t\t\t<div class=\"form-group\">\n\t\t\t\t\t\t\t\t\t<label class=\"\"><?php echo addslashes(t(\"{$label[$i]}\"))?></label>\n\t\t\t\t\t\t\t\t\t<input type=\"text\" name=\"{$field_name}\" id=\"{$field_name}\" value=\"<?php echo \${$field_name}?>\" class=\"form-control\" />\n\t\t\t\t\t\t\t\t</div>";
                    }
                }
                
                
                // Generate show list view
                if($show_in_view_page[$i] == 'show')
                {
                    $con_show_list_header .= "\n\t\t\t\$table_view[\"headers\"][++\$j][\"width\"] = \"{$width_percentage}%\";\n\t\t\t\$table_view[\"headers\"][\$j][\"align\"] = \"left\";\n\t\t\t\$table_view[\"headers\"][\$j][\"val\"] = addslashes(t(\"{$label[$i]}\"));";
                    if($sorting[$i] == 'show')
                    {
                        $con_show_list_header .= "\n\t\t\t\$table_view[\"headers\"][\$j][\"sort\"] = array('field_name'=>encrypt(\$arr_sort[{$i}]));";
                    }
                    
                    if($form_field_type[$i] == 'image_upload')
                    {
                        $con_show_list_view .= "\n\t\t\t\t\$table_view[\"tablerows\"][\$i][\$i_col++] = \"<img src='\".base_url('uploaded/{$this->folder_name}').\"/\".\$info[\$i][\"{$field_name}\"].\"' style='max-width:80px; max-height:80px;' alt='{$this->field_label}'/>\";";
                    }
                    else
                    {
                        if($ref_field != '') $field_name = $ref_field;
                        $con_show_list_view .= "\n\t\t\t\t\$table_view[\"tablerows\"][\$i][\$i_col++] = \$info[\$i][\"{$field_name}\"];";
                    }
                }
                
                unset($field_name, $class, $req_symbol, $value, $ref_table, $ref_field, $ref_tb_prefix);
            } // End of main loop
            
            // Write on file
##--------------------------------------------------------------------------------------##                    
##  Write script to the controller                                                      ##
##--------------------------------------------------------------------------------------##  

// Generate the controller file (Path to controller)
$this->controller_file = FCPATH.'application/controllers/'.$this->admin_folder_name.$this->file_name.'.php';
$controller ="<?php \n\n/***\n";
$controller .= $this->generate_file_info($this->file_name.'.php');
$controller .= "class ".ucfirst($this->file_name)." extends MY_Controller \n{";// Add class name
$controller .= $this->generate_contruct($table_name);  

$tbl = '';
if(!empty($this->ref_tb_list))
{
    $tbl .= "\n
            \$tbl[0] = array(
                'tbl' => \$this->tbl.' AS n',
                'on' =>''
            );";
    for($i = 0; $i<count($this->ref_tb_list); $i++)
    {
        $select_field[] = $this->ref_tb_list[$i]['prefix'].'.'.$this->ref_tb_list[$i]['field'];
        $tbl .="\n
            \$tbl[".($i+1)."] = array(
                'tbl' => \$this->tbl_ref_{$this->ref_tb_list[$i]['prefix']}.' AS {$this->ref_tb_list[$i]['prefix']}',
                'on' => 'n.{$this->ref_tb_list[$i]['main_tb_field']} = {$this->ref_tb_list[$i]['prefix']}.i_id'
            );";
    }
}
$select_field = count($select_field) > 0 ? 'n.i_id, '.implode(', ', $select_field) : 'n.*';   

// Generate show_list method
$controller .= "\n
    /****
    * Display the list of records 
    */
    public function show_list(\$order_by = '{$default_sort}', \$sort_type = 'desc',\$start = NULL, \$limit = NULL)
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
            {$con_search_additional}
            unset(\$s_search,\$arr_session,\$search_variable);
              
            //Setting Limits, If searched then start from 0//
            \$i_uri_seg = 6;
            \$start = \$this->input->post(\"h_search\") ? 0 : \$this->uri->segment(\$i_uri_seg);
            //end generating search query//
            
            // List of fields for sorting
            \$arr_sort = array(".implode(', ',$sorting_field).");   
            \$order_by = !empty(\$order_by)?in_array(decrypt(\$order_by),\$arr_sort)?decrypt(\$order_by):\$arr_sort[0]:\$arr_sort[0];
            
            \$limit = \$this->i_admin_page_limit;";
            if($tbl != '')
            {
$controller .="\n\t\t\t{$tbl}
            \$conf = array(
                'select' => '$select_field',
                'where' => \$s_where,
                'limit' => \$limit,
                'offset' => \$start,
                'order_by' => \$order_by,
                'order_type' => \$sort_type
            );
            \$info = \$this->acs_model->fetch_data_join(\$tbl, \$conf);
            
            \$conf2 = array(
                'select' => 'count(n.i_id) AS total',
                'where' => \$s_where
            );
            \$tmp =  \$this->acs_model->fetch_data_join(\$tbl, \$conf2);
            \$total = \$tmp[0]['total'];
            unset(\$tmp);
";            
            }
            else
            {          
$controller .="\n
            \$s_where .= \" ORDER BY \$order_by \$sort_type\"; 
            \$info = \$this->acs_model->fetch_data(\$this->tbl.' AS n', \$s_where, '', intval(\$start), \$limit);
            \$total = \$this->acs_model->count_info(\$this->tbl.' AS n', \$s_where, 'n.');";
            }
$controller .="
                  
            //Creating List view for displaying//
            \$table_view = array();  
            
            //Table Headers, with width,alignment//
            \$table_view[\"caption\"]                 = addslashes(t(\"{$this->mvc_title}\"));
            \$table_view[\"total_rows\"]              = count(\$info);
            \$table_view[\"total_db_records\"]        = \$total;
            \$table_view[\"detail_view\"]             = false;  // to disable show details. 
            \$table_view[\"order_name\"]              = encrypt(\$order_by);
            \$table_view[\"order_by\"]                = \$sort_type;
            \$table_view[\"src_action\"]              = \$this->pathtoclass.\$this->router->fetch_method();
            
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
            
            //\$this->data[\"table_view\"] = \$this->admin_showin_table(\$table_view,TRUE);
            \$this->data['total_record'] = \$table_view[\"total_db_records\"];
            \$this->data[\"table_view\"] = \$this->admin_showin_order_table(\$table_view,TRUE);
            
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
        {$con_search_additional}
        
        if(\$_POST)
        {
            \$posted = array();
            ".$con_c_field." ";
            if($con_form_validation != '') // Generate the CI form validation
            {
                $controller .= $con_form_validation;
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
                if($con_form_validation != '')
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
        {$con_search_additional}
        
        if(\$_POST)
        {
            \$posted = array();
        ".$con_c_field;
        $controller .="\n
            \$posted[\"h_id\"] = \$this->input->post(\"h_id\", true);";
        if($con_form_validation != '') // Generate the CI form validation
        {
            $controller .= $con_form_validation;
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
            if($con_form_validation != '')
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

if($con_dd_method != '')
{
    $controller .= "\n\t".$con_dd_method;
}

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
if($vw_form_validation != '') 
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
        var email_pattern = /^([A-Za-z0-9_\\-\\.])+\\@([A-Za-z0-9_\\-\\.])+\\.([A-Za-z]{2,4})$/;
        \$(\"#div_err\").hide(\"slow\");
        {$vw_form_validation}
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

            set_success_msg('CRUD has been generated successfully');
            
            // Add this to menu and menu_permit table
            $prev = $this->db->select('i_id', false)->get_where($this->tbl_prefix.'menu', array('s_link' => $this->file_name.'/'))->num_rows();
            if($prev == 0)
            {
                $this->db->insert($this->tbl_prefix.'menu', array('s_name' => $this->mvc_title, 's_link' => $this->file_name.'/', 'i_parent_id' => 1, 'i_main_id' => 1, 's_action_permit' => 'View List||View Detail||Add||Edit||Delete','en_s_name'=>$this->mvc_title));
                $insert_id = $this->db->insert_id();
                if($insert_id > 0)
                {
                    $info = array(
                        array('i_menu_id' => $insert_id,'s_action'=>'View List','s_link'=>$this->file_name.'/show_list/'), 
                        array('i_menu_id' => $insert_id,'s_action'=>'View Detail','s_link'=>$this->file_name.'/view_detail/'),
                        array('i_menu_id' => $insert_id,'s_action'=>'Add','s_link'=>$this->file_name.'/add_information/'), 
                        array('i_menu_id' => $insert_id,'s_action'=>'Edit','s_link'=>$this->file_name.'/modify_information/'), 
                        array('i_menu_id' => $insert_id,'s_action'=>'Delete','s_link'=>$this->file_name.'/delete_information/')
                    );
                   $this->db->insert_batch($this->tbl_prefix.'menu_permit', $info); 
                }
            }
            
            unset($con_form_validation, $vw_form_validation, $con_dd_method, $this->ref_tb_list, $sorting, $sorting_field);
        }
        
        redirect($this->pathtoclass);
    }
    
    protected function generate_form_field($type, $label, $name,  $class = '', $required = '', $value = '')
    {
        $str = '';
        switch($type)
        {
            case 'text':
            case 'password':
            case 'checkbox':
            case 'radio':
                $str = "<div class=\"col-md-5 {$class}\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"{$label}\"))?><span class=\"text-danger\">{$required}</span></label>\n\t\t\t<input class=\"form-control\" rel=\"{$name}\" id=\"{$name}\" name=\"{$name}\" value=\"<?php echo \$posted[\"{$name}\"];?>\" type=\"{$type}\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>";
            break;
            
            case 'textarea':
                $str = "<div class=\"col-md-5 {$class}\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"{$label}\"))?><span class=\"text-danger\">{$required}</span></label>\n\t\t\t<textarea name=\"{$name}\" id=\"{$name}\" rel=\"{$name}\" class=\"form-control\"><?php echo \$posted[\"{$name}\"]?></textarea><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>";      
            break;
           
            case 'select':
                $str = "<div class=\"col-md-5 {$class}\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"{$label}\"))?><span class=\"text-danger\">{$required}</span></label>\n\t\t\t<?php echo form_dropdown('{$name}', \$dd_val, (\$posted['{$name}']!= '' ? array(\$posted['{$name}']):''),'class=\"form-control\" id=\"{$name}\"')?><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>";
            break;
            
            case 'file':
                $str = "<div class=\"col-md-5 {$class}\">\n\t\t<div class=\"form-group\">\n\t\t<label for=\"focusedInput\"><?php echo addslashes(t(\"Upload {$label}\"))?><span class=\"text-danger\">{$required}</span></label>\n\t\t\t<input id=\"{$name}\" name=\"{$name}\" type=\"file\" /><span class=\"text-danger\"></span>\n\t\t</div>\n\t</div>";
            break;
        }
        unset($type, $label, $name, $class, $required, $value);
        return $str;
    }

}