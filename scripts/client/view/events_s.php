<?php

require_once 'scripts/database.php';

$eventsQuery = $db->prepare("SELECT events.id, events.name event_name, events.date, events.location_id, locations.id location_id, locations.city city_name, countries.name country_name, events.organization_id, organizations.name organization_name
								  FROM events LEFT JOIN organizations ON events.organization_id = organizations.id
                                  LEFT JOIN locations ON events.location_id = locations.id
								  LEFT JOIN countries ON countries.id = locations.country_id
								  WHERE events.id = :id
								  ");
								  
$id = filter_input(INPUT_GET, 'id');	

$eventsQuery->bindValue(':id', $id, PDO::PARAM_STR);
$eventsQuery->execute();


$event = $eventsQuery->fetch();

?>


<div class="content_part_container">
	<div class='content_part_short'> <?php echo $event['event_name'] ?> </div>
	<div class='content_part_short'> <?php echo $event['country_name'] ?> </div>
	<div class='content_part_short'>
		<img img type="flag" src = "<?php echo 'img/countries/flags/' . strtolower( $event['country_name'] ) . '.png'; ?>"/>
					<?php echo $event['city_name'] ?>
	</div>
	
</div>
