<?php
//session_start();
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
/*
$category = $_GET['tanksel'];

$dom = new DOMDocument;
$dom->Load('panzer.xml');
if ($dom->validate()) {
*/
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Auslese</title>
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
            <h1 class="display-4" style="text-align: center">Ausgabe</h1>
        </div>
    </div>
</header>
<section>
    <div style="margin: 10px;">
        <?php
        if($_GET['tanksel'] == "json"){
            $str = file_get_contents('3 fluege.json');
            $json = json_decode($str, true);
            echo "<table><thead><tr><th>Key</th><th>Value</th></tr></thead><tbody>";
            foreach ($json as $key => $value) {
                echo "<tr><td>Flugzeug</td><td>" . $value['Flugzeug'] . "</td></tr>
                                  <tr><td>Sitzplätze</td><td>" . $value['Sitzplaetze'] . "</td></tr>
                                  <tr><td>Flugnummer</td><td>" . $value['Flugnummer'] . "</td></tr>
                                  <tr><td>Start-Flughafen</td><td>" . $value['Startflughafen'] . "</td></tr>
                                  <tr><td>Ziel-FLughafen</td><td>" . $value['Zielflughafen'] . "</td></tr>
                                  <td>Pilot</td><td>" . $value['Pilotenname'] . "</td>";

            }
            echo "</tbody></table>";
        }else{
            $dom = new DOMDocument;
            $dom->Load('3 fluege.xml');
            if($dom->validate()){
                $xml = simplexml_load_file("3 fluege.xml");

                echo "<table>
                    <thead>
                        <tr>
                            <th>Flugzeug</th>
                            <th>Sitzplätze</th>
                            <th>Flugnummer</th>
                            <th>Start-Flughafen</th>
                            <th>Ziel-Flughafen</th>
                            <th>Pilot</th>
                        </tr>
                    </thead>
                    <tbody>";

                foreach ($xml->children() as $test) {
                    echo "<tr>
                                <td>$test->Flugzeug</td>
                                <td>$test->Sitzplaetze</td>
                                <td>$test->Flugnummer</td>
                                <td>$test->Startflughafen</td>
                                <td>$test->Zielflughafen</td>
                                <td>$test->Pilotenname</td>
                              </tr>";
                }

                echo "</tbody></table>";
            }
        }
        ?>
        <form name="fragen" method="GET" action="">
            <button type="reset" value="reset" class="btn btn-primary btn-lg" onclick="window.location.href='index.php'" class="btn btn-primary">Zurück</button>
        </form>
    </div>
</section>
</body>
</html>
<?php
    /*
} else{
    */
?>
<!--
    <div class="alert alert-danger" role="alert">
        XML Dokument ist invalide!
    </div>
    -->
<?php
    /*
}
    */
?>