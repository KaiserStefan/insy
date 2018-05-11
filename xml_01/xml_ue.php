<?php
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 09.05.2018
 * Time: 08:14
 */
session_start();

$server ='mysql:dbname=xml_database;host=localhost';
$username='root';
$password='';
$opt  = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
);
try {
    $pdo = new PDO($server, $username, $password, $opt);
    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
}
catch (PDOException $error) {
    die('Verbindung fehlgeschlagen: ' . $error->getMessage());

}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>xml</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<div class="jumbotron" >
    <h1 style="text-align: center">Tankshop</h1>
</div>
<div style="margin: 10px;">
<form style="display: flex; flex-direction: row;" name="fragen" method="POST" id="baseform">
    <select class="form-control" name="kat">

<?php
$dom = new DOMDocument;
$dom->Load('panzer.xml');
if ($dom->validate()) {
    echo "XML Dokument ist valide!", '<br>';
}
$xml=simplexml_load_file("panzer.xml")
or die("Error: Cannot create object");
$categorys = array();
foreach ($xml->tank as $child)
{
    array_push($categorys, $child->attributes());
    //echo $child->weight['unit'];
}
$categorys = array_unique($categorys);
//echo count($categorys);
foreach($categorys as $result) {
    echo ('<option value="'.$result.'">'.$result.'</option>\n');
}

echo '</select>';
echo ("<button onclick=\"submitForm('ausgabe.php')\" type='submit'>Auswählen</button></div>");
echo ('</form>');
/*
foreach($xml->children() as $tanks) {
    echo $tanks->name . ", ";
}
*/

