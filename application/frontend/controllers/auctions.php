<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class auctions extends CI_Controller {

    public function __construct() {
        parent::__construct();
		$this->load->model('products_model');
		$this->load->model('login_model');
    }
	public function live() {
		$data['master_title']='live';
	 	$data['master_body']='live';
	 	$this->load->theme('mainlayout', $data);
	}
	
	public function detail() { 
		$data['master_title']='detail';
	 	$data['master_body']='detail';
	 	$this->load->theme('mainlayout', $data);
	}
	
	public function closed() {
		$data['closed']= $this->products_model->get_closed_product();
		$data['master_title']='closed';
	 	$data['master_body']='closed';
	 	$this->load->theme('mainlayout', $data);
	}
	
	public function bid_now()
	{
		$data["bid_price"] = $this->input->post("bid_price")+0.1;
		$data["userid"] = $this->session->userdata("userid");
		$data["product_id"] = $this->input->post("product_id");
		$data["status"] = 1;
		$data["created_time"] = time();
		
		$diff = $this->input->post("end_timestamp") - time();
		
		//echo $diff;die;
		//check which plan user have taken
		$chk_plan = $this->products_model->chk_bids_available();
		
		if($chk_plan > 0){
			if($this->products_model->bid_now($data))
			{
				$last_id = $this->db->insert_id();
				if($diff >= 15)
				{
					//reset counter time to 15 sec
					$reset["id"] = $data["product_id"];
					$reset["end_date"] = time()+15;
					$this->products_model->reset_counter($reset);
				}
				else{
				}
				//insert notification for thr user as bid history
				$noti["bid_id"] = $last_id;
				$noti["product_id"] = $data["product_id"];
				$noti["userid"] = $data["userid"];
				$noti["type"] = "bid_deduction";
				$noti["message"] = "For the auction ";
				$noti["status"] = "1";
				$noti["created_time"] = time();
				$this->login_model->insert_notification($noti);
			
				//deduct bids from toal bids 
				 if($this->products_model->deduct_bids())
				 {
					$data["response"] = "success";
					$data["message"] = "Bid placed successfully";
				 }
				 else{
					 $data["response"] = "error";
					$data["message"] = "There was an error while deducting total bids";
				 }
			}
			else
			{
				$data["response"] = "error";
				$data["message"] = "There was an error while making bid";
			}
		}
		else
		{
			$data["response"] = "error";
			$data["message"] = "No bid left buy a plan";
		}
		echo json_encode($data);
	}
}
?>