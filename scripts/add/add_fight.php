<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		
		$fighter_id = filter_input(INPUT_POST, 'fighter_id');
		$opponent_id = filter_input(INPUT_POST, 'opponent_id');
		$weightclass_id = filter_input(INPUT_POST, 'weightclass_id');
		$event_id = filter_input(INPUT_POST, 'event_id');
		$result_type_id = filter_input(INPUT_POST, 'result_type_id');
		$winner_id = filter_input(INPUT_POST, 'winner_id');
		$end_round = filter_input(INPUT_POST, 'end_round');
		$end_time = filter_input(INPUT_POST, 'end_time');
		

		
		$userQuery = $db->prepare("INSERT INTO fights(id, fighter_id, opponent_id, weightclass_id, event_id, winner_id, end_round, end_time) VALUES (null, :fighter_id,  :opponent_id, :weightclass_id, :event_id, :winner_id, :end_round, :end_time)");
		$userQuery->bindValue(':fighter_id', $fighter_id, PDO::PARAM_STR);
		$userQuery->bindValue(':opponent_id', $opponent_id, PDO::PARAM_STR);
		$userQuery->bindValue(':weightclass_id', $weightclass_id, PDO::PARAM_STR);
		$userQuery->bindValue(':event_id', $event_id, PDO::PARAM_STR); 
		$userQuery->bindValue(':winner_id', $winner_id, PDO::PARAM_STR);
		$userQuery->bindValue(':end_round', $end_round, PDO::PARAM_STR);
		$userQuery->bindValue(':end_time', $end_time, PDO::PARAM_STR);
		$userQuery->execute();
		
		
		
		header('Location: ../panel.php?type=fights');
		exit();
	}
	
	
?>
