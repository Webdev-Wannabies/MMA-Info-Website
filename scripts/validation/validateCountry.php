<?php

require_once '../validation.php';

$_SESSION['countryEmptyName'] = checkEmpty($name);
$_SESSION['countryBadName'] = checkString($name);

if( $_SESSION['countryEmptyName'] || !$_SESSION['countryBadName'])
{
	$_SESSION['countryBadValues'] = true;
}
else
{
	$_SESSION['countryBadValues'] = false;
}