<?php
/*********
* Author: Acumen CS
* Date  : 30 Jan 2014
* Purpose:
* Model For general curd
* 
* @package 
* @subpackage general insert, update, delete, select
* 
*/


class Dw_model extends CI_Model
{
    private $conf;
    
    public function __construct()
    {
        try
        {
			parent::__construct();
			$this->conf = &get_config();
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
    
	// Add info 
	public function add_data($table, $info, $insert_ignore = false)
    {
        try
        {
            if(!empty($info))
            {
				$s_qry = $this->db->insert_string($table, $info);
				if($insert_ignore) $s_qry = str_replace('INSERT INTO','INSERT IGNORE INTO',$s_qry);
				return ($this->db->simple_query($s_qry))? $this->db->insert_id() : 0;
            }
			return false;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	// Add multiple info at a time using 2D array 
	public function add_multiple_data($table, $info)
    {
        try
        {
            if(!empty($info))
            {
				return $this->db->insert_batch($table, $info);
            }
			return false;
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }          
    }
	
	// Edit Info
	public function edit_data($table, $info = array(), $where = array(), $affected_rows = false)
	{
		try
		{
			$s_qry = $this->db->update_string($table, $info, $where); 
			$st = $this->db->simple_query($s_qry);
			
			if(!$affected_rows)
				return $st;
			else
				return $this->db->affected_rows() > 0 ? TRUE : FALSE;
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	// Fetch Info
	public function fetch_data($table, $where = array(), $feild_list = '', $limit = NULL, $offset = NULL)
	{
		try
		{ 
			if($feild_list != '') $this->db->select($feild_list);
			if(!empty($where) && intval($offset) > 0)
				return $this->db->get_where($table, $where, $limit, $offset)->result_array();
			else if(!empty($where))
				return $this->db->get_where($table, $where)->result_array();
			else
				return $this->db->get($table)->result_array();
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	// Execute Query  and if return_result =true  then returns result set else returns true false 
	public function exc_query($query = '', $return_result = true)
	{
		try
		{
			if($query == '') return '';
			if($return_result)
				return $query != '' ? $this->db->query($query)->result_array() : '';
			else
				return $this->db->simple_query($query);
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 	
	}
	
	/****
    * Fetch Total records
    * @param string @s_table_name 
    * @param string $s_where, ex- " status=1 AND deleted=0 " 
    * @returns int on success and FALSE if failed 
    */
    public function count_info($s_table_name,$arr_where = NULL)
    {
        try
        {
			return count($this->db->get_where($s_table_name,$arr_where)->result_array()); // CI function to fetch data
        }
        catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        }           
    } 
	
	
	// Delete Info
	public function delete_data($table, $where = array())
	{
		try
		{
			return $this->db->delete($table, $where)? TRUE : FALSE;
		}
		catch(Exception $err_obj)
        {
            show_error($err_obj->getMessage());
        } 
	}
	
	/*
	+-----------------------------------------------------------------------------------------------------------------------+
	| Name: permormed_formatted_join																						|
	| 		It fetch all the table's column(field) from database and find the matching and if find any column name is 	 	| 		
	|		comflicting then rename that field name with that paeticular table alias as prefix(i.e alias_field_name).		|
	|		Then generate the query, execute it and return the result as array.												|
	+-----------------------------------------------------------------------------------------------------------------------+
	| Param: ($table_details = array[][], $where)																			|
	|		 $table_details = array(																						|
	|								array(																					|
	|										'alias'=>'t1', 																	|
	|										'name'=>'table1', 																|
	|										'condition'=>''																	|
	|									 ),																					|
	|								array(																					|
	|										'alias'=>'t2', 																	|
	|										'name'=>'table2',																| 
	|										'condition'=>'ON t2.feild_name = t1.feild_name AND t2.feild_name = value'		|
	|									  ),																				|
	|								....																					|
	|						        );																						|
	|		 $where = " WHERE alias.field_name = condition 																	|
	|					[OREDER BY alias.field_name ASC/DESC]																|
	|					[GROUP BY alias.field_name]																			|
	|					[LIMIT start, offest]";																				|
	+-----------------------------------------------------------------------------------------------------------------------+
	| Return: result array();																								|
	+-----------------------------------------------------------------------------------------------------------------------+										
	*/
	
	function performed_formatted_join($table_details  = array(), $where = '')
	{
		if(empty($table_details))
			return;
		
		// Get all the table column name as array
		for($i = 0; $i<count($table_details); $i++)
		{
			$fields[$i] = $this->db->list_fields($table_details[$i]['name']);
		}
		
		// Finding the match and rename that field
		for($j = 0; $j < count($table_details); $j++)
		{
			for($k = 0; $k < count($fields[$j]); $k++)
			{
				for($l = $j+1; $l < count($fields); $l++)
				{
					for($m = 0; $m < count($fields[$l]); $m++)
					{
						if($fields[$j][$k] == $fields[$l][$m])
							$fields[$j][$m] = $fields[$l][$m].' AS '.$table_details[$l]['alias'].'_'.$fields[$l][$m];
					}
				}
			}
		}
		
		// Generating all the fields to be select
		$selects_fields = '';
		for($n = 0; $n < count($fields); $n++)
		{
			$tmp = implode(",{$table_details[$n]['alias']}.", $fields[$n]);
			$tmp = $table_details[$n]['alias'].'.'.$tmp;
			$selects_fields .=  $selects_fields != '' ? ','.$tmp : $tmp;
		}
		
		// Generating query
		$query = "SELECT {$selects_fields}
					FROM {$table_details[0]['name']} AS {$table_details[0]['alias']} ";
		for($o = 1; $o < count($table_details); $o++)
		{
			$query .= "LEFT JOIN {$table_details[$o]['name']} AS {$table_details[$o]['alias']} {$table_details[$o]['condition']} ";
		}			
		$query .= $where;			
					
		// Getting result
		$rs = $this->db->query($query);
		unset($i, $j, $k, $l, $m, $n, $o, $tmp, $table_details, $query, $fields, $selects_fields);
		return $rs->result_array();
	}
	
	/*******
    * Fetches All record from db for the id value.
    * User Dropdown List
    * @param int $id
    * @returns array
    */
	public function get_all_list($table, $where = '' , $feild_list = '', $order_by = '', $type = '')
	{
		$rs = $this->db->query("SELECT {$feild_list} FROM {$table} WHERE $where ORDER BY {$order_by} {$type}")->result_array();
		$field_name = explode(',',$feild_list);
		for($i = 0; $i <count($rs); $i++)
			$ret[$rs[$i][$field_name[0]]] = ucfirst($rs[$i][$field_name[1]]);
		return $ret;
		//echo $this->db->last_query();
	}
  
    public function __destruct()
    {} 
}
//end of class
?>