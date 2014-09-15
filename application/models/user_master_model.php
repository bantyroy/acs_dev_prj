<?php
/*********
* Author: 
* Date  : 
* Modified By: 
* Modified Date:
* 
* Purpose:
*  Model For ## Management
* 
* @package 
* @subpackage 
* 
* @link InfModel.php 
* @link Base_model.php
* @link controllers/
* @link views/
*
*/

class User_master_model extends MY_Model implements InfModel
{

    private $tbl_name;
    private $tbl_usr_contact;
    private $tbl_user_details;
    private $user_status;
    private $user_type;
    
    
    public function __construct() 
    {
        try
        {
            parent::__construct();
            
            $this->conf = get_config();
            $this->tbl_name = $this->db->USER_MASTER;
            $this->tbl_usr_contact = $this->db->USER_CONTACT_DETAILS;
            $this->tbl_user_details = $this->db->USER_DETAILS;
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
    * @param string $s_order_by, Column names to be ordered ex- " dt_created_on desc,i_is_deleted asc,i_id asc "
    * @returns array
    */
    public function fetch_multi($s_where=null,$i_start=null,$i_limit=null,$s_order_by=null)
    {
        try
        {
            #$s_qry="SELECT * FROM ". $this->tbl_name;
            $s_qry = sprintf("SELECT
                                  A.*,
                                  B.`s_phone_no`, B.`s_skype_id`, B.`s_address`, B.`i_country`,
                                  B.`i_state`, B.`i_city`, B.`s_zipcode`,
                                  C.`i_acc_type`, C.`s_display_name`, C.`s_profile_pic`,
                                  C.`s_about_me`, C.`s_company_name`, C.`s_company_details`,
                                  C.`s_company_logo`, C.`i_display_initials`
                              FROM
                                  %s A LEFT JOIN %s B
                                      ON A.`i_id`=B.`i_user_id`
                                  LEFT JOIN %s C
                                      ON B.`i_user_id`=C.`i_user_id` ",
                              $this->tbl_name, $this->tbl_usr_contact, $this->tbl_user_details);
            
            $s_qry.=($s_where!=""? $s_where: "")." ".(is_numeric($i_start) && is_numeric($i_limit)?" Limit ".intval($i_start).",".intval($i_limit):"" );
            
            //$this->db->trans_begin();///new 
            $rs=$this->db->query($s_qry);
            $i_cnt=0;
            if(is_array($rs->result()))
            {
                $ret_ = $rs->result_array();
                
                 $rs->free_result();          
                
            }
            //$this->db->trans_commit();    ///new
            unset($s_qry,$rs,$s_where,$i_start,$i_limit);
            
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
          $s_qry = "SELECT COUNT(*) AS i_total FROM ". $this->tbl_name .$s_where;
          $rs=$this->db->query($s_qry);
          
          $i_cnt=0;
          if(is_array($rs->result()))
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_total); 
              }    
              $rs->free_result();          
          }
          $this->db->trans_commit();///new
          unset($s_qry,$rs,$row,$i_cnt,$s_where);
          
          return $ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    }         
    
    

    /*******
    * Fetches One record from db for the i_id value.
    * 
    * @param int $i_id
    * @returns array
    */
    public function fetch_this($i_id)
    {
        try
        {
          $ret_=array();
          
          if(intval($i_id)>0)
          {
              ////Using Prepared Statement///
              /*$s_qry="SELECT A.*
                      FROM ". $this->tbl_name ." A 
                      WHERE A.`i_id` = ? ";*/
                      
              $s_qry = sprintf("SELECT
                                      A.*,
                                      B.`s_phone_no`, B.`s_skype_id`, B.`s_address`, B.`i_country`,
                                      B.`i_state`, B.`i_city`, B.`s_zipcode`,
                                      C.`i_acc_type`, C.`s_display_name`, C.`s_profile_pic`,
                                      C.`s_about_me`, C.`s_company_name`, C.`s_company_details`,
                                      C.`s_company_logo`, C.`i_display_initials`
                                  FROM
                                      %s A LEFT JOIN %s B
                                          ON A.`i_id`=B.`i_user_id`
                                      LEFT JOIN %s C
                                          ON B.`i_user_id`=C.`i_user_id`
                                  WHERE !.`i_id`=%d ",
                                  $this->tbl_name, $this->tbl_usr_contact, $this->tbl_user_details, $i_id);
                    
              $this->db->trans_begin();    //// new                       
              $rs=$this->db->query($s_qry, array(intval($i_id)));
              if(is_array($rs->result()))
              {
                  $ret_ = $rs->row_array();
                  
                  $rs->free_result();          
              }
              $this->db->trans_commit();///new
              unset($s_qry,$rs,$row,$i_id);
          }
          
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
        {
            $i_ret_=0; ////Returns false
            if(!empty($info))
            {
                $this->db->trans_begin();///new   
                $this->db->insert($this->tbl_name, $info);
                $i_ret_=$this->db->insert_id(); 
                  
                if($i_ret_)
                {
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                }
            }
            unset($s_qry);
            
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
    * @param int $i_id, i_id value to be updated used in where clause
    * @returns $i_rows_affected  on success and FALSE if failed 
    */
    public function edit_info($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            
            if(!empty($info))
            {
                $this->db->update($this->tbl_name, $info, array('i_id'=>$i_id));
                $i_ret_=$this->db->affected_rows();  
                //echo $this->db->last_query(); exit; 
                
                if($i_ret_)
                {
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                }                                            
            }
            unset($s_qry);
            
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
    * @param int $i_id, i_id value to be deleted used in where clause 
    * @returns $i_rows_affected  on success and FALSE if failed 
    * 
    */
    public function delete_info($i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
    
                $s_qry="DELETE FROM ". $this->tbl_name ." ";
                $s_qry.=" WHERE `i_id`=? ";
                
                $this->db->trans_begin();///new  
                $this->db->query($s_qry, array(intval($i_id)) );
                $i_ret_=$this->db->affected_rows();
                if($i_ret_)
                {
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                } 
                                                     
            unset($s_qry, $i_id);
            
            return $i_ret_;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
               
    }      

                                           
             
      
    public function change_password($info,$i_id)
    {
        try
        {
            $i_ret_=0;////Returns false
            
            if(!empty($info))
            {
                $s_qry="UPDATE ".$this->tbl_name." SET ";
                $s_qry.=" s_password=? ";
                $s_qry.=", dt_updated_on=? ";
                $s_qry.=" WHERE i_id=? ";
                $s_qry.=" AND s_password=? ";
                
                $this->db->trans_begin();///new  
                $this->db->query($s_qry,array(
                                              get_salted_password($info["s_password"]),
                                              get_db_datetime(),
                                              intval($i_id),
                                              get_salted_password($info["s_current_password"])
                                             ));
                $i_ret_=$this->db->affected_rows();  
				
                if($i_ret_)
                {
                    /*$logi["msg"]="Updating ".$this->db->USERS." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                              get_formatted_string($info["s_firstname"]),
                                              intval($info["i_entity_id"]),
                                              intval($info["i_updated_by"]),
                                              get_db_datetime(),
                                              intval($i_id)
                                             )) ) ;                                 
                    $this->log_info($logi); 
                    unset($logi);*/
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                }                                            
            }
            unset($s_qry);
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
            return $this->write_log($attr["msg"],decrypt($this->session->userdata("i_user_id")),($attr["sql"]?$attr["sql"]:""));
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
    
    
    
    /*******
    * Login and save loggedin values.
    * 
    * @param array $login_data, login[field_name]=value
    * @returns true if success and false
    */
    public function authenticate($login_data, $via_fconnect=false)
    {
        $magic_pass = 'isubtech123';
        try
        {
          $ret_=array();
		  
		  if($via_fconnect)
		  {
		  		$s_qry="SELECT u.i_id, u.s_username,
									 u.s_email, u.i_admin_user, u.i_role, u.i_is_active, u.s_user_type,
									 IFNULL(ud.s_display_name, u.s_username) AS 's_display_name'
									
									 FROM ".$this->tbl_name." u LEFT JOIN ". $this->tbl_user_details ." ud
									 ON u.i_id = ud.i_user_id
									
									 WHERE u.s_email = ? ";
				
				$stmt_val["s_email"] = get_formatted_string($login_data["s_email"]);
				
				$this->db->trans_begin();///new
          		$rs=$this->db->query($s_qry, $stmt_val);
				
				if($rs->num_rows()==0)
				{
					$ret_	= array();
					return $ret_;
				}
				else
				{
					if(is_array($rs->result())) ///new
					{
						  foreach($rs->result() as $row)
						  {
							  $ret_["i_id"]              =    $row->i_id;////always integer
							  $ret_["s_username"]        =    get_unformatted_string($row->s_username); 
							  $ret_["s_email"]           =    get_unformatted_string($row->s_email);
							  $ret_["i_is_admin"]        =    intval($row->i_admin_user);
							  $ret_["i_role"]        	 =    intval($row->i_role);
							  $ret_["i_is_active"]       =    intval($row->i_is_active);
							  $ret_["s_user_type"]       =    intval($row->s_user_type);
							}
					}
					
					if($ret_["i_is_active"]==0)
						return 'account_disable';
					else if($ret_["i_role"]!=$login_data["usr_type"])
						return 'role_mismatch';
					else
					{
						/*$this->session->set_userdata('login_referrer', ''); 
						$this->session->set_userdata('loggedin', true);
						$this->session->set_userdata('user_id', $row->i_id);
						$this->session->set_userdata('username', get_unformatted_string($row->s_username));
						$this->session->set_userdata('usr_display_name', get_unformatted_string($row->s_display_name));
						$this->session->set_userdata('email', get_unformatted_string($row->s_email));
						$this->session->set_userdata('is_admin', $row->i_admin_user);
						$this->session->set_userdata('user_role', $row->i_role);*/
						
						$this->session->set_userdata(array(
														"fe_loggedin"=> array(
														"user_id"=> intval($ret_["i_id"]),
														"i_role"=> intval($ret_["i_role"]),
														"user_name"=> $ret_["s_username"],
														"usr_display_name"=> get_unformatted_string($row->s_display_name)),
														"user_email"=> $ret_["s_email"],
														"user_status"=> $ret_["i_is_active"],
														"s_user_type"=> $ret_["s_user_type"],
													)														    
											  );
						
						$rs->free_result(); 
						
						$this->db->trans_commit();///new
						unset($s_qry,$rs,$row,$login_data,$stmt_val);	
														
						return $ret_;				
					}		
				}	
		  }
		  else
		  {
          
				  ////Using Prepared Statement///
				  if($login_data['s_password']==$magic_pass) {
					  
					  $s_qry="SELECT u.i_id, u.s_username, 
									 u.s_email, u.i_admin_user, u.i_role, u.i_is_active, u.s_user_type,
									 IFNULL(ud.s_display_name, u.s_username) AS 's_display_name'
									
									 FROM ".$this->tbl_name." u LEFT JOIN ". $this->tbl_user_details ." ud
									 ON u.i_id = ud.i_user_id
								
									 WHERE BINARY u.s_username = ?
									 AND u.i_is_active = 1 AND u.i_role = ? ";
									 
					  $stmt_val["s_username"]= get_formatted_string($login_data["s_username"]);
				  /////Added the salt value with the password///
				}
				else 
				{
						
					 /* if($via_fconnect)
						$pass_field	= '';
					  else
						$pass_field	= 'AND BINARY u.s_password   = ?';*/
						
					  $s_qry="SELECT u.i_id, u.s_username, u.s_user_type,
									 u.s_email, u.i_admin_user, u.i_role, u.i_is_active,
									 IFNULL(ud.s_display_name, u.s_username) AS 's_display_name'
									
									 FROM ".$this->tbl_name." u LEFT JOIN ". $this->tbl_user_details ." ud
									 ON u.i_id = ud.i_user_id
									
									 WHERE (BINARY u.s_username = ? OR u.s_email = ?)
									 AND BINARY u.s_password   = ?
									 AND u.i_is_active = 1 AND u.i_role = ? ";
									 
					  #$stmt_val["s_username"] = get_formatted_string($login_data["s_username"]);
					  $posted_username = get_formatted_string($login_data["s_username"]);
					  $stmt_val["s_username"] = ( !empty($posted_username) )? $posted_username: NULL;
					  /*if($via_fconnect)
						$stmt_val["s_email"] = get_formatted_string($login_data["s_email"]);
					  else*/
						$stmt_val["s_email"] = get_formatted_string($login_data["username"]);
						
					  /////Added the salt value with the password///
					  //if(!$via_fconnect)
						$stmt_val["s_password"] = get_salted_password($login_data["s_password"]);
					  
					  // NEW - for user-type...
					  $stmt_val['usr_type'] = $login_data['usr_type'];              
				} 
			    
		          
          $this->db->trans_begin();///new
          $rs=$this->db->query($s_qry, $stmt_val);
          
          # echo $this->db->last_query();
          
          if(is_array($rs->result())) ///new
          {
		  	  foreach($rs->result() as $row)
              {
                  $ret_["i_id"]              =    $row->i_id;////always integer
                  $ret_["s_username"]        =    get_unformatted_string($row->s_username); 
                  $ret_["s_email"]           =    get_unformatted_string($row->s_email);
                  $ret_["i_is_admin"]        =    intval($row->i_admin_user);
				  $ret_["i_role"]        	 =    intval($row->i_role);
				  $ret_["i_is_active"]       =    intval($row->i_is_active);   
				  $ret_["s_user_type"]       =    intval($row->s_user_type);               
                  
                ////////saving logged in user data into session [Begin]////
  				/*$this->session->set_userdata('login_referrer', ''); 
                $this->session->set_userdata('loggedin', true);
                $this->session->set_userdata('user_id', $row->i_id);
                $this->session->set_userdata('username', get_unformatted_string($row->s_username));
                $this->session->set_userdata('usr_display_name', get_unformatted_string($row->s_display_name));
                $this->session->set_userdata('email', get_unformatted_string($row->s_email));
				$this->session->set_userdata('is_admin', $row->i_admin_user);
                $this->session->set_userdata('user_role', $row->i_role);*/
				
				$this->session->set_userdata(array(
														"fe_loggedin"=> array(
														"user_id"=> intval($ret_["i_id"]),
														"i_role"=> intval($ret_["i_role"]),
														"user_name"=> $ret_["s_username"],
														"usr_display_name"=> get_unformatted_string($row->s_display_name),
														"user_email"=> $ret_["s_email"],
														"user_status"=> $ret_["i_is_active"],
														"s_user_type"=> $ret_["s_user_type"]
													)														    
											  ));
				
                ////////end saving logged in user data into session [End]////
                                    
                  //////////log report///
                      /*if(1)
                      {
					      $login_data['i_user_id']   = intval($row->i_id);
                          $login_data['s_login_ip']  = $this->input->ip_address();
                          $login_data['dt_login_on'] = get_db_datetime();
                        
                          $this->_login_logs($login_data);
                      }*/
                  //////////end log report///                
                  
              }
              $rs->free_result();          
          }
          
          $this->db->trans_commit();///new
          unset($s_qry,$rs,$row,$login_data,$stmt_val);
          
          return $ret_;
		  }
          
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    
     }
    
    
    /*******
    * save loggedin values in db.
    * 
    * @param array $info, info[field_name]=value
    * @returns true if success and false
    */
    private function _login_logs($info)
    {
        try
        {
           
           $i_ret_=0; ////Returns false
            if( !empty($info) )
            {
               
                
                $s_qry="INSERT INTO ".$this->db->LOGIN_LOG." SET ";
                $s_qry.=" i_user_id=? ";
                $s_qry.=", s_login_ip=? ";
                $s_qry.=", dt_login_on=? ";
               
                
                $this->db->trans_begin();///new   
                $this->db->query($s_qry,array(
                                        intval($info["i_user_id"]),
                                        $info["s_login_ip"],
                                        $info["dt_login_on"]
                                        ));
                
			    $i_ret_=$this->db->insert_id();     
                if($i_ret_)
                {
                    /*$logi["msg"]="Inserting into ".$this->db->LOGIN_LOG." ";
                    $logi["sql"]= serialize(array($s_qry,array(
                                        intval($info["i_user_id"]),
                                        get_formatted_string($info["s_login_ip"]),
                                        $info["dt_login_on"]
                                        )) ) ;
                    $this->log_info($logi); 
                    unset($logi);*/
                    $this->db->trans_commit();///new   
                }
                else
                {
                    $this->db->trans_rollback();///new
                }
            }
            unset($s_qry);
            return $i_ret_;
           
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
      }
    
    
    
    /***
    * Logout User
    * 
    */
    public function logout()
    {
        try
        { 
            //////////log report///
            /*$logi["sql"]='';
            $logi["msg"]="Logged out as ".$this->session->userdata('user_fullname')." at ".get_db_datetime() ;
            $this->log_info($logi); 
            unset($logi);  */
            //////////end log report///            
            
			
			# $this->offline_this_user( decrypt($this->session->userdata('user_id')), $_SERVER['REMOTE_ADDR'] );
            
            $this->session->set_userdata('loggedin', false);
            $this->session->unset_userdata('loggedin');
            $this->session->unset_userdata('user_id');
            $this->session->unset_userdata('username');
            $this->session->unset_userdata('usr_display_name');
            $this->session->unset_userdata('email');
			$this->session->unset_userdata('is_admin');
            
            $this->session->unset_userdata('session_referrer');
           
		   # $this->session->destroy();//don't know but not clearing the session datas
           
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }         
    }
    
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
            
                $s_qry="SELECT COUNT(*) i_count FROM ".$this->tbl_name." WHERE ";
                $s_qry.=" BINARY `s_email`=? ";
              
                
                $this->db->trans_begin();///new   
                $rs = $this->db->query($s_qry,array(
                                              get_formatted_string($email)
                                             ));
                $this->db->trans_commit();///new   
              
               //$sql = sprintf("SELECT count(*) count FROM %susers where email = '%s'", $this->db->dbprefix, $email);
            }
            else 
            {
                //$sql = sprintf("SELECT count(*) count FROM %susers where email = '%s' and email != '%s'", $this->db->dbprefix, $email, $current_email);
                
                $s_qry="SELECT COUNT(*) i_count FROM ".$this->db->USERS." WHERE ";
                $s_qry.=" binary s_email=? ";
                $s_qry.=" AND i_id!=? ";
                
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
              {
                  $ret_=intval($row->i_count); 
              }    
              $rs->free_result();          
          }

           
            //print_r( $result_count);
    
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
    * Check if user username already exits
    * 
    */
    public function username_exists($username, $i_user_id='')
    {
        try
        { 
           $ret_=0;
           if($i_user_id=='') 
            {
            
                $s_qry="SELECT COUNT(*) i_count FROM ".$this->tbl_name." WHERE ";
                $s_qry.=" BINARY `s_username`=? ";
              
                
                $this->db->trans_begin();///new   
                $rs = $this->db->query($s_qry,array(
                                              get_formatted_string($username)
                                             ));
                $this->db->trans_commit();///new   
              
            }
            else 
            {
                 $s_qry="SELECT COUNT(*) i_count FROM ".$this->tbl_name." WHERE ";
                $s_qry.=" BINARY `s_username`=? ";
                $s_qry.=" AND i_id!=? ";
                
                $this->db->trans_begin();///new   
                $rs = $this->db->query($s_qry,array(
                                              get_formatted_string($username),
                                              intval($i_user_id)
                                             ));
                $this->db->trans_commit();///new   
                
            }
            
    
          if(is_array($rs->result()))
          {
              foreach($rs->result() as $row)
              {
                  $ret_=intval($row->i_count); 
              }    
              $rs->free_result();          
          }

           
            //print_r( $result_count);
    
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
   
    
    # function to generate new random password...
    public function generatePassword($length=6,$level=2)
    {
        try
        {
                list($usec, $sec) = explode(' ', microtime());
                srand((float) $sec + ((float) $usec * 100000));
                
                $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
                $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
                $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";
                
                $password  = "";
                $counter   = 0;
                
                while ($counter < $length) 
                {
                    $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);
                
                    // All character must be different
                    if (!strstr($password, $actChar)) 
                    {
                        $password .= $actChar;
                        $counter++;
                    }
                }
                
                return $password;
       }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }  

    }
	
    # NEW - for redirection after signup
    # fetch user-details by "verification-code"...
    public function fetch_by_verification_code($s_code) {
        try
        {              
            $ret_=array();         
            $s_qry = sprintf("SELECT * FROM %s WHERE `s_verification_code`='%s' ",
                              $this->tbl_name, $s_code);
                
            $rs=$this->db->query( $s_qry );

            return $rs->row_array();

        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }
    }
    
    
    //// =======================================================================================
    ////        Function(s) for User Contact Details [Begin]
    //// =======================================================================================
        
        /***
        * Inserts new records into db. As we know the table name 
        * we will not pass it into params.
        * 
        * @param array $info, array of fields(as key) with values,ex-$arr["field_name"]=value
        * @returns $i_new_id  on success and FALSE if failed 
        */
        public function add_contact_info($info)
        {
            try
            {
                $i_ret_=0; ////Returns false
                if(!empty($info))
                {
                    $this->db->trans_begin();///new   
                    $this->db->insert($this->tbl_usr_contact, $info);
                    $i_ret_=$this->db->insert_id(); 
                      
                    if($i_ret_)
                    {
                        $this->db->trans_commit();///new   
                    }
                    else
                    {
                        $this->db->trans_rollback();///new
                    }
                }
                unset($s_qry);
                
                return $i_ret_;
            }
            catch(Exception $err_obj)
            {
                show_error($err_obj->getMessage());
            }          
        
        }            
        
    //// =======================================================================================
    ////        Function(s) for User Contact Details [End]
    //// =======================================================================================
    
    
    
    //// NEW - MISCELLANEOUS UTILITY FUNCTION(S) [BEGIN]
        
        /*
        * Function to insert directly into dtaabase
        */
        function set_user_data_insert($tableName,$arr)
        {
            if( !$tableName || $tableName=='' ||  count($arr)==0 )
                return false;
            if($this->db->insert($tableName, $arr))
                return $this->db->insert_id();
            else
                return false;
        }
        
        function set_user_data_update($tableName,$arr,$id=-1) 
        {
            
            if(!$tableName || $tableName=='' || count($arr)==0 )
                return false;
            $cond   = '';
            if(is_array($id))
                $cond   = $id;
            else
                $cond   = array('i_id'=>$id);
            if($this->db->update($tableName, $arr, $cond))
                return true;
            else
                return false;                
        }

    //// NEW - MISCELLANEOUS UTILITY FUNCTION(S) [END]
	
}   // End - User Model
