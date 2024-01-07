<?php
// Initialize the session
session_start();
require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
   // header("location: login.php");
   $text= file_get_contents('index_notlog.html');
} else {
    $text = file_get_contents('index_log.html');
    
}
echo $text;
exit;
?>