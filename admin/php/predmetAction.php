<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
    
    $query='INSERT INTO `predmet`(`uch`, `nazv`, `god`) VALUES ('.$_POST['uch'].',"'.$_POST['name'].'",'.$_POST['god'].')';

    mysql_query($query);

    echo mysql_insert_id();
    
}else if($_POST['method']=='delete'){
        
    $query='DELETE FROM `predmet` WHERE `id`='.$_POST['id'];

    mysql_query($query);

    echo mysql_insert_id();
    
}



mysql_close($link);


?>
