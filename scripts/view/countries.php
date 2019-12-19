<?php

require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$countriesQuery = $db->query('SELECT * FROM countries');
	$countries = $countriesQuery->fetchAll();
	
} 
else
{
	header('Location: ../admin.php'); 
	exit();
}
	
?>
			<table>
				
					<thead>
						<tr><th>ID</th><th>Name</th><th>Flag</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($countries as $country) : ?>
						<tr>
								<td><?php echo $country['id']; ?></td>
								<td><?php echo $country['name']; ?></td>
								<td> <img src = "<?php echo '../../img/countries/flags/' .strtolower( $country['name'] ). '.png' ?> " class = "flag"/></td>
								<td>
									<a href="panel.php?type=countries&id=<?php echo $country['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $country['id'];	?> &table=countries">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit/edit_country.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($countries as $country) 
					{
						if($country['id'] == $_GET['id'] )
						{
							$countryName = $country['name'];
						}
					}
				
				}
				else
				{
					$action = "add/add_country.php";
					$buttonText = "add"; 
					$countryName = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<input type="text" name="name" value="<?php echo $countryName  ?>" >
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
