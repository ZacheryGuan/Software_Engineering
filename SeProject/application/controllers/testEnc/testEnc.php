<?php

/**
 * Created by PhpStorm.
 * User: BoYiLi
 * Date: 17/5/18
 * Time: 上午14:28
 */
class testEnc extends CI_Controller
{
    /**
     * Home constructor.
     */
	public function __construct()
    {
        parent::__construct();
        $this->load->helper("url");
		$this->load->library('session');
		$this->load->library('encryption');
        $this->load->model("testEnc/testEnc_m");
    }
	
	public function testEnc1()
	{
		$this->load->view("testEnc/testEnc.html");
	}
	
	public function test()
	{	
		/* $resp = array();
		$username = $this->input->post("username");
	    $password = $this->input->post("password");
		
		echo "pw:",bin2hex($password), '<br />';
		
		$resp['submitted_data'] = $_POST; 
		$cr_pw=$this->encryption->encrypt($username);
		
		echo "crpw: ",bin2hex($cr_pw), '<br />';
		
		$de_pw=$this->encryption->decrypt($cr_pw);
		echo "depw: ",bin2hex($de_pw); */
		
		echo session_id();
		
	}
	
	public function index(){
		$this->load->view("testEnc/testEnc.html");
	}
}
