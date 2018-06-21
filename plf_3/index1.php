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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<?php
echo '<h1>Userverwaltung</h1>';
?>
<!--
<form method="POST" action="?php echo $_SERVER['PHP_SELF']?>">
-->
<form id="baseform" method="POST">

<select name="sel_user">';
    <?php

// Get all categories from the database - mind that in comparison to mysqli where we iterate through each row ADODB returns an array with all data
$query = 'SELECT * FROM user.users';
try {
foreach ($pdo -> query($query) as $row) {
        // add the category html to the return value
    echo ('<option value="'.$row['id'].'">'.$row['user'].'</option>\n');
    }
}catch(PDOException  $e ){
    echo "Fehler: ".$e;
    exit();
}
// Close the Select Box
echo '</select>';

echo ("<button name='update' onclick=\"submitForm('change.php')\" value='Update' type='submit'>Ändern</button>");
echo ("<button name='delete' onclick=\"submitForm('delete.php')\" value='Delete' type='submit'>Löschen</button>");
echo ("<button name='neu'  onclick=\"submitForm('new.php')\" value='Change' type='submit'>Einfügen</button>");


if (isset($_GET["updatef"])) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=user", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "update user.users set user=".$_GET['sel_user'];
        $conn->exec($sql);
        echo 'Daten wurden erfolgreich gelösct';
        echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
    }catch(PDOException  $e ){
        echo "Fehler: ".$e;
        exit();
    }
}
?>
</body>