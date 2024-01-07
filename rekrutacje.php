<?php
 session_start();
 require_once "config.php";
 // Check if the user is logged in, if not then redirect him to login page
 if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
     header("location: login.php");
    //$text= file_get_contents('index_notlog.html');
    //echo $text;
 }

$name = $_SESSION["username"];

$sql = "SELECT id, organizacja, isOpen FROM zgloszenia WHERE username LIKE '$name'";

$result =mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="./images/agh-icon.webp">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_table_st.css">
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
    <main class="container_table">
        <div class="table">
            <section class="table__header">
                <h1>Moje rekrutacje</h1>
            </section>
            <section class="table__body">
                <table>  
                    <thead>
                        <tr>
                            <th>Organizacja</th>
                            <th>Status</th>
                        </tr>
                    </thead>     
                    <tbody> 
                        <?php 
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>".$row["organizacja"]."</td>"; 
                                if ($row["isOpen"] == 0) {  
                                    echo "<td class='st'><p class='status notopen'>Do rozpatrzenia</p></td>";
                                }
                                else if ($row["isOpen"] == 1) {
                                    echo "<td class='st'><p class='status accepted'>Zaakceptowano</p></td>";
                                }  
                                else if ($row["isOpen"] == 2) {
                                    echo "<td class='st'><p class='status aborted'>Odrzucono</p></td>";
                                }
                                echo "</tr>";
                            }
                    
                        ?>
                    </tbody>
                </table>
            </section>
        </div>
    </main>
</body>
</html>