<?php

require_once("../../../php/connect.php");

$query=mysql_query('SELECT `grupp`.`id`,`grupp`.`nazv`, `spec`.`nazv` as "spec", `grupp`.`god` FROM `grupp`,`spec` WHERE `grupp`.`spec`=`spec`.`id` and  `grupp`.`uch`='.$_POST['uch']);

$r=array();

while($row=mysql_fetch_assoc($query)){
    $r[]=$row;
}


    

echo json_encode($r);

mysql_close($link);


?>
