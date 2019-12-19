<?php

session_start();
require_once '../database.php';

$userQuery = $db->prepare('UPDATE  sessions SET session_end = :session_end  WHERE id = :id' );
$userQuery->bindValue(':id', $_SESSION['session_id'], PDO::PARAM_STR);
$userQuery->bindValue(':session_end', date("Y-m-d H:i:s") );
$userQuery->execute();


unset($_SESSION['logged_id']);

header('Location: ../panel.php');

?>