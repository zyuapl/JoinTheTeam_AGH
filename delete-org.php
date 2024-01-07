<?php

session_start();
require_once "config.php";

$name = $_SESSION["name"];
$sqlDelOrg = "DELETE FROM organizations_info WHERE name = '$name'";
$sqlDelZgl = "DELETE FROM zgloszenia WHERE organizacja = '$name'";
$link->query($sqlDelOrg);
$link->query($sqlDelZgl);

$sqlTwo = "SELECT * FROM organizations_info";
                    $resultTwo =mysqli_query($link, $sqlTwo) ; 
                    $datas = array();

                    if (mysqli_num_rows($resultTwo) > 0) {
                    while ($row = mysqli_fetch_assoc($resultTwo)) {
                    $datas[] = $row;
                    }
                    }
                    $json = json_encode($datas);
                    file_put_contents("DB_json/organizations_info.json", $json);
                    mysqli_close($link);

header("location: organization.php");
exit;

?>