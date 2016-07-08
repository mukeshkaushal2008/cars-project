<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class cron extends CI_Controller {

    public function __construct() {
		
        parent::__construct();
		$this->load->model('cron_model');
    }
	
	public function index(){
		$this->cron_model->mark_product_as_closed();
	}
}

