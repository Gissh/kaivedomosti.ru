<?php

require_once("../../php/connect.php");

if($_POST['method']=='add'){
    
    $query=mysql_query('INSERT INTO `nagr`(`prepod`, `predmet`, `uch`, `chas`, `tip_ekz`, `date`, `sem`, `grupp`, `god`) VALUES ('.$_POST['prepod'].','.$_POST['predmet'].','.$_POST['uch'].','.$_POST['chas'].','.$_POST['tip_ekz'].',"'.$_POST['date'].'",'.$_POST['sem'].','.$_POST['grupp'].','.$_POST['god'].')');

    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }
    
}else if($_POST['method']=='delete'){
        
    $query=mysql_query('DELETE FROM `nagr` WHERE `id`='.$_POST['id']);

    if($query){
        echo mysql_insert_id();
    }else{
        echo 'err';
    }
    
}



mysql_close($link);


?>
