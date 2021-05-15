<!DOCTYPE html>
<html>
<head>
	<script>
		function getHTMLresult(result){
			var display = document.getElementById("display");
			display.innerHTML = result;
		}

		function html1(){
			var ajax= new XMLHttpRequest ();
			if(!ajax){alert("Ajaxне инициализирован");
				return;
			}
			var select = document.getElementById("select1").value;
			ajax.onreadystatechange = function()
			{
				if (ajax.readyState== 4)  { 
					if(ajax.status== 200) {// если ошибок нет
						getHTMLresult(ajax.responseText);
					}
					else {
						alert(ajax.status+ " -" + ajax.statusText);
						ajax.abort();
					}
				}
			}
			//params = "id=" + encodeURIComponent(select);
			ajax.open("POST", "results_1.php", true);
			params = "id=" + select;
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send(params);
		}

		function xml1(){
			var ajax= new XMLHttpRequest ();
			if(!ajax){alert("Ajaxне инициализирован");
				return;
			}
			var select = document.getElementById("select1").value;
			ajax.onreadystatechange = function()
			{
				if (ajax.readyState== 4)  { 
					if(ajax.status== 200) {// если ошибок нет
						var result = "";	// формирование таблицы
						result += "XML:<table>";
						result += "<tr>";
						result += "<td>name</td>";
						result += "<td>login</td>";
						result += "<td>password</td>";
						result += "<td>start</td>";
						result += "<td>stop</td>";
						result += "<td>in MB</td>";
						result += "<td>out MB</td>";
						result += "</tr>";
						var rows = ajax.responseXML.firstChild.children; // firstChild = <root>, children = table rows
						for (var i= 0; i< rows.length; i++) {
							result += "<tr>";
							result += "<td>" + rows[i].children[0].firstChild.nodeValue+ "</td>";
							result += "<td>" + rows[i].children[1].firstChild.nodeValue+ "</td>";
							result += "<td>" + rows[i].children[2].firstChild.nodeValue+ "</td>";
							result += "<td>" + rows[i].children[3].firstChild.nodeValue+ "</td>";
							result += "<td>" + rows[i].children[4].firstChild.nodeValue+ "</td>";
							result += "<td>" + rows[i].children[5].firstChild.nodeValue+ "</td>";
							result += "<td>" + rows[i].children[6].firstChild.nodeValue+ "</td>";
							result += "</tr>";
						}

						result += "</table>";
						getHTMLresult(result);

					}
					else {
						alert(ajax.status+ " -" + ajax.statusText);
						ajax.abort();
					}
				}
			}
			ajax.open("POST", "results_1_XML.php", true);
			params = "id=" + select;
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send(params);
		}

		function html2(){
			var ajax= new XMLHttpRequest ();
			if(!ajax){alert("Ajaxне инициализирован");
				return;
			}
			var date_start = document.getElementById("date1").value;
			var date_end = document.getElementById("date2").value;
			ajax.onreadystatechange = function()
			{
				if (ajax.readyState== 4)  { 
					if(ajax.status== 200) {// если ошибок нет
						getHTMLresult(ajax.responseText);
					}
					else {
						alert(ajax.status+ " -" + ajax.statusText);
						ajax.abort();
					}
				}
			}
			ajax.open("POST", "results_2.php", true);
			params = "date_start=" +date_start+"&date_end=" + date_end;
			ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			ajax.send(params);
		}

		function html3(){
			var ajax= new XMLHttpRequest ();
			if(!ajax){alert("Ajaxне инициализирован");
				return;
			}
			ajax.onreadystatechange = function()
			{
				if (ajax.readyState== 4)  { 
					if(ajax.status== 200) {// если ошибок нет
						getHTMLresult(ajax.responseText);
					}
					else {
						alert(ajax.status+ " -" + ajax.statusText);
						ajax.abort();
					}
				}
			}
			ajax.open("POST", "results_3.php", true);
			ajax.send(null);
		}

		function json3(){
			var ajax= new XMLHttpRequest ();
			if(!ajax){alert("Ajaxне инициализирован");
				return;
			}
			ajax.onreadystatechange = function()
			{
				if (ajax.readyState== 4)  { 
					if(ajax.status== 200) {// если ошибок нет
						var result = "";	// формирование таблицы
						result += "XML:<table>";
						result += "<tr>";
						result += "<td>name</td>";
						result += "<td>login</td>";
						result += "<td>password</td>";
						result += "<td>\$balance</td>";
						result += "</tr>";
						var rows =  JSON.parse(ajax.responseText); // JSON -> object
						for (var i= 0; i< rows.length; i++) {
							result += "<tr>";
							result += "<td>" + rows[i][0]+ "</td>";
							result += "<td>" + rows[i][1]+ "</td>";
							result += "<td>" + rows[i][2]+ "</td>";
							result += "<td>" + rows[i][3]+ "</td>";
							result += "</tr>";
						}

						result += "</table>";
						getHTMLresult(result);
					}
					else {
						alert(ajax.status+ " -" + ajax.statusText);
						ajax.abort();
					}
				}
			}
			ajax.open("POST", "results_3_json.php", true);
			ajax.send(null);
		}
	</script>
</head>
<body>
	<h1>Статистику работы в сети выбранного клиента</h1>
	<form method="POST" action="results_1.php">
<?php
$db_driver="mysql";
$host = "localhost";
$database = "L1";
$dsn = "$db_driver:host=$host; dbname=$database";
$username = "root";
$password = "";

$dbh = new PDO ($dsn, $username, $password,
	[PDO::ATTR_PERSISTENT => true,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8']
);
$sql = "SELECT * FROM client";
echo "<select name=\"id\" id=\"select1\">";
foreach ($dbh->query($sql) as $row) {
echo "<option value=\"{$row['id_client']}\">
{$row['id_client']}, {$row['name']}</option>
";
}
echo "</select><br>";
?>
	<input type="button"  onclick="html1()" value="html">
	<input type="button"  onclick="xml1()" value="XML">
	</form>

	<h1>Статистику работы в сети за указанный промежуток времени</h1>
	<form method="POST" action="results_2.php">
		<input type="date" name="date_start" id="date1">-
		<input type="date" name="date_end" id="date2"><br>
		<input type="button"  onclick="html2()" value="html">
	</form>

	<h1>Вывести список клиентов с отрицательным балансом счета</h1>
	<form method="POST" action="results_3.php">
		<input type="button" onclick="html3()" value="html">
		<input type="button" onclick="json3()" value="json">
	</form>

	<div id="display"></div>
</body>
</html>