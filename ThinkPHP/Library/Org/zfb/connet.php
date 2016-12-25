<?php 
$dbhost = 'localhost'; 
$dbuser = 'root'; //我的用户名 
$dbpass = 'root'; //我的密码 
$dbname = 'vosweb625'; //我的mysql库名 
$connect = mysql_connect($dbhost,$dbuser,$dbpass,$dbname); 
if ($connect) { 
   echo 'aaa';
} else { 
  die('Could not connect: ' . mysql_error());
} 
?> 