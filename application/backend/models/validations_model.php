<?php 
class validations_model extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }
	
	public function validate_data($arr)
	{
		//debug($arr);die;
		if($arr["model_name"] == "")
		{
			$this->session->set_flashdata("errormsg","Please enter model name");
			$err=1;		
		}
		else if(!$this->check_model($arr))
		{
			$this->session->set_flashdata("errormsg","This model name with brand already exists");
			$err=1;		
		}
		
		if($err==1)
		{
			return false;	
		}	
		else
		{
			return true;	
		}
			
	}
	
	public function check_model($arr = NULL){
		
		$this->db->select("model_name");
		$this->db->from("models");	
		
		if($arr["id"] == ""){
			$this->db->where(array("brand_id" => $arr["brand_id"],"model_name" => $arr["model_name"],"status <>" => "4"));
		}
		else{
			$this->db->where(array("brand_id" => $arr["brand_id"],"model_name" => $arr["model_name"],"status <>" => "4","id <>" => $arr["id"]));
		}
		$result=$this->db->get();
		$result=$result->result_array();
		//echo count($result);
		if(count($result)==0)
		{
			return true;	
		}
		else
		{
			return false;	
		}
	}
	
}
?>