<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление объяснительными</title>

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

        <h2 class='p-3'>Добавление объяснительной</h2>
        <div class="form-group  mb-2">
            <label>Группа</label>
            <select class='custom-select gruppList'>
                <?php
                        $query=mysql_query('SELECT `uch` from `prepod` WHERE `id`='.$_SESSION['id']);
                        $row=mysql_fetch_assoc($query);
                        $thisUch=$row['uch'];
                
                        $query=mysql_query('select `id`,`nazv` from `grupp`');
                        $row=mysql_fetch_assoc($query);
                        $firstGrupp=$row['id'];
                        echo '<option value='.$row['id'].'>'.$row['nazv'].' </option>';
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
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

        <button type="button" class='btn btn-success btnAddMenuItem'>Выдать ссылку</button>


        <h2 class='mt-5'>Актуальные ссылки</h2>

        <table class="table shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">ФИО</th>
                    <th scope="col">Ссылка</th>
                    <th scope="col">Текст</th>
                    <th scope="col">Дата</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody class='tbodyPredmetTable'>

                <?php
                        $query=mysql_query('SELECT `objasn`.`id`,`student`.`fam`,`student`.`name`,`student`.`otch`,`objasn`.`link`,`objasn`.`text`,`obj_date` FROM `student`,`objasn` WHERE `objasn`.`student_id`=`student`.`id`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td scope="row">'.$row['fam'].' '.$row['name'].' '.$row['otch'].'</td>
                    <td scope="row">'.$row['link'].'</td>
                    <td scope="row">'.$row['text'].'</td>
                    <td scope="row">'.$row['obj_date'].'</td>
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
            url: 'php/objasnAction.php',
            data: {
                student_id: $('.studentList option:selected').attr('value'),
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
            url: 'php/svedStudAction.php',
            data: {
                id: $(this).attr('data-id'),
                method: 'delete'
            },
            success: function(data) {
                $(this).parent().parent().remove();
            }
        });
    });



    $('.gruppList').change(function() {

        $.ajax({
            type: 'post',
            url: 'php/get/getStudent.php',
            data: {
                grupp: $('.gruppList option:selected').val()
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

    $('.student_selector').click(function() {
        $('.current_select_data').attr('data-stud', $(this).attr('data-stud'));
        $('.stud_tr').each(function() {
            if ($(this).attr('data-stud') == $('.current_select_data').attr('data-stud') && $(this).attr('data-type') == $('.current_select_data').attr('data-type')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });

    });

</script>

</html>
