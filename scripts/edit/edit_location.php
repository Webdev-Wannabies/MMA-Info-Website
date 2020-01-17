<?php
	session_start();
	require_once '../database.php';
	$session['locationBadValues'] = false;
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{	
		$id = filter_input(INPUT_GET, 'id');
		
		$city_name = filter_input(INPUT_POST, 'city');
		$country_id = filter_input(INPUT_POST, 'country_id');
        
		require_once '../validation/validateLocation.php';
		
		if($_SESSION['locationBadValues']==false)
	    {
	
		$userQuery = $db->prepare("UPDATE locations SET city = :city, country_id = :country_id WHERE id = :id ");
		$userQuery->bindValue(':id', $id, PDO::PARAM_STR);
		$userQuery->bindValue(':city', $city_name, PDO::PARAM_STR);
		$userQuery->bindValue(':country_id', $country_id, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: ../panel.php?type=locations');
		exit();
		
		}
		else
		{
			header('Location: ../panel.php?type=locations&id='. $id .'&city_name=' . $city_name .'&country_id=' . $country_id);
			exit();
		}
			
	}
	
	
?>
