<?php
/*********
* Author: Arnab Chattopadhyay
* Date  : 30 Dec 2010
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For Dashboard
* 
* @package Home
* @subpackage Dashboard
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/home.php
* @link views/admin/dashboard/
*/


class My_account_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class

    public function __construct()
    {
        try
        {
          parent::__construct();
          $this->tbl = $this->db->USER;          
          $this->conf =&get_config();
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
		  		  ."From ".$this->tbl." n "
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
		  		  ."From ".$this->tbl
				  ." AS u "." Where u.i_id =?";
                
          $rs=$this->db->query($s_qry,array(intval($i_id)));
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {				  
                  $ret_["id"]				= $row->i_id;////always integer
                  $ret_["s_user_name"]		= get_unformatted_string($row->s_user_name); 
				  $ret_["s_first_name"]		= get_unformatted_string($row->s_first_name); 
				  $ret_["s_last_name"]		= get_unformatted_string($row->s_last_name); 
				  $ret_["s_email"]			= get_unformatted_string($row->s_email);
				  $ret_["s_avatar"]			= get_unformatted_string($row->s_avatar);
				  $ret_["s_contact_number"]	= get_unformatted_string($row->s_contact_number);
				  $ret_["s_chat_im"]		= get_unformatted_string($row->s_chat_im);
				  $ret_["dt_created_on"]	= get_unformatted_string($row->dt_created_on);
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
	
	/*public function auth_pass($pass)
	{
		try
        {
			$s_password = md5(trim($pass).$this->conf["security_salt"]);
			$mix_data = $this->session->userdata('admin_loggedin');
			$i_id = decrypt($mix_data['user_id']);
			$this->db->select('i_id');
			$this->db->where('s_password', $s_password);
			$this->db->where('i_id',$i_id);
			$res = $this->db->get($this->tbl);
			$i_count = $res->num_rows();
			unset($s_password, $mix_data,  $i_id, $res);
			return $i_count;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  
	
	}      */    
        
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
        {
          
        }
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
    * @param int $i_id, id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"UPDATE ".$this->tbl." SET ";
                $s_qry.=" s_user_name=? ";
				$s_qry.=" ,s_avatar=? ";
				$s_qry.=" ,s_email=? ";
				$s_qry.=" ,s_contact_number=? ";
				$s_qry.=" ,s_chat_im=? ";
				
				if(isset($info["s_password"]) && !empty($info["s_password"]))
				{
					$s_password = md5(trim($info["s_password"]).$this->conf["security_salt"]);
					$s_qry.=", s_password= '".$s_password."' ";
				}
                $s_qry.=" WHERE i_id=? ";
				
                $i_ret_ = $this->db->query($s_qry,array(  
												  get_formatted_string($info["s_user_name"]),
												  get_formatted_string($info["s_avatar"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_contact_number"]),
												  get_formatted_string($info["s_chat_im"]),
												  intval($i_id)
												 ));
                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(  
												  get_formatted_string($info["s_user_name"]),
												  get_formatted_string($info["s_avatar"]),
												  get_formatted_string($info["s_email"]),
												  get_formatted_string($info["s_contact_number"]),
												  get_formatted_string($info["s_chat_im"]),
												  intval($i_id)
												 )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry,$info,$i_id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }      
    /******
    * Deletes all or single record from db. 
    * For Master entries deletion only change the flag i_is_deleted. 
    *
    * @param int $i_id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
            if(intval($i_id)>0)
            {
                $photo = $this->get_photo_name($i_id);
				get_file_deleted($this->uploaddir, $photo);
				get_file_deleted($this->thumbdir, $photo);

				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();        
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($i_id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($i_id)==-1)////Deleting All
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
            unset($s_qry, $i_id);
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
            $logindata=$this->session->userdata("admin_loggedin");
            return $this->write_log($attr["msg"],decrypt($logindata["user_id"]),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	
	/****
    * Deleting the image name from table
    * 
    * @param int $i_id
    * @returns TRUE on success and FALSE if failed 
    */
   /* public function del_pic($i_id)
	{
		try
        {
			return $this->db->update($this->tbl, array('s_photo'=>''), array('i_id'=>$i_id));
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  
	}*/
	
	/****
    * get the image name from table
    * 
    * @param int $i_id
    * @returns string
    */
    /*public function get_photo_name($i_id)
	{
		try
        {
			$this->db->select('s_photo');
			$this->db->where(array('i_id'=>$i_id));
			$mix_res = $this->db->get_where($this->tbl);
			$mix_name_array = $mix_res->result_array();
			return $mix_name_array[0]['s_photo'];
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  
	}*/
 
  
    public function __destruct()
    {}                 
  
  
}
///end of class
?>