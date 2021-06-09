<section class="reg_section">

	<form class="reg_form" method="post">
	
		<span>Реєстрація</span>
		<input type="text" name="first_name" placeholder="Ім'я"/>
		<input type="text" name="last_name" placeholder="Прізвище"/>
		<input type="text" name="telephone" placeholder="Телефон"/>
		<input type="text" name="email" placeholder="Email"/>
		<input type="text" name="city" placeholder="Місце проживання"/>
		<input type="text" name="first_password" placeholder="Пароль"/>
		<input type="text" name="password" placeholder="Введіть пароль ще раз"/>
		<h4>Результат: <?php echo $this->get('message'); ?></h4>
		<button type="submit">Зареєструватись</button>
		
	</form>
	
</section>