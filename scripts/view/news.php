<?php

require_once 'database.php';

if(isset($_SESSION['logged_id']))
{
	$newsQuery = $db->query('SELECT news.id, news.title, news.body, news.creation_date date, admins.login name FROM news
											LEFT JOIN admins ON news.admin_id = admins.id
	');
	$news = $newsQuery->fetchAll();
} 
else
{
	header('Location: ../admin.php'); 
	exit();
}
	
?>
			<table>
				
					<thead>
						<tr><th>ID</th><th>DATE</th><th>ADMIN</th><th>TITLE</th><th colspan = 3>Operations</th></tr>
					</thead>
					<tbody>
					<?php foreach ($news as $sinlgeNews) : ?>
						<tr>
								<td><?php echo $sinlgeNews['id']; ?></td>
								<td><?php echo $sinlgeNews['date']; ?></td>
								<td><?php echo $sinlgeNews['name']; ?></td>
								<td><?php echo $sinlgeNews['title']; ?></td>
								<td>
									<a href="panel.php?type=news&id=<?php echo $sinlgeNews['id'];  ?>">Edit</a>
								</td>
								<td>
									<a href="delete.php?id=<?php echo $sinlgeNews['id'];	?> &table=news">Delete</a>
								</td>
								<td>
									<a href="panel.php?id=<?php echo $sinlgeNews['id'];	?> &table=news">Delete</a>
								</td>
							</tr>
							
						<?php endforeach; ?>
					
					</tbody>
			</table>
			
			<?php		
				if(isset($_GET['id']))
				{			
					$action = "edit/edit_news.php?id={$_GET['id']}";
					$buttonText = "apply"; 
						
					foreach ($news as $sinlgeNews) 
					{
						if($sinlgeNews['id'] == $_GET['id'] )
						{
							$newsTitle = $sinlgeNews['title'];
							$newsBody = $sinlgeNews['body'];
						}
					}
				
				}
				else
				{
					$action = "add/add_news.php";
					$buttonText = "add"; 
					$newsTitle = "";
					$newsBody = "";
				}
			?>
				
			 <form method="post" action="<?php echo $action ?>" id = "news_form" name = "news_form">
					<input type="text" name="title" value="<?php echo $newsTitle  ?>" >
					<input type="submit" class="panel_part_small" value="<?php  echo $buttonText  ?>" >
			</form>
			
			<textarea class="text" cols="80" rows ="20" name="body" form="news_form"><?php echo $newsBody ?></textarea>
			
			
