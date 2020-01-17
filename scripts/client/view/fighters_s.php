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

$imgpath =  'img/fighters/profile/' . strtolower( $fighter['first_name'] . '_'. $fighter['last_name'] ) . '.png';
if( !file_exists($imgpath) )
{
	$imgpath = 'img/fighters/profile/silhouette.png';
}
									

?>

<div class="content_part_container">
	<div class='content_part_short'><img type="fighter_profile" src="<?php echo $imgpath ?>"/></div>
	<div class='content_part_short'><?php echo $fighter['first_name'] . ' ' . $fighter['last_name'] ?></div>
	<div class='content_part_short'><?php echo ' "' . $fighter['nickname'] . '" ' ?></div>
	<div class='content_part_short'><?php echo 'Born: ' . $fighter['birthdate'] ?></div>
	<div class='content_part_short'><?php echo 'Height: ' . $fighter['height'] . ' cm'?></div>
	<div class='content_part_short'><?php echo 'Weight: ' . $fighter['weight'] . ' kg'?></div>
	<div class='content_part_short'><?php echo 'Association: ' . $fighter['asocname']; ?></div>
	<div class='content_part_short'>
		<img img type="flag" src = "<?php echo 'img/countries/flags/' . strtolower( $fighter['countryname'] ) . '.png'; ?>"/>
					<?php echo $fighter['countryname']; ?>
	</div>
</div>
