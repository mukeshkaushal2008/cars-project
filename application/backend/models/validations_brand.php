<?php 
class validations_brand extends CI_Model {
 
    function __construct()
    {
        parent::__construct();
    }
	
	public function validate_data($arr)
	{
		//debug($arr);die;
		if($arr["brand_name"] == "")
		{
			$this->session->set_flashdata("errormsg","Please enter brand name");
			$err=1;		
		}
		else if(!$this->check_brand($arr))
		{
			$this->session->set_flashdata("errormsg","This brand name already exists");
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
	
	public function check_brand($arr = NULL){
		
		$this->db->select("brand_name");
		$this->db->from("brand");	
		
		if($arr["id"] == ""){
			$this->db->where(array("brand_name" => $arr["brand_name"],"status <>" => "4"));
		}
		else{
			$this->db->where(array("brand_name" => $arr["brand_name"],"status <>" => "4","id <>" => $arr["id"]));
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