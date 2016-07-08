<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class hotels extends CI_Controller {

    public function __construct() {
        parent::__construct();
       
    }
	public function index() {
		$data['master_title']='live';
	 	$data['master_body']='live';
	 	$this->load->theme('mainlayout', $data);
	}
}
?>