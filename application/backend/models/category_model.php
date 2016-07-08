<?php 
class category_model extends CI_Model {
    function __construct(){
        parent::__construct();
    }

	public function getcategoryData($searchdata=array(),$id=NULL,$employeer_id=NULL){
		
		if(!isset($searchdata["page"]) || $searchdata["page"]=="")
		{
			$searchdata["page"]=0;	
		}
	    if(!isset($searchdata["countdata"]))
		{	
			if(isset($searchdata["per_page"]) && $searchdata["per_page"]!="")
			{
				$recordperpage=$searchdata["per_page"];	
			}
			else
			{
				$recordperpage=1;
			}
			if(isset($searchdata["page"]) && $searchdata["page"]!="")
			{
				$startlimit=$searchdata["page"];	
			}
			else
			{
				$startlimit=0;
			}
		}
		
		$this->db->select("*");
		$this->db->from('category');
		$this->db->where(array('category.status <>'=>4));
		 ///// if super admin or admin is fetching the category under  employee account ////
		$this->db->order_by("category.id", "desc"); 
		if(count($searchdata)!=0){		
			foreach($searchdata as $key=>$val){
				if(isset($searcharray[$key]) && $searchdata[$key]!=""){
					if(array_key_exists($key,$searcharray)){
						$where=array($searcharray[$key]=>$val);
						$this->db->where($where);
					}
				}
			}		
		}
		if(isset($searchdata["search"]) && $searchdata["search"]!="search" && $searchdata["search"] != ""){
			$this->db->like('category.category_name', trim($searchdata["search"]));
		}
		
		if(isset($searchdata["per_page"]) && $searchdata["per_page"]!="")
		{
			if(isset($recordperpage) && $recordperpage!="" && ($startlimit!="" || $startlimit==0))
			{
				$this->db->limit($recordperpage,$startlimit);
			}
		}
		
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$resultset = $query->result_array();
		return $resultset; 
}
  
	public function view_category($id){
		$this->db->select("*");	
		$this->db->from('category');
		$this->db->where(array("id"=>$id,"status"=>"1"));
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$resultset=$query->row_array();
		return $resultset;
	}
	public function view_category_admin($id){
		$this->db->select("*");	
		$this->db->from('category');
		$this->db->where(array("id"=>$id));
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$resultset=$query->row_array();
		return $resultset;
	}
	
	public function get_featured_category(){
		$this->db->select("*");	
		$this->db->from('category');
		$this->db->where(array("status"=>"1"));
		$this->db->order_by("id","desc");
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$resultset=$query->result_array();
		return $resultset;
	}
	
	
    public function add_edit_category($array){
		if($array["id"] == ""){
		  if($this->db->insert("category",$array)){return true;}
		  else{return false;}
		}
		else{
			 $id = $array['id'];
		 	 unset($array['id']);
			 $this->db->where("id",$id);
	     	 return $this->db->update("category",$array);
		}
	}
	
	public function delete_category($id)
	{
		$array['status']= '4' ;
		$this->db->where("id",$id);
	    return $this->db->update("category",$array);
	}
	
	public function enable_disable_category($tagid,$status)
	{
		$data = array("status" => $status);
		$this->db->where("id",$tagid);
		$this->db->update("category",$data);		
	}
}
?>