<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Api_db extends CI_MODEL {

  /**
   * getAllProducts
   * @param string $sort
   */
  public function getAllProducts($sort="DESC"){
    $this->db->select('*', FALSE);
		$this->db->from('products');
		$this->db->where('status', '1');
		$this->db->order_by('created_at', $sort);
		return $this->db->get()->result();
  }

  /**
   * viewSingleProduct
   * @param int $id
   */
  public function viewSingleProduct($data){
    $this->db->select('*', FALSE);
		$this->db->from('products');
		$this->db->where('id', $data['id']);
		$this->db->where('status', '1');
		return $this->db->get()->result();
  }

  /**
   * saveProduct
   * @param array $data
   * @return boolean
   */
  public function saveProduct($data){
    $save_data = [
      'name'        => $data['name'],
      'description' => $data['description'],
      'price'       => $data['price'],
      'category_id' => $data['category_id'],
      'created_at'  => date('Y-m-d H:i:s')
    ];

    $query = $this->db->insert('products', $save_data);

    if($query){
      return true;
    } else {
      return false;
    }
  }

  /**
   * updateProduct
   * @param array $data
   * @return boolean
   */
  public function updateProduct($data){
    $save_data = [
      'name'        => $data['name'],
      'description' => $data['description'],
      'price'       => $data['price'],
      'category_id' => $data['category_id']
    ];

    $this->db->where('id', $data['id']);
		$query = $this->db->update('products', $save_data);

    if($query){
      return true;
    } else {
      return false;
    }
  }

  /**
   * deleteProduct
   * @param array $data
   * @return boolean
   */
  public function deleteProduct($data){
    $save_data = [
      'status' => '0'
    ];

    $this->db->where('id', $data['id']);
		$query = $this->db->update('products', $save_data);

    if($query){
      return true;
    } else {
      return false;
    }
  }

}