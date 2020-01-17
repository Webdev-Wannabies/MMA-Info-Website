<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$_SESSION['organizationBadValues']=false;
		
		$name = filter_input(INPUT_POST, 'name');
		$description = filter_input(INPUT_POST, 'description');
		
		require_once '../validation/validateOrganization.php';
		
		if($_SESSION['organizationBadValues']==false)
	    {
		$userQuery = $db->prepare("INSERT INTO organizations (id, name, description) VALUES(null,:name,:description)");
		$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
		$userQuery->bindValue(':description', $description, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: ../panel.php?type=organizations');
		exit();
		}
		else
		{
			header('Location: ../panel.php?type=organizations&name=' . $name . '&description=' . $description);
			exit();
		}
	}
	
	
?>