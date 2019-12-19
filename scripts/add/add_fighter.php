<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		
		$first_name = filter_input(INPUT_POST, 'first_name');
		$last_name = filter_input(INPUT_POST, 'last_name');
		$nickname = filter_input(INPUT_POST, 'nickname');
		$birthdate = filter_input(INPUT_POST, 'birthdate');
		$city_name = filter_input(INPUT_POST, 'city_name');
		$height = filter_input(INPUT_POST, 'height');
		$weight = filter_input(INPUT_POST, 'weight');
		$country_id = filter_input(INPUT_POST, 'country_id');
		$association_id = filter_input(INPUT_POST, 'association_id');

		
		$userQuery = $db->prepare("INSERT INTO fighters(id, first_name, last_name, nickname, birthdate, height, weight, country_id,  association_id) VALUES (null, :first_name,  :last_name, :nickname, :birthdate, :height, :weight, :country_id, :association_id)");
		$userQuery->bindValue(':first_name', $first_name, PDO::PARAM_STR);
		$userQuery->bindValue(':last_name', $last_name, PDO::PARAM_STR);
		$userQuery->bindValue(':nickname', $nickname, PDO::PARAM_STR);
		$userQuery->bindValue(':birthdate', $birthdate, PDO::PARAM_STR); 
		$userQuery->bindValue(':height', $height, PDO::PARAM_STR);
		$userQuery->bindValue(':weight', $weight, PDO::PARAM_STR);
		$userQuery->bindValue(':country_id', $country_id, PDO::PARAM_STR);
		$userQuery->bindValue(':association_id', $association_id, PDO::PARAM_STR);
		$userQuery->execute();
		
		
		
		header('Location: ../panel.php?type=fighters');
		exit();
	}
	
	
?>
