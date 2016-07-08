<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class users extends CI_Controller {
 	function __construct(){
        parent::__construct();
		$this->load->model("user_model");
	}
    public function profile() {
		$this->common->is_logged_in();
		$data['my_bids'] = $this->common->get_my_bids(); 
		$data['resultset'] = $this->user_model->view_user($this->session->userdata("userid")); 
        $data["item"] = "My-Profile";
        $data["master_title"] = $this->config->item('sitename');
        $data["master_body"] = "profile";
		//debug($data);die;
        $this->load->theme('mainlayout', $data);
    }
	
	public function address() {
		$this->common->is_logged_in();
		$data['resultset'] = $this->user_model->get_user_billing_info($this->session->userdata("userid")); 
		$data['resultset1'] = $this->user_model->get_user_shipping_info($this->session->userdata("userid")); 
        $data["item"] = "My-address";
        $data["master_title"] = $this->config->item('sitename');
        $data["master_body"] = "address";
		//debug($data);die;
        $this->load->theme('mainlayout', $data);
    }
	
	public function edit() {
		$this->common->is_logged_in();
		$userid = $this->session->userdata("userid");
		$data["countries"] = $this->common->get_all_countries(); 
		$data['resultset'] = $this->user_model->view_user($userid);
        $data["item"] = "Edit-Profile";
        $data["master_title"] = $this->config->item('sitename');
        $data["master_body"] = "edit_profile";
		//debug($data);die;
        $this->load->theme('mainlayout', $data);
    }
	
	public function add_billing() {
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		/*
         * validate before save
        */
		$arr=array(); 
		$data = array();
		$arr["id"] = clean($this->input->post("id"));
		$arr["userid"] = clean($this->session->userdata("userid"));
        $arr["name"] = clean($this->input->post("name"));
        $arr["email"] = clean($this->input->post("email"));
		$arr["phone"] = clean($this->input->post("phone"));
		$arr["country"] = clean($this->input->post("country"));
        $arr["address"] = ($this->input->post("address"));
		$arr["state"] = clean($this->input->post("state"));
		$arr["zip"] = clean($this->input->post("zip"));
		$arr["is_billing"] = clean($this->input->post("is_billing"));
		$arr["status"] = 1;
		$arr["created_time"] = time();
		//debug($arr);die;
		if($this->user_model->add_billing($arr)) {
			$data["response"] = "success";
			$data["message"] = "Your billing has been successfully updated";
		} 
		else{
			$data["response"] = "error";
			$data["message"] = "Technical error please contact admin";
		}
		  echo json_encode($data);
    }

	public function add_shipping() {
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		/*
         * validate before save
        */
		$arr=array(); 
		$data = array();
		$arr["id"] = clean($this->input->post("id"));
		$arr["userid"] = clean($this->session->userdata("userid"));
        $arr["name"] = clean($this->input->post("shipping_name"));
        $arr["email"] = clean($this->input->post("shipping_email"));
		$arr["phone"] = clean($this->input->post("shipping_phone"));
		$arr["country"] = clean($this->input->post("shipping_country"));
        $arr["address"] = ($this->input->post("shipping_address"));
		$arr["state"] = clean($this->input->post("shipping_state"));
		$arr["zip"] = clean($this->input->post("shipping_zip"));
		$arr["is_billing"] = ($this->input->post("is_billing"));
		$arr["is_shipping"] = 1;
		$arr["status"] = 1;
		$arr["created_time"] = time();
		// debug($arr);die;
		if($this->user_model->add_shipping($arr)) {
			if($arr["id"]==""){
				$data["id"] = $this->db->insert_id();
			}
			else{
				$data["id"] = $arr["id"];
			}
			$data["response"] = "success";
			$data["message"] = "Your billing has been successfully updated";
		} 
		else{
			$data["id"] = '';
			$data["response"] = "error";
			$data["message"] = "Technical error please contact admin";
		}
		  echo json_encode($data);
    }

	 public function edit_user_to_database() {
		
		if (!$this->input->is_ajax_request()) {
			exit('No direct script access allowed');
		}
		/*
         * validate before save
        */
		$arr=array(); 
		$data = array();
		$arr["id"] = clean($this->session->userdata("userid"));
        $arr["first_name"] = clean($this->input->post("first_name"));
        $arr["last_name"] = clean($this->input->post("last_name"));
        $arr["gender"] = clean($this->input->post("gender"));
		$arr["country"] = clean($this->input->post("country"));
		$arr["phone"] = clean($this->input->post("phone"));
		$arr["dob"] = $this->input->post("day")."-".$this->input->post("month")."-".$this->input->post("year");
		//debug($arr);die;
		if($this->user_model->edit_user($arr)) {
			$data["response"] = "success";
			$data["message"] = "Your account has been successfully updated";
		} 
		else{
			$data["response"] = "error";
			$data["message"] = "Technical error please contact admin";
		}
		  echo json_encode($data);
    }

	public function change_password() {
		$this->common->is_logged_in();
        $data["item"] = "Change password";
        $data["master_title"] = $this->config->item('sitename');
        $data["master_body"] = "change_password";
        $this->load->theme('mainlayout', $data);
    }
	
	public function edit_password() {
		
			$this->load->model("email_model");
			
            $userid = $this->session->userdata('userid');
            $data_user = $this->user_model->view_user($userid);
         
            $user_id = $userid;
            $user['old_password'] = $this->input->post('old_password');
            $user['password'] = $this->input->post('new_password');
            $user['confirm_password'] = $this->input->post('c_password');
		    $verify_pass = $this->common->validateHash($user['old_password'], $data_user['password']);
		  //debug($this->input->post());die;
			if($verify_pass == false){
				$response["response"] = "error"; 
				$response["message"] = "Please enter old password again"; 
		  	}
		    else{
				$data['id'] = $userid;
				$data['password'] = $this->common->salt_password($user);
				
				if($this->user_model->edit_account($data))
				{
					/****************send password email to the crossponding user ************/
					$emailarr["to"] = $data_user["email"];
					$emailarr["subject"] = "Change password confirmation";
					$emailarr["message"] = "<p>Hi ".$data_user['first_name']."</p>
					
					<p>Welcome to ".$this->config->item("sitename")."</p> 
					<p>Your password has been reset please use this password - ".$user['password']."</p>
					<p>We hope you have an enjoyable experience with us.</p>
					<p>Best Wishes,</p>
					<p>".$this->config->item("sitename")." Team</p>";
					
					$email_send = $this->email_model->sendIndividualEmail($emailarr); //send email ro the users
					if($email_send == 0)
					{
						$response["response"] = "success"; 
						$response["message"] = "Your password successfully updated";
					}
					else{
						$response["response"] = "error"; 
						$response["message"] = "There was an error while sending email";
					}
					/****************send password email to the crossponding user ************/
				}
				else{
					$response["response"] = "error"; 
					$response["message"] = "There was problem updating password please contact admin";
				}
            } 
			echo json_encode($response);
        }
		
	public function change_email()
	{
		$arr["id"] = $this->session->userdata("userid");
		$arr["email"] = clean($this->input->post("change_email"));
		$arr["change_new_email"] = clean($this->input->post("change_new_email"));
		$arr["confirm_new_email"] = clean($this->input->post("confirm_new_email"));
		
		$email = $this->user_model->check_email($arr);
		if(!$email){
			$data["response"] = "error";
			$data["message"] = "This email id already registered";
		}
		else if(!empty($arr["confirm_new_email"])){
			$result = $this->user_model->change_email($arr);
			if($result){
				$data["response"] = "success";
				$data["message"] = "Your email has been successfully updated";
			}
			else{
				$data["response"] = "error";
				$data["message"] = "Technical error please contact admin";
			}
		}
		echo json_encode($data);
	}
	
	public function newsletters(){
		
		$data = array();
		$arr = array();
		$result = '';
		
		$arr["email"] = ($this->input->post("news_email"));
		$arr["created_on"] = time();
		$arr["status"] = 1;
		//debug($arr);die;
		//$data["newsletter"] = $this->session->set_userdata("tempdata", strip_slashes($arr));
		if(!empty($arr["email"])){
			$result = $this->user_model->newsletter($arr);
		}
		//debug($result);die;
		if($arr["email"]==""){
			$data["response"] = "error";
			$data["message"] = "Please enter email address";
		}
		else if(!filter_var($arr["email"], FILTER_VALIDATE_EMAIL)) {
			$data["response"] = "error";
			$data["message"] = "Please enter valid email";
        }
		else if($result == 0){
			$data["response"] = "success";
			$data["message"] = "You have successfully subscribed for newsletters";
		}
		else if($result == 1){
			$data["response"] = "error";
			$data["message"] = "You have already subscribed for newsletters";
		}
		else if($result == 2){
			$data["response"] = "error";
			$data["message"] = "There was an error while subscribing newsletters please contact admin";
		}
		echo json_encode($data);die;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */