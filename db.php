<?php


$host = 'localhost';
$dbname = 'u374171611_bd_ferriso';
$user = 'u374171611_adminferriso';
$pass = '00Z)EL9TyU8';



$con = mysqli_connect($host, $user, $pass, $dbname);
if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
?>
