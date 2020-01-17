<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$_SESSION['result_typeBadValues'] = false;
		$_SESSION['result_typeEmptyDescription'] = false;
		$_SESSION['result_typeBadDescription'] = true;
		$_SESSION['result_typeEmptyAdditionalInfo'] = false;
		$_SESSION['result_typeBadAdditionalInfo'] = true;
		
		$description = filter_input(INPUT_POST, 'description');
		$additional_info = filter_input(INPUT_POST, 'additional_info');
		
		require_once '../validation/validateResult_type.php';
	    
        if($_SESSION['result_typeBadValues'] == false)
	    {		
			$userQuery = $db->prepare("INSERT INTO result_types (id, description, additional_info) VALUES(null,:description,:additional_info)");
			$userQuery->bindValue(':description', $description, PDO::PARAM_STR);
			$userQuery->bindValue(':additional_info', $additional_info, PDO::PARAM_STR);
			$userQuery->execute();
		
			header('Location: ../panel.php?type=result_types');
			exit();
		}
		else
		{
			header('Location: ../panel.php?type=result_types&description=' . $description .'&additional_info=' . $additional_info);
			exit();
		}
	}
	
	
?>