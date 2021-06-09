<?php
namespace Core;

/**
 * Class Model
 */
class Model implements DbModelInterface
{
    /**
     * @var
     */
    protected $table_name;
    /**
     * @var
     */
    protected $id_column;
    /**
     * @var array
     */
    protected $columns = [];
    /**
     * @var
     */
    protected $collection;
    /**
     * @var
     */
    protected $sql;
    /**
     * @var array
     */
    protected $params = [];

    /**
     * @return $this
     */
    public function initCollection()
    {
        $columns = implode(',',$this->getColumns());
        $this->sql = "select $columns from " . $this->table_name ;
        return $this;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        $db = new DB();
        $sql = "show columns from  $this->table_name;";
        $results = $db->query($sql);
        foreach($results as $result) {
            array_push($this->columns,$result['Field']);
        }
        return $this->columns;
    }


    /**
     * @param $params
     * @return $this
     */
    public function sort($params)
    {
		
		$sortBy = '';
		$sortType = '';
		
		foreach ($params as $key=>$value) {		
		
			$sortBy = $key;
			$sortType = $value;	

		}
		
		$this->sql .= " ORDER BY $sortBy $sortType ";
		
        return $this;
    } 
    /**
     * @return $this
     */
    public function getCollection()
    {
        $db = new DB();
		
        $this->sql .= ";";
	
        $this->collection = $db->query($this->sql, $this->params);
		
        return $this;
    }
	
	public function initQuery($sql, $params){
		
		$db = new DB();	
     
        return $db->query($sql, $params);
		
	}

    /**
     * @return mixed
     */
    public function select()
    {
        return $this->collection;
    }

    /**
     * @return null
     */
    public function selectFirst()
    {
        return isset($this->collection[0]) ? $this->collection[0] : null;
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getItem($id)
    {
        $sql = "select * from $this->table_name where $this->id_column = ?;";
        $db = new DB();
        $params = array($id);
       
		if($db->query($sql, $params) != false){
			return $db->query($sql, $params)[0];
		}
    }
	
	public function getUser($item){
		
		$sql = "select * from $this->table_name where email = ?;";
        $db = new DB();
        $params = array($item);
        return $db->query($sql, $params);
		
	}
	
	public function addUser($data)
	{
		
		$params = [];
		
		foreach($data as $key => $val){
			$params[":$key"] = $val;
		}
		
		$sql = "INSERT INTO `$this->table_name` (first_name,last_name,telephone,email,city,password,admin_role) VALUES (:first_name,:last_name,:telephone,:email,:city,:password,:admin_role);";
		$db = new DB();
	
		return $db->query($sql,$params);
		
	}
	
	public function getMaxPrice($column)
	{
		
		$sql = "SELECT MAX(price) FROM $this->table_name;";
        $db = new DB();
  
        $result = $db->query($sql);
		if (isset($result)) {
			return $result[0]['MAX(price)'];
		}else{
			return false;
		}
	}
	
	public function getLastItem()
	{
		
		$sql = "SELECT MAX(id) FROM $this->table_name;";
        $db = new DB();
  
        $result = $db->query($sql);
		if (isset($result)) {
			return $result;
		}else{
			return false;
		}
	}
	
	public function deleteItem($id)
	{
		$sql = "DELETE FROM $this->table_name WHERE id = ?";
		$params = array($id);
		$db = new DB();
		return $db->query($sql,$params);
	}

    /**
     * @return array
     */
    public function getPostValues()
    {
        $values = [];
        $columns = $this->getColumns();
		
        foreach ($columns as $column) {
            
            if ( isset($_POST[$column]) && $column !== $this->id_column ) {
                $values[$column] = $_POST[$column];
            }
            
            $column_value = filter_input(INPUT_POST, $column);
            if ($column_value && $column !== $this->id_column ) {
                $values[$column] = $column_value;
            }

        }
		
		foreach($values as $key=>$val){
			if($key == 'description'){		
				$values["$key"] =  htmlspecialchars($val);
			}else{
				$values["$key"] = strip_tags($val);
			}
		}
		
		$rate = 0;
		
        return $values;
		
		
    }
	
	 public function filter($params)
    {
		return $this;
    }


    public function getTableName(): string
    {
        return $this->table_name;
    }

    public function getPrimaryKeyName(): string
    {
        return $this->id_column;
    }

    public function getId()
    {
        return 1;
    }
}
