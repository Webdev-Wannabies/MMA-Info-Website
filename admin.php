<?php
	session_start();
	
	if(isset($_SESSION['logged_id'])){
		header('Location: panel.php');
		exit();
	}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title> login </title>
	<link rel="stylesheet" href="main.css">
</head> 
<body>
	<div class="container">
		<header> 

		</header>
		<main>
			<article>
				<form method="post" action="panel.php">
					<input type="text" name="login" placeholder="login">
					<input type="password" name="password" placeholder="password">
					<input type="submit" value="sign in" >
					<?php
					
					if (isset($_SESSION['bad_attempt'])) 
					{
						echo "Error! ";

						if( isset($_SESSION['empty_login']) )
						{
							echo "Empty login! ";
						}
						if( isset($_SESSION['empty_password']) )
						{
							echo "Empty password! ";
						}
						
						if( isset($_SESSION['wrong_login']) )
						{
							echo "Wrong login! ";
						}
						
						if( isset($_SESSION['wrong_password']) )
						{
							echo "Wrong password! ";
						}
						
						unset($_SESSION['bad_attempt']);
						unset($_SESSION['empty_login']);
						unset($_SESSION['empty_password']);
						unset($_SESSION['wrong_login']);
						unset($_SESSION['wrong_password']);
					}
					
					?>
				</form>
			</article>
		</main>
	</div>
</body>
</html>