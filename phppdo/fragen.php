<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Quizz PHP and MySQL with PDO</title>
</head>
<body>

<?php
if (!isset($_GET['kat'])) {
echo "1. Mal  haha <br />";
}
$server ='mysql:dbname=fragebogen;host=localhost';
$username='root';
$password='';
$opt  = array
            (
              PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );
try {
	$pdo = new PDO($server, $username, $password, $opt);
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
    } 
catch (PDOException $error) {
	die( 'Verbindung fehlgeschlagen: ' . $error->getMessage());
}


try {
	$query = 'SELECT * FROM fragebogen.kategorien';

echo ("<form name='F1' action=".$_SERVER['PHP_SELF']." method='GET'>");
echo '<select name="kat">\\n';
	echo $query;
foreach ($pdo -> query($query) as $row){
	echo ('<option value="'.$row['KategorieID'].'">'.$row['Bezeichnung'].'</option>\n');
}
}
catch (PDOException $error) { 
	echo "</select>";
	die( 'Verbindung fehlgeschlagen: ' . $error->getMessage());
}
	//echo $row['Bezeichnung'] ."<br />";


 echo '</select>';
 echo (" <input type='submit' name='submit' value='waehle' />");

if (isset($_GET['kat'])) {
	 $query = 'SELECT * FROM fragebogen.fragen where FK_Kategorie ='.$_GET['kat'];
     echo $query;
  foreach ($pdo -> query($query) as $row){
		echo "<br />";

	echo $row['FragenID'].': '.$row['Frage'];
}
}
 
echo ("</form>");

?>
 <a href="fragen.php?hhh=27"> haha</a>
</body>
</html>