<?php

require_once 'scripts/database.php';

$fightsQuery = $db->prepare('SELECT fights.id, F.id fighter_id, CONCAT( F.first_name, " ", F.last_name ) fighter_name, O.id opponent_id, CONCAT( O.first_name, " ", O.last_name ) opponent_name, weightclasses.lower_limit, weightclasses.upper_limit, events.name event_name, result_types.description, result_types.additional_info, W.id winner_id, end_round, end_time 
								  FROM fights 
								  LEFT JOIN fighters F ON fights.fighter_id = F.id
								  LEFT JOIN fighters O ON fights.opponent_id = O.id
								  LEFT JOIN fighters W ON fights.winner_id = W.id
								  LEFT JOIN weightclasses ON fights.weightclass_id = weightclasses.id
								  LEFT JOIN events ON fights.event_id  = events.id
								  LEFT JOIN result_types ON fights.result_type_id = result_types.id
								  WHERE (fighter_id = :id_1 OR opponent_id = :id_2)
								  ');
								  
$id = filter_input(INPUT_GET, 'id');	
$fightsQuery->bindValue(':id_1', $id, PDO::PARAM_STR);
$fightsQuery->bindValue(':id_2', $id, PDO::PARAM_STR);

$fightsQuery->execute();
$fights = $fightsQuery->fetchAll();

$fightersQuery = $db->query('SELECT * FROM fighters');
$fighters = $fightersQuery->fetchAll();
	
$eventsQuery = $db->query('SELECT * FROM events');
$events = $eventsQuery->fetchAll();
	
$weightclassesQuery = $db->query('SELECT * FROM weightclasses');
$weightclasses = $weightclassesQuery->fetchAll();

$result_typesQuery = $db->query('SELECT * FROM result_types');
$result_types = $result_typesQuery->fetchAll();

$wins = 0;
$loses = 0;
$draws = 0;

foreach( $fights as $fight )
{
	if($fight['winner_id'] == $id)
	{
		$wins++;
	}	
	else if($fight['winner_id'] == null)
	{
		$draws++;
	}
	else if($fight['fighter_id'] != $id)
	{
		$draws--;
	}	
	else
	{
		$draws--;
	}
						
}
	
?>

<div class="content_part_container">

	<div class="content_part_short">
		<?php echo 'Total: ' . count($fights); ?>
	</div>
	
	<div class="content_part_short">
		<?php echo 'Wins: ' . $wins; ?>
	</div>
	
	<div class="content_part_short">
		<?php echo 'Loses: ' . $loses; ?>
	</div>
		
	<div class="content_part_short">
		<?php echo 'Draws: ' . $draws; ?>
	</div>
	
	<?php foreach($fights as $fight) : ?>
			<div class="content_part_short">
				<?php
					if($fight['winner_id'] == $id)
					{
						echo "Win vs " . $fight['opponent_name'];
					} 
					else if($fight['winner_id'] == null)
					{
						echo "Draw vs " . $fight['opponent_name'];
					}
					else if($fight['fighter_id'] != $id)
					{
						echo "Loss vs " . $fight['fighter_name'];
					}	
					else
					{
						echo "Loss vs " . $fight['opponent_name'];
					}
							
					echo $fight['event_name'];
				?>
			</div>	
	<?php endforeach ?>
</div>
