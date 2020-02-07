<?php
/* set default timezone for Mexico City */
date_default_timezone_set('America/Mexico_City');
use Restserver\Libraries\REST_Controller;
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class Api extends REST_Controller {
  /* message general */
  public $save_message   = "Record set successfully";
  public $edit_success   = "Update record successfully";
  public $delete_success = "Delete record successfully";
  public $wrong_message  = "The record was not saved correctly";
  public $catch_message  = "Something went wrong please try again";
  public $param_message  = "The param ID is required";

	public function __construct() {
		/* CORS - Access-Control-Allow-Origin */
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, X-Auth-Token, Accept, Access-Control-Request-Method");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    $method = $_SERVER['REQUEST_METHOD'];
    if($method == "OPTIONS") {
      die();
    }
    parent::__construct();
    $this->load->database('default');
    $this->load->model('Api_db');
  }

  /**
   * showCategorys
   * @method GET
   * @param string sort
   */
  public function showCategorys_get()
  {
    try {
      /* get all products */
      $sortBy = $this->get('sort');
      $get_records = $this->Api_db->getAllCategorys($sortBy);

      if(count($get_records) > 0){
        return $this->response(array("success" => true, "items" => $get_records), 200);
      } else {
        return $this->response(array("success" => false, "items" => []), 200);
      }
    } catch (Exception $e) {
      return $this->response(array("success" => false, "msg" => $this->catch_message), 200);
    }
  }

  /**
   * showProducts
   * @method GET
   * @param string sort
   */
  public function showProducts_get()
  {
    try {
      /* get all products */
      $sortBy = $this->get('sort');
      $get_records = $this->Api_db->getAllProducts($sortBy);

      if(count($get_records) > 0){
        return $this->response(array("success" => true, "items" => $get_records), 200);
      } else {
        return $this->response(array("success" => false, "items" => []), 200);
      }
    } catch (Exception $e) {
      return $this->response(array("success" => false, "msg" => $this->catch_message), 200);
    }
  }

  /**
   * viewProductDetail
   * @method GET
   * @param int id
   */
  public function viewProductDetail_get()
  {
    try {
      /* view product detail */
      $id = $this->get('id');

      if($id != ""){
        $data = [
          'id' => $id
        ];

        $view_record = $this->Api_db->viewSingleProduct($data);
  
        if(count($view_record) > 0){
          return $this->response(array("success" => true, "item" => $view_record), 200);
        } else {
          return $this->response(array("success" => false, "item" => []), 200);
        }
      } else {
        return $this->response(array("success" => false, "msg" => $this->param_message), 200);
      }
    } catch (Exception $e) {
      return $this->response(array("success" => false, "msg" => $this->catch_message), 200);
    }
  }

  /**
   * saveNewProducts
   * @method POST
   */
  public function saveNewProducts_post()
  {
    try {
      $name        = $this->post('name');
      $description = $this->post('description');
      $price       = $this->post('price');
      $category_id = $this->post('category_id');

      $data = [
        'name'        => $name,
        'description' => $description,
        'price'       => $price,
        'category_id' => $category_id
      ];

      /* save new product */
      $store = $this->Api_db->saveProduct($data);
      if($store){
        return $this->response(array("success" => true, "msg" => $this->save_message), 201);
      } else {
        return $this->response(array("success" => false, "msg" => $this->wrong_message), 200);
      }
    } catch (Exception $e) {
      return $this->response(array("success" => false, "msg" => $this->catch_message), 200);
    }
  }

  /**
   * editProduct
   * @method POST
   */
  public function editProduct_post()
  {
    try {
      $id          = $this->post('id');
      $name        = $this->post('name');
      $description = $this->post('description');
      $price       = $this->post('price');
      $category_id = $this->post('category_id');

      $data = [
        'id'          => $id,
        'name'        => $name,
        'description' => $description,
        'price'       => $price,
        'category_id' => $category_id
      ];

      /* edit product */
      if($id != ""){
        $update = $this->Api_db->updateProduct($data);
        if($update){
          return $this->response(array("success" => true, "msg" => $this->edit_success), 200);
        } else {
          return $this->response(array("success" => false, "msg" => $this->wrong_message), 200);
        }
      } else {
        return $this->response(array("success" => false, "msg" => $this->param_message), 200);
      }
    } catch (Exception $e) {
      return $this->response(array("success" => false, "msg" => $this->catch_message), 200);
    }
  }

  /**
   * deleteProduct
   * @method POST
   * @param int id
   */
  public function deleteProduct_post()
  {
    try {
      $id = $this->post('id');

      $data = [
        'id' => $id
      ];

      /* delete product */
      if($id != ""){
        $delete = $this->Api_db->deleteProduct($data);
        if($delete){
          return $this->response(array("success" => true, "msg" => $this->delete_success), 200);
        } else {
          return $this->response(array("success" => false, "msg" => $this->wrong_message), 200);
        }
      } else {
        return $this->response(array("success" => false, "msg" => $this->param_message), 200);
      }
    } catch (Exception $e) {
      return $this->response(array("success" => false, "msg" => $this->catch_message), 200);
    }
  }
}
