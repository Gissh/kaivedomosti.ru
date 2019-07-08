<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Выбор ведомости</title>

    <link rel="stylesheet" href='../css/bootstrap.min.css'>

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel='stylesheet' href="../css/main.css">


</head>

<body>
    <?php    
    require_once('../php/connect.php');
    require_once('../php/base.php');
    
    
    ?>



    <div class="container shadow-sm">


        <h2 class='p-3' align='center'>Выбор ведомости</h2>

        <table class="table shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">группа</th>
                    <th scope="col">предмет</th>
                    <th scope="col">часы</th>
                    <th scope="col">тип</th>
                    <th scope="col">семестр</th>
                </tr>
            </thead>
            <tbody class='tbodyNagrTable'>

                <?php
                        $query=mysql_query('SELECT `nagr`.`id`,`nagr`.`grupp` as "gruppId", `predmet`.`nazv` as "predmet", `nagr`.`chas`, `tip_ekz`.`name` as "tip_ekz", `nagr`.`date`, `nagr`.`sem`, `grupp`.`nazv` as "grupp" FROM `nagr`,`predmet`,`grupp`,`tip_ekz` WHERE `grupp`.`id`=`nagr`.`grupp` and `predmet`.`id`=`nagr`.`predmet` and `nagr`.`tip_ekz`=`tip_ekz`.`id` and `nagr`.`prepod`='.$_SESSION['id']);
                        while($row=mysql_fetch_assoc($query)){ 
                            echo '<tr>
                            <td scope="row"><button type="button" class="btn btn-dark nagrBtn" data-id='.$row['id'].' data-type='.$row['tip_ekz'].'>Перейти</button></td>
                            <td scope="row">'.$row['grupp'].'</td>
                            <td scope="row">'.$row['predmet'].'</td>
                            <td scope="row">'.$row['chas'].'</td>
                            <td scope="row">'.$row['tip_ekz'].'</td>
                            <td scope="row">'.$row['sem'].'</td>
                            </tr>';
                        }
                        ?>
            </tbody>
        </table>




        <?php
    mysql_close($link);
    ?>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Сообщение</h5>
                </div>
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>

</body>

<script>
    function modalShow(modalText) {
        $('.modal').modal('show');
        $('.modal .modal-body').text(modalText);
        setTimeout(function() {
            $('.modal').modal('hide');
        }, 2500);
    }


    $('.nagrBtn').click(function() {
        document.location = "http://kaivedomosti.ru/site/nagr.php?id=" + $(this).attr('data-id');
    });

</script>

</html>
