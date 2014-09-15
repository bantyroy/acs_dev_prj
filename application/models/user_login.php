<?php
/*********
* Author: Sahinul Haque
* Date  : 15 Nov 2010
* Modified By: 
* Modified Date:
* Purpose:
*  Model For User Login
* @package User
* @subpackage Login
* @includes infModel.php 
* @includes MY_Model.php
* @link MY_Model.php
*/


class User_login extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_usr;

    public function __construct()
    {
        try
        {
          parent :: __construct();
		  $this->tbl_usr = $this->db->USER;
          $this->conf=&get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	/* update last login date */
	
	public function update_login_date($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_frontend_user." Set ";
                $s_qry.=" i_last_login_date=? ";
                $s_qry.=" Where id=? ";
                
                $this->db->query($s_qry,array(    
                                                      intval($info["i_last_login_date"]),
													  intval($i_id)

                                                     ));
                $i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_frontend_user." ";
                    $logi["sql"]= serialize(array($s_qry,array(    
                                                      intval($info["i_last_login_date"]),
													  intval($i_id)

                                                     )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry, $info,$i_id);
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
	public function update_login_time($i_id)
	{
		$this->db->query("UPDATE ".$this->tbl_emp." SET dt_last_login_date=NOW() WHERE id=?",array('id'=>$i_id));
		
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
			$s_qry = "SELECT * FROM {$this->tbl_usr} AS n "
					 ."{$s_where} "
					 .(is_numeric($i_start) && is_numeric($i_limit)?" LIMIT ".intval($i_start).",".intval($i_limit):"");
			return $this->db->query($s_qry)->result_array();
			//echo $this->db->last_query();
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
            return $this->db->count_all($this->tbl);
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
			//Using Prepared Statement//
			return $this->db->query("SELECT n.* FROM {$this->tbl_usr} AS n WHERE n.i_id = ?",array(intval($i_id)))->result_array();
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
    * @param int $id, id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($id)
    {
        try
        {
            $i_ret_=0;//Returns false
    
            if(intval($id)>0)
            {
				$s_qry="DELETE FROM ".$this->tbl_usr." ";
                $s_qry.="WHERE i_id=? ";
                $this->db->query($s_qry, array(intval($id)) );
				
                $i_ret_=$this->db->affected_rows();       
                if($i_ret_)
                {
                    $logi["msg"]="Deleting ".$this->tbl_usr." ";
                    $logi["sql"]= serialize(array($s_qry, array(intval($id))) ) ;
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                           
            }
            elseif(intval($id)==-1)//Deleting All
            {
				$s_qry="DELETE FROM ".$this->tbl_usr." ";
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
            $logindata=$this->session->userdata("admin_loggedin");
            return $this->write_log($attr["msg"],decrypt($logindata["user_id"]),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }  
	
	public function backend_user_login($login_data)
    {
         try
        {
          	$ret_=array();
		  
	  	    $s_qry="SELECT i_id,s_first_name,s_last_name,s_email,i_status,i_user_type FROM ".$this->tbl_usr." 
	  		WHERE s_user_name=?";
	        $s_qry.=" And s_password=? ";
	        $s_qry.="And i_status=1 ";

	        $stmt_val["s_user_name"]= trim($login_data["s_user_name"]);
	        /////Added the salt value with the password///

	        $stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);

	        $rs=$this->db->query($s_qry,$stmt_val);
			
			if($rs->num_rows()>0)
	        {
	              foreach($rs->result() as $row)
	              {
	                  $ret_["id"]=$row->i_id;////always integer
	                  $ret_["s_first_name"] = $row->s_first_name;
					 
					  $ret_["s_user_name"] = $row->s_user_name; 
	                  $ret_["s_full_name"] = $row->s_first_name.' '.$row->s_last_name; 
	                  $ret_["email"] = $row->s_email; 
	                  $ret_["i_user_type_id"]= $row->i_user_type;
	                  
	                  $ret_["s_status"]=(intval($row->i_status)==1?"Active":"InActive"); 
	                  
	                  ////////saving logged in user data into session////
	                  $this->session->set_userdata(array(
	                                                    "admin_loggedin"=> array(
	                                                    "user_id"=> encrypt(intval($ret_["id"])),
														"user_type_id"=> encrypt(intval($ret_["i_user_type_id"])),
	                                                    "user_name"=> $ret_["s_user_name"],
	                                                    "user_fullname"=> $ret_["s_full_name"],
	                                                    "user_status"=> $ret_["s_status"]       
	                                                           
	                                                        
	                                              )));
	                  ////////end saving logged in user data into session////
	                  //////////log report///
	                    $logi["msg"]="Logged in as ".$ret_['s_user_name']
	                                ."[".$ret_["s_unique_code"]."] at ".date("Y-M-d H:i:s") ;
	                    //$logi["sql"]= serialize(array($s_qry) ) ;
	                    //$logi["user_id"]=$ret_["id"];///Loggedin User Id                                 
	                    $this->log_info($logi); 
	                    unset($logi);  
	                    //////////end log report///   
	                   
	                  
	              }    
	              $rs->free_result();          
	          }
		 
          unset($s_qry,$rs,$row,$login_data,$stmt_val);
          return $ret_;
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	public function fe_user_login($login_data)
    {
		try
		{
			$ret_ = array();
			$s_qry = "SELECT i_id, s_first_name, s_last_name, s_user_name, s_email, i_status, i_user_type FROM ".$this->tbl_usr." 
						WHERE s_email = ? And s_password = ? AND i_status = 1 AND i_is_verified = 1 AND i_user_type IN(1,2)";
			
			$stmt_val["s_user_name"] = trim($login_data["s_user_name"]);
			//Added the salt value with the password
			$stmt_val["s_password"]= md5(trim($login_data["s_password"]).$this->conf["security_salt"]);
			$rs = $this->db->query($s_qry,$stmt_val);
			if($rs->num_rows()>0)
			{
				foreach($rs->result() as $row)
				{
					$ret_["id"]=$row->i_id;//always integer
					$ret_["s_first_name"] = $row->s_first_name;
					$ret_["s_user_name"] = $row->s_user_name; 
					$ret_["s_full_name"] = $row->s_first_name.' '.$row->s_last_name; 
					$ret_["email"] = $row->s_email; 
					$ret_["i_user_type"]= $row->i_user_type;
					$ret_["s_status"]=(intval($row->i_status)==1?"Active":"InActive"); 
					
					//saving logged in user data into session
					$this->session->set_userdata(
													array(
															"fe_loggedin"=> 
																array(
																		"user_id"		=> encrypt(intval($ret_["id"])),
																		"user_type"		=> encrypt(intval($ret_["i_user_type"])),
																		"user_name"		=> $ret_["s_user_name"],
																		"user_fullname"	=> $ret_["s_full_name"],
																		"first_name"	=> $ret_['s_first_name'],
																		"user_status"	=> $ret_["s_status"],
																		"email"			=> $ret_["email"]
																	 )
														)
												);
					//end saving logged in user data into session
					//log report
					$logi["msg"]="Logged in as ".$ret_['s_user_name']."[".$ret_["s_unique_code"]."] at ".date("Y-M-d H:i:s") ;
					$this->log_info($logi); 
					unset($logi);  
					//end log report
				}    
				$rs->free_result();          
			}
			unset($s_qry,$rs,$row,$login_data,$stmt_val);
			return $ret_;
		}
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
	
	
	public function change_status($info,$i_id)
    {
        try
        {
            $i_ret_=0;//Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl_usr." Set ";
                $s_qry.=" i_status= ? ";
                $s_qry.=" Where i_id=? ";
                //echo $i_id.$info['i_is_active'];
                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_status']),
                intval($i_id)
                ));

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl_usr." ";
                    $logi["sql"]= serialize(array($s_qry,array(	intval($info['i_status']),
                    intval($i_id)
                    )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi,$logindata);
                }                                                
            }
            unset($s_qry, $info,$i_id);
            return $i_ret_;
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