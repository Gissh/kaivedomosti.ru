<?php

require_once('../php/connect.php');

$query = mysql_query("UPDATE `objasn` SET `link`=NULL,`text`='".$_POST['text']."',`obj_date`=NOW() WHERE `link`=".$_POST['link']);

echo 1;

?>
