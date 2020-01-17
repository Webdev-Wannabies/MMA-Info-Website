<?php

require_once 'database.php';
$_SESSION['logged_id'] = 2;
if(isset($_SESSION['logged_id']))
{
	$weightclassesQuery = $db->query('SELECT weightclasses.id, weightclasses.lower_limit, weightclasses.upper_limit, weightclasses.name, organizations.name org
								  FROM weightclasses LEFT JOIN organizations ON weightclasses.organization_id = organizations.id ');
	$weightclasses = $weightclassesQuery->fetchAll();
	
	$orgQuery = $db->query('SELECT * FROM organizations');
	$organizations = $orgQuery->fetchAll();
	
	if(isset($_GET['id']))
	{
		$organizationIdQuery = $db->query('Select organization_id from weightclasses where id = ' .$_GET['id']);
		$organizationId = $organizationIdQuery->fetch(); 
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
						<tr><th>ID</th><th>LOWER LIMIT</th><th>UPPER LIMIT</th><th>NAME</th><th>ORGANIZATION</th> <th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($weightclasses as $weightclass) : ?>
						<tr>
								<td><?php echo $weightclass['id']; ?></td>
								<td><?php echo $weightclass['lower_limit']; ?></td>
								<td><?php echo $weightclass['upper_limit']; ?></td>
								<td><?php echo $weightclass['name']; ?></td>
								<td><?php echo $weightclass['org']; ?></td>
								<td>
									<a href="panel.php?type=weightclasses&id=<?php echo $weightclass['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $weightclass['id'];	?> &table=weightclasses">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']) && !isset($_GET['lower_limit']))
				{			
					$action = "edit/edit_weightclass.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($weightclasses as $weightclass) 
					{
						if($weightclass['id'] == $_GET['id'] )
						{
							$id = $weightclass['id'];
							$lower_limit = $weightclass['lower_limit'];
							$upper_limit = $weightclass['upper_limit'];
							$name = $weightclass['name'];
							$org = $weightclass['org'];
			
						}
					}
				
				}
				else if(isset($_GET['id']) && isset($_GET['lower_limit']))
				{
					$action = "edit/edit_weightclass.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
					$lower_limit = $_GET['lower_limit'];
					$upper_limit = $_GET['upper_limit'];
					$name = $_GET['name'];
					$org = $_GET['organization_id'];
				}
				else if(!isset($_GET['id']) && isset($_GET['lower_limit']))
				{
					$action = "add/add_weightclass.php";
					$buttonText = "add"; 
					
					$lower_limit = $_GET['lower_limit'];
					$upper_limit = $_GET['upper_limit'];
					$name = $_GET['name'];
					$org = $_GET['organization_id'];
				}
				else
				{
 					$action = "add/add_weightclass.php";
					$buttonText = "add";
					
					$id = "";
					$lower_limit = "";
					$upper_limit = "";
					$name = "";
					$org = "";
					

				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<label>Lower limit<input type="text" name="lower_limit" value="<?php echo $lower_limit ?>" ></label>
					<label>Upper limit<input type="text" name="upper_limit" value="<?php echo $upper_limit ?>" ></label>
					<label>Name<input type="text" name="name" value="<?php echo $name ?>" ></label>
					
					<label>Organization<select name="organization_id" > organization </option>
						<?php foreach ($organizations as $organization): ?>
								<option <?php if(isset($_GET['id']) && $organization['id']==$organizationId['organization_id'])echo"selected"; ?> value= "<?php echo $organization['id'] ?>" > <?php echo $organization['name'] ?> </option>
						<?php endforeach ?>
					</select></label>
					
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
			<?php
				if(isset($_SESSION['weightclassEmptyLowerLimit']) && $_SESSION['weightclassEmptyLowerLimit'] == true ) 
				{	
					echo "Empty lower  limit";
					$_SESSION['weightclassEmptyLowerLimit'] = false;
				}
				else if(isset($_SESSION['weightclassBadLowerLimit']) && $_SESSION['weightclassBadLowerLimit'] == false) 
				{	
					echo "lower limit schould be decimal value with dot";
					$_SESSION['weightclassBadLowerLimit'] = true;
				}
				if(isset($_SESSION['weightclassEmptyUpperLimit']) && $_SESSION['weightclassEmptyUpperLimit'] == true ) 
				{	
					echo "Empty upper limit ";
					$_SESSION['weightclassEmptyUpperLimit'] = false;
				}
				else if(isset($_SESSION['weightclassBadUpperLimit']) && $_SESSION['weightclassBadUpperLimit'] == false) 
				{	
					echo "upper limit schould be decimal value with dot";
					$_SESSION['weightclassBadUpperLimit'] = true;
				}
				if(isset($_SESSION['weightclassEmptyName']) &&$_SESSION['weightclassEmptyName'] == true ) 
				{	
					echo "Empty name ";
					$_SESSION['weightclassEmptyName'] = false;
				}
				else if(isset($_SESSION['weightclassBadName']) && $_SESSION['weightclassBadName'] == false) 
				{	
					echo "name schould be string";
					$_SESSION['weightclassBadName'] = true;
				}
			?>