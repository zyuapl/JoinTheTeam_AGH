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
if($_SESSION["isOrg"]!=0) {
    header("location: jointheteam-org.php");
    exit;
}
$name = $surname = $odp = $error = $info = $org = "";
$isOpen = 0;

$sqlName = "SELECT name, lastname FROM students WHERE username = '".$_SESSION["username"]."'";
$result = mysqli_query($link, $sqlName);
if ($row = $result ->fetch_assoc()) {
    $name = $row["name"];
    $surname = $row["lastname"];
}

if($_SERVER["REQUEST_METHOD"] == "POST") {

$username = htmlspecialchars($_SESSION["username"]);
$org = trim($_POST["organ"]);
$odp = trim($_POST["odp"]);


        $sql = "SELECT id FROM zgloszenia WHERE username = ? AND organizacja = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_org);
            
            // Set parameters
            $param_username = $username;
            $param_org = $org;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) > 0){
                    $error = "error";
                    $info = "Nie możesz dwa razy dodać zgłoszenia do tej samej organizacji";
                } else {
                    $username = htmlspecialchars($_SESSION["username"]);
                    $info = "Zgłoszenie zostało przesłane";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }

        if(empty($error)){
$sql = "INSERT INTO zgloszenia (username, imie, nazwisko, odpowiedz, organizacja, isOpen) VALUES (?, ?, ?, ?, ?, ?)";
if($stmt = mysqli_prepare($link, $sql)) {
    mysqli_stmt_bind_param($stmt, "sssssi", $param_username, $param_name, $param_surname, $param_odp, $param_org, $param_isOpen);
    $param_username = $username;
    $param_name = $name;
    $param_surname = $surname;
    $param_odp = $odp;
    $param_org = $org;
    $param_isOpen = $isOpen;

    mysqli_stmt_execute($stmt);

    mysqli_stmt_close($stmt);
}
mysqli_close($link);
        }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/agh-icon.webp">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="recrutation.css">
    <title>Join The Team AGH</title>
</head>
<body>
<header>
        <h1 class="header-title"><a href="jointheteam.php">
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
            <ul>
                <li>
                    <a href="user.php">
                        Moje konto
                    </a>
                </li>
                <li>
                    <a href="rekrutacje.php">
                        Moje rekrutacje
                    </a>
                </li>
                <li>
                    <a href="logout.php">                        
                            Wyloguj
                    </a>
                </li>
            </ul>
        </div>
    </header>
    <main class="container_recrutation">
        <div class="recrutation_window">
            <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">  
                    <label>Wybierz organizację</label> 
                    <select class="org" name="organ"></select>
                </div>    
            <div class="form-group">
                    <label>Napisz coś o sobie i dlaczego chcesz do nas dołączyć</label>
                    <textarea type="text" name="odp" style="font-size: large" class="form-control textarea" maxlength="500">Napisz coś o sobie...</textarea>
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-primary" value="Wyślij zgłoszenie">
                </div>
                <span class="invalid-feedback"><?php echo $info; ?></span>
            </form>
        </div>    
            
    </main>
<script src="recrutation.js?v=1"></script>
</body>
</html>