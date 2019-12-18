<?php

session_start();
require_once 'database.php';

function setErrorAndExit() 
{
    $_SESSION['bad_attempt'] = true;
		
	header('Location: admin.php'); 
	exit();
}

if(!isset($_SESSION['logged_id']))
{
	if( !isset( $_POST['login'] ) || !isset( $_POST['password'] ) )
	{	
		setErrorAndExit();
	}
	
	if( empty( $_POST['login'] ) ) 
	{
		$_SESSION["empty_login"] = true;
	}

	if( empty( $_POST['password'] ) )
	{
		$_SESSION["empty_password"] = true;
	}
	
	if( isset( $_SESSION["empty_login"] ) || isset( $_SESSION["empty_password"] ) )
	{
		setErrorAndExit();
	}
	
	$login = filter_input(INPUT_POST, 'login');
	$password = filter_input(INPUT_POST, 'password');
	    	
	$userQuery = $db->prepare('SELECT id, password FROM admins WHERE login = :login');
	$userQuery->bindValue(':login', $login, PDO::PARAM_STR);
	$userQuery->execute();
	$user = $userQuery->fetch();
		
	if($user)
	{	
		if( password_verify($password, $user['password']) ) 
		{		
				
			$_SESSION['logged_id'] = $user['id'];
			UNSET($_SESSION['bad_attempt']);
			
			$sessionQuery = $db->prepare('INSERT INTO sessions( id, admin_id, session_start, session_end ) VALUES ( null, :admin_id, :session_start, null )');
			$sessionQuery->bindValue(':admin_id', $user['id'], PDO::PARAM_STR);
			
			$session_start = date("Y-m-d H:i:s");
			$sessionQuery->bindValue(':session_start',  $session_start);
			$sessionQuery->execute();
			
			$sessionQuery = $db->prepare('SELECT id FROM sessions WHERE admin_id = :admin_id AND session_start = :session_start');
			$sessionQuery->bindValue(':admin_id', $user['id'], PDO::PARAM_STR);
			$sessionQuery->bindValue(':session_start', $session_start );
			$sessionQuery->execute();
			
			$session = $sessionQuery->fetch();
			
			$_SESSION['session_id'] = $session['id'];
		}
		else
		{
			$_SESSION["wrong_password"] = true;
			
			setErrorAndExit();
		}
	}
	else
	{
		$_SESSION["wrong_login"] = true;
			
		setErrorAndExit();
		
	}
} 

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title> admin-panel </title>
</head> 
<body>
	<div class="container">
		<header>
			<div class="top">
				<?php require_once('panel/top.php') ?>
			</div>
		</header>
		<main>
			<div class="content">
				<?php
				if( isset( $_GET['type'] ) && !empty( $_GET['type'] ) )
				{			
					$content_page = "view/" . $_GET['type'] . ".php";
					require_once( $content_page );
				}
				?>
			</div>
		</main>
		<div class="footer">
		
		</div>
		
		
	</div>
</body>
</html>