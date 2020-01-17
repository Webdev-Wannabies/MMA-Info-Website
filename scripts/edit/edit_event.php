<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$_SESSION['eventBadValues'] = false;
		
		$id = filter_input(INPUT_GET, 'id');
		
		$name = filter_input(INPUT_POST, 'name');
		$date = filter_input(INPUT_POST, 'date');
		$location_id = filter_input(INPUT_POST, 'location_id');
		$organization_id = filter_input(INPUT_POST, 'organization_id');
		
		require_once '../validation/validateEvent.php';
		
		if($_SESSION['eventBadValues']==false)
	    {
		
			$userQuery = $db->prepare("UPDATE events SET name = :name, date = :date, location_id = :location_id, organization_id = :organization_id WHERE id = :id" );
			$userQuery->bindValue(':id', $id, PDO::PARAM_STR);
			$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
			$userQuery->bindValue(':date', $date, PDO::PARAM_STR);
			$userQuery->bindValue(':location_id', $location_id, PDO::PARAM_STR);
			$userQuery->bindValue(':organization_id', $organization_id, PDO::PARAM_STR);
			$userQuery->execute();
		
		header('Location: ../panel.php?type=events');
		exit();
		}
		else
		{
			header('Location: ../panel.php?type=events&id=' . $id . '&name=' . $name . '&date=' . $date . '&location_id=' . $location_id . '&organization_id=' . $organization_id);
			exit();
		}
	}
	
	
?>
