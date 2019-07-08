<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление ведомостями</title>

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



    <div class="container shadow-sm pb-5">

        <h2 class='pt-5'>Редактирование нагрузки</h2>



        <div class='table-responsive'>
            <table class="table shadow-sm">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">id</th>
                        <th scope="col" style='min-width:200px;'>Учебное заведение</th>
                        <th scope="col" style='min-width:200px;'>Предмет</th>
                        <th scope="col" style='min-width:200px;'>ФИО</th>
                        <th scope="col" style='min-width:100px;'>Часы</th>
                        <th scope="col" style='min-width:150px;'>Тип экзамена</th>
                        <th scope="col">Дата</th>
                        <th scope="col">Семестр</th>
                        <th scope="col" style='min-width:150px;'>Группа</th>
                        <th scope="col" style='min-width:100px;'>Год</th>
                        <th scope="col">Активен</th>
                        <th scope="col">Редактировать</th>
                        <th scope="col">Удалить</th>
                    </tr>
                </thead>
                <tbody class='tbodySpecTable'>

                    <tr>
                        <td scope='row'></td>
                        <td><select class='custom-select uchList'>
                                <option selected disabled>Учебное заведение</option>
                                <?php
                        $query=mysql_query('SELECT * FROM `uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
                            </select></td>
                        <td><select class='custom-select predmetList'>
                                <option selected disabled>Предмет</option>
                            </select></td>

                        <td>
                            <select class='custom-select prepodList'>
                                <option selected disabled>Преподаватель</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" class="form-control hoursCount" min=1 max=500>
                        </td>

                        <td>
                            <select class='custom-select ekzList'>
                                <option value=1>Зачет</option>
                                <option value=2>Экзамен</option>
                                <option value=3>Диф. зачет</option>
                            </select>
                        </td>

                        <td>
                            <input type="date" class="form-control dateEkz">
                        </td>

                        <td>
                            <select class='custom-select semList'>
                                <option value=1>1</option>
                                <option value=2>2</option>
                            </select>
                        </td>

                        <td>
                            <select class='custom-select gruppaList'>
                                <option selected disabled>Группа</option>
                            </select>
                        </td>

                        <td>
                            <input type="number" class="form-control addGodSpec" readonly value='2019'>
                        </td>

                        <td>

                        </td>

                        <td>
                            <button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button>
                        </td>

                    </tr>

                    <?php
                        $query=mysql_query('SELECT `nagr`.`id`,`prepod`.`fam`,`prepod`.`name`,`prepod`.`otch`,`predmet`.`nazv` as "predmet",`uch`.`nazv` as "uch",`nagr`.`chas`,`tip_ekz`.`name` as "ekz",`nagr`.`date`,`nagr`.`sem`,`grupp`.`nazv` as "grupp",`nagr`.`god`,`nagr`.`active` FROM `nagr`,`prepod`,`predmet`,`tip_ekz`,`grupp`,`uch` WHERE `prepod`.`id`=`nagr`.`prepod` AND `predmet`.`id`=`nagr`.`predmet` AND `uch`.`id`=`nagr`.`uch` AND `tip_ekz`.`id`=`nagr`.`tip_ekz` AND `grupp`.`id`=`nagr`.`grupp`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td scope="row">'.$row['uch'].'</td>
                    <td scope="row">'.$row['predmet'].'</td>
                    <td scope="row">'.$row['fam'].' '.$row['name'].' '.$row['otch'].'</td>
                    <td scope="row">'.$row['chas'].'</td>
                    <td scope="row">'.$row['ekz'].'</td>
                    <td scope="row">'.$row['date'].'</td>
                    <td scope="row">'.$row['sem'].'</td>
                    <td scope="row">'.$row['grupp'].'</td>
                    <td scope="row">'.$row['god'].'</td>
                    <td scope="row">'.$row['active'].'</td>
                    <td><button type="button" class="btn btn-success editMenuLi">Редактировать</button></td>
                    <td><button type="button" class="btn btn-danger deleteMenuItem" data-id='.$row['id'].'>Удалить</button></td>
                </tr>';
                        }
                        ?>
                </tbody>
            </table>
        </div>


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



    $('.btnAddMenuItem').click(function() {
        $.ajax({
            type: 'post',
            url: 'php/nagrAction.php',
            data: {
                uch: $('.uchList option:selected').attr('value'),
                predmet: $('.predmetList option:selected').attr('value'),
                prepod: $('.prepodList option:selected').attr('value'),
                god: $('.addGodSpec').val(),
                chas: $('.hoursCount').val(),
                tip_ekz: $('.ekzList option:selected').attr('value'),
                date: $('.dateEkz').val(),
                sem: $('.semList option:selected').attr('value'),
                grupp: $('.gruppaList option:selected').attr('value'),
                method: 'add'
            },
            success: function(data) {
                if (data != 'err') {
                    $('.tbodySpecTable').append('<tr><th scope="row">' + data + '</th><td>' + $('.uchList option:selected').text() + '</td><td>' + $('.predmetList option:selected').text() + '</td><td>' + $('.prepodList option:selected').text() + '</td><td>' +
                        $('.hoursCount').val() + '</td><td>' + $('.ekzList option:selected').text() + '</td><td>' + $('.dateEkz').val() + '</td><td>' + $('.semList option:selected').text() + '</td><td>' + $('.gruppaList option:selected').text() + '</td><td>' + $('.addGodSpec').val() + '</td><td>1</td><td><button type = "button" class = "btn btn-success editMenuLi">Редактировать</button></td><td ><button type = "button" class = "btn btn-danger deleteMenuItem" data-id =' + data + '>Удалить</button></td> </tr>');
                    modalShow('Запись успешно добавлена!');

                } else {
                    modalShow('Произошла ошибка, запись не была добавлена!');
                }
            }
        });
    });

    $('.deleteMenuItem').click(function() {
        $(this).parent().parent().remove();

        $.ajax({
            type: 'post',
            url: 'php/nagrAction.php',
            data: {
                id: $(this).attr('data-id'),
                method: 'delete'
            },
            success: function(data) {
                $(this).parent().parent().remove();
                if (data != 'err') {
                    modalShow('Запись успешно удалена!');
                } else {
                    modalShow('Произошла ошибка, запись не была удалена!');
                }
            }
        });
    });


    $('.uchList').change(function() {

        $.ajax({
            type: 'post',
            url: 'php/get/getPrepod.php',
            data: {
                uch: $('.uchList option:selected').attr('value')
            },
            success: function(data) {
                $('.prepodList').empty();
                data = JSON.parse(data);
                for (var x = 0; x < data.length; x++) {
                    $('.prepodList').append('<option value=' + data[x]['id'] + '>' + data[x]['fam'] + ' ' + data[x]['name'] + ' ' + data[x]['otch'] + '</option>');
                }
            }
        });

        $.ajax({
            type: 'post',
            url: 'php/get/getPredmet.php',
            data: {
                uch: $('.uchList option:selected').attr('value')
            },
            success: function(data) {
                $('.predmetList').empty();
                data = JSON.parse(data);
                for (var x = 0; x < data.length; x++) {
                    $('.predmetList').append('<option value=' + data[x]['id'] + '>' + data[x]['nazv'] + '</option>');
                }
            }
        });

        $.ajax({
            type: 'post',
            url: 'php/get/getGruppa.php',
            data: {
                uch: $('.uchList option:selected').attr('value')
            },
            success: function(data) {
                $('.gruppaList').empty();
                data = JSON.parse(data);
                for (var x = 0; x < data.length; x++) {
                    $('.gruppaList').append('<option value=' + data[x]['id'] + '>' + data[x]['nazv'] + ' / ' + data[x]['spec'] + ' / ' + data[x]['god'] + ' год</option>');
                }
            }
        });

    });

</script>

</html>
