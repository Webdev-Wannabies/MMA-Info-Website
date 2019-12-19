<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		
		$admin_id = $_SESSION['logged_id'];
		$date =date("Y-m-d H:i:s");
		
		$title = filter_input(INPUT_POST, 'title');
		$body = filter_input(INPUT_POST, 'body');
		
		$userQuery = $db->prepare("INSERT INTO news (admin_id, title, body, creation_date ) 
		                           VALUES (:admin_id,:title,:body,:date)" );
		$userQuery->bindValue(':admin_id', $admin_id, PDO::PARAM_STR);
		$userQuery->bindValue(':title', $title, PDO::PARAM_STR);
		$userQuery->bindValue(':body', $body, PDO::PARAM_STR);
		$userQuery->bindValue(':date', $date, PDO::PARAM_STR);
		$userQuery->execute();
		
		
		
		header('Location: ../panel.php?type=news');
		exit();
	}
	
	
?>
