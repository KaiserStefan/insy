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
    <script src="script.js"></script>
</head>
<body>
<?php
echo '<h1>Userverwaltung</h1>';
?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF']?>">

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

echo ("<button name='update' value='Update' type='submit'>Ändern</button>");
echo ("<button name='delete' value='Delete' type='submit'>Löschen</button>");
echo ("<button name='neu' value='Change' type='submit'>Einfügen</button>");
echo '</form>';

if (isset($_POST["update"])) {
    ?>
    <div method="GET" name="updateform" action="<?php echo $_SERVER['PHP_SELF']?><div>">
    <?php
    $query = 'SELECT * FROM user.users where id ='.$_POST['sel_user'];
    foreach ($pdo -> query($query) as $row2) {
        echo "<div>".$row2['id'].". User:";
    ?>
        <input name="useri" required type="text" value="<?php echo $row2['user']?>" name="user">
        Password:<input name="passwdi" required type="password" value="<?php echo $row2['passwort']?>" name="passwd">
        <button name='updatef' value='Updatef' type='submit'>Ändern</button>
    </div></form>
    <?php
    }
    echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
}
else if (isset($_POST["delete"])) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=user", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "DELETE FROM user.users WHERE id=".$_POST['sel_user'];
        $conn->exec($sql);
            echo 'Daten wurden erfolgreich gelösct';
        echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
        }catch(PDOException  $e ){
        echo "Fehler: ".$e;
        exit();
    }
}
else if (isset($_POST["neu"])) {
    ?>
<div method="GET" name="updateform" action="<?php echo $_SERVER['PHP_SELF']?><div>">
    <?php
    $query = 'SELECT * FROM user.users where id ='.$_POST['sel_user'];
    foreach ($pdo -> query($query) as $row2) {
    ?>
    Neuer User:
    <input name="useri" required type="text" value="" name="user">
    Password:<input name="passwdi" required type="password" value="" name="passwd">
    <button name='updatef' value='Updatef' type='submit'>Ändern</button>
</div></form>
<?php
}
echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
}

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