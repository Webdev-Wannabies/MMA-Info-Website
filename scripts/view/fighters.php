<?php

require_once 'database.php';
$good = true;

if(isset($_SESSION['logged_id']))
{
	$fightersQuery = $db->query('SELECT fighters.id, fighters.first_name, fighters.last_name, fighters.nickname, fighters.gender,
                                  fighters.birthdate, fighters.height, fighters.weight, countries.name countryname,
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
	if(isset($_POST['first_name']))
	{
		require_once 'validation.php';
		
		$good = true;
		if(empty($_POST['first_name']))
		{
			$good = false;
			$efirstName = true;
		}
		else
		{
		    if(!checkString($_POST['first_name']))
			{
				$good = false;
				$vfirstName = true;
			}
		}
		
		if(empty($_POST['last_name']))
		{
			$good = false;
			$elastName = true;
		}
		else
		{
			if(!checkString($_POST['last_name']))
			{
				$good = false;
				$vlastName = true;
			}
		}
		
		if(empty($_POST['nickname']))
		{
			$good = false;
			$enickName = true;
		}
		else
		{
			if(!checkString($_POST['nickname']))
			{
				$good = false;
				$vnickName = true;
			}
		}
		
		if(empty($_POST['height']))
		{
			$good = false;
			$eheight = true;
		}
		else
		{
			if(!checkDecimal($_POST['height']))
			{
				$good = false;
				$vheight = true;
			}
		}
		
		if(empty($_POST['weight']))
		{
			$good = false;
			$eweight = true;
		}
		else
		{
			if(!checkDecimal($_POST['weight']))
			{
				$good = false;
				$vweight = true;
			}
		}
			
		if($good)
		{
			if($_GET['id'])
				header("Location: edit/edit_fighter.php?id={$_GET['id']}&first_name={$_POST['first_name']}&last_name={$_POST['last_name']}&nickname={$_POST['nickname']}&birthdate={$_POST['birthdate']}&height={$_POST['height']}&weight={$_POST['weight']}&country_id={$_POST['country_id']}&association_id={$_POST['association_id']}&gender={$_POST['gender']}");
		    else
				header("Location: add/add_fighter.php?first_name={$_POST['first_name']}&last_name={$_POST['last_name']}&nickname={$_POST['nickname']}&birthdate={$_POST['birthdate']}&height={$_POST['height']}&weight={$_POST['weight']}&country_id={$_POST['country_id']}&association_id={$_POST['association_id']}&gender={$_POST['gender']}"); 
		    exit();
		}
			
	}
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
											if( $fighter['gender'] == 'M' )
											{
												$imgpath = '../img/fighters/profile/blank_male.png';
											}
											else
											{
												$imgpath = '../img/fighters/profile/blank_female.png';
											}
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
				if(isset($_GET['id']))
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
							$country = $fighter['countryname'];
							$association = $fighter['asocname'];
							
						}
					}
				
				}
				else if($good == false)
				{
					$buttonText = "zly";
					if(isset($_GET['id']))
						$id = $_GET['id'];
					else
						$id = "";
					$firstname = $_POST['first_name'];
					$lastname = $_POST['last_name'];
					$nickname = $_POST['nickname'];
					$gender = $fighter['gender'];
					$birthdate = $_POST['birthdate'];
					$weight = $_POST['weight'];
					$height = $_POST['height'];
					$country = $_POST['country_id'];
					$association = $_POST['association_id'];
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
					$association = "";

				}
			?>
				
			 
			 <form method="post">
					<input type="text" name="first_name" value="<?php echo $firstname ?>" >
					<input type="text" name="last_name" value="<?php echo $lastname ?>" >
					<input type="text" name="nickname" value="<?php echo $nickname ?>" >
					<input type="date" name="birthdate" value="<?php echo $birthdate ?>" >
					<input type="radio" name="gender" value="M" <?php if( $gender == 'M' ) echo 'checked'; ?> >M
					<input type="radio" name="gender" value="F" <?php if( $gender == 'F' ) echo 'checked'; ?>>F
					<input type="text" name="height" value="<?php echo $height ?>" >
					<input type="text" name="weight" value="<?php echo $weight ?>" >
					
					<select name="country_id" > country </option>
						<?php foreach ($countries as $country): ?>
								<option value= "<?php echo $country['id'] ?>" > <?php echo $country['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<select name="association_id" > association </option>
						<?php foreach ($associations as $association): ?>
								<option value= "<?php echo $association['id'] ?>" > <?php echo $association['name'] ?> </option>
						<?php endforeach ?>
					</select>
					<input type="submit"  class="panel_part_small" value="<?php echo $buttonText  ?>" >
			</form>
			<?php
			echo"";
			    if(isset($efirstName))
				{
					echo "empty first name<br>";
					$efirstName = false;
				}
				if(isset($vfirstName))
				{
					echo "first name should be string<br>";
				    $vfirstName = false;
				}
				if(isset($elastName))
				{
					echo "empty last name<br>";
					$elastName =  false;
				}
				if(isset($vlastName))
				{
					echo "last name should be string<br>";
					$vlastName = false;
				}
				if(isset($enickName))
				{
					echo "empty nickname<br>";
				    $enickName = false;
				}
				if(isset($vnickName))
				{
					echo "nickname should be string <br>";
					$vnickName = false;
				}
				if(isset($eheight))
				{
					$eheight = false;
					echo "empty height<br>";
				}
				if(isset($vheight))
				{
					$vheight = false;
					echo "height should be decimal value with dot<br>";
				}
				if(isset($eweight))
				{
					$eweight = false;
					echo "empty weight<br>";
				}
				if(isset($vweight))
				{
					$vweight = false;
					echo "weight should be decimal value with dot<br>";
				}
				
					
			
			?>
			