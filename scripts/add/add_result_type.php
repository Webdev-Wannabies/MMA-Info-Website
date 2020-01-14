<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		
		$description = filter_input(INPUT_POST, 'description');
		$additional_info = filter_input(INPUT_POST, 'additional_info');
		
		$userQuery = $db->prepare("INSERT INTO result_types (id, description) VALUES(null,:description)");
		$userQuery->bindValue(':description', $description, PDO::PARAM_STR);
		$userQuery->bindValue(':additional_info', $additional_info, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: ../panel.php?type=result_types');
		exit();
	}
	
	
?>