<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*************************************
  * Created :December 2014
  * Creator : Fauzan Rabbani
  * Email   : jhanojan@gmail.com
  * Framework ver. : CI ver.2.2
*************************************/	

class forbidden extends CI_Controller {
	var $utama ='forbidden';
        var $title ='Forbidden';
	function __construct()
	{
		parent::__construct();
                is_login();
	}
	
	function index()
	{
		$this->main();
	}
	
	function main()
	{
                $data['title']='Forbidden';
		$data['content'] = 'contents/'.$this->utama.'/view';
		$this->load->view('layout/main',$data);
	}	
	
}
?>