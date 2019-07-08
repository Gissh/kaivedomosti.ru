<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
    
    $query=mysql_query('INSERT INTO `prepod`(`fam`, `name`, `otch`, `login`, `passw`, `tel`, `mail`, `uch`, `kurator`) VALUES ("'.$_POST['fam'].'","'.$_POST['name'].'","'.$_POST['otch'].'","'.$_POST['login'].'","'.$_POST['passw'].'","'.$_POST['tel'].'","'.$_POST['mail'].'",'.$_POST['uch'].','.$_POST['kurator'].')');

    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }
    
}else if($_POST['method']=='delete'){
        
    $query=mysql_query('DELETE FROM `prepod` WHERE `id`='.$_POST['id']);

    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }
    
}else if($_POST['method']=='edit'){
        
    $query=mysql_query('UPDATE `prepod` SET `fam`="'.$_POST['fam'].'",`name`="'.$_POST['name'].'",`otch`="'.$_POST['otch'].'",`login`="'.$_POST['login'].'",`passw`="'.$_POST['passw'].'",`tel`="'.$_POST['tel'].'",`mail`="'.$_POST['mail'].'",`uch`='.$_POST['uch'].',`kurator`='.$_POST['kurator'].' WHERE `id`='.$_POST['id']);

    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }
    
}



mysql_close($link);


?>
