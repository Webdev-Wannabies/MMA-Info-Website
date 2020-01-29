<?php

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
									<a href="panel.php?type=associations&id=<?php echo $association['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $association['id'];	?> &table=associations">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']) && !isset($_GET['name']))
				{			
					$action = "edit/edit_association.php?id={$_GET['id']}";
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
				else if(isset($_GET['id']) && isset($_GET['name']))
				{
					$action = "edit/edit_association.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
					$associationName = $_GET['name'];
					$associationDescription = $_GET['description'];
				}
				else if(!isset($_GET['id']) && isset($_GET['name']))
				{
					$action = "add/add_association.php";
					$buttonText = "add"; 
					
					$associationName = $_GET['name'];
					$associationDescription = $_GET['description'];
				}
				else
				{
					$action = "add/add_association.php";
					$buttonText = "add"; 
					$associationName = "";
					$associationDescription = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<label>Name<input type="text" name="name" value="<?php echo $associationName  ?>" ></label>
					<label>Description<input type="text" name="description" value="<?php echo $associationDescription  ?>" ></label>
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
			<?php
				if(isset($_SESSION['associationEmptyName']) && $_SESSION['associationEmptyName'] == true ) 
				{	
					echo "Empty Association Name <br>";
					$_SESSION['associationEmptyName'] = false;
				}
				else if(isset($_SESSION['associationBadName']) && $_SESSION['associationBadName'] == false) 
				{	
					echo "Name schould be string <br>";
					$_SESSION['associationBadName'] = true;
				}
				if(isset($_SESSION['associationEmptyDescription']) && $_SESSION['associationEmptyDescription'] == true ) 
				{	
					echo "Empty Description ";
					$_SESSION['associationEmptyDescription'] = false;
				}
				else if(isset($_SESSION['associationBadDescription']) && $_SESSION['associationBadDescription'] == false) 
				{	
					echo "description schould be string";
					$_SESSION['associationBadDescription'] = true;
				}
			?>