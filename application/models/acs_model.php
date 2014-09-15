<?php
/*********
* Author: Jagannath Samanta
* Date  : 01 Oct 2013
* Purpose:
* Model For general iud
* 
* @package 
* @subpackage general insert, update, delete
* 
*/


class Acs_model extends CI_Model
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
	public function add_data($table, $info)
    {
        try
        {
            if(!empty($info))
            {
				$s_qry = $this->db->insert_string($table, $info); 
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
			if($feild_list != '') $this->db->select($feild_list, false);
			if(!empty($where) && intval($limit) > 0)
				return $this->db->where($where, '', false)->get($table, $limit, $offset)->result_array();
			else if(!empty($where))
				return $this->db->where($where, '', false)->get($table)->result_array();
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
    public function count_info($s_table_name, $arr_where = NULL, $alias = '')
    {
        try
        {
			$tmp = $this->db->select('count('.$alias.'i_id) AS total', false)->where($arr_where,'',false)->get($s_table_name)->result_array(); 
			return intval($tmp[0]['total']);
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
	| Get result from multi table using join																				|
	+-----------------------------------------------------------------------------------------------------------------------+
	|@param 																												|
	|	$tbl = array(																										|
	|		0 => array(																										|
	|			'tbl' => $this->db->TBL_1.' AS t1',																			|
	|			'on' => ''																									|
	|		), 																												|
	|		1 => array(																										|
	|			'tbl' => $this->db->TBL_2.' AS t2',																			|
	|			'on' => 't2.field = n.field'																				|
	|		),																												|
	|		2 => array(																										|
	|			'tbl' => $this->db->TBL_3.' AS t3',																			|
	|			'on' => 't3.field = n.field'																				|
	|		) 																												|
	|	);																													|
	+-----------------------------------------------------------------------------------------------------------------------+															
	|	$conf = array(																										|
	|		'select' => 'n.*, t1.field, t2.i_id as t2_id',																	|
	|		'where' => 'n.i_id > 10',																						|
	|		'limit' => 10,																									|
	|		'offset' => 5,																									|
	|		'order_by' => 'n.feild',																						|
	|		'order_type' => 'DESC' // default ASC																			|
	|	);																													|
	+-----------------------------------------------------------------------------------------------------------------------+
	*/
	public function fetch_data_join($tbl = array(), $conf = array())
	{
		if(count($tbl) > 1 && $conf['select'] != '')
		{
			$this->db->select($conf['select'], false);
			for($i = 1; $i < count($tbl); $i++)
				$this->db->join($tbl[$i]['tbl'],$tbl[$i]['on'], 'left');
			
			if($conf['order_by'])
				$this->db->order_by($conf['order_by'], $conf['order_type'] == '' ? 'ASC' : $conf['order_type']);
			if($conf['where'] != '' && intval($conf['limit']) > 0)
				$tmp =  $this->db->where($conf['where'], '', false)->get($tbl[0]['tbl'], $conf['limit'], $conf['offset'])->result_array();
			else if($conf['where'] == '' && intval($conf['limit']) > 0)
				$tmp =  $this->db->get($tbl[0]['tbl'], $conf['limit'], $conf['offset'])->result_array();
			else if($conf['where'] = '')
				$tmp =  $this->db->where($conf['where'], '', false)->get($tbl[0]['tbl'])->result_array();
			else
				$tmp =  $this->db->get($tbl[0]['tbl'])->result_array();
			unset($tbl, $conf);
			return $tmp;
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
  
    public function __destruct()
    {} 
}
//end of class
?>