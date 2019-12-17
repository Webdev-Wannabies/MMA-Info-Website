<?php
	session_start();
	require_once 'database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$id = filter_input(INPUT_GET, 'id');
		
		$description = filter_input(INPUT_POST, 'description');
		
		$userQuery = $db->prepare("UPDATE result_types SET description = :description WHERE id = :id");
		$userQuery->bindValue(':id', $id, PDO::PARAM_STR);
		$userQuery->bindValue(':description', $description, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: result_types.php');
		exit();
	}

?>