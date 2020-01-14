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
?>