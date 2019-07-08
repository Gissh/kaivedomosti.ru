<?php

require_once("../../../php/connect.php");

$query=mysql_query('SELECT `id`, `fam`, `name`, `otch` FROM `prepod` where `uch`='.$_POST['uch']);

$r=array();

while($row=mysql_fetch_assoc($query)){
    $r[]=$row;
}


    

echo json_encode($r);

mysql_close($link);


?>
