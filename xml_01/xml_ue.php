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
            <h1 class="display-4" style="text-align: center">Tankshop</h1>
        </div>
    </div>
</header>
<section>
    <div style="margin: 10px;">
        <form name="fragen" method="GET" id="baseform">
            <div class="form-group">
                <select id="tankselect" class="form-control" name="tanksel">
                    <?php
                    $xml=simplexml_load_file("panzer.xml") or die("Error: Cannot load file!");
                    $categorys = array();
                    foreach ($xml->tank as $child)
                    {
                        array_push($categorys, $child->attributes());
                        //echo $child->weight['unit'];
                    }
                    $categorys = array_unique($categorys);
                    //echo count($categorys);
                    foreach($categorys as $result) {
                        echo ('<option value="'.$result.'">'.$result.'</option>');
                    }
                    ?>
                </select>
                <label for="tankselect">Please select your tank category</label>
            </div>
        <button class="btn btn-primary btn-lg" onclick="submitForm('ausgabe.php')" type='submit'>Auswählen</button>
        </form>
    </div>
    <?php
    /*
    foreach($xml->children() as $tanks) {
        echo $tanks->name . ", ";
    }
    */
    ?>
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