<?php

require_once 'database.php';
if(isset($_SESSION['result_typeBadValues']))
{
	$_SESSION['result_typeBadValues'] = false;
}

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

			<table>
					<thead>
						<tr><th>ID</th><th>Description</th><th>Additional</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($result_types as $result_type) : ?>
						<tr>
								<td><?php echo $result_type['id']; ?></td>
								<td><?php echo $result_type['description']; ?></td>
								<td><?php echo $result_type['additional_info']; ?></td>
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
				if(isset($_GET['id']) && !isset($_GET['description']))
				{			
					$action = "edit/edit_result_type.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($result_types as $result_type) 
					{
						if($result_type['id'] == $_GET['id'] )
						{
							$result_typeName = $result_type['description'];
							$result_additionalInfo = $result_type['additional_info'];
						}
					}
				}
				else if(isset($_GET['id']) && isset($_GET['description']))
				{
					$action = "edit/edit_result_type.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
					$result_typeName = $_GET['description'];
					$result_additionalInfo = $_GET['additional_info'];
				}
				else if(!isset($_GET['id']) && isset($_GET['description']))
				{
					$action = "add/add_result_type.php";
					$buttonText = "add";
					
					$result_typeName = $_GET['description'];
					$result_additionalInfo = $_GET['additional_info'];
				}
				else
				{
					$action = "add/add_result_type.php";
					$buttonText = "add"; 
					$result_typeName = "";
					$result_additionalInfo = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<label>Description<input type="text" name="description" value="<?php echo $result_typeName  ?>" ></label>
					<label>Additional info<input type="text" name="additional_info" value="<?php echo $result_additionalInfo  ?>" ></label>
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
			<?php
				if(isset($_SESSION['result_typeEmptyDescription']) && $_SESSION['result_typeEmptyDescription'] == true ) 
				{	
					echo "Empty Description";
					$_SESSION['result_typeEmptyDescription'] = false;
				}
				else if(isset($_SESSION['result_typeBadDescription']) && $_SESSION['result_typeBadDescription'] == false) 
				{	
					echo "Description schould be string";
					$_SESSION['result_typeBadDescription'] = false;
				}
				if(isset($_SESSION['result_typeEmptyAdditionalInfo']) && $_SESSION['result_typeEmptyAdditionalInfo'] == true ) 
				{	
					echo "Empty Additional Info";
					$_SESSION['result_typeEmptyAdditionalInfo'] = false;
				}
				else if(isset($_SESSION['result_typeBadAdditionalInfo']) && $_SESSION['result_typeBadAdditionalInfo'] == false) 
				{	
					echo "Additional info schould be string";
					$_SESSION['result_typeBadAdditionalInfo'] = false;
				}
			
			?>
			