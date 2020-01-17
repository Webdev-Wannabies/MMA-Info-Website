<?php

require_once '../validation.php';

$_SESSION['locationEmptyName'] = checkEmpty($city_name);
$_SESSION['locationBadName'] = checkString($city_name);

if($_SESSION['locationEmptyName'] || !$_SESSION['locationBadName'])
{
	$_SESSION['locationBadValues'] = true;
}
else
{
	$_SESSION['locationBadValues'] = false;
}
