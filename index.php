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
	<div class="row row-top">
		<div class="col-12 col-s-12">
			<a href="index.php">
				<img src="img/banner.png" class="banner" />
			</a>
		</div>
	</div>
	<div class="row row-middle">
		<div class="col-2 col-s-12 menu">
		
			<form method="get" class="search" action="index.php">
				<input type="text" placeholder="search..." name="search"/>
				
				<button type="submit">
					GO
				</button>
			</form>
			
			<br/>
			<a href="index.php">
				<div class="content_part_short">
					EVENTS
				</div>
			</a>
			
			<a href="index.php">
				<div class="content_part_short">
					FIGHTERS
				</div>
			</a>
				
			<a href="index.php">
				<div class="content_part_short">
					ASSOCIATIONS
				</div>
			</a>
			
			<a href="index.php">
				<div class="content_part_short">
					ORGANIZATIONS
				</div>
			</a>
			
			<a href="index.php">
				<div class="content_part_short">
					ABOUT
				</div>
			</a>
		</div> 
		
		<div class="col-8 col-s-8 content-l">
			
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
			else if( isset($_GET['type'] ) && isset($_GET['id'] ) )
			{
				$content_page = "scripts/client/view/" . $_GET['type'] . "_l.php";
				require_once( $content_page );
			}
			else
			{
				$content_page = "scripts/client/view/front_page_l.php";
				require_once( $content_page );
			}
			
			?>
		</div>
		<div class="col-2 col-s-4 content-s">
			<?php
			if( isset($_GET['type'] ) && isset($_GET['id'] ) )
			{
				$content_page = "scripts/client/view/" . $_GET['type'] . "_s.php";
				require_once( $content_page );
			}
			else
			{
				$content_page = "scripts/client/view/front_page_s.php";
				require_once( $content_page );
			}
			?>
		</div>
	</div>
	<div class="row row-bottom">
		<div class="col-12 col-s-12">
			Created by Gaweł Bartczak, Igor Dołomisiewicz.
		</div> 

	</div>	
</body>