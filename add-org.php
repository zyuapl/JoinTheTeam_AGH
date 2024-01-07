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

$name = $name_err = $description_short = $description_long = $site = $file = "";
$isActiveRecrutation = 0;

if($_SERVER["REQUEST_METHOD"] == "POST") {

$name = htmlspecialchars($_SESSION["name"]);
$username = htmlspecialchars($_SESSION["username"]);
$site = str_replace(' ', '', $name);
$site = strtolower($site).".html";
$picture = strtolower($username).".jpg";
$description_short = trim($_POST["short"]);
$description_long = trim($_POST["long"]);

        $sql = "SELECT id FROM organizations_info WHERE name = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_name);
            
            // Set parameters
            $param_name = $name;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $name_err = "Dodałeś już zgłoszenie";
                } else{
                    $name = htmlspecialchars($_SESSION["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        if(empty($name_err)){
$sql = "INSERT INTO organizations_info (name, description_short, description_long, site, picture, isActiveRecrutation) VALUES (?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "sssssi", $param_name, $param_desc_short, $param_desc_long, $param_site, $param_picture, $param_isActiveRecrutation);
    $param_name = $name;
    $param_desc_short = $description_short;
    $param_desc_long = $description_long;
    $param_site = $site;
    $param_picture = $picture;
    $param_isActiveRecrutation = $isActiveRecrutation;
    mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
}
        }
        header("location: organization.php");
}
$sqlTwo = "SELECT * FROM organizations_info";
                    $resultTwo =mysqli_query($link, $sqlTwo);
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
            <span>join</span>
            <span id="second">the</span>
            <span id="third">team</span>
            </a>
            <span><img src="./images/agh.jpg" alt="agh" height="30px" width="30px"></span>
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
                    <input type="submit" class="btn btn-primary" value="Dodaj organizację">
                </div>
        </div>
    </main>
</body>
</html>