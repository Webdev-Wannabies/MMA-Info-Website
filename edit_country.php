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
		
		$name = filter_input(INPUT_POST, 'name');
		
		$userQuery = $db->prepare( "UPDATE countries SET name= :name WHERE id = :id" );
		$userQuery->bindValue(':id', $id, PDO::PARAM_STR);
		$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: countries.php');
		exit();
	}

?>