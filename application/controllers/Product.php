<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// $this->output->set_header('Access-Control-Allow-Origin: *');
		// header('Content-type: application/json');
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		header('Content-type: application/json');

		$this->load->database();
		$this->load->model('Product_model');
		$this->load->helper('url');

	}

	public function index()
	{
		// echo 'api/product/index';
		return $this->Product_model->getProducts();
	}

	public function insertProduct()
	{
		$filename = $_FILES['photo']['name'];
		$file_tmp_name = $_FILES['photo']['tmp_name'];
		$new_filename = $this->renameFile($filename);
		$moveFile = $this->moveFile($file_tmp_name,$new_filename);
		if($moveFile){
			$data = [
				'name'=>$this->input->post('name'),
				'price'=>$this->input->post('price'),
				'stock'=>$this->input->post('stock'),
				'image'=>$new_filename
			];
			return $this->Product_model->insertProduct($data);
		}
	}

	
	public function deleteProduct()
	{
		$id = $this->uri->segment(5);
		return $this->Product_model->deleteProduct($id);
	}
	private function moveFile($file_tmp_name,$filename)
	{
		// $path = base_url("assets/images/$filename");
		$path = "assets/images/$filename";
		$moveFile = move_uploaded_file($file_tmp_name,$path);
		if($moveFile){
			return true;
		}else{
			return false;
		}
	}

	private function renameFile($filename)
	{
		$randomString = $this->randomString(10);
		$extension = pathinfo($filename, PATHINFO_EXTENSION);
		$new_filename = "$randomString.$extension";
		return $new_filename;
	}

	private function createFolder()
	{
		$directoryName = base_url('assets/images/');
		if(!file_exists('images')){
			mkdir('../../assets/images', 0777, true);
			echo $directoryName;
		}
		// return $directoryName;
	}	

	private function randomString($n)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; 
		$randomString = ''; 
	
		for ($i = 0; $i < $n; $i++) { 
			$index = rand(0, strlen($characters) - 1); 
			$randomString .= $characters[$index]; 
		} 
	
		return $randomString; 
	}
}
