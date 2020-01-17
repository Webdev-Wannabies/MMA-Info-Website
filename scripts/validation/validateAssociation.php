<?php

require_once '../validation.php';

$_SESSION['associationEmptyDescription'] = checkEmpty($description);
$_SESSION['associationBadDescription'] = checkString($description);
$_SESSION['associationEmptyName'] = checkEmpty($name);
$_SESSION['associationBadName'] = checkString($name);

if($_SESSION['associationEmptyDescription'] || !$_SESSION['associationBadDescription'] || $_SESSION['associationEmptyName'] || !$_SESSION['associationBadName'])
{
	$_SESSION['associationBadValues'] = true;
}
else
{
	$_SESSION['associationBadValues'] = false;
}