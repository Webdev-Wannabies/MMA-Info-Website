<?php

session_start();
require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$associationsQuery = $db->query('SELECT * FROM associations');
	$associations = $associationsQuery->fetchAll();
	
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
	<title> associations </title>
</head> 
<body>
			<table>
					<thead>
						<tr><th>ID</th><th>Name</th><th>Desc</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($associations as $association) : ?>
						<tr>
								<td><?php echo $association['id']; ?></td>
								<td><?php echo $association['name']; ?></td>
								<td><?php echo $association['description']; ?></td>
								<td>
									<a href="associations.php?id=<?php echo $association['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $association['id'];	?> &table=associations">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit_association.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($associations as $association) 
					{
						if($association['id'] == $_GET['id'] )
						{
							$associationName = $association['name'];
							$associationDescription = $association['description'];
						}
					}
				
				}
				else
				{
					$action = "add_association.php";
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