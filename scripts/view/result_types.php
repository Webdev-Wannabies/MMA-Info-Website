<?php

require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$result_typesQuery = $db->query('SELECT * FROM result_types');
	$result_types = $result_typesQuery->fetchAll();
	
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
	<title> result_types </title>
</head> 
<body>
			<header>
				<div class="top">
					<?php require_once('panel/top.php') ?>
				</div>
			</header>
			<table>
					<thead>
						<tr><th>ID</th><th>Description</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($result_types as $result_type) : ?>
						<tr>
								<td><?php echo $result_type['id']; ?></td>
								<td><?php echo $result_type['description']; ?></td>
								<td>
									<a href="panel.php?type=result_types&id=<?php echo $result_type['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $result_type['id'];	?> &table=result_types">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit/edit_result_type.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($result_types as $result_type) 
					{
						if($result_type['id'] == $_GET['id'] )
						{
							$result_typeName = $result_type['description'];
						}
					}
				
				}
				else
				{
					$action = "add/add_result_type.php";
					$buttonText = "add"; 
					$result_typeName = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<input type="text" name="description" value="<?php echo $result_typeName  ?>" >
					<input type="submit" value="<?php  echo $buttonText  ?>" >
			</form>
			
		</main>
	</div>
</body>
</html>