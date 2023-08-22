<?php
class MY_Form_validation extends CI_Form_validation
{
	public function __construct($config = array())
	{
		parent::__construct($config);
	}

	//$id = $this->uri->segment(3);


	public function edit_unique($str, $field)
	{
		sscanf($field, '%[^.].%[^.].%[^.].%[^.]', $table, $field, $columnIdName, $id);
		return isset($this->CI->db)
			? ($this->CI->db->limit(1)->get_where($table, array($field => $str, $columnIdName .'!=' => $id))->num_rows() === 0)
			: FALSE;
	}

}


