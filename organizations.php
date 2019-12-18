<?php

session_start();
require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$associationsQuery = $db->query('SELECT * FROM organizations');
	$organizations = $associationsQuery->fetchAll();
	
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
	<title> organizations </title>
</head> 
<body>
			<table>
					<thead>
						<tr><th>ID</th><th>Name</th><th>Desc</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($organizations as $organization) : ?>
						<tr>
								<td><?php echo $organization['id']; ?></td>
								<td><?php echo $organization['name']; ?></td>
								<td><?php echo $organization['description']; ?></td>
								<td>
									<a href="organizations.php?id=<?php echo $organization['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $organization['id'];	?> &table=organizations">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit_organization.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($organizations as $organization) 
					{
						if($organization['id'] == $_GET['id'] )
						{
							$associationName = $organization['name'];
							$associationDescription = $organization['description'];
						}
					}
				
				}
				else
				{
					$action = "add_organization.php";
					$buttonText = "add"; 
					$associationName = "";
					$associationDescription = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<input type="text" name="name" value="<?php echo $associationName  ?>" >
					<input type="text" name="description" value="<?php echo $associationDescription  ?>" >
					<input type="submit" value="<?php  echo $buttonText  ?>" >
			</form>
			
		</main>
	</div>
</body>
</html>