<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ведомость</title>

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


        <h2 class='p-3 nagrInfo' align='center' data-id='<?php echo $_GET["id"] ?>'>

            <?php
            
            $query=mysql_query('SELECT `nagr`.`id`,`nagr`.`grupp` as "gruppId", `predmet`.`nazv` as "predmet", `nagr`.`chas`, `tip_ekz`.`name` as "tip_ekz", `nagr`.`date`, `nagr`.`sem`, `grupp`.`nazv` as "grupp" FROM `nagr`,`predmet`,`grupp`,`tip_ekz` WHERE `grupp`.`id`=`nagr`.`grupp` and `predmet`.`id`=`nagr`.`predmet` and `nagr`.`tip_ekz`=`tip_ekz`.`id` and `nagr`.`prepod`='.$_SESSION['id']);
                        $row=mysql_fetch_assoc($query);
                        echo 'Группа: '.$row['grupp'].' | Предмет: '.$row['predmet'].' | Часы: '.$row['chas'].' | Тип: '.$row['tip_ekz'].' | Семестр: '.$row['sem'];
            
            ?>

        </h2>

        <table class="table shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">ФИО студента</th>
                    <th scope="col">Оценка</th>
                </tr>
            </thead>
            <tbody class='tbodyNagrTable'>

                <?php
                        $query=mysql_query('SELECT `student`.`id`,`student`.`fam`,`student`.`name`,`student`.`otch`,`uspev`.`ball` from `student`,`uspev` where `student`.`id`=`uspev`.`student` and `uspev`.`nagr`='.$_GET['id'].' union ALL SELECT `student`.`id`,`student`.`fam`,`student`.`name`,`student`.`otch`,NULL as "ball" from `student`,`nagr` where `nagr`.`id`='.$_GET['id'].' and `student`.`grupp`=`nagr`.`grupp` and `student`.`id` NOT IN (SELECT `student` as "id" FROM `uspev` where `nagr`='.$_GET['id'].')');
                

                            while($row=mysql_fetch_assoc($query)){ 
                            echo '<tr class="studentRow">
                            <td scope="row">'.$row['fam'].' '.$row['name'].' '.$row['otch'].'</td>
                            <td scope="row"><select class="custom-select ballList" data-id='.$row['id'].'>';
                                if($row['ball']==NULL){
                                    echo '
                                    <option value="0" selected>Не поставлено</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>';
                                }else{
                                    for($x=2;$x<=5;$x++){
                                        if($row['ball']==$x){
                                            echo '<option value="'.$x.'" selected>'.$x.'</option>';
                                        }else{
                                            echo '<option value="'.$x.'">'.$x.'</option>';
                                        }
                                    }
                                }
                                echo '
                            </select></td>
                            </tr>';
                            }
                        
                        ?>
            </tbody>
        </table>


        <button type="button" class='btn btn-success saveUsp mb-2'>Сохранить</button>

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


    $('.saveUsp').click(function() {
        var studVal = [];
        $('.ballList').each(function() {
            if ($(this).find(":selected").val() != 0) {
                studVal.push({
                    "id": $(this).attr('data-id'),
                    "val": $(this).find(":selected").val()
                });
            }
        });
        console.log(studVal);

        $.ajax({
            type: "post",
            url: "../php/saveUsp.php",
            data: {
                studVal: studVal,
                nagr: $('.nagrInfo').attr('data-id')
            },
            success: function(data) {
                if (data != 'err') {

                    modalShow('Записи были обновлены!');

                } else {
                    modalShow('Произошла ошибка!');
                }
            }
        });
    });

</script>

</html>
