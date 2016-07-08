<?php

class cron_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function mark_product_as_closed() {
        $this->db->select('id,end_date');
		$this->db->from('products');
		$this->db->where(array("end_date <=" => time()));
		$query = $this->db->get();
		//echo	$this->db->last_query();die;
		$resultset = $query->result_array();
		foreach($resultset as $k =>$v){
			$arr = array("status" =>2);
			$this->db->where("id", $v["id"]);
            $this->db->update("products", $arr);
		}
    }
}
?>