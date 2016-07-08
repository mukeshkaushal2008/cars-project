<?php

class email_model extends CI_Model {

    function __construct() {

        parent::__construct();

// $this->load->model("user_model");
    }

    public function send_newsletter($emailarr = array()) {

        //debug($emailarr);die;

        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'smtp.gmail.com',
            'smtp_port' => 465,
            'smtp_crypto' => 'ssl',
            'smtp_user' => 'mukeshkaushal2008@gmail.com',
            'smtp_pass' => 'kaushal@123$',
            'mailtype' => 'html',
            'charset' => 'iso-8859-1'
        );


        //debug($emailarr);die;
        $email = explode(',', $emailarr["email"]);
        foreach ($email as $k => $v) {

            $this->email->clear();

            $config["mailtype"] = "html";

            $this->email->initialize($config);

            $this->load->library('email', $config);

            $this->load->library('parser', $config);

            $this->email->set_newline("\r\n");

            $this->email->to($v); // change it to yours

            $this->email->from('mukeshkaushal2008@gmail.com', $this->config->item("sitename"));

            $this->email->subject($emailarr["subject"]);

            $this->email->message($emailarr["message"]);

            $result = $this->email->send();
        }

        if ($result) {
            $err = 0;
        } else {
            $err = 1;
        }
        return $err;
    }

    public function sendIndividualEmail($emailarr = array()) {


        //debug($emailarr);die;
        if ($_SERVER['SERVER_NAME'] == "localhost" || $_SERVER['SERVER_NAME'] == "192.168.1.226" || $_SERVER['SERVER_NAME'] == "112.196.33.85") {

            $config = array(
                'protocol' => 'smtp',
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => 465,
                'smtp_crypto' => 'ssl',
                'smtp_user' => 'slinfydotcom@gmail.com',
                'smtp_pass' => 'khattra007',
                'mailtype' => 'html',
                'charset' => 'iso-8859-1'
            );

            $this->load->library('email', $config);

            $this->load->library('parser', $config);

            $this->email->set_newline("\r\n");

            $this->email->to($emailarr["to"]); // change it to yours

            $this->email->from($config['smtp_user'], $this->config->item('sitename'));

            $this->email->subject($emailarr["subject"]);

            $this->email->message($emailarr["message"]);

            $result = $this->email->send();

            //echo $result; die;

            if ($result) {

                return $err = 0;
            } else {

                //echo  $this->email->print_debugger();die;

                return $err = 1;
            }
        } else {



            $this->email->clear();

            $config["mailtype"] = "html";

            $this->email->initialize($config);

            $this->email->to($emailarr["to"]); // change it to yours

            $this->email->from('info@hautebids.com', $this->config->item('sitename'));

            $this->email->subject($emailarr["subject"]);

            $this->email->message($emailarr["message"]);



            $result = $this->email->send();
            /* echo $this->email->print_debugger();
              echo $result; die;
             */
            if ($result) {
                return $err = 0;
            } else {

                // $this->email->print_debugger();
                return $err = 1;
            }
        }
    }

    /*     * *********************************************** Email function ends ************************************************* */
}
