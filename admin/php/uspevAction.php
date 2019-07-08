<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
    
    $query='INSERT INTO `uspev`(`nagr`, `student`, `ball`, `comment`) VALUES ('.$_POST['nagr'].','.$_POST['student'].','.$_POST['ball'].',"'.$_POST['comment'].'")';

    mysql_query($query);

    echo mysql_insert_id();
    
}else if($_POST['method']=='delete'){
        
    $query='DELETE FROM `uspev` WHERE `id`='.$_POST['id'];

    mysql_query($query);

    echo mysql_insert_id();
    
}



mysql_close($link);


?>
