<?php
namespace Models;

use Core\Model;

/**
 * Class Product
 */
class Orders extends Model
{

    /**
     * Product constructor.
     */
    function __construct()
    {
        $this->table_name = "orders";
        
    }
	
	public function addOrders($values){
		
		$column = '';
		$params = [];
		
		foreach($values as $key=>$val){
				$column .= "$key,";
				$params[":$key"] =  "$val";		
		}
		
		$column = rtrim($column,",");
		
		$sql = "INSERT INTO `$this->table_name` ($column) VALUES (:nameOrd, :email, :telephone, :sku, :name, :price);";
		
		$this->initQuery($sql,$params);
		
		return true;
	}
	
	public function getOrders($email){

		$sql = "select * from $this->table_name where email = ?;";
        $params = array($email);
		
		return $this->initQuery($sql,$params);
	}
	
   
}