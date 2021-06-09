<?php
	if(\Core\Helper::isAdmin() == true):
?>
<?php 
	
	$product = $this->get('product');
	if($product !== null):
?>
<?php
		if(isset($_GET['is_add']) == 1):
?>
<div class="product" style="padding:7px;"><p style="text-align:center; font-size:15pt; margin:0;">
		Товар додано
</p></div>
<?php endif; ?>
<?php	
		if(isset($_GET['is_edit']) == 1):
		
?>
<div class="product" style="padding:7px;"><p style="text-align:center; font-size:15pt; margin:0;">
		Товар відредаговано
</p></div>
<?php endif; ?>
<section class="add_section">
	
	<form class="edit_form" method="post">
		<input type="hidden" name="form_action" value="del">
		<h4>Код товару: </h4><input readonly value="<?php echo $product['sku'] ?>" type="text" placeholder="Код товару"/>
		<h4>Назва: </h4><input readonly value="<?php echo $product['name'] ?>" type="text" placeholder="Назва"/>
		<h4>Ціна: </h4><input readonly value="<?php echo $product['price'] ?>" type="text" placeholder="Ціна"/>
		<h4>Кількість: </h4><input readonly value="<?php echo $product['qty'] ?>" type="text" placeholder="Кількість"/>
		<h4>Опис товару: </h4><input readonly value="<?php echo $product['description'] ?>" type="text" placeholder="Опис товару"/>	
		<button type="submit" class="add_product">Видалити товар</button>
	</form>
	
	<form class="edit_form" method="post">
		<input type="hidden" name="form_action" value="edit">
		<h4>Новий код товару: </h4><input value="<?php echo $product['sku'] ?>" name="sku" type="text" placeholder="Код товару"/>
		<h4>Нова назва: </h4><input value="<?php echo $product['name'] ?>" name="name" type="text" placeholder="Назва"/>
		<h4>Нова ціна: </h4><input value="<?php echo $product['price'] ?>" name="price" type="text" placeholder="Ціна"/>
		<h4>Нова кількість: </h4><input value="<?php echo $product['qty'] ?>" name="qty" type="text" placeholder="Кількість"/>
		<h4>Новий опис товару: </h4><input value="<?php echo $product['description'] ?>" name="description" type="text" placeholder="Опис товару"/>
		<button type="submit" class="add_product">Редагувати</button>
		<h4>Результат: <?php echo $this->get('message'); ?></h4>
	</form>

</section>
<?php else: ?>	
<h3>Товар не знайдено</h3>
<?php endif; ?>
<?php else: ?>	
<h3>Тільки адміністратор може редагувати товари!</h3>
<?php endif; ?>