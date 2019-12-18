<?php
	session_start();
	require_once 'database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		
		$city_name = filter_input(INPUT_POST, 'city');
		$country_id = filter_input(INPUT_POST, 'country_id');

		
		$userQuery = $db->prepare("INSERT INTO locations (id, city, country_id) VALUES(null,:city_name, :country_id) ");
		$userQuery->bindValue(':city_name', $city_name, PDO::PARAM_STR);
		$userQuery->bindValue(':country_id', $country_id, PDO::PARAM_STR);
		$userQuery->execute();
		
		
		
		header('Location: locations.php');
		exit();
	}
	
	
?>
