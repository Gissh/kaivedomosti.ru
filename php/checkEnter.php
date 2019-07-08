<?php

session_start();

if(!isset($_SESSION['id'])){
    header("Location: http://kaivedomosti.ru/site/login.php");
}else{
 
}

?>
