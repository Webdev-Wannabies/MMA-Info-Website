<?php

require_once 'database.php';
$_SESSION['logged_id'] = 2;
if(isset($_SESSION['logged_id']))
{
	$eventsQuery = $db->query('SELECT events.id, events.name, events.date, CONCAT(locations.city, countries.name) loc, organizations.name org
								  FROM events LEFT JOIN organizations ON events.organization_id = organizations.id
                                  LEFT JOIN locations ON events.location_id = locations.id
								  LEFT JOIN countries ON countries.id = locations.country_id');
	$events = $eventsQuery->fetchAll();
	
	$locQuery = $db->query('SELECT * FROM locations LEFT JOIN countries ON countries.id = locations.country_id');
	$locations = $locQuery->fetchAll();
	
	$orgQuery = $db->query('SELECT * FROM organizations');
	$organizations = $orgQuery->fetchAll();
} 
else
{
		header('Location: ../admin.php'); 
		exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<title> events </title>
</head> 
<body>
			<header>
				<div class="top">
				<?php require_once('panel/top.php') ?>
				</div>
			</header>
			<table>
					<thead>
						<tr><th>ID</th><th>Name</th><th>DATE</th><th>LOCATION</th><th>ORGANIZATION</th> <th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($events as $event) : ?>
						<tr>
								<td><?php echo $event['id']; ?></td>
								<td><?php echo $event['name']; ?></td>
								<td><?php echo $event['date']; ?></td>
								<td><?php echo $event['loc']; ?></td>
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
				if(isset($_GET['id']))
				{			
					$action = "edit/edit_event.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($events as $event) 
					{
						if($event['id'] == $_GET['id'] )
						{
							$id = $event['id'];
							$name = $event['name'];
							$date = $event['date'];
							$location_id = $event['loc'];
							$orgganization_id = $event['org'];
			
						}
					}
				
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
					<input type="text" name="name" value="<?php echo $name ?>" >
					<input type="date" name="date" value="<?php echo $date ?>" >
					
					<select name="location_id" > location </option>
						<?php foreach ($locations as $location): ?>
								<option value= "<?php echo $location['id'] ?>" > <?php echo $location['city'] . ", " . $location['name']?> </option>
						<?php endforeach ?>
					</select>
					<select name="organization_id" > organization </option>
						<?php foreach ($organizations as $organization): ?>
								<option value= "<?php echo $organization['id'] ?>" > <?php echo $organization['name'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<input type="submit" value="<?php  echo $buttonText  ?>" >
			</form>
			
		</main>
	</div>
</body>
</html>