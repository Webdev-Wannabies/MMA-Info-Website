<?php

require_once '../validation.php';

$_SESSION['result_typeEmptyDescription'] = checkEmpty($description);
$_SESSION['result_typeBadDescription'] = checkString($description);
$_SESSION['result_typeEmptyAdditionalInfo'] = checkEmpty($additional_info);
$_SESSION['result_typeBadAdditionalInfo'] = checkString($additional_info);

if($_SESSION['result_typeEmptyDescription'] || !$_SESSION['result_typeBadDescription'] || $_SESSION['result_typeEmptyAdditionalInfo'] || !$_SESSION['result_typeBadAdditionalInfo'])
{
	$_SESSION['result_typeBadValues'] = true;
}
else
{
	$_SESSION['result_typeBadValues'] = false;
}