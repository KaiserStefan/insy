<?php
session_start();

$server ='mysql:dbname=user;host=localhost';
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
    try {
        $sql = "DELETE FROM user.users WHERE id=".$_POST['sel_user'];
        $pdo->exec($sql);
        echo 'Daten wurden erfolgreich gelösct';
        echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
    }catch(PDOException  $e ){
        echo "Fehler: ".$e;
        exit();
    }