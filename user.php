<?php
 session_start();
 require_once "config.php";
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
if($_SESSION["isOrg"]==1) {
    header("location: jointheteam-org.php");
    exit;
}
 
$error = $info = "";
$username = $_SESSION["username"];

$sqlR = "SELECT name, lastname FROM students WHERE username = '".$username."'";
$result = mysqli_query($link, $sqlR);
if ($row = $result->fetch_assoc()){
$name = $row["name"];
$lastname = $row["lastname"];
}


if($_SERVER["REQUEST_METHOD"] == "POST"){

    if(empty(trim($_POST["name"])) || empty(trim($_POST["lastname"]))){
        $error = "Wprowadzono nieprawidłowe dane";
    } else {
        $sql = "SELECT id, name, lastname FROM students WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;

            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
            }
            else {
                echo "Ups, coś poszło nie tak...";
            }
            mysqli_stmt_close($stmt);
        }
    }
    $name = trim($_POST["name"]);
    $lastname = trim($_POST["lastname"]);

    if (empty($error)) {
        $sql = "UPDATE students SET name = '".$name."', lastname = '".$lastname."' WHERE username = '".$username."'";
        $link->query($sql);
        $info = "Dane zostały pomyślnie zmienione";
        header("location: user.php");
    }
    else {
        $info = "Wystąpił błąd";
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
    <link rel="stylesheet" href="user_style.css">
    <title>Join The Team AGH</title>
</head>
<body>
<header>
        <h1 class="header-title"><a href="jointheteam.php">
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
    <main class="container_user">
        <div class="user_table">
        <form class="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="table_title">
                <h1>Twoje dane</h1>
            </div>
            <div class="form-group">
                <label>Imię</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" value="<?php 
                
                    echo $name;
                
                ?>">
            </div>    
            <div class="form-group">
                <label>Nazwisko</label>
                <input type="text" name="lastname" class="form-control <?php echo (!empty($error)) ? 'is-invalid' : ''; ?>" value="<?php 
                
                    echo $lastname;
                
                ?>">
            </div>
            <div class="form-group">
                <label>Numer indeksu</label>
                <span>244352</span>
            </div>
            <div class="form-group sub">
                <input type="submit" class="btn btn-primary" value="Edytuj dane">
            </div>
            <div class="form-group reset">
            <span id="user"><a class="reset_pass" href="reset-password.php">Resetuj hasło</a></span>
            </div>
        </form>
        <span class="invalid-feedback"><?php echo $info; ?></span>
            
        </div>
    </main>
</body>