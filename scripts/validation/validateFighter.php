<?php

require_once '../validation.php';

$_SESSION['fighterEmptyWeight'] = checkEmpty($weight);
$_SESSION['fighterBadWeight'] = checkDecimal($weight);
$_SESSION['fighterEmptyHeight'] = checkEmpty($height);
$_SESSION['fighterBadHeight'] = checkDecimal($height);
$_SESSION['fighterEmptyFirstName'] = checkEmpty($first_name);
$_SESSION['fighterBadFirstName'] = checkString($first_name);
$_SESSION['fighterEmptyLastName'] = checkEmpty($last_name);
$_SESSION['fighterBadLastName'] = checkString($last_name);
$_SESSION['fighterEmptyNickName'] = checkEmpty($nickname);
$_SESSION['fighterBadNickName'] = checkString($nickname);
$_SESSION['fightBadDate'] = checkFormDate($birthdate);
$_SESSION['fightNoGender'] = checkGender($gender);

if($_SESSION['fighterEmptyWeight'] || !$_SESSION['fighterBadWeight'] || $_SESSION['fighterEmptyHeight'] || !$_SESSION['fighterBadHeight'] || $_SESSION['fighterEmptyFirstName'] || !$_SESSION['fighterBadFirstName'] || $_SESSION['fighterEmptyLastName'] || !$_SESSION['fighterBadLastName'] || $_SESSION['fighterEmptyNickName'] || !$_SESSION['fighterBadNickName'] || $_SESSION['fightBadDate'] || $_SESSION['fightNoGender'] )
{
	$_SESSION['fighterBadValues'] = true;
}
else
{
	$_SESSION['fighterBadValues'] = false;
}