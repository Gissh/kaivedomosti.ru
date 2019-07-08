<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){

    $query=mysql_query('INSERT INTO `spec`(`uch`, `nazv`, `nomer`, `god`) VALUES ('.$_POST['uch'].',"'.$_POST['name'].'","'.$_POST['numberSpec'].'",'.$_POST['god'].')');
    
    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }

    
    
}else if($_POST['method']=='delete'){
        
    $query=mysql_query('DELETE FROM `spec` WHERE `id`='.$_POST['id']);

    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }
    
}else if($_POST['method']=='edit'){
        
    $query=mysql_query('UPDATE `spec` SET `uch`='.$_POST['uch'].',`nazv`="'.$_POST['name'].'",`nomer`="'.$_POST['numberSpec'].'",`god`='.$_POST['god'].' WHERE `id`='.$_POST['id']);

    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }
    
}



mysql_close($link);


?>
