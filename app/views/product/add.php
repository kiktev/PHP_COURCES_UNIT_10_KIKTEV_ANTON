<?php
	if(\Core\Helper::isAdmin() == true):
?>
<section class="add_section">

	<form class="add_form" method="post">
		<input name="sku" type="text" maxlength="30" placeholder="Код товару"/>
		<input name="name" type="text" maxlength="30" placeholder="Назва"/>
		<input name="price" type="text" maxlength="30" placeholder="Ціна"/>
		<input name="qty" type="text" maxlength="30" placeholder="Кількість"/>
		<input name="description" type="text" maxlength="200" placeholder="Опис"/>
		<button type="submit" class="add_product">Додати товар </button>
		<span>Результат: <?php echo $this->get('message') ?></span>
	</form>
	
</section>
<?php else: ?>	
<h3>Тільки адміністратор може додавати товари!</h3>
<?php endif; ?>