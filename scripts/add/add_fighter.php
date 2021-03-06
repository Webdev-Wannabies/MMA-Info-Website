<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$_SESSION['fighterBadValues']=false;
		
		$first_name = filter_input(INPUT_POST, 'first_name');
		$last_name = filter_input(INPUT_POST, 'last_name');
		$nickname = filter_input(INPUT_POST, 'nickname');
		$gender = filter_input(INPUT_POST, 'gender');
		$birthdate = filter_input(INPUT_POST, 'birthdate');
		$height = filter_input(INPUT_POST, 'height');
		$weight = filter_input(INPUT_POST, 'weight');
		$country_id = filter_input(INPUT_POST, 'country_id');
		$association_id = filter_input(INPUT_POST, 'association_id');

		require_once '../validation/validateFighter.php';
		
		if($_SESSION['fighterBadValues']==false)
	    {
			$userQuery = $db->prepare("INSERT INTO fighters(id, first_name, last_name, nickname, gender, birthdate, height, weight, country_id,  association_id) VALUES (null, :first_name,  :last_name, :nickname, :gender, :birthdate, :height, :weight, :country_id, :association_id)");
			$userQuery->bindValue(':first_name', $first_name, PDO::PARAM_STR);
			$userQuery->bindValue(':last_name', $last_name, PDO::PARAM_STR);
			$userQuery->bindValue(':nickname', $nickname, PDO::PARAM_STR);
			$userQuery->bindValue(':gender', $gender, PDO::PARAM_STR); 
			$userQuery->bindValue(':birthdate', $birthdate, PDO::PARAM_STR); 
			$userQuery->bindValue(':height', $height, PDO::PARAM_STR);
			$userQuery->bindValue(':weight', $weight, PDO::PARAM_STR);
			$userQuery->bindValue(':country_id', $country_id, PDO::PARAM_STR);
			$userQuery->bindValue(':association_id', $association_id, PDO::PARAM_STR);
			$userQuery->execute();
		
			header('Location: ../panel.php?type=fighters');
			exit();
		}
		else
		{
			header('Location: ../panel.php?type=fighters&first_name='.$first_name.'&last_name='.$last_name.'&nickname='.$nickname.'&gender='.$gender.'&birthdate='.$birthdate.'&height='.$height.'&weight='.$weight.'&country_id='.$country_id.'&association_id='.$association_id);
			exit();
		}
	}
	
	
?>
