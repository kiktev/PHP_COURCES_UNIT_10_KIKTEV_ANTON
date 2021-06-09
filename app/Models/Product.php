<?php
namespace Models;

use Core\Model;

/**
 * Class Product
 */
class Product extends Model
{

    /**
     * Product constructor.
     */
    function __construct()
    {
        $this->table_name = "products";
        $this->id_column = "id";
    }
	
	public function filterProduct($min,$max)
	{
		
		$sql = " WHERE (price >= :min) AND (price <= :max)";
				
		$this->sql .= $sql;
		$this->params[':min'] = $min;
		$this->params[':max'] = $max;
		
		return $this;
	}
	
	public function saveProduct($id,$values)
	{

		$params = [];
		
		foreach($values as $key=>$val){
			$params[":$key"] = $val;
		}
		$params[':id'] = $id;
		$sql = "UPDATE $this->table_name SET `sku` = :sku,`name` = :name, `price` = :price,
		`qty` = :qty, `description` = :description WHERE id = :id;";
		
		$this->initQuery($sql,$params);
		
		return true;
		
	}
	
	public function addProduct($values)
	{
		
		$params = [];
		
		foreach($values as $key=>$val){
			
				$params[":$key"] =  "$val";
			
		}
		
		$sql = "INSERT INTO `$this->table_name` (sku,name,price,qty,description) VALUES (:sku,:name,:price,:qty,:description);";
		$this->initQuery($sql,$params);
		
		return true;
		
	}
	
   
}