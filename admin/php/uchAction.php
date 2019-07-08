<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
    
    $query='INSERT INTO `uch`(`nazv`) VALUES ("'.$_POST['name'].'")';

    mysql_query($query);

    echo mysql_insert_id();
    
}else if($_POST['method']=='delete'){
        
    $query='DELETE FROM `uch` WHERE `id`='.$_POST['id'];

    mysql_query($query);
    
}else if($_POST['method']=='edit'){
    $query=mysql_query('UPDATE `uch` SET `nazv`="'.$_POST['name'].'" WHERE `id`='.$_POST['id']);
    
}

if($query){
    echo mysql_insert_id($query);
}else{
    echo 'err';
}



mysql_close($link);


?>
