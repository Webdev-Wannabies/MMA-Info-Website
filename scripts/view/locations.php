<?php

require_once 'database.php';

$_SESSION['locationBadValues'] = false;


if(isset($_SESSION['logged_id']))
{
	$locationsQuery = $db->query('SELECT locations.id, locations.city, countries.name country_name FROM locations LEFT JOIN countries ON locations.country_id = countries.id');
	$locations = $locationsQuery->fetchAll();
	
	$countriesQuery = $db->query('SELECT * FROM countries');
	$countries = $countriesQuery->fetchAll();
	
	if(isset($_GET['id']))
	{
		$countryIdQuery = $db->query('Select country_id from locations where id = ' .$_GET['id']);
		$countryId = $countryIdQuery->fetch(); 
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
				if(isset($_GET['id']) && !isset($_GET['city_name']) )
				{			
					$action = "edit/edit_location.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($locations as $location) 
					{
						if($location['id'] == $_GET['id'] )
						{
							$city_name = $location['city'];
							$country_name = $location['country_name'];
						}
					}
				
				}
				else if(isset($_GET['id']) && isset($_GET['city_name']))
				{
							
					$action = "edit/edit_location.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
					$city_name = $_GET['city_name'];
					$countryId['country_id'] = $_GET['country_id'];
					
				}
				else if( !isset($_GET['id']) && isset($_GET['city_name'] ))
				{
					$action = "add/add_location.php";
					$buttonText = "add";
					
					$city_name = $_GET['city_name'];
					$countryId['country_id'] = $_GET['country_id'];
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
					<label>City<input type="text" name="city" value="<?php echo $city_name ?>" ></label>
										
					<label>Country<select name="country_id" > country </option>
						<?php foreach ($countries as $country): ?>
								<option <?php if(isset($_GET['id']) && $country['id']==$countryId['country_id'])echo"selected"; ?> value= "<?php echo $country['id'] ?>" > <?php echo $country['name'] ?> </option>
						<?php endforeach ?>
					</select></label>
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
				<?php 
						
						if(isset($_SESSION['locationEmptyName']) && $_SESSION['locationEmptyName'] == true ) 
						{	
							echo "Empty Location Name";
							$_SESSION['locationEmptyName'] = false;
						}
						else if(isset($_SESSION['locationBadName']) && $_SESSION['locationBadName'] == false) 
						{	
							echo "Name schould be string";
							$_SESSION['locationBadName'] = false;
						}
                    ?>    