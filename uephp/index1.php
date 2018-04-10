<?php
session_start();
$_SESSION["frage_id"] = "";
$_SESSION["kategorie"] = "";
$_SESSION["antworten"] = array();

$server ='mysql:dbname=fragebogen;host=localhost';
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
    <title>Fragen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script src="script.js"></script>
</head>
<body>
<div class="jumbotron" >
    <h1 style="text-align: center">Fragen</h1>
</div>
<div style="margin: 10px;">
<?php
try {
    $query = 'SELECT * FROM kategorien';
?>
    <form style="display: flex; flex-direction: row;" name="fragen" method="GET" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select class="form-control" name="kat">
        <?php
    echo $query;
    foreach ($pdo -> query($query) as $row){
        echo ('<option value="'.$row['KategorieID'].'">'.$row['Bezeichnung'].'</option>\n');
    }
}
catch (PDOException $error) {
    echo "</select>";
    die( 'Verbindung fehlgeschlagen: ' . $error->getMessage());
}
echo '</select>';
echo ("<button type='submit' class='btn btn-primary'>Auswählen</button></div>");
echo ('</form>');

if (isset($_GET['kat'])) {

    $_SESSION["kategorie"] = $_GET['kat'];
    ?>
    <form action="ausgabe.php" method="get">
    <div class="panel panel-default" style="margin-left: auto;margin-right: auto; margin-top: 20px">
        <div class="panel-heading" style="text-align: center">Thema -
            <?php
            $query = 'select * from kategorien where KategorieID ='.$_SESSION["kategorie"];
            foreach ($pdo -> query($query) as $row){
                echo $row['Bezeichnung'];}?>
        </div>
        <ul class="panel-body">
            <?php
            $query = 'select * from fragen where FK_Kategorie ='.$_SESSION["kategorie"];
            foreach ($pdo -> query($query) as $row) {?>
                <div class="list-group"><li href="#"  class="list-group-item active">
                        <?php
                        echo $row['Frage'];
                        echo'</li>';
                        $query2 = 'select * from antworten where FK_FragenID ='.$row['FragenID'];
                        foreach ($pdo -> query($query2) as $row2) {
                            ?>
                        <li href="#" class="list-group-item ">
                            <span>
                            <input required type="radio" value="<?php echo $row2['AntwortID']?>" id="id<?php echo $row2['AntwortID']?>" name="frage<?php echo $row2['FK_FragenID']?>">
                            <label for="frage<?php echo $row2['FK_FragenID']?>"><?php echo $row2['Text']?></label>
                            </span>
                        </li>
                        <?php
                }
                echo '</div>';
            }
            ?>
        </div>
    </ul>
        <input class="btn btn-primary" type="submit" value="Auswärten">
    </form>
    <?php
    echo '<form name="fragen" method="GET" action="">';
    echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'" class="btn btn-primary" style="margin-bottom: 0">Erneut Abfragen</button>');
}
echo ("</form>");
?>
</body>
</html>