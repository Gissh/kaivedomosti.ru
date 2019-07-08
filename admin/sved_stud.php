<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление сведениями</title>

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

        <h2 class='p-3'>Добавление сведений</h2>
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

        <div class="form-group  mb-2">
            <label>Раздел</label>
            <select class='custom-select razdelList'>
                <?php
                        $query=mysql_query('SELECT * FROM `sved_razdel` where `uch`='.$thisUch);
                        $row=mysql_fetch_assoc($query);
                        $firstRazdel=$row['id'];
                        echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
            </select>
        </div>

        <div class="form-group  mb-2">
            <label>Тип</label>
            <select class='custom-select tipList'>
                <?php
                        $query=mysql_query('SELECT * FROM `sved_tip` where `razdel`='.$firstRazdel);
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
            </select>
        </div>

        <div class='form-group bm-2'>
            <label>Значение</label>
            <input class='svedValue form-control'>
        </div>

        <button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button>


        <h2 class='mt-5'>Редактирование Сведений</h2>

        <?php
        
        $query=mysql_query('SELECT `grupp`.`nazv`,`kurator`.`grupp_id` FROM `kurator`,`grupp` WHERE `kurator`.`prepod_id`='.$_SESSION['id'].' AND `grupp`.`id`=`kurator`.`grupp_id`');
        $grupp=array();
        while($row=mysql_fetch_assoc($query)){
            $grupp[]=$row;
        }
        
        $query=mysql_query('SELECT DISTINCT `sved_razdel`.`id`,`sved_razdel`.`nazv` FROM `sved_stud`,`sved_razdel` WHERE `sved_stud`.`razdel`=`sved_razdel`.`id` AND `sved_razdel`.`uch`='.$_SESSION['uch']);
        $doc_type=array();
        while($row=mysql_fetch_assoc($query)){
            $doc_type[]=$row;
        }
        
        
        $query=mysql_query('SELECT `student`.`id`,`student`.`grupp`,`student`.`fam`,`student`.`name`,`student`.`otch` FROM `student`,`kurator` WHERE `kurator`.`grupp_id`=`student`.`grupp` AND `kurator`.`prepod_id`='.$_SESSION['id']);
        $students=array();
        while($row=mysql_fetch_assoc($query)){
            $students[]=$row;
        }
        
        $query=mysql_query('SELECT DISTINCT `sved_stud`.`id`,`student`.`id` as "stud_id",`student`.`grupp`,`student`.`fam`,`student`.`name`,`student`.`otch`,`sved_tip`.`nazv`,`sved_stud`.`val`,`sved_stud`.`razdel` FROM `sved_stud`,`student`,`sved_tip`,`kurator` WHERE `sved_stud`.`student`=`student`.`id` AND `sved_tip`.`id`=`sved_stud`.`tip_sv` AND `student`.`grupp` IN (SELECT `grupp_id` FROM `kurator` WHERE `prepod_id`='.$_SESSION['id'].')');
        $stud_data=array();
         while($row=mysql_fetch_assoc($query)){
             $stud_data[]=$row;
        }
                        ?>


        <div class="row mb-5">
            <div class="col-4">

                <ul class="nav nav-tabs" role="tablist">
                    <?php
                    
                    foreach($grupp as $row){
                        echo '<li class="nav-item"><a class="nav-link grupp_selector" data-toggle="tab" href="#" role="tab" data-id='.$row['grupp_id'].'>'.$row['nazv'].'</a></li>';
                    }
                    
                    ?>
                </ul>


                <div class="list-group" id="list-tab" role="tablist">
                    <?php
                    
                    foreach($students as $row){
                        echo '<a class="list-group-item list-group-item-action student_selector" data-toggle="list" href="#" role="tab" data-stud='.$row['id'].' data-grupp='.$row['grupp'].'>'.$row['fam'].' '.$row['name'].' '.$row['otch'].'</a>';
                    }
                    
                    ?>
                </div>
            </div>
            <div class="col-7">
                <ul class="nav nav-tabs" role="tablist">
                    <?php
                    
                    foreach($doc_type as $row){
                        echo '<li class="nav-item"><a class="nav-link doc_selector" data-toggle="tab" href="#" role="tab" data-id='.$row['id'].'>'.$row['nazv'].'</a></li>';
                    }
                    
                    ?>
                </ul>

                <table class="table shadow-sm">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">Название</th>
                            <th scope="col">Значение</th>
                        </tr>
                    </thead>
                    <tbody class='tbodyPredmetTable'>
                        <?php
                        
                        foreach($stud_data as $row){
                            echo '<tr class="stud_tr" data-stud='.$row['stud_id'].' data-type='.$row['razdel'].'><td>'.$row['nazv'].'</td><td>'.$row['val'].'</td></tr>';
                        }
                        
                        ?>
                    </tbody>
                </table>
                <input type="hidden" class='current_select_data' data-stud='-1' data-type='-1'>
            </div>
        </div>

        <?php
    mysql_close($link);
    ?>
    </div>
</body>

<script>
    $('.btnAddMenuItem').click(function() {
        $.ajax({
            type: 'post',
            url: 'php/svedStudAction.php',
            data: {
                tip_sv: $('.tipList option:selected').attr('value'),
                student: $('.studentList option:selected').attr('value'),
                razdel: $('.razdelList option:selected').attr('value'),
                val: $('.svedValue').val(),
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

    $('.doc_selector').click(function() {
        $('.current_select_data').attr('data-type', $(this).attr('data-id'));
        $('.stud_tr').each(function() {
            if ($(this).attr('data-stud') == $('.current_select_data').attr('data-stud') && $(this).attr('data-type') == $('.current_select_data').attr('data-type')) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

    $('.grupp_selector').click(function() {
        var this_grupp = $(this).attr('data-id');
        $('.student_selector').each(function() {
            if ($(this).attr('data-grupp') == this_grupp) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });

</script>

</html>
