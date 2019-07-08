<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление успеваемости</title>

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

        <h2 class='p-3'>Добавление успеваемости</h2>
        <div class="form-group  mb-2">
            <label>Ведомость</label>
            <select class='custom-select nagrList'>
                <?php
                        $query=mysql_query('SELECT `nagr`.`id`,`nagr`.`grupp` as "gruppId", `predmet`.`nazv` as "predmet", `nagr`.`chas`, `tip_ekz`.`name` as "tip_ekz", `nagr`.`date`, `nagr`.`sem`, `grupp`.`nazv` as "grupp" FROM `nagr`,`predmet`,`grupp`,`tip_ekz` WHERE `grupp`.`id`=`nagr`.`grupp` and `predmet`.`id`=`nagr`.`predmet` and `nagr`.`tip_ekz`=`tip_ekz`.`id` and `nagr`.`prepod`='.$_SESSION['id']);
                        $row=mysql_fetch_assoc($query);
                        $firstGrupp=$row['gruppId'];
                        echo '<option value='.$row['id'].' data-grupp='.$row['gruppId'].'> Группа: '.$row['grupp'].' | Предмет: '.$row['predmet'].' | Часы: '.$row['chas'].' | Тип: '.$row['tip_ekz'].' | Семестр: '.$row['sem'].'</option>';
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'> Группа: '.$row['grupp'].' | Предмет: '.$row['predmet'].' | Часы: '.$row['chas'].' | Тип: '.$row['tip_ekz'].' | Семестр: '.$row['sem'].'</option>';
                        }
                        ?>
            </select>
        </div>

        <div class="form-group  mb-2">
            <label>Студент</label>
            <select class='custom-select studentList'>
                <?php
                        $query=mysql_query('SELECT * FROM `student` where `grupp`='.$firstGrupp);
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['fam'].' '.$row['name'].' '.$row['otch'].'</option>';
                        }
                        ?>
            </select>
        </div>

        <div class='form-group mb-2'>
            <label>Балл</label>
            <select class='custom-select ballList'>
                <option value='2'>2</option>
                <option value='3'>3</option>
                <option value='4'>4</option>
                <option value='5'>5</option>
            </select>
        </div>

        <div class='form-group bm-2'>
            <label>Комментарий</label>
            <input class='comment form-control'>
        </div>

        <button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button>


        <h2 class='mt-5'>Редактирование предметов</h2>




        <table class="table shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">nagr</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Балл</th>
                    <th scope="col">Комментарий</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody class='tbodyPredmetTable'>

                <?php
                        $query=mysql_query('SELECT `uspev`.`id`, `uspev`.`nagr`, `student`.`fam`,`student`.`name`,`student`.`otch`, `uspev`.`ball`, `uspev`.`comment` FROM `uspev`,`student` WHERE `uspev`.`student`=`student`.`id`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td scope="row">'.$row['nagr'].'</td>
                    <td scope="row">'.$row['fam'].' '.$row['name'].' '.$row['otch'].'</td>
                    <td scope="row">'.$row['ball'].'</td>
                    <td scope="row">'.$row['comment'].'</td>
                    <td><button type="button" class="btn btn-success editMenuLi">Редактировать</button></td>
                    <td><button type="button" class="btn btn-danger deleteMenuItem" data-id='.$row['id'].'>Удалить</button></td>
                </tr>';
                        }
                        ?>
            </tbody>
        </table>



        <?php
    mysql_close($link);
    ?>
    </div>
</body>

<script>
    $('.btnAddMenuItem').click(function() {
        $.ajax({
            type: 'post',
            url: 'php/uspevAction.php',
            data: {
                nagr: $('.nagrList option:selected').attr('value'),
                student: $('.studentList option:selected').attr('value'),
                ball: $('.ballList option:selected').attr('value'),
                comment: $('.comment').val(),
                method: 'add'
            },
            success: function(data) {
                $('.tbodyPredmetTable').append('<tr><th scope="row">' + data + '</th><td>' + $('.addPredmetItemName').val() + '</td><td>' + $('.uchList option:selected').text() + '</td><td>' +
                    $('.addGodSpec').val() + '</td><td><button type = "button" class = "btn btn-success editMenuLi">Редактировать</button></td><td ><button type = "button" class = "btn btn-danger deleteMenuItem" data-id =' + data + '>Удалить</button></td> </tr>');
            }
        });
    });

    $('.deleteMenuItem').click(function() {
        $(this).parent().parent().remove();

        $.ajax({
            type: 'post',
            url: 'php/uspevAction.php',
            data: {
                id: $(this).attr('data-id'),
                method: 'delete'
            },
            success: function(data) {
                $(this).parent().parent().remove();
            }
        });
    });



    $('.nagrList').change(function() {

        $.ajax({
            type: 'post',
            url: 'php/get/getStudent.php',
            data: {
                grupp: $('.nagrList option:selected').attr('data-grupp')
            },
            success: function(data) {
                $('.studentList').empty();
                data = JSON.parse(data);
                for (var x = 0; x < data.length; x++) {
                    $('.studentList').append('<option value=' + data[x]['id'] + '>' + data[x]['fam'] + ' ' + data[x]['name'] + ' ' + data[x]['otch'] + '</option>');
                }
            }
        });

    });

</script>

</html>
