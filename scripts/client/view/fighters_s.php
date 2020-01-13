<?php

require_once 'scripts/database.php';

$id = filter_input(INPUT_GET, 'id');

$fightersQuery = $db->prepare("SELECT fighters.id, fighters.first_name, fighters.last_name, fighters.nickname, fighters.birthdate, fighters.height, fighters.weight, 
								countries.name countryname,
								associations.name asocname
							FROM fighters LEFT JOIN countries ON fighters.country_id = countries.id 
							LEFT JOIN associations ON fighters.association_id = associations.id
							WHERE fighters.id = :id"
							);
								  

$fightersQuery->bindValue(':id', $id, PDO::PARAM_STR);	
$fightersQuery->execute();

$fighter = $fightersQuery->fetch();
?>

<div class='content_short_part' type='right'><img src = "<?php echo 'img/countries/flags/' . strtolower( $fighter['countryname'] ) . '.png'; ?> "/></div>
<div class='content_short_part' type='right'><?php echo $fighter['countryname']; ?></div>
<div class='content_short_part'><img src = "<?php echo 'img/fighters/profile/' . strtolower( $fighter['first_name'] . '_'. $fighter['last_name'] ) . '.png' ?>" class = "picture"/></div>
<div class='content_short_part'><?php echo $fighter['first_name'] . ' ' . $fighter['last_name'] ?></div>
<div class='content_short_part'><?php echo ' "' . $fighter['nickname'] . '" ' ?></div>
<div class='content_short_part'><?php echo 'Born: ' . $fighter['birthdate'] ?></div>
<div class='content_short_part'><?php echo 'Height: ' . $fighter['height'] . ' cm'?></div>
<div class='content_short_part'><?php echo 'Weight: ' . $fighter['weight'] . ' kg'?></div>
<div class='content_short_part'><?php echo 'Association: ' . $fighter['asocname']; ?></div>
<div class='content_short_part'>
	<a href="panel.php?type=fighters&id=<?php echo $fighter['id'];  ?>">Edit</a>
</div>
