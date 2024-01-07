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
if($_SESSION["isOrg"]!=1) {
    header("location: jointheteam.php");
    exit;
}
$name = $_SESSION["name"];
$nameNoSpace = str_replace(' ','',$name);

$sql = "SELECT id, imie, nazwisko, odpowiedz, isOpen, organizacja FROM zgloszenia WHERE organizacja LIKE '$name'";

$result =mysqli_query($link, $sql) ; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/agh-icon.webp">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-org.css">
    <link rel="stylesheet" href="style-site.css">
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
                    <a href='organization.php?$nameNoSpace'>
                        Konto
                    </a>
                    
                </li>
                <li>
                    <a href='our-recrutation.php?$nameNoSpace'>
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
    <main class="container">
    <div class="article">
        <aside class="panel">
                <div>
                <section class="kola-items">
                    <button class="category-all">Wszystkie</button>
                    <button class="category-active">Aktywna rekrutacja</button>
                    </section>
                </div>
        </aside>
            <section class="kolo">
            </section> 
        </div>
    </main>
    <script src="main.js?v=1"></script>
</body>
</html>

