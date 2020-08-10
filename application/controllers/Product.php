<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Product_model');
		header("Access-Control-Allow-Origin: *");
	}

	public function index()
	{
		// echo 'api/product/index';
		return $this->Product_model->getProduct();
	}
}
