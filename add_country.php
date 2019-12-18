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
		
		$userQuery = $db->prepare("INSERT INTO countries (id, name) VALUES(null,:name)");
		$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: countries.php');
		exit();
	}
	
	
?>