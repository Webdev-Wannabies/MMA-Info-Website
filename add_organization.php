<?php
	session_start();
	require_once 'database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$name = filter_input(INPUT_POST, 'name');
		$description = filter_input(INPUT_POST, 'description');
		
		$userQuery = $db->prepare("INSERT INTO organizations (id, name) VALUES(null,:name,:description)");
		$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: organizations.php');
		exit();
	}
	
	
?>