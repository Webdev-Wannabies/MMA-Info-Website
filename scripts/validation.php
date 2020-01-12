<?php 
function checkEmpty($value){
	if(empty($value))
		return true;
	else    
		return false;
}	

function checkDecimal($value){
	if (!preg_match('/^[0-9]{1,3}\.[0-9]{1,2}$/', $value)) 
    {
		return false;
    }
    return true;
}	

function checkInt($value){
	if (!preg_match('/^[0-9]{1,3}$/', $value)) 
    {
		return false;
    }
    return true;	
}	

function checkString($value){
	if (!preg_match('/^[a-z]+$/', $value)) 
    {
		return false;
    }
    return true;
}
?>