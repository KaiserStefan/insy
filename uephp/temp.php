<?php
/**
 * Created by PhpStorm.
 * User: andlk
 * Date: 21.02.2018
 * Time: 08:49
 */

session_start();

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
    <title>Quizz</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link src="style.css">
    <link src="script.js">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <!--<script>window.addEventListener('beforeunload', function () {
            alert(10);
        }, false);</script>-->
</head>
<body>
<div class="jumbotron" >
    <h1 style="text-align: center">Welcome to our Quizz</h1>
</div>
<!--<div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
        Thema
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu">
        <li><a href="#">HTML</a></li>
        <li><a href="#">CSS</a></li>
        <li><a href="#">JavaScript</a></li>
    </ul>
</div>-->
<?php
try {
    $query = 'SELECT * FROM kategorien';

    echo ("<form name='QuizForm' action=".$_SERVER['PHP_SELF']." method='GET'>");
    echo '<div class="col-lg-8"><select class="form-control" name="kat">\\n';
    echo $query;
    foreach ($pdo -> query($query) as $row){
        echo ('<option value="'.$row['KategorieID'].'">'.$row['Bezeichnung'].'</option>\n');
    }
}
catch (PDOException $error) {
    echo "</select>";
    die( 'Verbindung fehlgeschlagen: ' . $error->getMessage());
}
echo '</select></div>';
echo ("<div class='col-lg-4'><button type='submit' class='btn btn-primary'>Starten</button></div>");
echo ('</form>');

if (isset($_GET['kat'])) {
    ?>

    <div class="panel panel-default" style="margin-left: auto;margin-right: auto; margin-top: 20px">
        <div class="panel-heading" style="text-align: center">Fragenkatalog -
            <?php
            $query = 'select Bezeichnung from kategorien where KategorieID ='.$_GET['kat'];
            foreach ($pdo -> query($query) as $row){
                echo $row['Bezeichnung'];}?>
        </div>
        <div class="panel-body">
            <div class="progress" style="margin-right: 120px; margin-left: 120px">
                <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40"
                     aria-valuemin="0" aria-valuemax="100" style="width:40%">
                    40%
                </div>
            </div>
            <div class="list-group">
                <a href="#" class="list-group-item active">
                    <?php
                    $query = 'select Frage from fragen where FragenID ='.$_GET['kat'];
                    foreach ($pdo -> query($query) as $row) {
                        echo $row['Frage'];
                    }
                    ?>
                </a>
                <a href="#" class="list-group-item"><?php  $query = 'select text from antworten where FK_FragenID ='.$_GET['kat'];
                    foreach ($pdo -> query($query) as $row){echo $row['text'];}?></a>
                <a href="#" class="list-group-item">Morbi leo risus</a>
                <a href="#" class="list-group-item">Porta ac consectetur ac</a>
                <a href="#" class="list-group-item">Vestibulum at eros</a>
            </div>
            <ul class="pagination">
                <li><a href="#">1</a></li>
                <li><a href="#">2</a></li>
                <li><a href="#">3</a></li>
                <li><a href="#">4</a></li>
                <li><a href="#">5</a></li>
            </ul>
        </div>
    </div>
    <?php
    echo("<form name='QuizForm' action=".$_SERVER['PHP_SELF']." method='GET'>");
    echo('<button type="reset" value="reset" onclick="window.location.href=index.php" class="btn btn-primary">Erneut quizzen</button>');
}
echo ("</form>");
?>
</body>
</html>