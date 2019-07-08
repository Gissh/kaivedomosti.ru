<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
    
    $query='INSERT INTO `menu`(`name`, `link`, `admin`) VALUES ("'.$_POST['name'].'","'.$_POST['link'].'",'.$_POST['admin'].')';

    mysql_query($query);

    echo mysql_insert_id();
    
}else if($_POST['method']=='delete'){
        
    $query='DELETE FROM `menu` WHERE `id`='.$_POST['id'];

    mysql_query($query);

    echo mysql_insert_id();
    
}else if($_POST['method']=='edit'){
        
    $query='UPDATE `menu` SET `name`="'.$_POST['name'].'",`link`="'.$_POST['link'].'",`admin`='.$_POST['admin'].' WHERE `id`='.$_POST['id'];

    mysql_query($query);

    echo mysql_insert_id();
    
}



mysql_close($link);


?>
