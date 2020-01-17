<?php

require_once '../validation.php';

$_SESSION['organizationEmptyDescription'] = checkEmpty($description);
$_SESSION['organizationBadDescription'] = checkString($description);
$_SESSION['organizationEmptyName'] = checkEmpty($name);
$_SESSION['organizationBadName'] = checkString($name);

if($_SESSION['organizationEmptyDescription'] || !$_SESSION['organizationBadDescription'] || $_SESSION['organizationEmptyName'] || !$_SESSION['organizationBadName'])
{
	$_SESSION['organizationBadValues'] = true;
}
else
{
	$_SESSION['organizationBadValues'] = false;
}