<?php 

ob_start();

class login_model extends CI_Model { 

    function __construct(){

        parent::__construct();

    }



	public function check_admin_login($arr){

		$this->db->select("*");

		$this->db->from("admin");

		$this->db->where(array("username" => $arr["username"]));

		$result=$this->db->get();

		//echo $this->db->last_query();die;

		$countrows=$result->num_rows();

		$result=$result->row_array();

		return $result;

	}

    

    public function add_user($arr) {

		$arr["password"] = $this->common->salt_password($arr);//generate salted password 

		//debug($arr);die;

        return $this->db->insert('users', $arr);

		//echo $this->db->last_query();die;

    }

    public function insert_notification($arr) {

		return $this->db->insert('bids_history', $arr);

    }


     public function verify_email($id,$type)  

	{	

		$this->db->select('count(*) as count');

		$this->db->from('users');

		$this->db->where(array('id'=>$id,'is_verified' => 0));

		$query = $this->db->get();

		//echo $this->db->last_query();die;

		$verfied=$query->row_array();

		if($verfied["count"] > 0){

			$arr = array("is_verified"=>1);

			$this->db->where(array('id'=>$id));

			$result = $this->db->update("users",$arr);

			$data='0';

		}

		else{

			$data='1';

		}

		return $data;

	}

   

    public function check_email($email)



    {

        $this->db->select('id');

        $this->db->from('users');

        $this->db->where(array('email' => $email,"status <>"=>"4"));

        $query = $this->db->get();

		//echo $this->db->last_query();die;

        $resultset=$query->num_rows();

        

		if($resultset==0)

        {

           return true;    

        }

        else

        {

            return false;   

        }           

    }

	

	public function update_password_with_email($data = array()) {

		$this->db->where('email', $data['email']);

		if($this->db->update('users', $data)) {

			return true;

		} else {

			return false;

		}

	}



}