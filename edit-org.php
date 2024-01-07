<?php
// Initialize the session
session_start();
require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
   //$text= file_get_contents('index_notlog.html');
   //echo $text;
}
if($_SESSION["isOrg"]==0) {
    header("location: jointheteam-org.php");
    exit;
}

$sql = "SELECT description_short, description_long FROM organizations_info WHERE name = '".$_SESSION["name"]."'";
$result = mysqli_query($link, $sql);
$row = $result->fetch_assoc();

$description_short = $row["description_short"]; 
$description_long = $row["description_long"];
$name = $_SESSION["name"];

if($_SERVER["REQUEST_METHOD"] == "POST") {

$description_short = trim($_POST["short"]);
$description_long = trim($_POST["long"]);
$sql = "UPDATE organizations_info SET description_short = '".$description_short."', description_long = '".$description_long."' WHERE name = '".$name."'";
$link->query($sql);

header("location: organization.php");

}

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




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/agh-icon.webp">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="edit-org.css">
    <title>Join The Team AGH</title>
</head>
<body>
    <header>
    <h1 class="header-title"><a href="jointheteam-org.php">
            <span id="first">join</span>
            <span id="second">the</span>
            <span id="third">team</span>
            <span><img src="./images/agh.jpg" alt="agh" height="30px" width="30px"></span>
            </a>
        </h1>  
        <div class="empty"></div>
        <div class="empty"></div>
        <div class="links">
            <a href="#"><img src="./images/menu.png" alt="menu" height="30px"></a>
            <?php echo "
            <ul>
                <li>
                    <a href='organization.php'>
                        Konto
                    </a>
                    
                </li>
                <li>
                    <a href='our-recrutation.php'>
                        Rekrutacja
                    </a>
                </li>
                <li>
                    <a href='logout.php'>                        
                            Wyloguj
                    </a>
                </li>
            </ul>";
            ?>
        </div>
    </header>
    <main class="container_edit_org">
        <div class="edit_window">
            <section class="title_edit">
            <h1><?php echo htmlspecialchars($_SESSION["name"]);?></h1>
            </section>
            <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group">
                    <label>Wpisz krótki opis</label>
                    <textarea name="short" style="font-size: large" class="form-control textarea short" maxlength="500"><?php echo $description_short;?></textarea>
                </div>
                <div class="form-group">
                    <label>Wpisz długi opis</label>
                    <textarea type="text" name="long" style="font-size: large" class="form-control textarea long" maxlength="500"><?php echo $description_long;?></textarea>
                </div>
                <div class="form-group sub">
                    <input type="submit" class="btn btn-primary" value="Potwierdź zmiany">
                </div>
        </div>
    </main>
</body>
</html>