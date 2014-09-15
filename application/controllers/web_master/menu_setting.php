<?php

/* * *******
 * Author: Acumen CS
 * Date  : 30 Jan 2014
 * Modified By: 
 * Modified Date:
 * 
 * Purpose:
 *  Controller For Menu setting
 * 
 * @package 
 * @subpackage 
 * 
 * @link InfController.php 
 * @link My_Controller.php
 * @link model/menu_model.php
 * @link views/admin/menu_setting/
 */

class Menu_setting extends My_Controller implements InfController {

    public $cls_msg; //All defined error messages. 
    public $pathtoclass;

    public function __construct() {

        try {
            parent::__construct();


            $this->data['title'] = "Menu Setting"; //Browser Title
            //Define Errors Here//
            $this->cls_msg = array();
            $this->cls_msg["no_result"] = "No information found about news.";
            $this->cls_msg["save_err"] = "New main menu failed to add.";
            $this->cls_msg["save_err_blank"] = "Sorry ! Please provide data to required field.";
            $this->cls_msg["save_succ"] = "New main menu added successfully.";

            $this->cls_msg["save_succ_permit"] = "Menu permission set successfully.";
            $this->cls_msg["save_err_permit"] = "menu permission failed to set.";

            $this->cls_msg["delete_err"] = "Information about news failed to remove.";
            $this->cls_msg["delete_succ"] = "Information about news removed successfully.";
            $this->cls_msg["status_succ"] = "Status of news saved successfully.";
            $this->cls_msg["status_err"] = "Status of news failed to save.";
            //end Define Errors Here//
            $this->pathtoclass = admin_base_url() . $this->router->fetch_class() . "/"; //for redirecting from this class
            // loading default model here //
            $this->load->model("menu_model", "mod_menu");

            // end loading default model here //
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function index() {
        try {
            redirect($this->pathtoclass . "show_list");
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * **
     * Display the list of records
     * 
     */

    public function show_list($start = NULL, $limit = NULL) {
        try {
            $this->data['heading'] = "Menu Setting"; //Package Name[@package] Panel Heading


            if ($_POST) {
                $info = array();
                $info['s_name'] = trim($this->input->post('txt_menu_title'));
                $info['i_parent_id'] = (intval($this->input->post('opt_status')) == 1) ? 0 : -99;
                $info['i_main_id'] = 0;
                $info['s_link'] = '';

                if ($info['s_name'] != '') {
                    $i_aff = $this->mod_menu->add_main_menu($info);
                    if ($i_aff) {
                        set_success_msg($this->cls_msg["save_succ"]);
                    } else {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                } else {
                    set_error_msg($this->cls_msg["save_err_blank"]);
                }
            }



            $info = $this->mod_menu->fetch_main_menu($s_where);
            //$info    = $this->mod_menu->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
            //Creating List view for displaying//
            $table_view = array();
            //$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
            //Table Headers, with width,alignment//
            $table_view["caption"] = "Main Menus";
            $table_view["total_rows"] = count($info);
            $table_view["detail_view"] = false;
            //$table_view["total_db_records"]=$this->mod_menu->gettotal_info($s_where);
            //$table_view["order_name"]=$order_name;
            //$table_view["order_by"]  =$order_by;
            $table_view["src_action"] = $this->pathtoclass . $this->router->fetch_method();

			$j = 0 ;
            $table_view["headers"][$j]["width"]		= "40%";
            $table_view["headers"][$j]["align"]		= "left";
            $table_view["headers"][$j]["val"]		= "Main Menus";
            $table_view["headers"][++$j]["width"]	= "15%";
            $table_view["headers"][$j]["val"]		= "Status";
            $table_view["headers"][++$j]["val"]		= "Action";
			$table_view["headers"][$j]["align"]		= "center";


            //end Table Headers, with width,alignment//
            //Table Data//
            for ($i = 0; $i < $table_view["total_rows"]; $i++) {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["id"]); //Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++] = '<span>' . $info[$i]["s_name"] . '</span>' . '<input style="background: #FFFFC0; display: none;" type="text" value="' . $info[$i]["s_name"] . '">';


                $table_view["tablerows"][$i][$i_col++] = ($info[$i]["status"] == 'showing') ? make_label($info[$i]["status"]) : make_label($info[$i]["status"], 'warning');

                $action = '<a id="edit_row_' . $info[$i]["id"] . '" href="javascript:void(0);" class="btn btn-mini btn-primary" ><i class="icon-edit icon-white"></i> Edit</a>';



                $action .=' <a class="btn btn-mini btn-success" id="save_row_' . $info[$i]["id"] . '" href="javascript:void(0);" >
                <i class="icon-save icon-white"></i> Save</a>';


                $action .='&nbsp;&nbsp;<a class="btn btn-mini btn-warning"  id="delete_row_' . $info[$i]["id"] . '" href="javascript:void(0);" >
                <i class="icon-trash icon-white"></i> Delete</a>';

                $action .='&nbsp;&nbsp;<a class="btn btn-mini btn-info"  id="change_row_' . $info[$i]["id"] . '" href="javascript:void(0);" >
                <i class="icon-refresh icon-white"></i> Status</a>';
                if ($info[$i]["i_parent_id"] == 0) {
                    $action .='&nbsp;&nbsp;<a class="btn btn-mini btn-danger"  id="go_row_' . $info[$i]["id"] . '" href="' . admin_base_url() . 'menu_setting/sub_menu_list/' . encrypt($info[$i]["id"]) . '" >
                 <i class="icon-share icon-white"></i> Sub Menu</a>';
                }
                $table_view["tablerows"][$i][$i_col++] = $action;
            }
            //end Table Data//
            unset($i, $i_col, $start, $limit);

            $this->data["table_view"] = $this->admin_showin_table($table_view);

            //Creating List view for displaying//
            //$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
            //echo $this->data["search_action"];

            $this->render();
            unset($table_view, $info);
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *
     * Method to Display and Save New information
     * This have to sections: 
     *  >>Displaying Blank Form for new entry.
     *  >>Saving the new information into DB
     * After Posting the form, the posted values must be
     * shown in the form if any error occurs to avoid re-entry of the form.
     * 
     * On Success redirect to the showList interface else display error here.
     */

    public function add_information() {
        //echo $this->router->fetch_method();exit();
        try {
            
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *
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

    public function modify_information($i_id = 0) {

        try {
            
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *
     * Method to Delete information
     * This have no interface but db operation 
     * will be done here.
     * 
     * On Success redirect to the showList interface else display error in showList interface. 
     * @param int $i_id, id of the record to be modified.
     */

    public function remove_information($i_id = 0) {
        try {
            $i_ret_ = 0;
            $pageno = $this->input->post("h_pageno"); //the pagination page no, to return at the same page
            //Deleting What?//
            $s_del_these = $this->input->post("h_list");
            switch ($s_del_these) {
                case "all":
                    $i_ret_ = $this->mod_menu->delete_info(-1);
                    break;
                default:         //Deleting selected,page //
                    //First consider the posted ids, if found then take $i_id value//
                    $id = (!$i_id ? $this->input->post("chk_del") : $i_id); //may be an array of IDs or single id
                    if (is_array($id) && !empty($id)) {//Deleting Multi Records
                        //Deleting Information//
                        $tot = count($id) - 1;
                        while ($tot >= 0) {
                            $i_ret_ = $this->mod_menu->delete_info(decrypt($id[$tot]));
                            $tot--;
                        }
                    } elseif ($id > 0) {//Deleting single Records
                        $i_ret_ = $this->mod_menu->delete_info(decrypt($id));
                    }
                    break;
            }
            unset($s_del_these, $id, $tot);

            if ($i_ret_) {
                set_success_msg($this->cls_msg["delete_succ"]);
            } else {
                set_error_msg($this->cls_msg["delete_err"]);
            }
            redirect($this->pathtoclass . "show_list" . ($pageno ? "/" . $pageno : ""));
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *
     * Shows details of a single record.
     * 
     * @param int $i_id, Primary key
     */

    public function show_detail($i_id = 0) {
        try {
            if (trim($i_id) != "") {
                $info = $this->mod_menu->fetch_this(decrypt($i_id));

                if (!empty($info)) {
                    $temp = array();
                    $temp["s_id"] = encrypt($info["id"]); //Index 0 must be the encrypted PK 
                    $temp["s_news_title"] = trim($info["s_title"]);
                    $temp["s_news_description"] = trim($info["s_description"]);
                    $temp["s_is_active"] = trim($info["s_is_active"]);
                    $temp["dt_created_on"] = trim($info["dt_created_on"]);

                    $this->data["info"] = $temp;
                    unset($temp);
                }
                unset($info);
            }
            $this->add_css("css/admin/style.css"); //include main css
            $this->add_js("js/jquery/jquery-1.4.2.js"); //include main css
            $this->add_css("js/jquery/themes/ui-darkness/ui.all.css"); //include jquery css

            $this->render("news/show_detail", TRUE);
            unset($i_id);
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *
     * Checks duplicate value using ajax call
     */

    public function ajax_checkduplicate() {
        
    }

    public function ajax_edit_main_menu() {
        try {
            $info = array();
            $info['s_name'] = $this->input->post('edited_data');
            if ($this->input->post('link_data')) {
                $info['s_link'] = $this->input->post('link_data');
            }
            $id = $this->input->post('row_id');

            $i_aff = $this->mod_menu->edit_main_menu($info, $id);
            if ($i_aff) {
                echo 'ok';
            } else {
                echo 'error';
            }
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function ajax_change_status_main_menu() {
        try {
            $info = array();
            $data = trim($this->input->post('data'));
            $id = $this->input->post('row_id');
            if ($data == 'showing') {
                $info['i_parent_id'] = -99;
            } else {
                $info['i_parent_id'] = 0;
            }

            $i_aff = $this->mod_menu->edit_main_menu($info, $id);
            if ($i_aff) {
                if ($info['i_parent_id'] == -99) {
                    echo 'hidden';
                } else {
                    echo 'showing';
                }
            } else {
                echo 'error';
            }
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function sub_menu_list($menu_id) {
        try {
            $this->data['heading'] = "Sub Menu Setting"; //Package Name[@package] Panel Heading

            if ($_POST) {
                $posted = array();
                $posted['s_name'] = trim($this->input->post('txt_menu_title'));
                $posted['s_link'] = trim($this->input->post('txt_menu_link'));

                $posted['opt_status'] = intval($this->input->post('opt_status'));


                $info = array();

                $info['i_parent_id'] = decrypt($menu_id);

                if ($posted['opt_status']) {
                    $info['i_main_id'] = decrypt($menu_id);
                } else {
                    $info['i_main_id'] = -99;
                }
                $info['s_name'] = $posted['s_name'];
                $info['s_link'] = $posted['s_link'];

                if ($info['s_name'] != '') {
                    $i_aff = $this->mod_menu->add_main_menu($info);
                    if ($i_aff) {
                        set_success_msg($this->cls_msg["save_succ"]);
                    } else {
                        set_error_msg($this->cls_msg["save_err"]);
                    }
                } else {
                    set_error_msg($this->cls_msg["save_err_blank"]);
                }
            }

            $i_menu_id = decrypt($menu_id);
            $s_where = " WHERE n.i_parent_id=" . $i_menu_id . " OR i_main_id=" . $i_menu_id;
            $info = $this->mod_menu->fetch_sub_menu($s_where);

            //$info    = $this->mod_menu->fetch_multi_sorted_list($s_where,$s_order_name,$order_by,intval($start),$limit);
            //Creating List view for displaying//
            $table_view = array();
            //$order_name = empty($order_name)?encrypt($arr_sort[0]):$order_name; 
            //Table Headers, with width,alignment//
            $table_view["caption"] = "Sub Menus";
            $table_view["total_rows"] = count($info);
            $table_view["detail_view"] = false;
            //$table_view["total_db_records"]=$this->mod_menu->gettotal_info($s_where);
            //$table_view["order_name"]=$order_name;
            //$table_view["order_by"]  =$order_by;
            $table_view["src_action"] = $this->pathtoclass . $this->router->fetch_method();

			$j = 0;
            $table_view["headers"][$j]["width"] = "19%";
            $table_view["headers"][$j]["align"] = "left";
            $table_view["headers"][$j]["val"] = "Sub Menus";
            $table_view["headers"][++$j]["width"] = "10%";
            $table_view["headers"][$j]["val"] = "Menu Link";
            $table_view["headers"][++$j]["width"] = "5%";
            $table_view["headers"][$j]["val"] = "Status";

            $table_view["headers"][++$j]["val"] = "Action";
			 $table_view["headers"][$j]["width"] = "35%";


            //end Table Headers, with width,alignment//
            //Table Data//
            for ($i = 0; $i < $table_view["total_rows"]; $i++) {
                $i_col = 0;
                $table_view["tablerows"][$i][$i_col++] = encrypt($info[$i]["id"]); //Index 0 must be the encrypted PK 
                $table_view["tablerows"][$i][$i_col++] = '<span>' . $info[$i]["s_name"] . '</span>' . '<input style="background: #FFFFC0; display: none;" type="text" value="' . $info[$i]["s_name"] . '">';
                $table_view["tablerows"][$i][$i_col++] = '<span>' . $info[$i]["s_link"] . '</span>' . '<input style="background: #FFFFC0; display: none;" type="text" value="' . $info[$i]["s_link"] . '">';

                $table_view["tablerows"][$i][$i_col++] = ($info[$i]["status"] == 'showing') ? make_label($info[$i]["status"]) : make_label($info[$i]["status"], 'warning');



                $action = '<a id="edit_row_' . $info[$i]["id"] . '" href="javascript:void(0);" class="btn btn-mini btn-primary" ><i class="icon-edit icon-white"></i> Edit</a>';


                $action .=' <a class="btn btn-mini btn-success" id="save_row_' . $info[$i]["id"] . '" href="javascript:void(0);" >
                <i class="icon-save icon-white"></i> Save</a>';


                $action .='&nbsp;&nbsp;<a class="btn btn-mini btn-warning"  id="delete_row_' . $info[$i]["id"] . '" href="javascript:void(0);" >
                <i class="icon-trash icon-white"></i> Delete</a>';


                $action .='&nbsp;&nbsp;<a class="btn btn-mini btn-info"  id="change_row_' . $info[$i]["id"] . '" href="javascript:void(0);" >
                <i class="icon-refresh icon-white"></i> Status</a>';


                if ($info[$i]["s_link"]) {

                    $action .='&nbsp;&nbsp;<a class="btn btn-mini btn-danger"  id="go_row_' . $info[$i]["id"] . '" href="' . admin_base_url() . 'menu_setting/menu_permission/' . encrypt($info[$i]["id"]) . '" target="blank_" >
                 <i class="icon-share-alt icon-white"></i> Set action</a>';
                }


                $table_view["tablerows"][$i][$i_col++] = $action;
            }
            //end Table Data//
            unset($i, $i_col, $start, $limit);

            $this->data["table_view"] = $this->admin_showin_table($table_view);

            //Creating List view for displaying//
            //$this->data["search_action"]=$this->pathtoclass.$this->router->fetch_method();//used for search form action
            //echo $this->data["search_action"];

            $s_where = " WHERE n.i_parent_id=" . $i_menu_id . " AND s_link=''";
            $info_menus = $this->mod_menu->fetch_sub_menu($s_where);
            $arr_menus = array();
            if ($info_menus) {
                foreach ($info_menus as $val) {
                    $arr_menus[$val['id']] = $val['s_name'];
                }
            }

            $this->data['arr_menus'] = $arr_menus;
            $this->render('menu_setting/sub_menu_list');
            unset($table_view, $info);
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function menu_permission($enc_menu_id = '') {
        //echo 'politique de confidentialit&eacute;';
        try {

            $this->data['title'] = "Menu setting"; //Browser Title
            $this->data['heading'] = "Menu Permission";
            $this->data['pathtoclass'] = $this->pathtoclass;
            $this->data['mode'] = "add";

            $i_menu_id = decrypt($enc_menu_id);


            //Submitted Form//
            if ($_POST) 
			{
				$posted = array();
                $posted['txt_action'] = $this->input->post('txt_action');
                $posted['txt_link'] = $this->input->post('txt_link');
                $posted['h_id'] = $this->input->post('h_id');
                $posted['txt_extra_action'] = $this->input->post('txt_extra_action');


                $data = array();

                $s_actions = '';
                if (!empty($posted['txt_action'])) {
                    foreach ($posted['txt_action'] as $key => $val) {

                        if ($val != '') {
                            $s_actions .= $val . '||';
                            $data[$key]['s_action'] = $val;
                            $data[$key]['s_link'] = $posted['txt_link'][$key];
                            $data[$key]['h_id'] = $posted['h_id'][$key];
                        }
                    }
                }

                if (!empty($posted['txt_extra_action'])) {
                    foreach ($posted['txt_extra_action'] as $val) {
                        $s_actions .= $val . '||';
                    }
                }
                $s_actions = rtrim($s_actions, '|');


                //pr($data,1);
                // Edit menu table set all action like Add ||  Edit || Status
                $this->mod_menu->edit_info(array('s_action_permit' => $s_actions), $i_menu_id);

                $info = array();

                if (!empty($data)) {
                    $info['i_menu_id'] = $i_menu_id;
                    $info['i_user_type'] = 0;
                    foreach ($data as $val) {

                        $info['s_action'] = $val['s_action'];
                        $info['s_link'] = $val['s_link'];

                        if ($val['h_id'] == -1)
                            $i_aff = $this->mod_menu->add_menu_permit($info);
                        else
                            $i_aff = $this->mod_menu->edit_menu_permit($info, $val['h_id']);
                    }
                }



                if ($i_aff) {//saved successfully
                    set_success_msg($this->cls_msg["save_succ_permit"]);

                    redirect($this->pathtoclass . "menu_permission/" . $enc_menu_id);
                } else {//Not saved, show the form again
                    set_error_msg($this->cls_msg["save_err_permit"]);
                }
            } 
			else 
			{
                $s_where = " WHERE i_menu_id=" . decrypt($enc_menu_id) . " AND (i_user_type=0 OR i_user_type=-99)";
				$info = $this->mod_menu->fetch_menu_permission($s_where);
				
                $actions = array();
				$temp_action = array();
				if (!empty($info)) {
	                foreach ($info as $key => $val) {
                        $temp_action[] = $val['s_action'];
                        $actions[$key]['txt_action'] = $val['s_action'];
                        $actions[$key]['txt_link'] = $val['s_link'];
                        $actions[$key]['h_id'] = $val['id'];
                    }
                }
				
                $this->data['actions'] = json_encode($actions);
                $info_menu = $this->mod_menu->fetch_this($i_menu_id);
                $all_action = explode('||', $info_menu['s_action_permit']);
                $this->data['extra_action'] = array_diff($all_action, $temp_action);
                unset($all_action, $temp_action, $info_menu, $actions);

                $s_where = " WHERE i_id=" . decrypt($enc_menu_id) . " ";
                $info_menu = $this->mod_menu->fetch_sub_menu($s_where);

                if (!empty($info_menu) && count($info_menu) == 1) {
                    preg_match('~^(.*\/).*~', $info_menu[0]['s_link'], $matches);
                    $this->data['controler_link'] = $matches[1];
                }
            }
            $this->data['i_menu_id'] = decrypt($enc_menu_id);
            $this->data['BREADCRUMB'] = array(addslashes('Menu Permission'));
            /* $this->data['arr_status'] =   array(0=>'Keep',1=>'Add'); */
            $this->data['posted'] = $posted;

            //end Submitted Form//
            $this->render("menu_setting/menu_permission");
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function ajax_delete_menu_permission() {
        try {
            $i_menu_id = intval($this->input->post('i_menu_id'));
            $i_menu_permit_id = intval($this->input->post('i_menu_permit_id'));
            $s_remove_action = $this->input->post('s_remove_action');

            $info_menu = $this->mod_menu->fetch_this($i_menu_id);

            $arr_all_action = explode('||', $info_menu['s_action_permit']);
            $key = array_search($s_remove_action, $arr_all_action);

            unset($arr_all_action[$key]);

            $this->mod_menu->edit_info(array('s_action_permit'=>implode('||',$arr_all_action)),$i_menu_id);

            

            $i_aff  =   $this->mod_menu->delete_menu_permission($i_menu_permit_id);

            if ($i_aff) {
                echo 'ok';
            } else {
                echo 'error';
            }
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function ajax_delete_main_menu() {
        try {
            $menu_id = intval($this->input->post('row_id'));
            $i_aff = $this->mod_menu->delete_main_menu($menu_id);

            if ($i_aff) {
                echo 'ok';
            } else {
                echo 'error';
            }
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function ajax_delete_sub_menu() {
        try {
            $menu_id = intval($this->input->post('row_id'));
            $i_aff = $this->mod_menu->delete_sub_menu($menu_id);
            if ($i_aff) {
                echo 'ok';
            } else {
                echo 'error';
            }
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function __destruct() {
        
    }

}

?>
