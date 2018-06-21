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
if (isset($_POST["updateform"])) {
    try {
        $sql = "update users set user=".$_POST['useri']." AND passwort= where".$_POST['passwdi'];
        $pdo->exec($sql);
        echo 'Daten wurden erfolgreich geändert';
        echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
    }catch(PDOException  $e ){
        echo "Fehler: ".$e;
        exit();
    }
} else {
    ?>
<form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <div>
    <?php
    $query = 'SELECT * FROM user.users where id =' . $_POST['sel_user'];
    foreach ($pdo->query($query) as $row2) {
        echo "<div>" . $row2['id'] . ". User:";
        ?>
        <input name="useri" required type="text" value="<?php echo $row2['user'] ?>" name="user">
        Password:<input name="passwdi" required type="password" value="<?php echo $row2['passwort'] ?>" name="passwd">
        <button name='updateform' value='updateform' type='submit'>Ändern</button>
        </div></form>
        <?php
    }
    echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
}