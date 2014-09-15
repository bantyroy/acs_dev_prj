<?php
/*********
* Author: Mrinmoy MOndal
* Date  : 25 June 2013
* Modified By: 
* Modified Date:
* 
* Purpose:
* Model For User
* 
* @package User
* @subpackage User
* 
* @link InfModel.php 
* @link MY_Model.php
* @link controllers/manage_user.php
* @link views/corporate/manage_user/
*/



class User_model extends MY_Model implements InfModel
{
    private $conf;
    private $tbl;///used for this class
	private $tbl_doc;
	private $tbl_manage;
	private $tbl_task;

    public function __construct()
    {
        try
        {
          parent::__construct();
          
		  $this->tbl 			  	= $this->db->USER;
		  $this->tbl_doc 			= $this->db->FILE_ATTACHMENT;
		  $this->tbl_manage 		= $this->db->TASK_MANAGEMENT;
		  $this->tbl_task 			= $this->db->TASK;
		    
		  $this->conf 				= & get_config();
		 
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
	        $s_qry="SELECT * FROM ".$this->tbl
		  			.($s_where!=""?$s_where:"" ).(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
	       	$rs=$this->db->query($s_qry);
			$i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
			  	  $ret_[$i_cnt]["i_id"]			= intval($row->i_id);////always integer
				  $ret_[$i_cnt]["s_first_name"]	= $row->s_first_name; 
				 
				  $ret_[$i_cnt]["s_last_name"]	= $row->s_last_name; 
				 
				  $ret_[$i_cnt]["dt_created_on"]= get_date_required_format($row->dt_created_on); 
				  $ret_[$i_cnt]["s_email"] = $row->s_email; 
				  $ret_[$i_cnt]["s_password"] = $row->s_password; 
				  $ret_[$i_cnt]["s_user_name"] = $row->s_user_name; 
				  $ret_[$i_cnt]["s_address"] = $row->s_address; 
				   
				  $ret_[$i_cnt]["s_contact_number"]= $row->s_contact_number; 
				  $ret_[$i_cnt]["i_created_by"]= $row->i_created_by;
				  $ret_[$i_cnt]["i_status"]= $row->i_status; 				  
				 
			   $i_cnt++; //Incerement row
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
    }   //End of function fetch_multi
	
	
	public function fetch_multi_sorted_list($s_where=null,$order_name,$order_by,$i_start=null,$i_limit=null)
    {
        try
        {
			
          $ret_=array();
		  $s_qry="SELECT * FROM ".$this->tbl." "
                 .($s_where!=""?$s_where:"" )." ORDER BY {$order_name} {$order_by}".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
		
			//echo $s_qry; 
			
          $rs=$this->db->query($s_qry);
          $i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
			  	  $ret_[$i_cnt]["i_id"]				= intval($row->i_id);////always integer
				  $ret_[$i_cnt]["s_first_name"]		= $row->s_first_name; 
				  $ret_[$i_cnt]["s_last_name"]		= $row->s_last_name; 
				  $ret_[$i_cnt]["s_user_name"]		= $row->s_user_name; 
				 
				  $ret_[$i_cnt]["dt_created_on"]	= date('Y-m-d H:i:s',$row->dt_created_on); 
				  $ret_[$i_cnt]["s_email"]			= $row->s_email; 
				  $ret_[$i_cnt]["s_password"]		= $row->s_password; 
				 
				  $ret_[$i_cnt]["s_address"]		= $row->s_address; 
				 $ret_[$i_cnt]["i_created_by"]		= $row->i_created_by;
				  $ret_[$i_cnt]["s_contact_number"]	= $row->s_contact_number; 				  
				  $ret_[$i_cnt]["i_status"]			= $row->i_status; 
				 
                  $i_cnt++; //Incerement row
              }    
              $rs->free_result();          
          }
          unset($s_qry,$rs,$row,$i_cnt,$s_where,$i_start,$i_limit,$order_name,$order_by);
          return $ret_;
         
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	

	
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
          unset($s_qry,$rs,$row,$i_cnt,$s_where);
          return $ret_;
		  
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }  //End of function gettotal_info        
    

    
    
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
	        $s_qry="SELECT * FROM ".$this->tbl." WHERE i_id=".intval($i_id)."";
		  			
	       	$rs=$this->db->query($s_qry);
			$i_cnt=0;
          if($rs->num_rows()>0)
          {
              foreach($rs->result() as $row)
              {
			  	  $ret_[$i_cnt]["i_id"]			= intval($row->i_id);////always integer
				  $ret_[$i_cnt]["s_first_name"]	= $row->s_first_name; 
				 
				  $ret_[$i_cnt]["s_last_name"]	= $row->s_last_name; 
				  $ret_[$i_cnt]["s_user_name"]	= $row->s_user_name; 
				  $ret_[$i_cnt]["i_created_by"]	= $row->i_created_by;
				  $ret_[$i_cnt]["dt_created_on"]= get_date_required_format($row->dt_created_on); 
				  $ret_[$i_cnt]["s_email"]		= $row->s_email; 
				  //$ret_[$i_cnt]["s_password"]		= $row->s_password; 
				  //$ret_[$i_cnt]["s_user_name"]		= $row->s_user_name; 
				  $ret_[$i_cnt]["s_address"]	= $row->s_address; 
				   
				  $ret_[$i_cnt]["s_contact_number"]= $row->s_contact_number; 
				  
				  $ret_[$i_cnt]["i_status"]= $row->i_status; 
				   $ret_[$i_cnt]["i_user_type"]= $row->i_user_type;				  
				 
			   $i_cnt++; //Incerement row
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
    }  //End of function fetch_this     
	

        
    /***
    * Inserts new records into db. As we know the table name 
    * we will not pass it into params.
	* since we have two different user tables to manage, aicte_admin and aicte_college_user
	* so for login access we are using aicte_admin table and for college to user mapping
	* we are using aicte_college_user.
    * 
    * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
    * @returns $i_new_id  on success and FALSE if failed 
    */
	
    public function add_info($info)
    {
		try{
			 $i_ret_=0; ////Returns false
	            if(!empty($info))
	            {
	                $s_qry="Insert Into ".$this->tbl." Set ";
	                $s_qry.=" s_first_name=? ";
					$s_qry.=", s_last_name=? ";
					$s_qry.=", s_user_name=? ";
					$s_qry.=", s_password=? ";
					$s_qry.=", s_email=? ";
					$s_qry.=", s_address=? ";
					$s_qry.=", s_contact_number=? ";
					$s_qry.=", i_created_by=? ";
					$s_qry.=", i_user_type=? ";
					$s_qry.=", i_status=? ";
					
					
					
					$s_qry.=", dt_created_on=NOW() ";
					
	                $this->db->query($s_qry,array(
													  $info["s_first_name"],
													  $info["s_last_name"],
													  $info["s_user_name"],
													  md5(($info["s_password"]).$this->conf["security_salt"]),
													  $info["s_email"],
													  $info["s_address"],
													  $info["s_contact_number"],
													  $info["i_created_by"],
													  $info["i_user_type"],
													  $info["i_status"]
													 ));
													 
					
	                $i_ret_=$this->db->insert_id();     
	                
	            }
	            unset($s_qry, $info );
	            return $i_ret_;
			
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
	                $s_qry="Update ".$this->tbl." Set ";
	                $s_qry.=" s_first_name=? ";
					$s_qry.=", s_last_name=? ";
					$s_qry.=", s_email=? ";
					$s_qry.=", s_address=? ";
					$s_qry.=", s_contact_number=? ";
					$s_qry.=", i_user_type=? ";
					$s_qry.=" Where i_id=? ";
					
					$i_aff=$this->db->query($s_qry,array(
																  $info["s_first_name"],
																  $info["s_last_name"],
																  $info["s_email"],
																  $info["s_address"],
																  $info["s_contact_number"],
																  $info["i_user_type"],
																  $i_id
																 ));
																 
			}
            unset($s_qry, $info,$i_id);
            return $i_aff;
			
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
				$s_qry="DELETE FROM ".$this->tbl." ";
                $s_qry.=" Where i_id=? ";
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();    
				//echo $this->db->last_query();    
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
   
	public function edit_my_account($info,$i_id)
	{
	 try
        {
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"UPDATE ".$this->tbl." SET ";
                $s_qry.=" s_name=? ";
				if(isset($info["s_password"]) && !empty($info["s_password"]))
				{
					$s_password = md5(trim($info["s_password"]).$this->conf["security_salt"]);
					$s_qry.=", s_password= '".$s_password."' ";
				}
                $s_qry.=" WHERE i_id=? ";
				
                $i_ret_ = $this->db->query($s_qry,array(  
												  $info["s_name"],
												  intval($i_id)
												 ));
                //$i_ret_=$this->db->affected_rows();   
                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
                    $logi["sql"]= serialize(array($s_qry,array(  
												  $info["s_name"],
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
	    
	
	public function ckeck_password($s_password)
	{
		/*
		$s_password = md5(trim($s_password).$this->conf["security_salt"]);
		$mix_data = $this->session->userdata('admin_loggedin');
		$i_id = decrypt($mix_data['user_id']);
		
		$s_qry="SELECT i_id FROM ".$this->tbl." 
  		WHERE i_id=?";
        $s_qry.=" And s_password=? ";
		
        $stmt_val	=	array();
		$stmt_val['i_id']	   =	$i_id ;
          /////Added the salt value with the password///

        $stmt_val["s_password"]= $s_password;

        $rs=$this->db->query($s_qry,$stmt_val);
		//echo $this->db->last_query();
		$i_count = $rs->num_rows();
		unset($s_password, $mix_data,  $i_id, $rs);
		return $i_count;
		*/
	}
	
	 public function assign_as_director($i_id,$s_unique_code)
    {
        try
        {
           /*
			$i_ret_=0;////Returns false
           
              
		    $s_qry  = "UPDATE ".$this->tbl." SET ";
            $s_qry.=" e_user_type='DIRECTOR' ";
			$s_qry.=", s_unique_code= '".str_replace('ALA','ALD',$s_unique_code)."' ";
			$s_qry.=", dt_date_of_promotion=NOW() ";
		

            $s_qry.=" WHERE i_id=? ";
            
            $i_ret_ = $this->db->query($s_qry,array(
												  intval($i_id)
												 
                                                 ));
                         
           
            unset($s_qry, $info,$i_id);
            return $i_ret_;*/
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
            $i_ret_=0;////Returns false
            if(!empty($info))
            {
                $s_qry	=	"Update ".$this->tbl." Set ";
                $s_qry.=" i_status= ? ";
                $s_qry.=" Where i_id=? ";
                //echo $i_id.$info['i_is_active'];
                $i_ret_=$this->db->query($s_qry,array(	intval($info['i_status']),
                intval($i_id)
                ));

                if($i_ret_)
                {
                    $logi["msg"]="Updating ".$this->tbl." ";
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
	
	
	
	
	public function fetch_all_data_csv()
	{
		try
		{
			$this->load->dbutil();
			
			$info=array();
			
			$s_query="SELECT i_id as `User Id`, s_first_name as `First Name`, s_last_name as `Last Name`, s_user_name as `User Name`,s_email as `Email`, s_address as `Address`, s_contact_number as `Contact Number`, i_user_type as `User Type Id` FROM ".$this->tbl." where i_id>2";
			
			$sql=$this->db->query($s_query);
			
			$info=$this->dbutil->csv_from_result($sql);
			
			return $info; 
		}
		catch(Exception $err_obj)
		{
			show_error($err_obj->getMessege());
		}
	}	



    # NEW FUNCTIONS [BEGIN]
    
        /***
        * Check if user email already exits
        * 
        */
        public function email_exists($email, $i_user_id='')
        {
            try
            { 
               $ret_=0;
               if($i_user_id=='') 
                {
                
                    $s_qry="SELECT COUNT(*) i_count FROM ".$this->tbl." WHERE ";
                    $s_qry.=" BINARY `s_email`=? ";
                  
                    
                    $this->db->trans_begin();///new   
                    $rs = $this->db->query($s_qry,array(
                                                  get_formatted_string($email)
                                                 ));
                    $this->db->trans_commit();///new   
                  
                }
                else 
                {
                    $s_qry="SELECT COUNT(*) i_count FROM ".$this->tbl." WHERE ";
                    $s_qry.=" binary `s_email`=? ";
                    $s_qry.=" AND id!=? ";
                    
                    $this->db->trans_begin();///new   
                    $rs = $this->db->query($s_qry,array(
                                                  get_formatted_string($email),
                                                  intval($i_user_id)
                                                 ));
                    $this->db->trans_commit();///new   
                    
                }
                
        
                if(is_array($rs->result()))
                {
                    foreach($rs->result() as $row)
                        $ret_=intval($row->i_count);
                    
                    $rs->free_result();          
                }

               
        
                if($ret_==0) {
                    return false;
                }
                else {
                    return true;
                }
            }
            catch(Exception $err_obj)
            {
                show_error($err_obj->getMessage());
            }         
        }


        /***
        * Check if username already exits
        * 
        */
        public function username_exists($email, $i_user_id='')
        {
            try
            { 
               $ret_=0;
               if($i_user_id=='') 
                {
                
                    $s_qry="SELECT COUNT(*) i_count FROM ".$this->tbl." WHERE ";
                    $s_qry.=" BINARY `s_email`=? ";
                  
                    
                    $this->db->trans_begin();///new   
                    $rs = $this->db->query($s_qry,array(
                                                  get_formatted_string($email)
                                                 ));
                    $this->db->trans_commit();///new   
                  
                }
                else 
                {
                    $s_qry="SELECT COUNT(*) i_count FROM ".$this->tbl." WHERE ";
                    $s_qry.=" binary `s_email`=? ";
                    $s_qry.=" AND id!=? ";
                    
                    $this->db->trans_begin();///new   
                    $rs = $this->db->query($s_qry,array(
                                                  get_formatted_string($email),
                                                  intval($i_user_id)
                                                 ));
                    $this->db->trans_commit();///new   
                    
                }
                
        
                if(is_array($rs->result()))
                {
                    foreach($rs->result() as $row)
                        $ret_=intval($row->i_count);
                    
                    $rs->free_result();          
                }

               
        
                if($ret_==0) {
                    return false;
                }
                else {
                    return true;
                }
            }
            catch(Exception $err_obj)
            {
                show_error($err_obj->getMessage());
            }         
        }
    
    # NEW FUNCTIONS [END]
	
    public function __destruct()
    {}                 
  
  
}
///end of class
?>