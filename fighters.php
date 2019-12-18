<?php

session_start();
require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$fightersQuery = $db->query('SELECT fighters.id, fighters.first_name, fighters.last_name, fighters.nickname,
                                  fighters.birthdate, fighters.height, fighters.weight, countries.name countryname, organizations.name orgname,
								  associations.name asocname
								  FROM fighters LEFT JOIN countries ON fighters.country_id = countries.id 
								  LEFT JOIN organizations ON fighters.organization_id = organizations.id 
								  LEFT JOIN associations ON fighters.association_id = associations.id');
	$fighters = $fightersQuery->fetchAll();
	
	$countriesQuery = $db->query('SELECT * FROM countries');
	$countries = $countriesQuery->fetchAll();
	
	$orgQuery = $db->query('SELECT * FROM organizations');
	$organizations = $orgQuery->fetchAll();
	
	$assQuery = $db->query('SELECT * FROM associations');
	$associations = $assQuery->fetchAll();
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
	<title> fighters </title>
</head> 
<body>
			<table>
					<thead>
						<tr><th>ID</th><th>FIRST NAME </th><th>LAST NAME </th><th>NICKNAME </th><th>BIRTHDATE</th><th>HEIGHT</th><th>WEIGHHT</th><th>COUNTRY </th><th>ORGANIZATION</th><th>ASSOCIATION</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($fighters as $fighter) : ?>
						<tr>
								<td><?php echo $fighter['id']; ?></td>
								<td><?php echo $fighter['first_name']; ?></td>
								<td><?php echo $fighter['last_name']; ?></td>
								<td><?php echo $fighter['nickname']; ?></td>
								<td><?php echo $fighter['birthdate']; ?></td>
								<td><?php echo $fighter['height']; ?></td>
								<td><?php echo $fighter['weight']; ?></td>
								<td><?php echo $fighter['countryname']; ?></td>
								<td><?php echo $fighter['orgname']; ?></td>
								<td><?php echo $fighter['asocname']; ?></td>
								<td>
									<a href="fighters.php?id=<?php echo $fighter['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $fighter['id'];	?> &table=fighters">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit_fighter.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($fighters as $fighter) 
					{
						if($fighter['id'] == $_GET['id'] )
						{
							$id = $fighter['id'];
							$firstname = $fighter['first_name'];
							$lastname = $fighter['last_name'];
							$nickname = $fighter['nickname'];
							$birthdate = $fighter['birthdate'];
							$weight = $fighter['weight'];
							$height = $fighter['height'];
							$country = $fighter['countryname'];
							$organization = $fighter['orgname'];
							$association = $fighter['asocname'];
							
						}
					}
				
				}
				else
				{
 					$action = "add_fighter.php";
					$buttonText = "add";
					
					$id = "";
					$firstname = "";
					$lastname = "";
					$nickname = "";
					$birthdate = "";
					$weight = "";
					$height = "";
					$country = "";
					$organization = "";
					$association = "";

				}
			?>
				
			 <form method="post" action="<?php echo $action ?>">
					<input type="text" name="id" value="<?php echo $id ?>" >
					<input type="text" name="first_name" value="<?php echo $firstname ?>" >
					<input type="text" name="last_name" value="<?php echo $lastname ?>" >
					<input type="text" name="nickname" value="<?php echo $nickname ?>" >
					<input type="date" name="birthdate" value="<?php echo $birthdate ?>" >
					<input type="text" name="weight" value="<?php echo $weight ?>" >
					<input type="text" name="height" value="<?php echo $height ?>" >
					
					<select name="country_id" > country </option>
						<?php foreach ($countries as $country): ?>
								<option value= "<?php echo $country['id'] ?>" > <?php echo $country['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<select name="organization_id" > organization </option>
						<?php foreach ($organizations as $organization): ?>
								<option value= "<?php echo $organization['id'] ?>" > <?php echo $organization['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<select name="association_id" > association </option>
						<?php foreach ($associations as $association): ?>
								<option value= "<?php echo $association['id'] ?>" > <?php echo $association['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<input type="submit" value="<?php  echo $buttonText  ?>" >
			</form>
			
		</main>
	</div>
</body>
</html>