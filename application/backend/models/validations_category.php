<?php 
class validations_category extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }
	
	public function validate_data($arr)
	{
		//debug($arr);die;
		if($arr["category_name"] == "")
		{
			$this->session->set_flashdata("errormsg","Please enter category name");
			$err=1;		
		}
		else if(!$this->check_category($arr))
		{
			$this->session->set_flashdata("errormsg","This category name already exists");
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
	
	public function check_category($arr = NULL){
		
		$this->db->select("category_name");
		$this->db->from("category");	
		
		if($arr["id"] == ""){
			$this->db->where(array("category_name" => $arr["category_name"],"status <>" => "4"));
		}
		else{
			$this->db->where(array("category_name" => $arr["category_name"],"status <>" => "4","id <>" => $arr["id"]));
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