<?php

session_start();
require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$countriesQuery = $db->query('SELECT * FROM countries');
	$countries = $countriesQuery->fetchAll();
	
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
	<title> countries </title>
</head> 
<body>
			<table>
					<thead>
						<tr><th>ID</th><th>Name</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($countries as $country) : ?>
						<tr>
								<td><?php echo $country['id']; ?></td>
								<td><?php echo $country['name']; ?></td>
								<td>
									<a href="countries.php?id=<?php echo $country['id'];  ?>">Edit</a>
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
					$action = "edit_country.php?id={$_GET['id']}";
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
					$action = "add_country.php";
					$buttonText = "add"; 
					$countryName = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<input type="text" name="name" value="<?php echo $countryName  ?>" >
					<input type="submit" value="<?php  echo $buttonText  ?>" >
			</form>
			
		</main>
	</div>
</body>
</html>