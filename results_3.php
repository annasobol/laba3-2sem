<!DOCTYPE html>
<html>

<head>
</head>
<body>
<?php
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

echo "<table>";
echo "<tr>";
echo "<td>name</td>";
echo "<td>login</td>";
echo "<td>password</td>";
echo "<td>balance</td>";
echo "</tr>";
foreach ($res as $row){
echo "<tr>";
echo "<td>{$row['name']}</td>";
echo "<td>{$row['login']}</td>";
echo "<td>{$row['password']}</td>";
echo "<td>{$row['balance']}</td>";
echo "</tr>";
}
echo "</table>";



?>
</body>
</html>