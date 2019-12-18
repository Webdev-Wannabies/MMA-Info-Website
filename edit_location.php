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
		
		$city_name = filter_input(INPUT_POST, 'city');
		$country_id = filter_input(INPUT_POST, 'country_id');

		
		$userQuery = $db->prepare("UPDATE locations SET city = :city, country_id = :country_id WHERE id = :id ");
		$userQuery->bindValue(':id', $id, PDO::PARAM_STR);
		$userQuery->bindValue(':city', $city_name, PDO::PARAM_STR);
		$userQuery->bindValue(':country_id', $country_id, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: locations.php');
		exit();
	}
	
	
?>
