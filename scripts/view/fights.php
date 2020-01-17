<?php


require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$fightsQuery = $db->query('SELECT fights.id, F.nickname fn, O.nickname opn, weightclasses.name wn, events.name en, result_types.description, W.nickname wnn, end_round, end_time 
								  FROM fights LEFT JOIN fighters F ON fights.fighter_id = F.id
								  LEFT JOIN fighters O   ON fights.opponent_id = O.id
								  LEFT JOIN fighters W ON fights.winner_id = W.id
								  LEFT JOIN weightclasses  ON fights.weightclass_id = weightclasses.id
								  LEFT JOIN events  ON fights.event_id  = events.id
								  LEFT JOIN result_types  ON fights.result_type_id = result_types.id');
	$fights = $fightsQuery->fetchAll();
	
	$fightersQuery = $db->query('SELECT * FROM fighters');
	$fq = $fightersQuery->fetchAll();
	
	$eventsQuery = $db->query('SELECT * FROM events');
	$events = $eventsQuery->fetchAll();
	
	$weightclassesQuery = $db->query('SELECT * FROM weightclasses');
	$weightclasses = $weightclassesQuery->fetchAll();

	$result_typesQuery = $db->query('SELECT * FROM result_types');
	$result_types = $result_typesQuery->fetchAll();
	
	if(isset($_GET['id']))
	{
		$oneFightQuery = $db->query('Select fighter_id, opponent_id, weightclass_id, event_id, result_type_id, winner_id from fights where id = ' .$_GET['id']);
		$oneFight = $oneFightQuery->fetch(); 
	}
	
	} 
else
{
		header('Location: admin.php'); 
		exit();
}
?>

			<table>
					<thead>
						<tr><th>ID</th><th>FIGHTER</th><th>FIGHTER</th><th>WEIGHTCLASS</th><th>EVENT</th><th>RESULT</th><th>WINNER</th><th>ROUNDS</th><th>TIME</th> <th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($fights as $fight) : ?>
						<tr>
								<td><?php echo $fight['id']; ?></td>
								<td><?php echo $fight['fn']; ?></td>
								<td><?php echo $fight['opn']; ?></td>
								<td><?php echo $fight['wn']; ?></td>
								<td><?php echo $fight['en']; ?></td>
								<td><?php echo $fight['description']; ?></td>
								<td><?php echo $fight['wnn']; ?></td>
								<td><?php echo $fight['end_round']; ?></td>
								<td><?php echo $fight['end_time']; ?></td>
								<td>
									<a href="panel.php?type=fights&id=<?php echo $fight['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $fight['id'];	?> &table=fights">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']) && !isset($_GET['fighter_id']))
				{			
					$action = "edit/edit_fight.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($fights as $fight) 
					{
						if($fight['id'] == $_GET['id'] )
						{
							$id = $fight['id'];
							$fighter_id = $fight['fn'];
							$opponent_id =$fight['opn'];
							$weightclass_id = $fight['wn'];
							$event_id = $fight['en'];
							$result_type_id = $fight['description'];
							$winner_id = $fight['wnn'];
							$end_round = $fight['end_round'];
							$end_time = $fight['end_time'];
			
						}
					}
				
				}
				else if(isset($_GET['id']) && isset($_GET['fighter_id']))
				{
					$action = "edit/edit_fight.php?id={$_GET['id']}";
					$buttonText = "apply";
					
					$id = $_GET['id'];
					$fighter_id = $_GET['fighter_id'];
					$opponent_id =$_GET['opponent_id'];
					$weightclass_id = $_GET['weightclass_id'];
					$event_id = $_GET['event_id'];
					$result_type_id = $_GET['result_type_id'];
					$winner_id = $_GET['winner_id'];
					$end_round = $_GET['end_round'];
					$end_time = $_GET['end_time'];
				}
				else if(!isset($_GET['id']) && isset($_GET['fighter_id']))
				{
					$action = "add/add_fight.php";
					$buttonText = "add";
					
					$fighter_id = $_GET['fighter_id'];
					$opponent_id =$_GET['opponent_id'];
					$weightclass_id = $_GET['weightclass_id'];
					$event_id = $_GET['event_id'];
					$result_type_id = $_GET['result_type_id'];
					$winner_id = $_GET['winner_id'];
					$end_round = $_GET['end_round'];
					$end_time = $_GET['end_time'];
				}
				else
				{
 					$action = "add/add_fight.php";
					$buttonText = "add";
					
					$id = '';
					$fighter_id ='' ;
					$opponent_id ='';
					$weightclass_id ='' ;
					$event_id ='';
					$result_type_id ='' ;
					$winner_id = '';
					$end_round ='' ;
					$end_time = '';
					

				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<label> Fighter<select name="fighter_id" > FIGHTER </option>
						<?php foreach ($fq as $f): ?>
								<option <?php if(isset($_GET['id']) && $oneFight['fighter_id'] == $f['id']) echo "selected"; ?> value= "<?php echo $f['id'] ?>" > <?php echo $f['nickname'] ?> </option>
						<?php endforeach ?>
					</select></label>
					<label> Fighter<select name="opponent_id" > OPPONENT </option>
						<?php foreach ($fq as $f): ?>
								<option <?php if(isset($_GET['id']) && $oneFight['opponent_id'] == $f['id']) echo "selected"; ?> value= "<?php echo $f['id'] ?>" > <?php echo $f['nickname'] ?> </option>
						<?php endforeach ?>
					</select></label>					
					
					<label>Event<select name="event_id" > oevent </option>
						<?php foreach ($events as $event): ?>
								<option <?php if(isset($_GET['id']) && $oneFight['event_id'] == $event['id']) echo "selected"; ?> value= "<?php echo $event['id'] ?>" > <?php echo $event['name'] ?> </option>
						<?php endforeach ?>
					</select></label>
					
					<label>Weightclass<select name="weightclass_id" > weightclass </option>
						<?php foreach ($weightclasses as $weightclass): ?>
								<option <?php if(isset($_GET['id']) && $oneFight['weightclass_id'] == $weightclass['id']) echo "selected"; ?> value= "<?php echo $weightclass['id'] ?>" > <?php echo $weightclass['name'] ?> </option>
						<?php endforeach ?>
					</select></label>
					
					<label>Result Type<select name="result_type_id" > result_type </option>
						<?php foreach ($result_types as $result_type): ?>
								<option <?php if(isset($_GET['id']) && $oneFight['result_type_id'] == $result_type['id']) echo "selected"; ?> value= "<?php echo $result_type['id'] ?>" > <?php echo $result_type['description'] ?> </option>
						<?php endforeach ?>
					</select></label>
					
					<label>Winner<select name="winner_id" > WINNER </option>
						<?php foreach ($fq as $f): ?>
								<option <?php if(isset($_GET['id']) && $oneFight['winner_id'] == $f['id']) echo "selected"; ?> value= "<?php echo $f['id'] ?>" > <?php echo $f['nickname'] ?> </option>
						<?php endforeach ?>
					</select></label>
					<label>End Round<input type="text" name="end_round" value="<?php echo $end_round ?>" ></label>
					<label>End Time<input type="text" name="end_time" value="<?php echo $end_time ?>" ></label>
					
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
			<?php
			if(isset($_SESSION['fightEmptyRounds']) && $_SESSION['fightEmptyRounds'] == true ) 
				{	
					echo "Empty round number";
					$_SESSION['fightEmptyRounds'] = false;
				}
				else if(isset($_SESSION['fightBadRounds']) && $_SESSION['fightBadRounds'] == false) 
				{	
					echo "Rounds schould be integer";
					$_SESSION['fightBadRounds'] = true;
				}
				if(isset($_SESSION['fightEmptyTime']) && $_SESSION['fightEmptyTime'] == true ) 
				{	
					echo "Empty time ";
					$_SESSION['fightEmptyTime'] = false;
				}
				else if(isset($_SESSION['fightBadTime']) && $_SESSION['fightBadTime'] == false) 
				{	
					echo "Time should have :";
					$_SESSION['fightBadTime'] = true;
				}
			?>