<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Stefan Kaiser
 * Date: 10.04.2018
 * Time: 19:31
 */
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
    <h1 style="text-align: center">Auswärtung</h1>
</div>
<?php

foreach ($_GET as $key => $value) {

    $query = 'select * from antworten where AntwortID ='.$value;
    foreach ($pdo -> query($query) as $row){
        if ($row["richtig"] == true) {
            $query2 = 'select * from fragen where FragenID ='.$row["FK_FragenID"];
            foreach ($pdo -> query($query2) as $row2){
                ?>
                <p>Die Antwort auf die Frage: <?php echo($row2["Frage"])?> war RICHTIG</p>
                <?php
            }
        } else {
            $query2 = 'select * from fragen where FragenID ='.$row["FK_FragenID"];
            foreach ($pdo -> query($query2) as $row2){
                ?>
                <p>Die Antwort auf die Frage: <?php echo($row2["Frage"])?> war FALSCH</br>
                    Die Richtige Antwort wäre: <?php
                $query3 = 'select * from antworten where FK_FragenID = '.$row["FK_FragenID"].' AND richtig = 1';
                foreach ($pdo -> query($query3) as $row3){
                    echo ($row3["Text"]);
                }
                    ?>
                </p>
                <?php
            }
        }
    }
};
    echo '<form name="fragen" method="GET" action="">';
    echo('<button type="reset" value="reset" onclick="window.location.href=\'index1.php\'" class="btn btn-primary" style="margin-bottom: 0">Erneut Abfragen</button>');
echo ("</form>");
?>
</body>