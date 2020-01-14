<?php

require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$locationsQuery = $db->query('SELECT locations.id, locations.city, countries.name country_name FROM locations LEFT JOIN countries ON locations.country_id = countries.id');
	$locations = $locationsQuery->fetchAll();
	
	$countriesQuery = $db->query('SELECT * FROM countries');
	$countries = $countriesQuery->fetchAll();
	
} 
else
{
		header('Location: admin.php'); 
		exit();
}
	
?>

			<table>
					<thead>
						<tr><th>ID</th><th>Country</th><th>City</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($locations as $location) : ?>
						<tr>
								<td><?php echo $location['id']; ?></td>
								<td><?php echo $location['country_name']; ?></td>
								<td><?php echo $location['city']; ?></td>
								<td>
									<a href="panel.php?type=locations&id=<?php echo $location['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $location['id'];	?> &table=locations">Delete</a>
								</td>
							</tr>
							
					<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit/edit_location.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($locations as $location) 
					{
						if($location['id'] == $_GET['id'] )
						{
							$city_name = $location['city'];
							$country_name = $location['name'];
						}
					}
				
				}
				else
				{
					$action = "add/add_location.php";
					$buttonText = "add";
					
					$city_name = "";
					$country_name = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<input type="text" name="city" value="<?php echo $city_name ?>" >
					<select name="country_id" > country </option>
						<?php foreach ($countries as $country): ?>
								<option value= "<?php echo $country['id'] ?>" > <?php echo $country['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>