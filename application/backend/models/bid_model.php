<?php
class bid_model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
	public function payment_history($array){
		if($this->db->insert("payments",$array)){return true;}
		else{return false;}
	}
	public function get_all_bids() {
        $this->db->select("*");
        $this->db->from('bids_plan');
        $where = array("status" => 1);
        $this->db->where($where);
        $query = $this->db->get();
      //  echo $this->db->last_query();
        $resultset = $query->result_array();
        return $resultset;
    }
	public function get_product_name($id) {
        $this->db->select("name");
        $this->db->from('products');
        $where = array("id" => $id);
        $this->db->where($where);
        $query = $this->db->get($query);
        //echo $this->db->last_query();die;
        $resultset = $query->row_array();
        return !empty($resultset["name"]) ? $resultset["name"] : "";
    }
	
	public function get_bids_history() {
        $this->db->select("*");
        $this->db->from('bids_history');
        $where = array("bids_history.userid" => $this->session->userdata("userid"),"status" => 1);
        $this->db->where($where);
		$this->db->order_by('id','desc');
        $query = $this->db->get();
      //  echo $this->db->last_query();
        $resultset = $query->result_array();
        return $resultset;
    }
	
	public function buy_plan($id){
		$this->db->select("*");	
		$this->db->from('bids_plan');
		$this->db->where(array("id" => $id,"status"=>"1"));
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$resultset=$query->row_array();
		return $resultset;
	}
	public function get_plan_data($id){
		$this->db->select("sum(total_bids+free_bids) as total_bids,price");	
		$this->db->from('bids_plan');
		$this->db->where(array("id" => $id,"status"=>"1"));
		$query = $this->db->get();
		//echo $this->db->last_query();die;
		$resultset=$query->row_array();
		return $resultset;
	}
	
	public function getbidData($searchdata = array()) {

        if (!isset($searchdata["page"]) || $searchdata["page"] == "") {
            $searchdata["page"] = 0;
        }
        if (!isset($searchdata["countdata"])) {
            if (isset($searchdata["per_page"]) && $searchdata["per_page"] != "") {
                $recordperpage = $searchdata["per_page"];
            } else {
                $recordperpage = 1;
            }
            if (isset($searchdata["page"]) && $searchdata["page"] != "") {
                $startlimit = $searchdata["page"];
            } else {
                $startlimit = 0;
            }
        }

        $this->db->select("*,bids.product_id as pid,products.name");
        $this->db->from("bids");
		$this->db->join("bids_history","bids_history.bid_id = bids.id","left outer");
		$this->db->join("products","products.id = bids.product_id","left outer");
		
        if (isset($searchdata["search"]) && ($searchdata["search"] != "")) {
            //$this->db->like('users.nationality', ($searchdata["search"]));
            $where = array("products.name" => $searchdata["search"]);
            $this->db->where($where);
        }

        foreach ($searchdata as $key => $val) {
            if (isset($searcharray[$key]) && $searchdata[$key] != "") {
                if (array_key_exists($key, $searcharray)) {
                    $where = array($searcharray[$key] => $val);
                    $this->db->where($where);
                }
            }
        }

        $where = array("bids.status <>" => "4");
        $this->db->where($where);
		$this->db->group_by("bids.product_id");
        $this->db->order_by("bids.id DESC");
        //$this->db->order_by("name ASC");	

        if (isset($searchdata["per_page"]) && $searchdata["per_page"] != "") {
            if (isset($recordperpage) && $recordperpage != "" && ($startlimit != "" || $startlimit == 0)) {
                $this->db->limit($recordperpage, $startlimit);
            }
        }

        $query = $this->db->get();
      // echo $this->db->last_query();die;
        $resultset = $query->result_array();
        //debug($resultset);die;
        return $resultset;
    }


   
	public function view_bid($searchdata=array()){
		
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
		
		//$this->db->select("bids.bid_price,bids.product_id,bids_history.userid");
		$this->db->select("*");
                $this->db->from('bids');
		//$this->db->join("bids_history","bids_history.bid_id = bids.id","left outer");
       
		
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
		 $where = array("bids.product_id" => $searchdata['id'],"bids.status" =>1);
		
		$this->db->where($where);
		$this->db->order_by('bids.id','desc');
		
		/*if(isset($searchdata["search"]) && $searchdata["search"]!="search" && $searchdata["search"]!=""){
			$this->db->like('products.name', trim($searchdata["search"]));
		}*/
		
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

    public function delete_bid($id) {
        $this->db->where("id", $id);
        $arr = array("status" => 4);
        return $this->db->update("bids", $arr);
        //return $this->db->last_query();
    }
	public function update_user_bids($arr) {
		$id = $arr["id"];
		unset($arr["id"]);
        $this->db->where("id", $id);
        return $this->db->update("users", $arr);
        //return $this->db->last_query();
    }
	
}
?>