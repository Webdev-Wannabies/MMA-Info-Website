<?php

require_once 'scripts/database.php';

if( isset( $_GET['search'] ) )
{
	$tables = require_once 'scripts/client/search_data.php';
	
	if( empty( $_GET['search'] ) )
	{
		header('Location: index.php');
		exit();
	}
	
	$searchResults = [];
	
	$tableCount = 0;
	$tableNames = array_keys( $tables );
	
	while( $tableCount < count($tableNames) )
	{	
		$tableName = $tableNames[ $tableCount ];
		$table = $tables[ $tableName ];
		
		$searchResults[ $tableName ] = [];
		
		foreach( $table as $column )
		{
			$keywordCount = 0;
			$keywords = explode ( " ",  $_GET['search'] );
			
			$construct = " ";
			
			foreach( $keywords as $keyword ) 
			{
				if( $keywordCount == 0 )
				{ 
					$construct .= "$column LIKE '%" . $keyword . "%' ";
				}
				else
				{
					$construct .= "OR $column LIKE '%" . $keyword . "%' ";
				}
						
				$keywordCount++;
			}
			
			$construct = "SELECT * FROM $tableName WHERE" . $construct . ";";
		
			echo '<p>' . $construct . '</p>';
					
			$searchQuery = $db->prepare( $construct );
			$searchQuery->execute();
			
			$searchResults[ $tableName ] += $searchQuery->fetchAll();
		}
		
		$tableCount++;
	}	
} 

?>

<!DOCTYPE html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<link rel="stylesheet" type="text/css" href="css/client.css">
	<title> MMA-Info-Website </title>
</head> 
<body>
	<div class="row-top">
		<div class="col-3 col-l-3 col-xl-3">
			ICON
		</div> 
		<div class="col-9 col-l-9 col-xl-9">
			BANNER
		</div>
	</div>
	<div class="row-middle">
		<div class="col-2 col-l-2 col-xl-2">
		
			<form method="get" class="search" action="index.php">
				<input type="text" placeholder="search..." name="search"/>
				
				<button type="submit">
					GO
				</button>
			</form>
			
			<br/>
			MENU
		</div> 
		
		<div class="col-8 col-l-8 col-xl-8">
			<?php
			if( isset( $searchResults ) )
			{
				foreach( array_keys( $searchResults ) as $resultType )
				{
					foreach( $searchResults[$resultType] as $result )
					{
						require 'scripts/client/search_result.php';
					}
				}	
			}
			else
			{
				if( isset($_GET['type'] ) && isset($_GET['id'] ) )
				{
					$content_page = "scripts/client/view/" . $_GET['type'] . "_l.php";
					require_once( $content_page );
				}
			}
			
			// ELSE DISPLAY NEWS - TO DO
			?>
		</div>
		<div class="col-2 col-l-2 col-xl-2">
			<?php
			if( isset($_GET['type'] ) && isset($_GET['id'] ) )
			{
				$content_page = "scripts/client/view/" . $_GET['type'] . "_s.php";
				require_once( $content_page );
			}
			?>
		</div>
	</div>
	<div class="row-bottom">
		<div class="col-12 col-l-12 col-xl-12">
			FOOTER
		</div> 

	</div>	
</body>