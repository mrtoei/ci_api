<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
		header('Content-type: application/json');

		$this->load->database();
		$this->load->model('Product_model');
		$this->load->helper('file','url');

	}

	public function index()
	{
		// echo 'api/product/index';
		return $this->Product_model->getProducts();
	}

	public function insertProduct()
	{
		$date = date('Y-m-d H:i:s');
		if(empty($_FILES['photo'])){
			$data = [
				'name'=>$this->input->post('name'),
				'price'=>$this->input->post('price'),
				'stock'=>$this->input->post('stock'),
				'image'=>'no-image.png',
				'created_at'=>$date,
				'updated_at	'=>$date
			];
		}else{
			$filename = $_FILES['photo']['name'];
			$file_tmp_name = $_FILES['photo']['tmp_name'];
			$new_filename = $this->renameFile($filename);
			$moveFile = $this->moveFile($file_tmp_name,$new_filename);
			if($moveFile){
				$data = [
					'name'=>$this->input->post('name'),
					'price'=>$this->input->post('price'),
					'stock'=>$this->input->post('stock'),
					'image'=>$new_filename,
					'created_at'=>$date,
					'updated_at	'=>$date
				];
			}
		}
		// echo json_encode($data);
		return $this->Product_model->insertProduct($data);
	}

	public function updateProduct()
	{
		$date = date('Y-m-d H:i:s');
		$id = $this->uri->segment(5);
		$data = [];
		if(empty($_FILES['photo'])){
			$data = [
				'name'=>$this->input->post('name'),
				'price'=>$this->input->post('price'),
				'stock'=>$this->input->post('stock'),
				'updated_at	'=>$date
			];
			
		}else{
			$image = $this->Product_model->getImage($id);
			$filename = $_FILES['photo']['name'];
			$file_tmp_name = $_FILES['photo']['tmp_name'];
			$new_filename = $this->renameFile($filename);
			if($image != 'no-image.png'){
				$removeFile = $this->removeFile($image);
				if($removeFile){
					$moveFile = $this->moveFile($file_tmp_name,$new_filename);
					if($moveFile){
						$data = [
							'name'=>$this->input->post('name'),
							'price'=>$this->input->post('price'),
							'stock'=>$this->input->post('stock'),
							'image'=>$new_filename,
							'updated_at	'=>$date
						];
					}
				}
			}else{
				$moveFile = $this->moveFile($file_tmp_name,$new_filename);
				if($moveFile){
					$data = [
						'name'=>$this->input->post('name'),
						'price'=>$this->input->post('price'),
						'stock'=>$this->input->post('stock'),
						'image'=>$new_filename,
						'updated_at	'=>$date
					];
				}
			}
		}
		return $this->Product_model->updateProduct($id, $data);
		// echo json_encode($data);
	}

	public function getProduct()
	{
		$id = $this->uri->segment(4);
		return $this->Product_model->getProduct($id);

	}

	
	public function deleteProduct()
	{
		$id = $this->uri->segment(5);
		return $this->Product_model->deleteProduct($id);
	}

	private function removeFile($image)
	{
		if(unlink(FCPATH."assets/images/$image")){
			return true;
		}else{
			return true;
		}
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
