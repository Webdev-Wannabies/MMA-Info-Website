<?php

require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$eventsQuery = $db->query('SELECT events.id, events.name event_name, events.date, events.location_id, locations.id loc_id, locations.city, countries.name, events.organization_id, organizations.name org
								  FROM events LEFT JOIN organizations ON events.organization_id = organizations.id
                                  LEFT JOIN locations ON events.location_id = locations.id
								  LEFT JOIN countries ON countries.id = locations.country_id');
	$events = $eventsQuery->fetchAll();
	
	
	$locQuery = $db->query('SELECT locations.id, locations.city, countries.name FROM locations LEFT JOIN countries ON countries.id = locations.country_id');
	$locations = $locQuery->fetchAll();
	
	$orgQuery = $db->query('SELECT * FROM organizations');
	$organizations = $orgQuery->fetchAll();
	
	if(isset($_GET['id']))
	{
		$oneEventQuery = $db->query('Select location_id, organization_id from events where id = ' .$_GET['id']);
		$oneEvent = $oneEventQuery->fetch(); 
	}
} 
else
{
		header('Location: ../admin.php'); 
		exit();
}
?>

			<table>
					<thead>
						<tr><th>ID</th><th>Name</th><th>DATE</th><th>LOCATION</th><th>ORGANIZATION</th> <th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($events as $event) : ?>
						<tr>
								<td><?php echo $event['id']; ?></td>
								<td><?php echo $event['event_name']; ?></td>
								<td><?php echo $event['date']; ?></td>
								<td><?php echo $event['city'] . ', ' . $event['name']; ?></td>
								<td><?php echo $event['org']; ?></td>
								<td>
									<a href="panel.php?type=events&id=<?php echo $event['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $event['id'];	?> &table=events">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']) && !isset($_GET['name']))
				{			
					$action = "edit/edit_event.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($events as $event) 
					{
						if($event['id'] == $_GET['id'] )
						{
							$id = $event['id'];
							$name = $event['event_name'];
							$date = $event['date'];
							$location_id = $event['location_id'];
							$orgganization_id = $event['organization_id'];
			
						}
					}
				
				}
				else if(isset($_GET['id']) && isset($_GET['name']))
				{
					$action = "edit/edit_event.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
					$id = $_GET['id'];
					$name = $_GET['name'];
					$date = $_GET['date'];
					$location_id = $_GET['location_id'];
				    $orgganization_id = $_GET['organization_id'];
				}
				else if(!isset($_GET['id']) && isset($_GET['name']))
				{
					$action = "add/add_event.php";
					$buttonText = "add";
			
					$name = $_GET['name'];
					$date = $_GET['date'];
					$location_id = $_GET['location_id'];
				    $orgganization_id = $_GET['organization_id'];
				}
				else
				{
 					$action = "add/add_event.php";
					$buttonText = "add";
					
					$id = "";
					$name = '';
				    $date = '';
				    $location_id = '';
					$orgganization_id = '';
					

				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<label>Event name<input type="text" name="name" value="<?php echo $name ?>" ></label>
					<label>Date<input type="date" name="date" value="<?php echo $date ?>" ></label>
					
					<select name="location_id" > <oprion> Location </option>
						<?php foreach ($locations as $location): ?>
								<option <?php if($location_id == $location['id']) echo "selected"; ?> value= "<?php echo $location['id'] ?>" > <?php echo $location['city'] . ", " . $location['name']?> </option>
						<?php endforeach ?>
					</select>
					<select name="organization_id" > <option>Organization </option>
						<?php foreach ($organizations as $organization): ?>
								<option <?php if($orgganization_id == $organization['id']) echo "selected"; ?> value= "<?php echo $organization['id'] ?>" > <?php echo $organization['name'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
			<?php
				if(isset($_SESSION['eventEmptyName']) && $_SESSION['eventEmptyName'] == true ) 
				{	
					echo "Empty event name <br>";
					$_SESSION['eventEmptyName'] = false;
				}
				else if(isset($_SESSION['eventBadName']) && $_SESSION['eventBadName'] == false) 
				{	
					echo "Name schould be string <br>";
					$_SESSION['eventBadName'] = true;
				}
				if(isset($_SESSION['eventBadNDate']) && $_SESSION['eventBadNDate'] == true) 
				{	
					echo "Date is not selected";
					$_SESSION['eventBadNDate'] = false;
				}
			?>
			