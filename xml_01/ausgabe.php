<?php
session_start();
/**
 * Created by PhpStorm.
 * User: Stefan
 * Date: 09.05.2018
 * Time: 08:14
 */
/*
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
*/
$category = $_GET['tanksel'];

$dom = new DOMDocument;
$dom->Load('panzer.xml');
if ($dom->validate()) {
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Tankshop</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="script.js"></script>
</head>
<body>
<header>
    <div class="jumbotron jumbotron-fluid" >
        <div class="container">
            <h1 class="display-4" style="text-align: center">Tankshop - Ausgabe</h1>
        </div>
    </div>
</header>
<section>
    <div style="margin: 10px;">
        <?php
        $xml=simplexml_load_file("panzer.xml") or die("Error: Cannot load file!");
        $categorys = array();


        $json = json_encode($xml);
        //echo $json;


        $array = json_decode($json,TRUE);
        foreach ($xml->children() as $child) {
            if ($child['category'] == $category) {
                ?>
                <ul class="list-group">
                    <li class="list-group-item active"><?php echo $child->name?></li>
                    <li class="list-group-item">Operating country: <?php echo $child->operating_country?></li>
                    <li class="list-group-item">Weight: <?php echo $child->weight." ".$child->weight['unit']?></li>
                    <?php
                    if ($child->crew[1] != "") {
                        ?>
                        <li class="list-group-item"><?php echo ucfirst($child->crew[0]['type'])." crew count: ".$child->crew[0]?></li>
                        <li class="list-group-item"><?php echo ucfirst($child->crew[1]['type'])." crew count: ".$child->crew[1]?></li>
                        <?php
                    } else{
                        ?>
                        <li class="list-group-item"><?php echo ucfirst($child->crew['type'])." crew count: ".$child->crew[0]?></li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
            }
        }
        ?>
        <form name="fragen" method="GET" action="">
            <button type="reset" value="reset" class="btn btn-primary btn-lg" onclick="window.location.href='xml_ue.php'" class="btn btn-primary">Zurück</button>
        </form>
    </div>
</section>
</body>
</html>
<?php
} else{
?>
    <div class="alert alert-danger" role="alert">
        XML Dokument ist invalide!
    </div>
<?php
}
?>