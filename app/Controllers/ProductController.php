<?php
namespace Controllers;

use Core\Controller;
use Core\View;
use Core\Helper;

/**
 * Class ProductController
 */
class ProductController extends Controller
{
    public function indexAction()
    {
        $this->forward('product/list');
    }

    /**
     *
     */
    public function listAction()
    {
	
	
		$minPrice = 0;
		$maxPrice = $this->getModel('Product')->getMaxPrice('price');
		
		$this->set('message_err', '');
        $this->set('title', "Товари");
		
		if(isset($_POST['action'])){
			
			switch($_POST['action']){
				
				case 'filter':
				
				if (is_float(filter_var($_POST['minPrice'], FILTER_VALIDATE_FLOAT)) &&
					is_float(filter_var($_POST['maxPrice'], FILTER_VALIDATE_FLOAT))) {
						
						$minPrice = $_POST['minPrice'];
						$maxPrice = $_POST['maxPrice'];
						
					}else{
						$this->set('message_err', 'Використовуйте тип (float)');
					}
				
				break;
				
			}
		}
			
        $products = $this->getModel('Product')
            ->initCollection()
			->filterProduct($minPrice,$maxPrice)
            ->sort($this->getSortParams())	
            ->getCollection()
            ->select();
		
		
		foreach($products as $key => $product){
			
			if(isset($product['description'])){
				$products[$key]['description'] = htmlspecialchars_decode($product['description']);
			}
			
		}
			
        $this->set('products', $products);
				
		$this->set('maxPrice',$maxPrice);
		
        $this->renderLayout();
    }
	
    /**
     *
     */
	
    public function editAction()
    {
        $model = $this->getModel('Product');
        $this->set('message', '');
        $this->set("title", "Редагування товару");
        $product = $model->getItem($this->getId());
			
		if(isset($product['description'])){
			$product['description'] =  htmlspecialchars_decode($product['description']);
		}
		
        $this->set('product', $product);
		
		$id = $this->get('product')['id'];
		
		if(isset($_POST['form_action'])){
			
			$form_action = $_POST['form_action'];
			
			switch($form_action){
				
				case 'del':
				if ($id) {
					
					$model->deleteItem($id);
					\Core\Helper::redirect('/product/list?is_delete=1');
					
				}
				break;
				
				case 'edit':
				if ($id) {
					
					if($values = $model->getPostValues()){					
						
						if($this->valueCheck($values) != false){
							
							$model->saveProduct($id,$values);
							$this->set('message', 'Зміни внесено');	
							\Core\Helper::redirect("/product/edit?id=$id&is_edit=1");
						}
					}		
					
				}
				
				break;
			}
		}	
		
        $this->renderLayout();
    }

    /**
     *
     */
    public function addAction()
    {
		
		
        $model = $this->getModel('Product');
		
        $this->set("title","Додавання товару");
		
		$this->set('message', '');
		
        if ($values = $model->getPostValues()) {
		
			if ($this->valueCheck($values) != false) {
				
				$model->addProduct($values);
				$id = $model->getLastItem()['0']['MAX(id)'];	
				$this->set('message', 'Товар додано');
				\Core\Helper::redirect("/product/edit?id=$id&is_add=1");
				
			}
			     
        }	
        $this->renderLayout();
    }
	
	public function valueCheck($values)
	{
		$rate=0;
			
			foreach($values as $val){
				if (empty(trim($val))) {
					$rate++;
				}
			}			
			if ($rate<1) {	
				if (is_float(filter_var($values['price'], FILTER_VALIDATE_FLOAT)) &&
					is_float(filter_var($values['qty'], FILTER_VALIDATE_FLOAT))) {
					return $values;
				}else{
					$this->set('message', 'Ціна та кількість має бути числового типу (float)');			
					return false;
				}
			}else{
				$this->set('message', 'Заповніть всі поля');
				return false;
			}
	}
	
    public function getSortParams()
    {
        $params = [];
		
		if (empty($_POST)) {
			if(isset($_COOKIE['cookie_params'])){
				$cookie_params = unserialize($_COOKIE['cookie_params'], ["allowed_classes" => false]);		
				return $cookie_params;	
			}
		}
		//var_dump($_COOKIE);
		$sort= filter_input(INPUT_POST, 'sort');
			
		switch ($sort) {
			
			case 'price_DESC':
			$params['price'] = 'DESC';
			break;
			
			case 'price_ASC':
			$params['price'] = 'ASC';
			break;
			
			case 'qty_DESC':
			$params['qty'] = 'DESC';
			break;
			
			case 'qty_ASC':
			$params['qty'] = 'ASC';
			break;
			
			default:		
			$params['price'] = 'ASC';
					
		}
		
		setcookie('cookie_params', '', time()-3600);
        setcookie('cookie_params', serialize($params), time()+3600);
		
        return $params;
		
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        
        if (isset($_GET['id'])) {
            return filter_input(INPUT_GET, 'id');
        } else {
            return NULL;
        } 
   
    }
    
    
}