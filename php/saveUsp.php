<?php

require_once('../php/connect.php');

    $studval=$_POST['studVal'];

    for($x=0;$x<count($studval);$x++){
        $query = mysql_query("select `id` from `uspev` where `student`=".$studval[$x]['id']." and `nagr`=".$_POST['nagr']);
        if(mysql_num_rows($query)==0){
            $query=mysql_query("INSERT INTO `uspev`(`nagr`, `student`, `ball`, `comment`) VALUES (".$_POST['nagr'].",".$studval[$x]['id'].",".$studval[$x]['val'].",null)");
        }else{
            $query=mysql_query('UPDATE `uspev` SET `ball`='.$studval[$x]['val'].' WHERE `student`='.$studval[$x]['id']);
        }
    }

    if($query){
        echo 1;
    }else{
        echo 'err';
    }

?>
