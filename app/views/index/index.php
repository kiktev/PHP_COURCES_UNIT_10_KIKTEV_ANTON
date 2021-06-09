<?php if(isset($_SESSION['id'])):?>
<h3>Hello, user!</h3>
<?php else: ?>
<h3>Hello, unauthorized user!</h3>
<?php endif; ?>
<?php echo "hello"; ?>


