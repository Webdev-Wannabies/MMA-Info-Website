<?php 
function checkEmpty($value)
{
	return empty($value);
}	

function checkDecimal($value)
{
	return preg_match('/^[0-9]{1,3}\.[0-9]{1,2}$/', $value);
}	

function checkInt($value)
{
	return preg_match('/^[0-9]{1,3}$/', $value);	
}	

function checkString($value)
{
	return preg_match('/^[a-zA-Z]+$/', $value);

}
function checkTime($value)
{
	return preg_match('/^[0-9]{1,2}\:[0-9]{1,2}$/', $value);
}	

function checkFighters($f1, $f2, $winner)
{
	if($winner == $f1 || $winner == $f2)
		return true;
	else 
		return false;
}

function checkFormDate($ddd)
{
	if($ddd == "")
		return true;
	else
		return false;		
}

function checkGender($gender)
{
	if($gender != "M" && $gender != "F")
			return true;
	else
		return false;	
}

?>