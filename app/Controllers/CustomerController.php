<?php
namespace Controllers;

use Core\Controller;
use Core\View;
use Core;

/**
 * Class ProductController
 */
class CustomerController extends Controller
{
      
    public function listAction()
    {
        $this->set('title', "Клієнти");
		
		$customers = $this->getModel('Customer')
            ->initCollection()
            //->sort($this->getSortParams())
            ->getCollection()
            ->select();
		
        $this->set('customers', $customers);

        $this->renderLayout();
    }
	
	public function cart_listAction(){
		
		$this->set('title', "Корзина");
		
		$email = \Core\Helper::getCustomer($_SESSION['id'])['email'];
		
		$orders = $this->getModel('Orders')->getOrders($email);
		
		$this->set('orders', $orders);
		
		if(isset($_GET['id'])){
			$id = $_GET['id'];
			$this->toCart($id,$email);
			Core\Helper::redirect('/customer/cart_list');	
		}
		
		if(isset($_POST['order_id'])){
			$id = $_POST['order_id'];
			$this->deleteOrder($id);
			Core\Helper::redirect('/customer/cart_list');
		}
		
        $this->renderLayout();
		
	}
	
	
	public function toCart($id,$email){
		
		$product = $this->getModel('Product')->getItem($id);
		$values = [];
		
		$nameOrd = \Core\Helper::getCustomer($_SESSION['id'])['first_name'];
		$telephone = \Core\Helper::getCustomer($_SESSION['id'])['telephone'];
		
		$values['nameOrd'] = $nameOrd;
		$values['email'] = $email;
		$values['telephone'] = $telephone;
		$values['sku'] = $product['sku'];
		$values['name'] = $product['name'];
		$values['price'] = $product['price'];
		
		$this->getModel('Orders')->addOrders($values);
	
	}
	
	public function deleteOrder($id){
		$this->getModel('Orders')->deleteItem($id);
	}
	
	public function loginAction()
    {
		$this->set('title', "Вхід");
		$this->set('message', '');
		
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
        {
            $email = filter_input(INPUT_POST, 'email');
            $password = md5(filter_input(INPUT_POST, 'password'));
			
			if(!empty(trim($email)) && !empty(trim($password))){		
			
				$customer = $this->getModel('customer')->getUser($email);
								
				if (!empty($customer)) {
					
					$customer = $customer[0];
					
					if ($customer['password'] == $password) {	
					
						$_SESSION['id'] = $customer['customer_id'];
						Core\Helper::redirect('/index/index');	
						
					}else{
						$this->set('message', 'Пароль не вірний');
					}
					
				} else {
					$this->set('message', 'Користувача з таким email не знайдено');
				}
				
			}else{
				$this->set('message', 'Заповніть всі поля');
			}  
        }     
        $this->renderLayout();
    }
	
	public function registerAction(){
		
		$this->set('title', "Реєстрація");
		$this->set('message', '');
		
        if (filter_input(INPUT_SERVER, 'REQUEST_METHOD') === 'POST')
        {
			
			$data = [];
			$rate = 0;
			
			foreach($_POST as $key => $val){
				if(!empty(trim($val))){
					$data[$key] = strip_tags($val);
				}else{
					$rate++;
				}
			}
			
			if (!empty($data) && $rate <1) {	
				
				if (filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
					
					$customer = $this->getModel('customer')->getUser($data['email']);
									
					if (!empty($customer)) {
						
						$this->set('message', 'Користувач з таким email вже є');
						
					}else{
						
						if($data['first_password'] == $data['password']){
							
							unset($data['first_password']);
							$password = $data['password'];
												
							if (ctype_alnum($password) && strlen($password) >= 8 ) {
								
								$data['admin_role'] = 0; 
								$data['password'] = md5($password);
								$this->getModel('customer')->addUser($data);
								$this->set('message', 'Вас зареєстровано');
								Core\Helper::redirect('/index/index');
							}else{
								$this->set('message', 'Пароль вказано не вірно');
							}
							
						}else{
							$this->set('message', 'Паролі не збігаються');
						}
						
					}
				}else{
					$this->set('message', 'Email вказано не вірно');
				}
				
			}else{
				$this->set('message', 'Заповніть всі поля');
			}  
        }     
        $this->renderLayout();
	}

    public function logoutAction()
    {
        
        $_SESSION = [];

       // expire cookie

        if (!empty($_COOKIE[session_name()]))
        {
            setcookie(session_name(), "", time() - 3600, "/");
        }
        session_destroy();
		
        Core\Helper::redirect('/index/index');
    }
   
    
}