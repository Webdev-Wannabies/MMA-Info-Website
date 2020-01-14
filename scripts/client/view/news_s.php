<?php

require_once 'scripts/database.php';

$id = filter_input(INPUT_GET, 'id');

$newsQuery = $db->prepare('SELECT DATE_FORMAT(news.creation_date, \'%a %D %b %Y %H:%i\') creation_date, admins.login admin_name FROM news
											LEFT JOIN admins ON news.admin_id = admins.id
											WHERE news.id = :id
											');
						
$newsQuery->bindValue(':id', $id, PDO::PARAM_STR);	
$newsQuery->execute();
	
$news = $newsQuery->fetch();

?>

<div class="content_part_short">
	<?php echo $news['admin_name']  ?>
</div>
<div class="content_part_short">
	<?php echo $news['creation_date']; ?>
</div>
	
			
