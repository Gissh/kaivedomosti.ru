<?php

require_once('../php/connect.php');


    $query = mysql_query("SELECT `id`,`uch`,`kurator`,`fam`,`name`,`otch` FROM `prepod` WHERE `id`=".$_POST['id']." AND `passw`='".$_POST['pass']."'");

    if(mysql_num_rows($query)!=0){
        
        session_start();
        
        $row=mysql_fetch_assoc($query);
        
        $_SESSION['id']= $row['id'];

        $_SESSION['uch']= $row['uch'];
        
        $_SESSION['fio']=$row['fam'].' '.$row['name'].' '.$row['otch'];
        
        $_SESSION['admin']=$row['kurator'];

        echo 1;
    }

    else

    {
        
        echo 0;

    }





?>
