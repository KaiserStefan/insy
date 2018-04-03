<html>
<body>
<?php


if (isset($_GET["von"])) {
    $von = $_GET["von"];
    echo $von;
}

?>

<form action="insy_name.php" method="get">
    <input type="text" name="von" value="

    <?php if (isset($_GET["von"])) {
        echo $von;
    } ?>
">
    <input type="submit"> </input>
    <input type="text" name="zu" value="
    <?php if (isset($_GET["von"])) {
        echo $von;
    } ?>
">

</form>


</body>