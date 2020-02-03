<?php

require_once 'scripts/database.php';

$fightsQuery = $db->prepare('SELECT fights.id, F.id fighter_id, CONCAT( F.first_name, " ", F.last_name) fighter_name, O.id opponent_id, CONCAT( O.first_name, " ", O.last_name) opponent_name, weightclasses.lower_limit, weightclasses.upper_limit, result_types.description, result_types.additional_info, W.id winner_id, end_round, end_time 
								FROM fights 
								LEFT JOIN fighters F ON F.id = fights.fighter_id
								LEFT JOIN fighters O ON O.id = fights.opponent_id
								LEFT JOIN fighters W ON W.id = fights.winner_id
								LEFT JOIN weightclasses ON weightclasses.id = fights.weightclass_id
								LEFT JOIN result_types ON result_types.id = fights.result_type_id
								WHERE fights.event_id = :id
								  ');
								  
$id = filter_input(INPUT_GET, 'id');	

$fightsQuery->bindValue(':id', $id, PDO::PARAM_STR);
$fightsQuery->execute();

$fights = $fightsQuery->fetchAll();

?>

<div class="content_part_container">

	<div class="content_part_short">
		<?php echo 'Total: ' . count($fights); ?>
	</div>
	
	<?php foreach($fights as $fight) : ?>
			<div class="content_part_short">
				<?php
					echo $fight['fighter_name'] . " vs " . $fight['opponent_name'];
				?>
			</div>	
	<?php endforeach ?>
</div>
