<?php
	session_start();
	require_once '../database.php';
	
	if(!isset($_SESSION['logged_id'])){
		header('Location: admin.php');
		exit();
	}
	else
	{
		$_SESSION['fightBadValues']=false;
		
		$id = filter_input(INPUT_GET, 'id');
		
		$fighter_id = filter_input(INPUT_POST, 'fighter_id');
		$opponent_id = filter_input(INPUT_POST, 'opponent_id');
		$weightclass_id = filter_input(INPUT_POST, 'weightclass_id');
		$event_id = filter_input(INPUT_POST, 'event_id');
		$result_type_id = filter_input(INPUT_POST, 'result_type_id');
		$winner_id = filter_input(INPUT_POST, 'winner_id');
		$end_round = filter_input(INPUT_POST, 'end_round');
		$end_time = filter_input(INPUT_POST, 'end_time');

		require_once '../validation/validateFight.php';
		
		if($_SESSION['fightBadValues']==false)
	    {
			$userQuery = $db->prepare("UPDATE fights SET fighter_id = :fighter_id, opponent_id = :opponent_id, weightclass_id = :weightclass_id,
									   event_id = :event_id, result_type_id = :result_type_id, winner_id = :winner_id, end_round = :end_round, end_time = :end_time WHERE id = :id" );
			$userQuery->bindValue(':id', $id, PDO::PARAM_STR);
			$userQuery->bindValue(':fighter_id', $fighter_id, PDO::PARAM_STR);
			$userQuery->bindValue(':opponent_id', $opponent_id, PDO::PARAM_STR);
			$userQuery->bindValue(':weightclass_id', $weightclass_id, PDO::PARAM_STR);
			$userQuery->bindValue(':event_id', $event_id, PDO::PARAM_STR); 
			$userQuery->bindValue(':winner_id', $winner_id, PDO::PARAM_STR);
			$userQuery->bindValue(':result_type_id', $result_type_id, PDO::PARAM_STR); 
			$userQuery->bindValue(':end_round', $end_round, PDO::PARAM_STR);
			$userQuery->bindValue(':end_time', $end_time, PDO::PARAM_STR);
			$userQuery->execute();
				
			header('Location: ../panel.php?type=fights');
			exit();
		}
		else
		{
			header('Location: ../panel.php?type=fights&id=' . $id . '&fighter_id=' . $fighter_id . '&opponent_id=' . $opponent_id . '&weightclass_id=' . $weightclass_id . '&event_id=' . $event_id .'&result_type_id=' . $result_type_id .
			'&winner_id=' . $winner_id . '&end_round=' . $end_round . '&end_time=' . $end_time);
			exit();
		}
	}
	
	
?>
