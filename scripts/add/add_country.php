<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$_SESSION['countryBadValues']=false;
		
		$name = filter_input(INPUT_POST, 'name');
		
		require_once '../validation/validateCountry.php';
		
		if($_SESSION['countryBadValues']==false)
	    {
		$userQuery = $db->prepare("INSERT INTO countries (id, name) VALUES(null,:name)");
		$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
		$userQuery->execute();
		
		header('Location: ../panel.php?type=countries');
		exit();
		}
		else
		{
			header('Location: ../panel.php?type=countries&name=' . $name);
			exit();
		}
	}
	
	
?>