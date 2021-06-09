<?php

$orders =  $this->get('orders');

foreach($orders as $order)  :
?>
	
    <div class="product">
        <p class="sku">Код: <?php echo $order['sku']?></p>
        <h4><?php echo $order['name']?><h4>
        <p> Ціна: <span class="price"><?php echo $order['price']?></span> грн</p>
        <p> Дата додавання в корзину: <?php echo $order['date_at']?></p>
		
        <p>
			<form method="POST">
				<input type="hidden" name="order_id" value="<?php echo $order['id'] ?>"></input>
				<button type="submit">Видалити з корзини</button>
			</form>
        </p>
		
    </div>
<?php endforeach; ?>

