<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
    
    $query='INSERT INTO `sved_stud`(`student`, `tip_sv`, `val`, `razdel`) VALUES ('.$_POST['student'].','.$_POST['tip_sv'].',"'.$_POST['val'].'",'.$_POST['razdel'].')';

    mysql_query($query);

    echo mysql_insert_id();
    
}else if($_POST['method']=='delete'){
        
    $query='DELETE FROM `sved_stud` WHERE `id`='.$_POST['id'];

    mysql_query($query);

    echo mysql_insert_id();
    
}



mysql_close($link);


?>
