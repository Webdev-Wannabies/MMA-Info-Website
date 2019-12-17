<?php
	session_start();
	require_once 'database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$description = filter_input(INPUT_POST, 'description');
		
		$userQuery = $db->prepare("INSERT INTO result_types (id, description) VALUES(null,:description)");
		$userQuery->bindValue(':description', $description, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: result_types.php');
		exit();
	}
	
	
?>