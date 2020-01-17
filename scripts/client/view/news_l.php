<?php

require_once 'scripts/database.php';

$id = filter_input(INPUT_GET, 'id');

$newsQuery = $db->prepare('SELECT * FROM news WHERE id = :id');
						
$newsQuery->bindValue(':id', $id, PDO::PARAM_STR);	
$newsQuery->execute();
	
$news = $newsQuery->fetch();

?>

<div class="content_part_container">
	<div class="content_part_short">
		<h2>
			<?php echo $news['title']; ?>
		</h2>
	</div>

	<div class="content_part_short">
		<?php echo $news['body']; ?>
	</div>
</div>
	

			
