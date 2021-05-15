<?php

header('Content-Type: application/json');

$db_driver="mysql";
$host = "localhost";
$database = "l1";
$dsn = "$db_driver:host=$host; dbname=$database";
$username = "root";
$password = "";
$dbh = new PDO ($dsn, $username, $password,
	[PDO::ATTR_PERSISTENT => true,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
);

$sql = 'SELECT * FROM client WHERE balance < 0';
$res=$dbh->query($sql);

$obj = [];
$i = 0;
foreach ($res as $row){
	$obj[$i] = array();
	$obj[$i][0] = $row['name'];
	$obj[$i][1] = $row['login'];
	$obj[$i][2] = $row['password'];
	$obj[$i][3] = $row['balance'];
	$i += 1;
}
print (json_encode($obj));
?>