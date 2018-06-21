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

<form method="GET" name="updateform" action="<?php echo $_SERVER['PHP_SELF']?><div>">
<?php
$query = 'SELECT * FROM user.users where id ='.$_POST['sel_user'];
foreach ($pdo -> query($query) as $row2) {
    ?>
    Neuer User:
    <input name="useri" required type="text" value="" name="user">
    Password:<input name="passwdi" required type="password" value="" name="passwd">
    <button name='updatef' value='Updatef' type='submit'>Ändern</button>
    </form></form>
    <?php
}
echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'">Return</button>');
