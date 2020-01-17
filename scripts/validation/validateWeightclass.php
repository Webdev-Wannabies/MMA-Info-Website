<?php

require_once '../validation.php';

$_SESSION['weightclassEmptyLowerLimit'] = checkEmpty($lower_limit);
$_SESSION['weightclassBadLowerLimit'] = checkDecimal($lower_limit);
$_SESSION['weightclassEmptyUpperLimit'] = checkEmpty($upper_limit);
$_SESSION['weightclassBadUpperLimit'] = checkDecimal($upper_limit);
$_SESSION['weightclassEmptyName'] = checkEmpty($name);
$_SESSION['weightclassBadName'] = checkString($name);

if($_SESSION['weightclassEmptyLowerLimit'] || !$_SESSION['weightclassBadLowerLimit'] || $_SESSION['weightclassEmptyName'] || !$_SESSION['weightclassBadName'] 
   || $_SESSION['weightclassEmptyUpperLimit'] || !$_SESSION['weightclassBadUpperLimit'])
{
	$_SESSION['weightclassBadValues'] = true;
}
else
{
	$_SESSION['weightclassBadValues'] = false;
}