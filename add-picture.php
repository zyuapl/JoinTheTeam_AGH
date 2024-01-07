<?php

session_start();
require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   header("location: login.php");
   exit;
}

$name = $_SESSION["name"];

$sql = "SELECT id, name, description_short, description_long, site, picture, isActiveRecrutation FROM organizations_info WHERE name LIKE '$name'";
$result = mysqli_query($link, $sql);
$row = $result->fetch_assoc();
$plik_nazwa_tmp = $_FILES["plik1"]["tmp_name"];
$plik_nazwa_oryginalna = $_FILES["plik1"]["name"];
$plik_wielkosc = $_FILES["plik1"]["size"];

if (is_uploaded_file($plik_nazwa_tmp)) {
  move_uploaded_file($plik_nazwa_tmp, "images/$row[picture]");
  chmod("images/$row[picture]", 0664);
}
    header("location: organization.php");
   exit;
?>