<?php 

session_start();
require_once "config.php";

if(isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "UPDATE organizations_info SET isActiveRecrutation = 1 WHERE id = $id";
    $link->query($sql);
}

$sql = "SELECT * FROM organizations_info";
$result =mysqli_query($link, $sql) ; 
$datas = array();

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $datas[] = $row;
    }
}
$json = json_encode($datas);

file_put_contents("DB_json/organizations_info.json", $json);

header("location: our-recrutation.php");
exit;
?>