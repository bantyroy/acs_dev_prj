<?php

    # get salt-key value...
    function get_salt() {
        $ci = get_instance();
        return $ci->config->item('salt');
    } 

    # function to get-salted-password...
    function get_salted_password($password) {
        $ci = get_instance();
        $salt = $ci->config->item('salt');

        return sha1($salt.$password);
    }

    # for formatted array print...
    function dump($obj) {
        echo '<pre>';
        print_r($obj);
        echo '</pre>';
    }
    
    
    # form user fullname (fname + lname)...
    function _form_usr_fullname($usr_info=null) {
        
        $USR_FULL_NAME = '';
        if( !empty($usr_info) ) {
            
            $USR_FULL_NAME = ucfirst($usr_info['s_fname']);
            $USR_FULL_NAME .= ( !empty($usr_info['s_lname']) )? ' '. ucfirst($usr_info['s_lname']): '';
        }
        
        return $USR_FULL_NAME;
    }

    
    # ========================================================================
    #       LinkedIN Related Helper Function(s) - Begin
    # ========================================================================

        # function to fetch LinkedIN phone number(s)...
        function _get_linkedin_phone_nos($linkedin_phone_obj=null) {
            
            $LINKEDIN_PHONE_ARR = array();
            
            if( !empty($linkedin_phone_obj) ) {
                
                $no_phone_nos = $linkedin_phone_obj->_total;
                $phone_no_arr = $linkedin_phone_obj->values;
                
				if(!empty($phone_no_arr))
				{
                	foreach($phone_no_arr as $phone_nos)
                    	$LINKEDIN_PHONE_ARR[] = $phone_nos->phoneNumber; 
				}  
                
            }
            
            return $LINKEDIN_PHONE_ARR;
            
        }
    
    # ========================================================================
    #       LinkedIN Related Helper Function(s) - End
    # ========================================================================    