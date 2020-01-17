<?php

require_once 'scripts/database.php';

$id = filter_input(INPUT_GET, 'id');

$newsQuery = $db->query('SELECT news.id, news.title, SUBSTR(news.body, 1, 127) body_short, DATE_FORMAT(news.creation_date, \' %b %D %Y\') creation_date, admins.login admin_name FROM news
											LEFT JOIN admins ON news.admin_id = admins.id
											ORDER BY creation_date
											');
						
$news_data = $newsQuery->fetchAll();

?>

<?php foreach ($news_data as $news) : ?>

<div class="content_part_container">
	<div>
		<?php echo $news['title']  ?>
	</div>
	<div>
		<?php echo $news['body_short'] . '...' ?>
	</div>
	<div>
		<?php echo 'By: ' . $news['admin_name']; ?>
		<?php echo $news['creation_date']; ?>
	</div>
	<div type="bottom_right">
	<a href="index.php?type=news&id= <?php echo $news['id'] ?> ">
		<button action="read_more_button">
			Read more...
		</button>
	</a>
	</div>
</div>

<?php endforeach; ?>
			
