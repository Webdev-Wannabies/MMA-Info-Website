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
				if(isset($_GET['id']))
				{			
					$action = "edit/edit_weightclass.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($weightclasses as $weightclass) 
					{
						if($weightclass['id'] == $_GET['id'] )
						{
							$id = $weightclass['id'];
							$firstname = $weightclass['lower_limit'];
							$lastname = $weightclass['upper_limit'];
							$name = $weightclass['name'];
							$org = $weightclass['org'];
			
						}
					}
				
				}
				else
				{
 					$action = "add/add_weightclass.php";
					$buttonText = "add";
					
					$id = "";
					$firstname = "";
					$lastname = "";
					$name = "";
					$org = "";
					

				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<input type="text" name="lower_limit" value="<?php echo $firstname ?>" >
					<input type="text" name="upper_limit" value="<?php echo $lastname ?>" >
					<input type="text" name="name" value="<?php echo $name ?>" >
					
					<select name="organization_id" > organization </option>
						<?php foreach ($organizations as $organization): ?>
								<option value= "<?php echo $organization['id'] ?>" > <?php echo $organization['name'] ?> </option>
						<?php endforeach ?>
					</select>
					
					<input type="submit" value="<?php  echo $buttonText  ?>" >
			</form>
