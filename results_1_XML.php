<?php

header('Content-Type: text/xml');
header("Cache-Control: no-cache, must-revalidate");


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

$sql = 'SELECT * FROM seanse INNER JOIN client ON seanse.fid_client = client.id_client
WHERE client.id_client = :id';
$sth=$dbh->prepare($sql);
$sth->execute(array(':id' => $_POST['id']));
$res=$sth->fetchAll();

echo '<?xml version="1.0" encoding="utf8" ?>';
echo "<root>";

foreach ($res as $row){
	print "<row>";
	print "<Name>${row['name']}</Name>";
	print "<Login>${row['login']}</Login>";
	print "<Password>${row['password']}</Password>";
	print "<Start>${row['start']}</Start>";
	print "<Stop>${row['stop']}</Stop>";
	print "<InMB>${row['in_traffic']}</InMB>";
	print "<OutMB>${row['out_traffic']}</OutMB>";
	print "</row>";
}

echo "</root>";
?>