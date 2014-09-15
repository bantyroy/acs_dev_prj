<?php
/*********
* Author: Mrinmoy Mondal
* Date  : 06 July 2013
* Modified By: 
* Modified Date: 
* 
* Purpose:
*  Model For auto mail
* 
* @package CMS
* @subpackage auto_mail
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/Auto_mail.php
* @link views/admin/auto_mail/
*/


class Auto_mail_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->tbl = $this->db->AUTOMAIL;          
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
			if($s_where) $this->db->where($s_where, '', false);
			return $this->db->get($this->tbl, $i_limit, $i_start)->result_array();
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
			if($s_where) $this->db->where($s_where,'',false);
			return $this->db->count_all_results($this->tbl);		
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }         
    

    /*******
    * Fetches One record from db for the id value.
    * 
    * @param int $id
    * @returns array
    */
    public function fetch_this($i_id)
    {
        try
        {
			return $this->db->get_where($this->tbl, array('i_id'=>$i_id))->result_array();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }            
		
    //public function fetch_contact_us_content($key,$type)
	public function fetch_mail_content($key)
    {
        try
        {
			$ret_=array();
			////Using Prepared Statement///
			$s_qry = "SELECT n.* FROM {$this->tbl} AS n  WHERE n.s_key='{$key}' ";
			$rs=$this->db->query($s_qry,array(intval($id))); 
			if($rs->num_rows()>0)
			{
				foreach($rs->result() as $row)
				{
					$ret_["id"]			= $row->i_id;////always integer
					$ret_["s_subject"]	= $row->s_subject; 
					$ret_["s_body"]	= $row->s_body; 		  
				}    
				$rs->free_result();          
			}
			unset($s_qry,$rs,$row,$id);
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
    {
        try
        {}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }            

    /***
    * Update records in db. As we know the table name 
    * we will not pass it into params.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @param int $id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$id)
    {
        try
        {}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }      
    /******
    * Deletes all or single record from db. 
    * For Master entries deletion only change the flag i_is_deleted. 
    *
    * @param int $id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($id)==-1)////Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl." ";
                $this->db->query($s_qry);
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting all information from ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                
            }
            unset($s_qry, $id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }      

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
            //$logindata=$this->session->userdata("admin_loggedin");
            return $this->write_log($attr["msg"],decrypt(get_userLoggedIn("user_id")),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
    public function __destruct()
    {}                 
  
  
}