<?php 

session_start();
require_once "config.php";

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "UPDATE zgloszenia SET isOpen = 2 WHERE id = $id";
    $link->query($sql);
}

header("location: our-recrutation.php");
exit;
?>