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
$sql = "SELECT id, imie, nazwisko, odpowiedz, isOpen FROM zgloszenia WHERE organizacja LIKE '$name'";


$result =mysqli_query($link, $sql); 

$sqlTwo = "SELECT id, isActiveRecrutation FROM organizations_info WHERE name LIKE '$name'";
$resultTwo = mysqli_query($link, $sqlTwo);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/agh-icon.webp">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style_table_org.css">
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
    <main class="container_table">
        <?php
        if (mysqli_num_rows($resultTwo)>0) {
        $rowTwo=$resultTwo -> fetch_assoc(); 
        $isActive = $rowTwo["isActiveRecrutation"];
        if($isActive == 0){
            echo "
            <section class=disactive>
            <h1>W tym momencie organizacja nie prowadzi rekrutacji</h1>
            <a href='start_rec.php?id=$rowTwo[id]'><p class='start'>Rozpocznij rekrutację</p></a>
            </section>";
        } else {
            echo "
                <div class='table'>
                <section class='table__header'>
                <h1>Rekrutacja trwa!</h1>
            </section>
            <section class='table__body'>
                <table>
                <thead>
                    <tr>
                        <th>Nazwisko</th>
                        <th>Odpowiedź</th>
                        <th>Status</th>
                        <th>Wybierz</th>
                    </tr>
                </thead>
                <tbody>";        
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>"; 
                        echo "<td class='name'><p>".$row["imie"]." ".$row["nazwisko"]."</p></td>";
                        echo "<td class='answer'><p>".$row["odpowiedz"]."</td>";
                        if ($row["isOpen"] == 0) { 
                            echo "<td><p class='status notopen'>Do rozpatrzenia</p></td>";
                        }
                        else if ($row["isOpen"] == 1) {
                            echo "<td><p class='status accepted'>Zaakceptowano</p></td>";
                        }  
                        else if ($row["isOpen"] == 2) {
                            echo "<td><p class='status aborted'>Odrzucono</p></td>";
                        }
                        echo "<td>
                                <section class='todo'>
                                <a class='btn' href='accept.php?id=$row[id]'><p>Akceptuj</p></a>
                                <a class='btn' href='delete.php?id=$row[id]'><p>Odrzuć</p></a>
                                </section>
                            </td>";
                        echo "</tr>";
                    }  
        echo "
        </tbody>
        </table>
        </section>
        <section class='endofrec'>
        <a href='end_rec.php?id=$rowTwo[id]'><p class='rec end'>Zakończ rekrutację</p></a>
        </section>
        </div>"; 
    }   
    }   else {
            echo "
            <section class=disactive>
            <h1>Aby prowadzić rekrutację musisz dodać stronę organizacji</h1>
            <a href='add-org.php'><p class='start'>Dodaj organizację</p></a>
            </section>
            ";
    }
    ?>
    
    </main>
</body>
</html>