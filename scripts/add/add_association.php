<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$_SESSION['associationBadValues']=false;
		
		$name = filter_input(INPUT_POST, 'name');
		$description = filter_input(INPUT_POST, 'description');
		
		require_once '../validation/validateAssociation.php';
		
		if($_SESSION['associationBadValues']==false)
	    {
			$userQuery = $db->prepare("INSERT INTO associations (id, name, description) VALUES(null,:name,:description)");
			$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
			$userQuery->bindValue(':description', $description, PDO::PARAM_STR);
			$userQuery->execute();
		
			header('Location: ../panel.php?type=associations');
			exit();
		}
		else
		{
			header('Location: ../panel.php?type=associations&name=' . $name . '&description=' . $description);
			exit();
		}
	}
	
	
?>