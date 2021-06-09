<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>">
<select name='sort'>
    <option <?php echo filter_input(INPUT_POST, 'sort') === 'price_ASC' ? 'selected' : '';?> value="price_ASC">від дешевших до дорожчих</option>
    <option <?php echo filter_input(INPUT_POST, 'sort') === 'price_DESC' ? 'selected' : '';?> value="price_DESC">від дорожчих до дешевших</option>
	<option <?php echo filter_input(INPUT_POST, 'sort') === 'qty_ASC' ? 'selected' : '';?> value="qty_ASC">по зростанню кількості</option>
    <option <?php echo filter_input(INPUT_POST, 'sort') === 'qty_DESC' ? 'selected' : '';?> value="qty_DESC">по спаданню кількості</option>
</select>

<input type="submit" value="Submit">
</form>
<form class="filter_form" method="POST">
	<input type="hidden" name="action" value="filter"/>
	Ціна від: <input name="minPrice" type="text" value="0" name="min"/>
	Ціна до: <input name="maxPrice" type="text" value="<?php echo $this->get('maxPrice'); ?>" name="max"/>
	<button type="submit">Застосувати фільтр</button>
	<span style="font-size:14pt;"><?php echo $this->get('message_err'); ?></span>
</form>
<?php
		if(isset($_GET['is_delete']) == 1):
?>
<div class="product" style="padding:7px;"><p style="text-align:center; font-size:15pt; margin:0;">
        Товар видалено
</p></div>
<?php endif; ?>

<?php
		if(\Core\Helper::isAdmin() == true):
?>
<div class="product"><p>
        <?= \Core\Url::getLink('/product/add', 'Додати товар'); ?>
</p></div>
<?php endif; ?>

<?php

$products =  $this->get('products');

foreach($products as $product)  :
?>

    <div class="product">
        <p class="sku">Код: <?php echo $product['sku']?></p>
        <h4><?php echo $product['name']?><h4>
        <p> Ціна: <span class="price"><?php echo $product['price']?></span> грн</p>
        <p> Кількість: <?php echo $product['qty']?></p>
		<p> Опис: <?php echo htmlspecialchars_decode($product['description'])?></p>
        <p><?php if(!$product['qty'] > 0) { echo 'Нема в наявності'; } ?></p>
		<?php
			if(\Core\Helper::isAdmin() == true):
		?>
        <p>
            <?= \Core\Url::getLink('/product/edit', 'Редагувати', array('id'=>$product['id'])); ?>
        </p>
		
		<?php endif; ?>
		<p>
            <?= \Core\Url::getLink('/customer/cart_list', 'Додати в корзину', array('id'=>$product['id'])); ?>
        </p>
    </div>
<?php endforeach; ?>

