<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title> PHP and MySQL with pdo  for DB Sport</title>
</head>

<?php
//phpinfo();
/***
 * This document contains a demonstration for accessing a
 * MySQL Demo Database via PDO and OOP
 * we connect to MySQL but its easy to exchange the underlying
 * database (e.g. to Oracle) without having to alter the PHP code.
 *
 * Database:    MySQL on localhost (XAMPP)
 * Codebase:    PHP OOP
 */

// We use PDO to do a database connection and require the functionality



try {

    $server   = 'mysql:dbname=sportgeschaeft;host=localhost';
	$user     = 'root';
	$password = '';
	$options  = array
            (
              PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );
	$pdo      = new PDO($server, $user, $password, $options);
	
	// because we have default errormode_silent we change to ERRMODE_EXCEPTION
	
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ; 
    } 
catch (PDOException $error) {
    die( 'Verbindung fehlgeschlagen: ' . $error->getMessage());
	//print_r($error);
}


try {
	// now we want to select data
	$query = 'SELECT * FROM artikel ';
	//$query= 'SELECT pk_ArtikelNr,artikel.Name,VK_Preis,hersteller.name
    //             FROM artikel join hersteller on fk_HerstellerNr = pk_HerstellerNr';
	foreach ($pdo -> query($query) as $row) {
		echo ' <br/>';
		echo count($row);
		echo ' <br/>';
		echo ' <br/> Artikelname: '.$row["Name"]. ' <br/>';
		print_r($row);
	}
	

	// or with class PDOStatement
	echo ' <br/>';
	$stmt   = $pdo -> query($query);
	$result = $stmt -> fetchAll();
	print_r ($result);
	echo "Einzelner Zugriff".$result[0]["Name"];
	
	echo ' <br/>  mit fetch <br/>';
	$stmt   = $pdo -> query($query);
	while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
	  {
	   echo ' <br/>'. $row["pk_ArtikelNr"]. $row["Name"]. '<br/>';
	   }
	// gehts ein 2. mal auch ??
	echo ' <br/>  mit fetch 2. Schleife <br/>';
	while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
	  {
	   echo ' <br/>'. $row["pk_ArtikelNr"]. $row["Name"]. '<br/>';
	   }
	
	//echo '<br/>show methods: <br/>';
	//var_dump(get_class_methods(get_class($stmt)));
	//echo '<br/> show variables: <br/>';
	//var_dump(get_class_vars(get_class($stmt)));
	
} 
catch (PDOException $error) {
    echo 'Fehler beim Lesen in der DB: ' . $error->getMessage();
}
try {
} 
catch (PDOException $error) {
    echo '....: ' . $error->getMessage();
}

?>








<br/> Tabellenausgabe für alle Artikel <br/>
<?php
    
?>



</body>
<table border="1">
<tr>
   <th> Artikelnummer</th>
   <th> Name   </th>
   <th> Verkaufspreis   </th>
   <th> Hersteller Nr  </th>
</tr>
 <?php
 try {
   $stmt   = $pdo -> query($query);
	while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
	  {
	   echo '<tr>';
	     echo ' <td>'. $row["pk_ArtikelNr"].'</td>';
         echo ' <td>'.   $row["Name"]. '</td>';
		 echo ' <td>'.   $row["VK_Preis"]. '</td>';
		 echo ' <td>'.   $row["fk_HerstellerNr"]. '</td>';
	   echo '</tr>';
	   }
	echo '</table>';
  
} 
catch (PDOException $error) {
    echo 'Fehler beim Lesen der Daten ' . $error->getMessage();
}   
?> 
<table border="1">
<tr>
   <th> Artikelnummer</th>
   <th> Name   </th>
   <th> Verkaufspreis   </th>
   <th> Hersteller  </th>
</tr>
 <?php
 try {
   $query= 'SELECT pk_ArtikelNr,artikel.Name,VK_Preis,hersteller.Name as HerName
                 FROM artikel join hersteller on fk_HerstellerNr = pk_HerstellerNr
				   order by pk_ArtikelNr';
   $stmt   = $pdo -> query($query);
	while( $row = $stmt->fetch(PDO::FETCH_ASSOC) )
	  {
	   echo '<tr>';
	     echo ' <td>'. $row["pk_ArtikelNr"].'</td>';
         echo ' <td>'.   $row["Name"]. '</td>';
		 echo ' <td>'.   $row["VK_Preis"]. '</td>';
		 echo ' <td>'.   $row["HerName"]. '</td>';
	   echo '</tr>';
	   }
	echo '</table>';
  
} 
catch (PDOException $error) {
    echo 'Fehler beim Lesen der Daten ' . $error->getMessage();
}   
?> 
</html>