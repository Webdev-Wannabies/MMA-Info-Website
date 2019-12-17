<?php

session_start();
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
	} 
else
{
		header('Location: admin.php'); 
		exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title> fights </title>
</head> 
<body>
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
									<a href="fights.php?id=<?php echo $fight['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $fight['id'];	?> &table=fights">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit_fight.php?id={$_GET['id']}";
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
				else
				{
 					$action = "add_fight.php";
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
					<select name="fighter_id" > FIGHTER </option>
						<?php foreach ($fq as $f): ?>
								<option value= "<?php echo $f['id'] ?>" > <?php echo $f['nickname'] ?> </option>
						<?php endforeach ?>
					</select>
					<select name="opponent_id" > OPPONENT </option>
						<?php foreach ($fq as $f): ?>
								<option value= "<?php echo $f['id'] ?>" > <?php echo $f['nickname'] ?> </option>
						<?php endforeach ?>
					</select>					
					
					<select name="event_id" > oevent </option>
						<?php foreach ($events as $event): ?>
								<option value= "<?php echo $event['id'] ?>" > <?php echo $event['name'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<select name="weightclass_id" > weightclass </option>
						<?php foreach ($weightclasses as $weightclass): ?>
								<option value= "<?php echo $weightclass['id'] ?>" > <?php echo $weightclass['name'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<select name="result_type" > result_type </option>
						<?php foreach ($result_types as $result_type): ?>
								<option value= "<?php echo $result_type['id'] ?>" > <?php echo $result_type['description'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<select name="winner_id" > WINNER </option>
						<?php foreach ($fq as $f): ?>
								<option value= "<?php echo $f['id'] ?>" > <?php echo $f['nickname'] ?> </option>
						<?php endforeach ?>
					</select>
					<input type="text" name="end_round" value="<?php echo $end_round ?>" >
					<input type="text" name="end_time" value="<?php echo $end_time ?>" >
					
					<input type="submit" value="<?php  echo $buttonText  ?>" >
			</form>
			
		</main>
	</div>
</body>
</html>