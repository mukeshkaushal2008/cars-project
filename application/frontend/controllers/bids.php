<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class bids extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('bid_model');
		$this->load->model("user_model");
		$this->load->model("login_model");
		
    }
	public function index() {
        $data['resultset'] = $this->bid_model->get_all_bids();
        $data["item"] = "bid";
        //debug($data['resultset']);die;
        $data["master_title"] = "Manage bid";
        $data["master_body"] = "bids";
        $this->load->theme('mainlayout', $data);
    }

	public function history() {
        $data['my_bids'] = $this->common->get_my_bids(); 
		$data['bids_history'] = $this->bid_model->get_bids_history(); 
        $data["item"] = "bid history";
        $data["master_title"] = "Manage bid history";
        $data["master_body"] = "history";
		//debug($data);die;
        $this->load->theme('mainlayout', $data);
    }
    
    public function buy_plan() {
		$id = $this->uri->segment(3);
		$data["countries"] = $this->common->get_all_countries(); 
		$data['user_info'] = $this->user_model->get_user_billing_info($this->session->userdata("userid")); 
        $data['resultset'] = $this->bid_model->buy_plan($id);
        $data["item"] = "buy_plan";
        $data["master_title"] = "buy plan";
        $data["master_body"] = "buy_plan";
		//debug($data);die;
        $this->load->theme('mainlayout', $data);
    }

	public function payment(){
		require_once(BASEPATH.'libraries/stripe/lib/Stripe.php');
		
		Stripe::setApiKey("sk_test_PCdbAXeTWMXiAmnNXtXoAqat");
		
		//get plan amount 
		$price=array();
		$price = $this->bid_model->get_plan_data($this->input->post("plan_id"));
		$plan_id = ($this->input->post("plan_id"));
		$stripeToken = $this->input->post("stripeToken");
		$amount = $price["price"]*100;
	    
		if(isset($_POST)) {
			try{
			$response= Stripe_Charge::create(array( 
				"amount" => $amount, 
				"currency" => "usd", 
				"card" => $stripeToken,
			 ));
		
		 $result = json_decode($response);
		// $card = $result->card;
		
		 $transection=$result->balance_transaction;
		  if(!empty($transection))
		  {
			  //transection logs
			  $data["userid"] = $this->session->userdata("userid");
			  $data["plan_id"] = $plan_id;
			  $data["amount"] = $price["price"];
			  $data["txn_id"] = $transection;
			  $data["status"] = 1;
			  $data["created_time"] = time();
			  if($this->bid_model->payment_history($data)){
				  
				  $arr["id"] = $data["userid"];
				  $arr["bid_plan_id"] = $plan_id;
				  $arr["total_bids"] = $price["total_bids"] + $this->common->get_my_bids();
				  if($this->bid_model->update_user_bids($arr)){
					  
					$noti["bid_id"] = '0';
					$noti["product_id"] = '0';
					$noti["userid"] = $data["userid"];
					$noti["type"] = "bid_purchase";
					$noti["message"] = "+ ".$price["total_bids"]." bids has been credited to your account";
					$noti["status"] = "1";
					$noti["bids_credited"] = $price["total_bids"];
					$noti["created_time"] = time();
					$this->login_model->insert_notification($noti);  
					
				  	$this->session->set_flashdata("successmsg","Payment completed successfully");
		   		  	redirect(base_url().'bids/history/');
				  }
		      }
			  else{
				   $this->session->set_flashdata("errormsg","There was an error");
				   redirect(base_url().$this->router->class."/buy_plan/".$plan_id);
			  }
		  }
		 }catch(Exception $e){
		  // echo "The error was: " . $e->getMessage() ;die;
		   $err=1;
		 	$this->session->set_flashdata("errormsg " . $e->getMessage());
		   redirect(base_url().$this->router->class."/buy_plan/".$plan_id);
		}
		}
	}
//==================================================bid Comments Section End=============================================================================//
}

?>