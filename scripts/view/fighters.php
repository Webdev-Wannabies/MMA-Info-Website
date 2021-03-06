<?php

require_once 'database.php';


if(isset($_SESSION['logged_id']))
{
	$fightersQuery = $db->query('SELECT fighters.id, fighters.first_name, fighters.last_name, fighters.nickname, fighters.gender,
                                  fighters.birthdate, fighters.height, fighters.country_id, fighters.association_id, fighters.weight, countries.name countryname,
								  associations.name asocname
								  FROM fighters LEFT JOIN countries ON fighters.country_id = countries.id 
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
		header('Location: ../admin.php'); 
		exit();
}
	
?>

			<table>
					<thead>
						<tr><th>ID</th><th>FIRST NAME </th><th>LAST NAME </th><th>NICKNAME </th><th>GENDER </th><th>BIRTHDATE</th><th>HEIGHT</th><th>WEIGHHT</th><th>COUNTRY</th><th>ASSOCIATION</th><th>PICTURE</th><th colspan = 2>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($fighters as $fighter) : ?>
						<tr>
								<td><?php echo $fighter['id']; ?></td>
								<td><?php echo $fighter['first_name']; ?></td>
								<td><?php echo $fighter['last_name']; ?></td>
								<td><?php echo $fighter['nickname']; ?></td>
								<td><?php echo $fighter['gender']; ?></td>
								<td><?php echo $fighter['birthdate']; ?></td>
								<td><?php echo $fighter['height']; ?></td>
								<td><?php echo $fighter['weight']; ?></td>
								<td><?php echo $fighter['countryname']; ?></td>
								<td><?php echo $fighter['asocname']; ?></td>
								<td>
									<?php 
										$imgpath =  '../img/fighters/profile/' . strtolower( $fighter['first_name'] . '_'. $fighter['last_name'] ) . '.png';
										
										if( !file_exists($imgpath) )
										{
											$imgpath = '../img/fighters/profile/silhouette.png';
										}
									?>
									<img src = "<?php echo $imgpath ?>" class = "picture"/>
								</td>
								<td>
									<a href="panel.php?type=fighters&id=<?php echo $fighter['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $fighter['id'];	?> &table=fighters">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']) && !isset($_GET['first_name']))
				{			
					$action = "edit/edit_fighter.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
						
					foreach ($fighters as $fighter) 
					{
						if($fighter['id'] == $_GET['id'] )
						{
							$id = $fighter['id'];
							$firstname = $fighter['first_name'];
							$lastname = $fighter['last_name'];
							$nickname = $fighter['nickname'];
							$gender = $fighter['gender'];
							$birthdate = $fighter['birthdate'];
							$weight = $fighter['weight'];
							$height = $fighter['height'];
							$country = $fighter['country_id'];
							$association = $fighter['association_id'];
							
						}
					}
				
				}
				else if(isset($_GET['id']) && isset($_GET['first_name']))
				{
					$action = "edit/edit_fighter.php?id={$_GET['id']}";
					$buttonText = "apply"; 
					
					$firstname = $_GET['first_name'];
					$lastname = $_GET['last_name'];
					$nickname = $_GET['nickname'];
					$gender = $_GET['gender'];
					$birthdate = $_GET['birthdate'];
					$weight = $_GET['weight'];
					$height = $_GET['height'];
					$country = $_GET['country_id'];
					$association = $_GET['association_id'];
				}
				else if(!isset($_GET['id']) && isset($_GET['first_name']))
				{
					$action = "add/add_fighter.php";
					$buttonText = "add";
					
					$firstname = $_GET['first_name'];
					$lastname = $_GET['last_name'];
					$nickname = $_GET['nickname'];
					$gender = $_GET['gender'];
					$birthdate = $_GET['birthdate'];
					$weight = $_GET['weight'];
					$height = $_GET['height'];
					$country = $_GET['country_id'];
					$association = $_GET['association_id'];
				}
				else
				{
 					$action = "add/add_fighter.php";
					$buttonText = "add";
					
					$id = "";
					$firstname = "";
					$lastname = "";
					$nickname = "";
					$gender = "";
					$birthdate = "";
					$weight = "";
					$height = "";
					$country ="";
					$association = "";

				}
			?>
				
			 
			 <form method="post" action="<?php echo $action ?>">
					<label>First Name<input type="text" name="first_name" value="<?php echo $firstname ?>" ></label>
					<label>Last Name<input type="text" name="last_name" value="<?php echo $lastname ?>" ></label>
					<label>Nick Name<input type="text" name="nickname" value="<?php echo $nickname ?>" ></label>
					<label>Birthdate<input type="date" name="birthdate" value="<?php echo $birthdate ?>" >
					<label>Gender<input type="radio" name="gender" value="M" <?php if( $gender == 'M' ) echo 'checked'; ?> >M</label>
					<input type="radio" name="gender" value="F" <?php if( $gender == 'F' ) echo 'checked'; ?>>F</label>
					<label>Height<input type="text" name="height" value="<?php echo $height ?>" ></label>
					<label>Weight<input type="text" name="weight" value="<?php echo $weight ?>" ></label>
					
					<select name="country_id" > <option value="0"> Country </option>
						<?php foreach ($countries as $countryFE): ?>
								<option <?php if($countryFE['id'] == $country) echo "selected";?> value= "<?php echo $countryFE['id'] ?>" > <?php echo $countryFE['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<select name="association_id" > association <option value="0"> Association</option>
						<?php foreach ($associations as $associationFE): ?>
						        <?php echo $association . "association   associationFE" . $associationFE['id']; ?>   
								<option <?php if($associationFE['id']==$association) echo "selected";?> value= "<?php echo $associationFE['id'] ?>" > <?php echo $associationFE['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<input type="submit"  class="panel_part_small" value="<?php echo $buttonText  ?>" >
			</form>
			<?php
			    if(isset($_SESSION['fighterEmptyFirstName']) && $_SESSION['fighterEmptyFirstName'] == true ) 
				{	
					echo "Empty first name<br>";
					$_SESSION['fighterEmptyFirstName'] = false;
				}
				else if(isset($_SESSION['fighterBadFirstName']) && $_SESSION['fighterBadFirstName'] == false) 
				{	
					echo "First name schould be decimal value with dot<br>";
					$_SESSION['fighterBadFirstName'] = true;
				}
				if(isset($_SESSION['fighterEmptyLastName']) && $_SESSION['fighterEmptyLastName'] == true ) 
				{	
					echo "Empty last name <br>";
					$_SESSION['fighterEmptyLastName'] = false;
				}
				else if(isset($_SESSION['fighterBadLastName']) && $_SESSION['fighterBadLastName'] == false) 
				{	
					echo "Last name schould be decimal value with dot<br>";
					$_SESSION['fighterBadLastName'] = true;
				}
				if(isset($_SESSION['fighterEmptyNickName']) && $_SESSION['fighterEmptyNickName'] == true ) 
				{	
					echo "Empty nickname <br>";
					$_SESSION['fighterEmptyNickName'] = false;
				}
				else if(isset($_SESSION['fighterBadNickName']) && $_SESSION['fighterBadNickName'] == false) 
				{	
					echo "Nickname schould be string<br>";
					$_SESSION['fighterBadNickName'] = true;
				}
				if(isset($_SESSION['fightBadDate']) && $_SESSION['fightBadDate'] == true ) 
				{	
					echo "Empty birthdate <br>";
					$_SESSION['fightBadDate'] = false;
				}
				if(isset($_SESSION['fighterEmptyHeight']) && $_SESSION['fighterEmptyHeight'] == true ) 
				{	
					echo "Empty height <br>";
					$_SESSION['fighterEmptyHeight'] = false;
				}
				else if(isset($_SESSION['fighterBadHeight']) && $_SESSION['fighterBadHeight'] == false) 
				{	
					echo "Height schould be decimal value with dot<br>";
					$_SESSION['fighterBadHeight'] = true;
				}
				if(isset($_SESSION['fightNoGender']) && $_SESSION['fightNoGender'] == true)
				{
					echo "Choose Gender <br> ";
					$_SESSION['fightNoGender'] == false;
				}					
				if(isset($_SESSION['fighterEmptyWeight']) && $_SESSION['fighterEmptyWeight'] == true ) 
				{	
					echo "Empty weight<br> ";
					$_SESSION['fighterEmptyWeight'] = false;
				}
				else if(isset($_SESSION['fighterBadWeight']) && $_SESSION['fighterBadWeight'] == false) 
				{	
					echo "Weight schould be decimal value with dot<br>";
					$_SESSION['fighterBadWeight'] = true;
				}
			?>
			