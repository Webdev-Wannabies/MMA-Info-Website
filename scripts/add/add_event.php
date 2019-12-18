<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		
		$name = filter_input(INPUT_POST, 'name');
		$date = filter_input(INPUT_POST, 'date');
		$location_id = filter_input(INPUT_POST, 'location_id');
		$organization_id = filter_input(INPUT_POST, 'organization_id');
		

		
		$userQuery = $db->prepare("INSERT INTO events (name, date,location_id, organization_id ) 
		                           VALUES (:name,:date,:location_id,:organization_id)" );
		$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
		$userQuery->bindValue(':date', $date, PDO::PARAM_STR);
		$userQuery->bindValue(':location_id', $location_id, PDO::PARAM_STR);
		$userQuery->bindValue(':organization_id', $organization_id, PDO::PARAM_STR);
		$userQuery->execute();
		
		
		
		header('Location: panel.php?type=events');
		exit();
	}
	
	
?>
