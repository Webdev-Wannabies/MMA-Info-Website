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
		
		$id = filter_input(INPUT_GET, 'id');
		$name = filter_input(INPUT_POST, 'name');
		$description = filter_input(INPUT_POST, 'description');
		
		require_once '../validation/validateAssociation.php';
		
		if($_SESSION['associationBadValues']==false)
	    {
			$userQuery = $db->prepare( "UPDATE associations SET name= :name, description = :description WHERE id = :id" );
			$userQuery->bindValue(':id', $id, PDO::PARAM_STR);
			$userQuery->bindValue(':name', $name, PDO::PARAM_STR);
			$userQuery->bindValue(':description', $description, PDO::PARAM_STR);
			$userQuery->execute();
		
			header('Location: ../panel.php?type=associations');
			exit();
		}
		else
		{
			header('Location: ../panel.php?type=associations&id=' . $id . '&name=' . $name . '&description=' . $description);
			exit();
		}
	}

?>