<?php
	if(isset($_SESSION['logged_id'])){
		header('Location: panel.php');
		exit();
	}
?>

<form method="post" action="panel.php">
		<input type="text" name="login" placeholder="login">
		<input type="password" name="password" placeholder="password">
		<input type="submit" value="sign in" >
</form>
