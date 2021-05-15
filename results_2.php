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

// $sql = 'SELECT * FROM seanse INNER JOIN client ON seanse.fid_client = client.id_client
// WHERE client.id_client = :id';
$sql = 'SELECT * FROM seanse INNER JOIN client ON seanse.fid_client = client.id_client
WHERE start >= :date_start AND stop <= :date_end';
$sth=$dbh->prepare($sql);
$sth->execute(array(':date_start' => $_POST['date_start'], ':date_end' => $_POST['date_end']));
$res=$sth->fetchAll();

echo "<table>";
echo "<tr>";
echo "<td>name</td>";
echo "<td>login</td>";
echo "<td>password</td>";
echo "<td>start</td>";
echo "<td>stop</td>";
echo "<td>in MB</td>";
echo "<td>out MB</td>";
echo "</tr>";
foreach ($res as $row){
echo "<tr>";
echo "<td>{$row['name']}</td>";
echo "<td>{$row['login']}</td>";
echo "<td>{$row['password']}</td>";
echo "<td>{$row['start']}</td>";
echo "<td>{$row['stop']}</td>";
echo "<td>{$row['in_traffic']}</td>";
echo "<td>{$row['out_traffic']}</td>";
echo "</tr>";
}
echo "</table>";



?>
</body>
</html>