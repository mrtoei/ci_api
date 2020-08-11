
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model {
	public function getProducts(){
		// $data = array();
		$this->db->select('*');
		$this->db->from('products');
		$data = $this->db->get()->result_array();
		echo json_encode($data);
	}

	public function insertProduct($data)
	{
		$insert = $this->db->insert('products', $data);
		if($insert){
			echo json_encode([
				'status'=>200,
				'msg'=>' Product inserted'
			]);
		}
	}

	public function getProduct($id)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id',$id);
		$data = $this->db->get();
		if($data->num_rows() > 0){
			echo json_encode($data->row());
		}else{
			echo json_encode([
				'status'=>404,
				'msg'=>'This product is not found!!'
			]);
		}
		
	}

	public function deleteProduct($id)
	{
		// echo json_encode([
		// 	'status'=>200,
		// 	'msg'=>'Product deleted'
		// ]);

		// die;
		$this->db->where('id',$id);
		$delete = $this->db->delete('products');
		try {
			if($delete){
				echo json_encode([
					'status'=>200,
					'msg'=>'Product deleted'
				]);
			}else{
				echo json_encode([
					'status'=>404,
					'msg'=>'Product not found!'
				]);
			}
		} catch (Exception  $error) {
			echo json_encode($error);
		}
	
	}
}
