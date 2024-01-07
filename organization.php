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



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/agh-icon.webp">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style-organization.css">
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
            <ul>
                <li>
                    <a href="organization.php">
                        Konto
                    </a>
                </li>
                <li>
                    <a href="our-recrutation.php">
                        Rekrutacja
                    </a>
                </li>
                <li>
                    <a href="logout.php">                        
                            Wyloguj
                    </a>
                </li>
            </ul>
        </div>
        </div>
    </header>
    <main class="container_set">
        <?php
        if (mysqli_num_rows($result)>0) {
        echo "
            <div class='org_set'>
            <section class='picture'>
                <img src='./images/$row[picture]' height = '200px' width = '300px'>
                <form action='add-picture.php' method='post' enctype='multipart/form-data'>
            <div class='add_pic'>
            <input type='hidden' name='MAX_FILE_SIZE' value='510000' />
            <input name='plik1' type='file'/>
            <input type='submit' class='btn' value=' wyślij '/>
            </div>
            </form> 
            </section>
            <section class='my_site'>

            <h1>".$name."</h1>

            <div class='desc short'>
            <label>Krótki opis:</label>
            <p>".$row["description_short"]."</p>
            </div>

            <div class='desc long'>
            <label>Szczegóły:</label>
            <p>".$row["description_long"]."</p>
            </div>
            <div class='desc button'>
            <a class='aa' href='edit-org.php?$row[name]'>Edytuj opis</a>
            <a class='aa' href='delete-org.php'>Usuń stronę organizacji</a>
            </div>
            </section>
            </div>";
        } else {
            echo "
            <div class='org-add'>
            <a class='aa' href='add-org.php'>Dodaj organizację</a>
            </div>";
        }
        ?>
        
    </main>
</body>