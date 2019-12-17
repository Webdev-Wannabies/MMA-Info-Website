<?php
	session_start();
	require_once 'database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		
		$lower_limit = filter_input(INPUT_POST, 'lower_limit');
		$upper_limit = filter_input(INPUT_POST, 'upper_limit');
		$name = filter_input(INPUT_POST, 'name');
		$organization_id = filter_input(INPUT_POST, 'organization_id');
		

		
		$userQuery = $db->prepare("INSERT INTO weightclasses (lower_limit, upper_limit, name, organization_id ) 
		                           VALUES (:lower_limit,:upper_limit,:name,:organization_id)" );
		$userQuery->bindValue(':lower_limit', $lower_limit, PDO::PARAM_STR);
		$userQuery->bindValue(':upper_limit', $upper_limit, PDO::PARAM_STR);
		$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
		$userQuery->bindValue(':organization_id', $organization_id, PDO::PARAM_STR);
		$userQuery->execute();
		
		
		
		header('Location: weightclasses.php');
		exit();
	}
	
	
?>
