<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
        
    $query='INSERT INTO `objasn`(`student_id`, `link`) VALUES ('.$_POST['student_id'].','.rand(10000,99999).')';

    mysql_query($query);

    echo mysql_insert_id();
    
}else if($_POST['method']=='delete'){
        
    $query='DELETE FROM `predmet` WHERE `id`='.$_POST['id'];

    mysql_query($query);

    echo mysql_insert_id();
    
}



mysql_close($link);


?>
