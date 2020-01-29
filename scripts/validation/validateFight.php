<?php

require_once '../validation.php';

$_SESSION['fightEmptyRounds'] = checkEmpty($end_round);
$_SESSION['fightBadRounds'] = checkInt($end_round);
$_SESSION['fightEmptyTime'] = checkEmpty($end_time);
$_SESSION['fightBadTime'] = checkTime($end_time);


if($_SESSION['fightEmptyRounds'] || !$_SESSION['fightBadRounds'] || $_SESSION['fightEmptyTime'] || !$_SESSION['fightBadTime'] )
{
	$_SESSION['fightBadValues'] = true;
}
else
{
	$_SESSION['fightBadValues'] = false;
}