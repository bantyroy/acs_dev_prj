<?php
/*********
* Author: Acumen CS
* Date  : 30 Jan 2014
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
* @link controllers/menu_permission.php
* @link views/admin/menu_permission/
*/


class Permission_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->MENU;    
		  $this->tbl_permit = $this->db->MENUPERMIT;      
          $this->conf =& get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }

    /******
    * This method will fetch all records from the db. 
    * 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @param int $i_start, starting value for pagination
    * @param int $i_limit, number of records to fetch used for pagination
    * @returns array
    */
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null)
    {
        try
        {
          	$ret_=array();
			$s_qry="SELECT * FROM ".$this->tbl_permit." n "
                .($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_[$i_cnt]["id"]=$row->i_id;////always integer
                  $ret_[$i_cnt]["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name));    
				  $ret_[$i_cnt]["s_link"]=stripslashes(htmlspecialchars_decode($row->s_link));                
                  $i_cnt++;
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit, $s_desc);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	
	
	/****
    * Fetch Total records
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function gettotal_info($s_where=null)
    {
        try
        {
          $ret_=0;
          $s_qry="Select count(*) as i_total "
                ."From ".$this->tbl_permit." n "
                .($s_where!=""?$s_where:"" );
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit);
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }         
    

    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id)
    {
        try
        {
          $ret_=array();
          ////Using Prepared Statement///
          $s_qry="Select * "
                ."From ".$this->tbl." AS n "
                ." Where n.i_id=?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id))); 		  
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
				  
                  $ret_["id"]=$row->i_id;////always integer
                  $ret_["s_name"]=stripslashes(htmlspecialchars_decode($row->s_name)); 
				  $ret_["s_link"]=stripslashes(htmlspecialchars_decode($row->s_link)); 
                 
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_id);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }            
        
    /***
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
    public function add_info($info)
    {}            
	/// insert query to insert into menu permit table   ////
	/*$s_qry = "INSERT INTO `format`.`quoteurjob_menu_permit` (`i_id`,`i_menu_id`,`action`,`s_link`,`i_user_type`)
				VALUES (NULL , '4', 'Delete', 'state/remove_information/', '0')";*/
	
    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {}      
    /******
    * Deletes all or single record from db. 
    * For Master entries deletion only change the flag i_is_deleted. 
    *
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($i_id)
    {}      

    /****
    * Register a log for add,edit and delete operation
    * 
    * @param mixed $attr
    * @returns TRUE on success and FALSE if failed 
    */
    public function log_info($attr)
    {
        try
        {
            $logindata=$this->session->userdata("admin_loggedin");
            return $this->write_log($attr["msg"],decrypt($logindata["user_id"]),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
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
				$i_user_type_id = intval($i_user_type_id);
				$s_check_url = str_replace("web_master/","",$s_url);
				$method = $this->router->fetch_method();
				//$array = $this->uri->ruri_to_assoc(3); 
								
	            $pre_route_controller=$CI->uri->segment(2);
	            $post_route_controller=$CI->uri->rsegment(1);
						  
				/*$s_qry="Select count(*) AS i_total From ".$this->tbl_permit;
				$s_qry.=" Where (i_user_type=? And (s_link LIKE '".$pre_route_controller."%' OR s_link LIKE '".$post_route_controller."%')) OR (s_link LIKE '".$s_check_url."%' And s_action='Default')";		
				$rs=$this->db->query($s_qry, intval($i_user_type_id));*/ // BY JS
				
				if($method == 'index') $method = '';
				
				$sql = "SELECT COUNT(*) AS i_total FROM {$this->tbl_permit} WHERE (i_user_type = {$i_user_type_id} AND (s_link LIKE '".$pre_route_controller.'/'.$method."%' OR s_link LIKE '".$post_route_controller.'/'.$method."%')) OR (i_user_type = {$i_user_type_id} AND s_link = '{$s_check_url}') OR ((s_link LIKE '".$s_check_url."%' OR s_link LIKE '".$method."%') AND s_action='Default') OR ('".$s_check_url."' LIKE '%ajax_%'  OR '".$s_check_url."' LIKE '%nap\_%') ";
				                         
                $row = $this->db->query($sql)->result_array();
				return $row[0]['i_total'] > 0 ? true : false;
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
			$s_qry.=" Where (i_user_type=? And (s_link LIKE '".$s_where["controller"]."/%' OR s_link LIKE '".$s_where["alias_controller"]."/%')) OR 
					  ((s_link LIKE '".$s_where["controller"]."/%' OR s_link LIKE '".$s_where["alias_controller"]."/%') And s_action='Default' )";                            
			
			//$rs=$this->db->query($s_qry, intval($i_user_type_id));
			$rs=$this->db->query($s_qry, $s_where['i_user_type_id']);
			//echo $this->db->last_query();exit;
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



	
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>