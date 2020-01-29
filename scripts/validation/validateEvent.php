<?php

require_once '../validation.php';

$_SESSION['eventEmptyName'] = checkEmpty($name);
$_SESSION['eventBadName'] = checkString($name);
$_SESSION['eventBadNDate'] = checkString($date);

if($_SESSION['eventEmptyName'] || !$_SESSION['eventBadName'] || $_SESSION['eventBadNDate'])
{
	$_SESSION['eventBadValues'] = true;
}
else
{
	$_SESSION['eventBadValues'] = false;
}
