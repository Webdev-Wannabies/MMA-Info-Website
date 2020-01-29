<?php

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
									<a href="panel.php?type=organizations&id=<?php echo $organization['id'];  ?>" >Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $organization['id']; ?> &table=organizations" >Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']) && !isset($_GET['name']))
				{			
					$action = "edit/edit_organization.php?id={$_GET['id']}";
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
				else if(isset($_GET['id']) && isset($_GET['name']))
				{
					$action = "edit/edit_organization.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
					$associationName = $_GET['name'];
					$associationDescription = $_GET['description'];
				}
				else if(!isset($_GET['id']) && isset($_GET['name']))
				{
					$action = "add/add_organization.php";
					$buttonText = "add"; 
					
					$associationName = $_GET['name'];
					$associationDescription = $_GET['description'];
				}
				else
				{
					$action = "add/add_organization.php";
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
				if(isset($_SESSION['organizationEmptyName']) && $_SESSION['organizationEmptyName'] == true ) 
				{	
					echo "Empty Organization Name <br>";
					$_SESSION['organizationEmptyName'] = false;
				}
				else if(isset($_SESSION['organizationBadName']) && $_SESSION['organizationBadName'] == false) 
				{	
					echo "Organization Name schould be string <br>";
					$_SESSION['organizationBadName'] = true;
				}
				if(isset($_SESSION['organizationEmptyDescription']) && $_SESSION['organizationEmptyDescription'] == true ) 
				{	
					echo "Empty Organization Description ";
					$_SESSION['organizationEmptyDescription'] = false;
				}
				else if(isset($_SESSION['organizationBadDescription']) && $_SESSION['organizationBadDescription'] == false) 
				{	
					echo "Organization description schould be string";
					$_SESSION['organizationBadDescription'] = true;
				}
			?>