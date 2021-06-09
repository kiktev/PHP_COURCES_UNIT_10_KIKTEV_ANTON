<section class="login_section">

	<form class="login_form" method="post">
	
		<span>Авторизація</span>
		<input type="text" name="email" placeholder="Email"/>
		<input type="text" name="password" placeholder="Пароль"/>
		<h4>Результат: <?php echo $this->get('message');?></h4>
		<button type="submit">Авторизуватись</button>	
		
	</form>
	
</section>