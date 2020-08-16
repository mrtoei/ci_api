
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model {
	public function getProducts(){
		// $data = array();
		$this->db->select('*');
		$this->db->from('products');
		$query = $this->db->get()->result_array();
		$data = [];
		
		foreach ($query as $value) {
			$path_image = base_url("assets/images/no-image.png");
			$image = '';
			if($value['image']!='no-image.png'){
				$image = $value['image'];
				$path_image = base_url("assets/images/$image") ;
			}
			array_push($data,[
				'id'=>$value['id'],
				'name'=>$value['name'],
				'price'=>$value['price'],
				'stock'=>$value['stock'],
				'image'=>$path_image,
			]);
		}
		echo json_encode($data);
	}

	public function insertProduct($data)
	{
		$insert = $this->db->insert('products', $data);
		if($insert){
			echo json_encode([
				'status'=>201,
				'msg'=>'Product inserted'
			]);
		}
	}

	public function getProduct($id)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id',$id);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			foreach ($query->result() as $value) {
				$path_image = base_url("assets/images/no-image.png");
				$image = '';
				if($value->image != 'no-image.png'){
					$image = $value->image;
					$path_image = base_url("assets/images/$image") ;
				}
				$data = [
					'id'=>$value->id,
					'name'=>$value->name,
					'price'=>$value->price,
					'stock'=>$value->stock,
					'image'=>$path_image,
				];
			}
			
			echo json_encode($data);
		}else{
			echo json_encode([
				'status'=>404,
				'msg'=>'This product is not found!!'
			]);
		}
		
	}
	public function updateProduct($id , $data)
	{
		$this->db->where('id',$id);
		$update = $this->db->update('products', $data);
		if($update){
			echo json_encode([
				'status'=>200,
				'msg'=>'Product updated'
			]);
		}
	}
	

	public function deleteProduct($id)
	{
		$image = $this->getImage($id);
		if($image != 'no-image.png'){
			$this->removeFile($image);
		}
		
		$this->db->where('id',$id);
		$delete = $this->db->delete('products');
		try {
			if($delete){
				echo json_encode([
					'status'=>204,
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

	public function getImage($id)
	{
		$this->db->select('*');
		$this->db->from('products');
		$this->db->where('id',$id);
		$query = $this->db->get();

		
		foreach ($query->result() as $value) {
			return $value->image;
		}
	}

	private function removeFile($image)
	{
		@unlink(FCPATH."assets/images/$image");
	}

}
