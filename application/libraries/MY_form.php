<?php

class MY_form extends CI_Form_validation{

  	function is_unique($str, $field)
  {
    list($table, $field) = explode('.', $field);

	$this->CI->form_validation->set_message('is_unique','The %s is already registered');
   $this->CI->form_validation->lang['is_unique']="This email/username has aleady been registered.";
	 if (isset($this->CI->db))
    {
        $query = $this->CI->db->where($field, $str)->get($table); 
      	return $query->num_rows() === 0;
    }

    return FALSE;
  }

}

?>