<?php

require_once '../validation.php';

$_SESSION['eventEmptyName'] = checkEmpty($name);
$_SESSION['eventBadName'] = checkString($name);

if($_SESSION['eventEmptyName'] || !$_SESSION['eventBadName'])
{
	$_SESSION['eventBadValues'] = true;
}
else
{
	$_SESSION['eventBadValues'] = false;
}
