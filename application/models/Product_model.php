
<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Product_model extends CI_Model {
	public function getProduct(){
		// echo "api/product model";
		$product1 =  array(
			"name" => "Macbook Pro 13 2020",
			"stock" => 41,
			"price" => 59900,
			"image" => "https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mbp13touch-space-select-202005_GEO_TH?wid=452&hei=420&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1587460269141"
		);

		$product2 =  array(
			"name" => "Macbook Pro 16 2020",
			"stock" => 23,
			"price" => 89900,
			"image" => "https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/mbp16touch-space-select-201911_GEO_TH?wid=452&hei=420&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1573165435536"
	
		);


		$product3 =  array(
			"name" => "iMac 21",
			"stock" => 355,
			"price" => 51900,
			"image" => "https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/imac-21-retina-selection-hero-201903?wid=452&hei=420&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1553120924619"
		);

		$product4 =  array(
			"name" => "iMac 27 2020",
			"stock" => 46,
			"price" => 79900,
			"image" => "https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/imac-27-selection-hero-202008?wid=452&hei=420&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1594932848000"
		);

		$product5 =  array(
			"name" => "iMac Pro",
			"stock" => 59,
			"price" => 172900,
			"image" => "https://store.storeimages.cdn-apple.com/8756/as-images.apple.com/is/imacpro-27-retina-selection-hero?wid=452&hei=420&fmt=jpeg&qlt=95&op_usm=0.5,0.5&.v=1511982294002"
		);

		
		$data = array(
				$product1,
				$product2,
				$product3,
				$product4,
				$product5
			);
		echo json_encode($data);
	}
}
