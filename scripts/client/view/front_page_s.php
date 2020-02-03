<?php

require_once 'scripts/database.php';

$id = filter_input(INPUT_GET, 'id');

$eventQuery = $db->query('SELECT events.id, events.name, DATE_FORMAT(events.date, \' %b %D %Y\') date, locations.city, countries.name country_name FROM events
											LEFT JOIN locations ON events.location_id = locations.id
											LEFT JOIN countries ON locations.country_id = countries.id
											ORDER BY events.date
											LIMIT 5
											');
						
$events_data = $eventQuery->fetchAll();

?>
<div class="content_part_container">
	<div class="content_part_short">
		Latest events:
	</div>
</div>

<?php foreach ($events_data as $event) : ?>
<div class="content_part_container">
	<div class="content_part_short">
		<?php echo $event['name']  ?>
	</div>
	<div class="content_part_short">
		<?php echo $event['date'] . '...' ?>
	</div>
	<div class="content_part_short">
		<?php echo 'By: ' . $event['city']; ?>
		<?php echo $event['country_name']; ?>
	</div>
	<div class="content_part_short">
	<a href="index.php?type=events&id= <?php echo $event['id'] ?> ">
		<button action="read_more_button">
			Check out
		</button>
	</a>
	</div>
</div>

<?php endforeach; ?>
			
