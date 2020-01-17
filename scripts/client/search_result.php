
	<div class='content_part_container'>
	<?php
	if( isset($_GET['search']) )
	{
	?>
		<a href= <?php echo "index.php?type=" . $resultType . "&id=" . $result['id'] ?> > 
		
		<?php
		switch( $resultType )
		{
			case "fighters":
					echo $result['first_name'] . " " . $result['last_name'];
				break;
				
			case "events":
					echo $result['name'];
				break;
				
			case "news":
					echo $result['title'];
				break;
			default:
					echo "Unknown";
				break;
		}
		
		?>
		
		</a> 
	<?php
	}
	?>
	</div>
