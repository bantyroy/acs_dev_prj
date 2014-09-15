<?php

/* * *******
 * Author: Mrinmoy Mondal
 * Date  : 3 Jan 2011
 * Modified By: 
 * Modified Date:
 * 
 * Purpose:
 *  Model For Menu
 * 
 * @package Content Management
 * @subpackage news
 * 
 * @link InfModel.php 
 * @link MY_Model.php
 * @link controllers/news.php
 * @link views/admin/news/
 */

class Menu_model extends MY_Model implements InfModel {

    private $conf;
    private $tbl; ///used for this class
    private $tbl_permit;

    public function __construct() {
        try {
            parent::__construct();
            $this->tbl = $this->db->MENU;
            $this->tbl_permit = $this->db->MENUPERMIT;
            $this->conf = & get_config();
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * ****
     * This method will fetch all records from the db. 
     * 
     * @param string $s_where, ex- " status=1 AND deleted=0 " 
     * @param int $i_start, starting value for pagination
     * @param int $i_limit, number of records to fetch used for pagination
     * @returns array
     */

    public function fetch_multi($s_where = null, $i_start = null, $i_limit = null, $s_action_wh = null) {
        try {
            $ret_ = array();
            $s_qry = "SELECT n.* FROM " . $this->tbl . " n "
                    . ($s_where != "" ? $s_where : "" ) . (is_numeric($i_start) && is_numeric($i_limit) ? " Limit " . intval($i_start) . "," . intval($i_limit) : "" );
            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["s_name"] = $row->s_name;
                    $ret_[$i_cnt]["s_link"] = $row->s_link;
                    $ret_[$i_cnt]["s_action_permit"] = $row->s_action_permit;
                    if ($s_action_wh != null) {
                        $s_wh = $s_action_wh . " And p.i_menu_id ={$row->i_id} ";

                        $ret_[$i_cnt]['actions'] = $this->fetch_action($s_wh);
                    }


                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt, $s_where, $i_start, $i_limit, $s_desc);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function fetch_all_menus($s_where = null, $i_start = null, $i_limit = null, $i_user_type_id) {
        try {
            $ret_ = array();
            $s_qry = "SELECT * FROM " . $this->tbl . " n "
                    . ($s_where != "" ? $s_where : "" ) . (is_numeric($i_start) && is_numeric($i_limit) ? " Limit " . intval($i_start) . "," . intval($i_limit) : "" );
            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["s_name"] = stripslashes(htmlspecialchars_decode($row->s_name));


                    $s_wh = " WHERE n.i_main_id='" . $ret_[$i_cnt]["id"] . "' And n.s_link!='' ";
                    $s_action_wh = " WHERE i_user_type={$i_user_type_id} ";
                    $ret_[$i_cnt]["s_sub_menu"] = $this->fetch_multi($s_wh, '', '', $s_action_wh);

                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt, $s_where, $i_start, $i_limit, $s_desc);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /* to set the menus in top navigation depending on user type 
     *  @see common_helper.php create_menus()
     */

    public function fetch_menus_navigation($s_where = null, $i_user_type_id, $or = ' ORDER BY i_id ASC ') 
	{
        try 
		{
            $ret_ = array();
			
            $s_qry = "SELECT n.*, 
							(
								SELECT count(i_id) 
									FROM {$this->tbl_permit} 
									WHERE i_menu_id = n.i_id AND (i_user_type = '{$i_user_type_id}' OR s_action = 'Default') 
							) AS i_total_controls
			        	FROM " .$this->tbl. " n "
                       .($s_where != "" ? $s_where : "" )
					   .$or 
					   .(is_numeric($i_start)&&is_numeric($i_limit)?" Limit " . intval($i_start) . "," . intval($i_limit) : "" );
            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["s_name"] = stripslashes(htmlspecialchars_decode($row->s_name));
                    $ret_[$i_cnt]["s_link"] = stripslashes(htmlspecialchars_decode($row->s_link));
                    $ret_[$i_cnt]["i_total_controls"] = $row->i_total_controls;
                    $ret_[$i_cnt]["s_icon_class"] = $row->s_icon_class;
                    $ret_[$i_cnt]["t_name"] = $row->{db_field_wrtcl('s_name')};

                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt, $s_where, $i_start, $i_limit, $s_desc);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function fetch_menu_permission_of_user_type($s_where = null, $i_user_type_id) {
        try {
            $ret_ = array();
            $s_qry = "SELECT count(*) AS i_total_controls
			        FROM " . $this->tbl_permit . " n "
                    . ($s_where != "" ? $s_where : "" ) . " And (i_user_type={$i_user_type_id} OR s_action='Default') " . ' ORDER BY i_id ASC ' . (is_numeric($i_start) && is_numeric($i_limit) ? " Limit " . intval($i_start) . "," . intval($i_limit) : "" );


            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["i_total_controls"] = $row->i_total_controls;
                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt, $s_where, $i_start, $i_limit, $s_desc);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function fetch_action($s_where = null, $i_start = null, $i_limit = null) {
        try {
            $ret_ = array();
            $s_qry = "SELECT * FROM " . $this->tbl_permit . " p  "
                    . ($s_where != "" ? $s_where : "" ) . (is_numeric($i_start) && is_numeric($i_limit) ? " Limit " . intval($i_start) . "," . intval($i_limit) : "" );
            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    //$ret_[$i_cnt]["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name));    
                    $ret_[$i_cnt]["s_action"] = stripslashes(htmlspecialchars_decode($row->s_action));
                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt, $s_where, $i_start, $i_limit, $s_desc);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * **
     * Fetch Total records
     * @param string $s_where, ex- " status=1 AND deleted=0 " 
     * @returns int on success and FALSE if failed 
     */

    public function gettotal_info($s_where = null) {
        try {
            $ret_ = 0;
            $s_qry = "Select count(*) as i_total "
                    . "From " . $this->tbl . " n "
                    . ($s_where != "" ? $s_where : "" );
            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_ = intval($row->i_total);
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt, $s_where, $i_start, $i_limit);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *****
     * Fetches One record from db for the id value.
     * 
     * @param int $i_id
     * @returns array
     */

    public function fetch_this($i_id) {
        try {
            $ret_ = array();
            ////Using Prepared Statement///
            $s_qry = "Select * "
                    . "From " . $this->tbl . " AS n "
                    . " Where n.i_id=?";

            $rs = $this->db->query($s_qry, array(intval($i_id)));
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {

                    $ret_["id"] = $row->i_id; ////always integer
                    $ret_["en_s_name"] = $row->en_s_name;
                    $ret_["s_link"] = $row->s_link;
                    $ret_["s_action_permit"] = $row->s_action_permit;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_id);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *
     * Inserts new records into db. As we know the table name 
     * we will not pass it into params.
     * 
     * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
     * @returns $i_new_id  on success and FALSE if failed 
     */

    public function add_info($info) {
        try {
            $i_ret_ = 0; ////Returns false
            if (!empty($info)) {
                $update = array();
                if (isset($info['s_link']))
                    $update['s_link'] = $info['s_link'];
                if (isset($info['i_parent_id']))
                    $update['i_parent_id'] = $info['i_parent_id'];
                if (isset($info['i_main_id']))
                    $update['i_main_id'] = $info['i_main_id'];
                if (isset($info['s_action_permit']))
                    $update['s_action_permit'] = $info['s_action_permit'];
                if (isset($info['s_icon_class']))
                    $update['s_icon_class'] = $info['s_icon_class'];
                if (isset($info['en_s_name']))
                    $update['en_s_name'] = $info['en_s_name'];
                if (isset($info['ar_s_name']))
                    $update['ar_s_name'] = $info['ar_s_name'];
                if (isset($info['i_display_order']))
                    $update['i_display_order'] = $info['i_display_order'];
            }
            unset($s_qry, $info);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * *
     * Update records in db. As we know the table name 
     * we will not pass it into params.
     * 
     * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
     * @param int $i_id, id value to be updated used in where clause
     * @returns $i_rows_affected  on success and FALSE if failed 
     */

    public function edit_info($info, $i_id) {
        try {
            $i_ret_ = 0; ////Returns false
            if (!empty($info)) {
                $update = array();
                if (isset($info['s_link']))
                    $update['s_link'] = $info['s_link'];
                if (isset($info['i_parent_id']))
                    $update['i_parent_id'] = $info['i_parent_id'];
                if (isset($info['i_main_id']))
                    $update['i_main_id'] = $info['i_main_id'];
                if (isset($info['s_action_permit']))
                    $update['s_action_permit'] = $info['s_action_permit'];
                if (isset($info['s_icon_class']))
                    $update['s_icon_class'] = $info['s_icon_class'];
                if (isset($info['en_s_name']))
                    $update['en_s_name'] = $info['en_s_name'];
                if (isset($info['ar_s_name']))
                    $update['ar_s_name'] = $info['ar_s_name'];
                if (isset($info['i_display_order']))
                    $update['i_display_order'] = $info['i_display_order'];

                $this->db->where('i_id', $i_id);
                $this->db->update($this->tbl, $update);
            }
            unset($s_qry, $info, $i_id);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /*     * ****
     * Deletes all or single record from db. 
     * For Master entries deletion only change the flag i_is_deleted. 
     *
     * @param int $i_id, id value to be deleted used in where clause 
     * @returns $i_rows_affected  on success and FALSE if failed 
     * 
     */

    public function delete_info($i_id) {
        
    }

    /*     * **
     * Register a log for add,edit and delete operation
     * 
     * @param mixed $attr
     * @returns TRUE on success and FALSE if failed 
     */

    public function log_info($attr) {
        try {
            $logindata = $this->session->userdata("admin_loggedin");
            return $this->write_log($attr["msg"], decrypt($logindata["user_id"]), ($attr["sql"] ? $attr["sql"] : ""));
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function fetch_main_menu($s_where = '') {
        try {
            $ret_ = array();
            $s_qry = "SELECT n.* FROM " . $this->tbl . " n WHERE n.i_parent_id IN (0,-99) AND i_main_id=0";

            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["s_name"] = stripslashes(htmlspecialchars_decode($row->s_name));
                    $ret_[$i_cnt]["i_parent_id"] = $row->i_parent_id;
                    $ret_[$i_cnt]["status"] = ($row->i_parent_id == -99) ? 'hidden' : 'showing';
                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function add_main_menu($info) {
        try {
            $i_ret_ = 0;
            if (!empty($info)) {
                $s_qry = "Insert Into " . $this->tbl . " Set ";
                $s_qry.=" s_name=? ";
                $s_qry.=", en_s_name=? ";
                $s_qry.=" ,s_link=? ";
                $s_qry.=", i_parent_id=? ";
                $s_qry.=", i_main_id=? ";

                $this->db->query($s_qry, array(
                    trim(htmlspecialchars($info["s_name"])),
                    trim(htmlspecialchars($info["s_name"])),
                    trim(htmlspecialchars($info["s_link"])),
                    $info["i_parent_id"],
                    $info["i_main_id"]
                ));
                $i_ret_ = $this->db->insert_id();
            }
            unset($s_qry, $info);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function edit_main_menu($info, $id) {
        try {
            $i_ret_ = 0;
            if (!empty($info)) {
                $i_ret_ = $this->db->update($this->tbl, $info, array('i_id' => $id));
            }

            unset($s_qry, $info);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function fetch_sub_menu($s_where = '') {
        try {
            $ret_ = array();
            $s_qry = "SELECT n.* FROM " . $this->tbl . " n " . ($s_where != "" ? $s_where : "" );

            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["s_name"] = stripslashes(htmlspecialchars_decode($row->s_name));
                    $ret_[$i_cnt]["s_link"] = stripslashes(htmlspecialchars_decode($row->s_link));
                    $ret_[$i_cnt]["i_parent_id"] = $row->i_parent_id;
                    $ret_[$i_cnt]["i_main_id"] = $row->i_main_id;
                    $ret_[$i_cnt]["status"] = ($row->i_parent_id == -99) ? 'hidden' : 'showing';
                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function fetch_menu_permission($s_where = '') {
        try {
            $ret_ = array();
            $s_qry = "SELECT n.* FROM " . $this->tbl_permit . " n " . ($s_where != "" ? $s_where : "" );

            $rs = $this->db->query($s_qry);

            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["i_menu_id"] = intval($row->i_menu_id);
                    $ret_[$i_cnt]["s_action"] = stripslashes(htmlspecialchars_decode($row->s_action));
                    $ret_[$i_cnt]["s_link"] = stripslashes(htmlspecialchars_decode($row->s_link));
                    $ret_[$i_cnt]["i_user_type"] = $row->i_user_type;
                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($s_qry, $rs, $row, $i_cnt);
            return $ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function add_menu_permit($info) {
        try {
            $i_ret_ = 0;
            if (!empty($info)) {
                $s_qry = "Insert Into " . $this->tbl_permit . " Set ";
                $s_qry.=" i_menu_id=? ";
                $s_qry.=" ,s_action=? ";
                $s_qry.=" ,s_link=? ";
                $s_qry.=", i_user_type=? ";

                $this->db->query($s_qry, array(
                    intval($info["i_menu_id"]),
                    trim(htmlspecialchars($info["s_action"])),
                    trim(htmlspecialchars($info["s_link"])),
                    $info["i_user_type"]
                ));
                $i_ret_ = $this->db->insert_id();
            }
            unset($s_qry, $info);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    public function edit_menu_permit($info, $id) {
        try {
            $i_ret_ = 0;
            if (!empty($info)) {
                $i_ret_ = $this->db->update($this->tbl_permit, $info, array('i_id' => $id));
            }

            unset($s_qry, $info);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /**
     * Delete Main menus with all there submenus label 1 and label 2
     * with all the permission given to all the submenu.
     *  
     * @param mixed $i_main_menu_id
     */
    public function delete_main_menu($i_main_menu_id = '') {
        try {
            $s_qry = " SELECT * FROM " . $this->tbl . " WHERE i_main_id = " . $i_main_menu_id;
            $ret_ = array();

            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["i_parent_id"] = $row->i_parent_id;
                    $ret_[$i_cnt]["status"] = ($row->i_parent_id == -99) ? 'hidden' : 'showing';
                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($rs, $row, $i_cnt);

            if (!empty($ret_)) {
                foreach ($ret_ as $value) {
                    $this->delete_menu_permission($value['id']);
                }
            }

            $s_qry = " DELETE FROM " . $this->tbl . " WHERE i_main_id = " . $i_main_menu_id . " OR i_id = " . $i_main_menu_id;
            $this->db->query($s_qry);
            $i_ret_ = $this->db->affected_rows();
            unset($s_qry);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /**
     * Delete Submenu label 1 or 2 
     * In case of submenu 1 check whether it has submenu label or not
     * Delete menus with there menu permission.
     * 
     * @param int $i_sub_menu_id
     */
    public function delete_sub_menu($i_sub_menu_id = '') {
        try {
            $s_qry = " SELECT * FROM " . $this->tbl . " WHERE i_parent_id = " . $i_sub_menu_id;
            $ret_ = array();

            $rs = $this->db->query($s_qry);
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $ret_[$i_cnt]["id"] = $row->i_id; ////always integer
                    $ret_[$i_cnt]["i_parent_id"] = $row->i_parent_id;
                    $ret_[$i_cnt]["status"] = ($row->i_parent_id == -99) ? 'hidden' : 'showing';
                    $i_cnt++;
                }
                $rs->free_result();
            }
            unset($rs, $row, $i_cnt);

            if (!empty($ret_)) {
                foreach ($ret_ as $value) {
                    $this->delete_menu_permission($value['id']);
                }
            } else {
                $this->delete_menu_permission($i_sub_menu_id);
            }

            $s_qry = " DELETE FROM " . $this->tbl . " WHERE i_parent_id = " . $i_sub_menu_id . " OR i_id = " . $i_sub_menu_id;
            $this->db->query($s_qry);
            $i_ret_ = $this->db->affected_rows();
            unset($s_qry);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }

    /**
     * Delete from menu permit table all the permission associate with menu .
     * 
     * @param int $s_where
     */
    public function delete_menu_permission($i_id) {
        try {
            $s_qry = " DELETE  FROM " . $this->tbl_permit . " WHERE i_id=?";
            $this->db->query($s_qry,array($i_id));
            $i_ret_ = $this->db->affected_rows();
            unset($s_qry);
            return $i_ret_;
        } catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }
	
	public function delete_old_menu_permission($where = '') 
	{
        try 
		{
			if($where == '') return false;
            return $this->db->query(" DELETE  FROM " . $this->tbl_permit . " {$where} ");
        }catch (Exception $err_obj) {
            show_error($err_obj->getMessage());
        }
    }


    public function fetch_access_control($i_user_type = 0) {
        $ret_ = array();

        $s_qry = "SELECT m1.i_id first_label_id,m1.s_name first_label_menu,m2.i_id second_label_id,m2.s_name second_label_menu,m2.s_action_permit,mp2.i_id i_menu_permit_id, mp2.actions
					FROM  ( 
							SELECT *
							FROM " . $this->tbl . "
							WHERE i_parent_id =0
						  )m1
					LEFT JOIN " . $this->tbl . " m2 ON m1.i_id = m2.i_parent_id
					LEFT JOIN ( 
								SELECT mp.i_id,mp.i_menu_id, GROUP_CONCAT( mp.s_action SEPARATOR '##' ) AS actions
								FROM " . $this->tbl_permit . " mp
								WHERE mp.i_user_type = ?
								AND mp.i_menu_id <>0
								GROUP BY (mp.i_menu_id))mp2 ON m2.i_id = mp2.i_menu_id";

        $rs = $this->db->query($s_qry, array($i_user_type));


        if ($rs->num_rows() > 0) {
            foreach ($rs->result() as $row) {
                $ret_[$i_cnt]["first_label_id"] = $row->first_label_id; ////always integer
                $ret_[$i_cnt]["second_label_id"] = $row->second_label_id;
                $ret_[$i_cnt]["first_label_menu"] = $row->first_label_menu;
                $ret_[$i_cnt]["second_label_menu"] = $row->second_label_menu;
                $ret_[$i_cnt]["s_action_permit"] = $row->s_action_permit;
                $ret_[$i_cnt]["i_menu_permit_id"] = $row->i_menu_permit_id;
                $ret_[$i_cnt]["actions"] = $row->actions;

                $i_cnt++; //Incerement row
            }
            $rs->free_result();
        }
        unset($rs, $s_qry);

        return $ret_;
    }

    public function add_menu_permit_for_user($info) {
        $i_aff = 0;
        if (!empty($info)) {
            $s_qry = "SELECT count(*) as i_total "
                    . "FROM " . $this->tbl_permit . " n WHERE i_user_type=? AND i_menu_id=? AND s_action=? ";

            $rs = $this->db->query($s_qry, array('i_user_type' => $info['i_user_type'],
                'i_menu_id' => $info['i_menu_id'],
                's_action' => $info['s_action']
            ));
            $i_cnt = 0;
            if ($rs->num_rows() > 0) {
                foreach ($rs->result() as $row) {
                    $i_cnt = intval($row->i_total);
                }
                $rs->free_result();
            }
            if ($i_cnt == 0) {
                $s_qry = "INSERT INTO " . $this->tbl_permit . " SET ";
                $s_qry.=" i_menu_id=? ";
                $s_qry.=" ,s_action=? ";
                $s_qry.=" ,s_link=? ";
                $s_qry.=", i_user_type=? ";

                $this->db->query($s_qry, array(
                    intval($info["i_menu_id"]),
                    $info["s_action"],
                    $info["s_link"],
                    $info["i_user_type"]
                ));
                $i_aff = $this->db->insert_id();
            }
            else
                $i_aff = $i_cnt;
        }
        return $i_aff;
    }

    public function get_link_for_menu($i_menu_id, $i_user_type = 0) 
	{
        $ret_ = array();
        $s_qry = " SELECT * FROM " . $this->tbl_permit . " WHERE i_menu_id=? AND i_user_type=? ";
        $rs = $this->db->query($s_qry, array('i_menu_id' => $i_menu_id, 'i_user_type' => $i_user_type));
        if ($rs->num_rows() > 0) {
            foreach ($rs->result() as $row) {
                $ret_[$row->s_action] = $row->s_link;
            }
            $rs->free_result();
        }
        unset($rs, $s_qry);
        return $ret_;
    }
	
	// added by JS
	public function delete_old_permission_list($menu_id, $user_type)
	{
		if(intval($menu_id) == 0) return false;
		 return $this->db->query("DELETE FROM {$this->tbl_permit} WHERE i_menu_id = ? AND i_user_type = ?", array('i_menu_id' => $menu_id, 'i_user_type' => $user_type));
	}
    
    
    /****
    * can_user_access having access rights to control them. 
    * Company controller cannot be edited or deleted because in some of php scripts
    * the company id used are hardcodded.
    * 
    * @param int $i_user_type_id, user type; 0=> super admin
    * @returns array of menu controllers 
    */
	
	public function can_user_access($i_user_type_id=null,$s_url)
    {
        try
        { 			
				/**
				* in the database we used to store the link, excluding "admin/" [admin_base_url()] from path.
				* hence  $s_parse_url replaces "/admin/" from raw url
				*/
				
				/**** for checking with full raw url  *****/
				/*$s_parse_url = str_replace("/admin/","",$s_url);
				$s_qry="Select count(*) i_total From ".$this->tbl_permit;
                $s_qry.=" Where (i_user_type=? And s_link LIKE '$s_parse_url%') OR 
						  (s_link LIKE '$s_parse_url%' And s_action='Default' )"; */  
				
				
				$CI = & get_instance();				
				/**** for checking using controller and method  *****/
				$s_check_url = str_replace("/admin/","",$s_url);
				$method = $this->router->fetch_method();
				//$array = $this->uri->ruri_to_assoc(3); 
								
	            $pre_route_controller=$CI->uri->segment(2);
	            $post_route_controller=$CI->uri->rsegment(1);
						  
				$s_qry="Select count(*) AS i_total From ".$this->tbl_permit;
				$s_qry.=" Where (i_user_type=? And (s_link LIKE '".$pre_route_controller."%' OR s_link LIKE '".$post_route_controller."%')) OR 
					  (s_link LIKE '".$s_check_url."%' And s_action='Default')";		                         
                $rs=$this->db->query($s_qry, intval($i_user_type_id));
				//echo $this->db->last_query();
				$row = $rs->result();		
				return $row[0]->i_total;
				
			
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }   	


	/* fetch contorols depending on user access */
	public function fetching_access_control($s_where=null)
    {
        try
        { 			  

			$s_qry="Select * From ".$this->tbl_permit;
			$s_qry.=" Where (i_user_type=? And (s_link LIKE '".$s_where["controller"]."%' OR s_link LIKE '".$s_where["alias_controller"]."%')) OR 
					  ((s_link LIKE '".$s_where["controller"]."%' OR s_link LIKE '".$s_where["alias_controller"]."%') And s_action='Default' )";                            
			
			//$rs=$this->db->query($s_qry, intval($i_user_type_id));
			$rs=$this->db->query($s_qry, $s_where['i_user_type_id']);
			//echo $this->db->last_query();
			$row = $rs->result_array();	
			$ret_ = array();	
			foreach($row as $value)
			{
				$ret_[$value['s_action']] = 1;
			}
			return $ret_;
            
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }

    public function __destruct() {
        
    }

}

///end of class
?>