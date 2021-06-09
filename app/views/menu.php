<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <ul class="nav navbar-nav">
    <?php 
        foreach($this->get('menuCollection') as $item)  :
    ?>
        <li>
            <?= \Core\Url::getLink($item['path'], $item['name']); ?>
        </li>
    <?php endforeach; ?>
    </ul>
    <ul class="nav navbar-nav navbar-right">
		<?php $user = Core\Helper::getCustomer(); ?>
		<?php if($user != false):?>
			<li><a href="#"><span class="glyphicon glyphicon-user"></span><?= $user['last_name'] . " " . $user['first_name'];?></a></li>
			<li><a href="<?php echo $this->getBP();?>/customer/logout/"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
			<li><a href="<?php echo $this->getBP();?>/customer/cart_list/"><span class="glyphicon glyphicon-shopping-cart"></span> Корзина</a></li>
		<?php else: ?>
			<li><a href="<?php echo $this->getBP();?>/customer/register/"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			<li><a href="<?php echo $this->getBP();?>/customer/login/"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			
		<?php endif; ?>		
    </ul>
  </div>
</nav>