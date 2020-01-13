<?php

session_start();
require_once 'database.php';
$_SESSION['logged_id']=2;

if( !isset($_SESSION['logged_id']) )
{
	if( !isset( $_POST['login'] ) || !isset( $_POST['password'] ) )
	{
		unset($_SESSION['bad_attempt']);
		unset($_SESSION['empty_login']);
		unset($_SESSION['empty_password']);
		unset($_SESSION['wrong_login']);
		unset($_SESSION['wrong_password']);
	}
	else
	{
		if( empty( $_POST['login'] ) ) 
		{
			$_SESSION["empty_login"] = true;
		}

		if( empty( $_POST['password'] ) )
		{
			$_SESSION["empty_password"] = true;
		}
		
		if( empty( $_SESSION["empty_login"] ) || empty( $_SESSION["empty_password"] ) )
		{
			 $_SESSION['bad_attempt'] = true; 
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
				$_SESSION['login'] = $login;
				
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
				$_SESSION['bad_attempt'] = true; 
			}
		}
		else
		{
			$_SESSION["wrong_login"] = true;
			$_SESSION['bad_attempt'] = true;
		}
	}
} 

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="../css/panel.css">
	<title> admin-panel </title>
</head> 
<body>
	<div class="header panel_part">
		<label class="panel_part_small" type="right">  
			<?php  
				if( isset( $_SESSION['login'] ))
				{
					echo $_SESSION['login'];
				}
				else
				{
					echo '';
				}
				
			?>  
		</label>
		<a href="panel/logout.php" class = "logout_button panel_part_small" type ="right"> Logout </a>
	</div>
	<div class="container panel_part">
			
			<div class="top panel_part">
				<?php
					if( isset($_SESSION['logged_id']) )
					{
						require_once('panel/top.php');
					}
					else
					{
						require_once('panel/login.php');
						
						if ( isset($_SESSION['bad_attempt']) ) 
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
						}				
				}
				?>
			</div>
			<div class= "content panel_part">
				<?php
				if( isset( $_GET['type'] ) && !empty( $_GET['type'] ) )
				{			
					$content_page = "view/" . $_GET['type'] . ".php";
					require_once( $content_page );
				}
				?>
			</div>
			
		
	</div>
	<div class = "footer panel_part" >
		FOOTER
	</div>
</body>
</html>