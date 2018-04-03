<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Questionaire PHP and MySQL with PDO</title>
</head>

<?php

/***
 * This document contains a demonstration for accessing a MySQL Demo Database via ADODB and OOP
 * This example is technically a better approach than the phpmysqli one - we will use a questionaire class for our operations to get
 * reusable code and also use ADODB as a data access wrapper to connect to MySQL - this allows to exchange the underlying
 * database (e.g. to Oracle) without having to alter the PHP code.
 *
 * Database:    MySQL on localhost (XAMPP)
 * Codebase:    PHP OOP
 */


class Questionaire{
    private $DB;
    private $method = "get";

    /***
     * Constructor for a new questionaire, the database details have to be passed as parameters
     * @param $server   Servername
     * @param $username Username
     * @param $password Password
     * @param $database Database
     */
    function __construct($server, $username, $password, $options){
		try	{
        // Create a new Database Object for mysql
        // Connect with: Server, User, Password, Database
		$this->DB = new PDO($server, $username, $password, $options);
		// because we have default errormode_silent we change to ERRMODE_EXCEPTION
	
		$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
		}catch(PDOException  $e ){
		echo "Fehler: ".$e;
		exit();
		}
    }

    /***
     * Creates a Category Selection form with an optional submit button
     * @param $name     value for the name attribute of the form
     * @param $action   sets where the form should be submit to
     * @param null $submitbuttontext    Text for the submit button if null no submit button is generated
     * @return string
     */
    function createCategoriesSelectionForm($name, $action, $submitbuttontext = null){
        // create a temporary variable to store the return code in
        $rv = "<form name='$name' action='$action' method='$this->method'>";

        // Insert the categories select box
        $rv .= $this->createCategoriesSelectBox();

        // if a submit button text has been passed we create a submit button with the according text
        if($submitbuttontext!=null)
            $rv .= "<input type='submit' value='$submitbuttontext' />";
        // close the form
        $rv .= '</form>';

        return $rv;
    }

    /***
     *
     * @param bool $attachDeleteButton  if true adds a delete submit button to the select box
     */
    function createCategoriesSelectBox(){
        // create a temporary variable to store the return code in
        $rv = '<select name="sel_categories">';

        // Get all categories from the database - mind that in comparison to mysqli where we iterate through each row ADODB returns an array with all data
		$query = 'SELECT KategorieID, Bezeichnung FROM fragebogen.kategorien';
		try {
        foreach ($this->DB -> query($query) as $row){
            // add the category html to the return value
            $rv .= $this->createCategoriesSelectBoxEntry($row['KategorieID'], $row['Bezeichnung']);
        }
		$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION) ;
		}catch(PDOException  $e ){
		echo "Fehler: ".$e;
		exit();
		}
        // Close the Select Box
        $rv .= '</select>';

        return $rv;
    }

    /***
     * Creates a single select box entry for a given category
     *
     * @param $ID       ID of the category
     * @param $desc     Description of the category
     * @return string   HTML representation of an option entry for the given category for use inside a select box
     */
    function createCategoriesSelectBoxEntry($ID, $desc){
        return '<option value="'.$ID.'">'.$desc.'</option>';
    }

    /***
     * Deletes a category from the database
     *
     * @param $ID   ID of the category that should be deleted
     */
    function deleteCategory($ID){
		try {
			
        $this->DB->query("DELETE FROM fragebogen.kategorien WHERE KategorieID=".intval($ID));
    	
		}catch(PDOException  $e ){
		echo "Fehler: ".$e;
		exit();
		}
	}

    function createCategoryInsertionForm($name, $action, $buttondescription = 'Insert Category'){
        return "<form name='$name' action='$action' method='$this->method'>
                    <input type='text' name='insert_category' />
                    <input type='submit' value='$buttondescription' />
               </form>";
    }

    function insertCategory($description){
        $description = htmlspecialchars($description);
		$INS="INSERT INTO fragebogen.kategorien (Bezeichnung) VALUES ('".$description."')";
		//echo $INS;
		try {
			
        $this->DB->query($INS);
		
		}catch(PDOException  $e ){
		echo "Fehler: ".$e;
		exit();
		}
    }
}
?>
<body>

<?php
    // create a questionaire class
	$opt  = array
            (
              PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            );
    $qn = new Questionaire('mysql:dbname=fragebogen;host=localhost', 'root', '',$opt);

    // insert a category if requested
    if(isset($_GET['insert_category']))
        $qn->insertCategory($_GET['insert_category']);

    // delete a category if requested
    if(isset($_GET['sel_categories']))
        $qn->deleteCategory($_GET['sel_categories']);

?>
Categories <br/>
<?php
    // output the selection form
    echo $qn->createCategoriesSelectionForm('frm_categories',$_SERVER['PHP_SELF'],'Delete');
?>
<br/>
Insert category<br/>
<?php    // output the category insertion form
    echo $qn->createCategoryInsertionForm('frm_insertcategory', $_SERVER['PHP_SELF']);
?>



</body>


</html>