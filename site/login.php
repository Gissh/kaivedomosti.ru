<?php 
session_start();
session_destroy(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вход</title>

    <link rel="stylesheet" href='../css/bootstrap.min.css'>

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel='stylesheet' href="../css/main.css">


</head>

<body>
    <?php    
    require_once('../php/connect.php');
    
    ?>



    <div class="container shadow-sm mt-5" style="width:350px;">


        <h2 class='p-3' align='center'>Вход</h2>

        <div class="form-group  mb-2">
            <label>Учебное заведение</label>
            <select class='custom-select uchList'>
                <?php
                        $query=mysql_query('SELECT * FROM `uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
            </select>
        </div>

        <div class="form-group  mb-2">
            <label>Преподаватель</label>
            <select class='custom-select prepodList'>
                <?php
                        $query=mysql_query('SELECT * FROM `uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
            </select>
        </div>

        <div class='from-group mb-2'>
            <label>Пароль</label>
            <input type='password' class='form-control passInput'>
        </div>

        <div class="alert alert-danger mb-3" role="alert" style='display:none'>
            Вы ввели неверный пароль!
        </div>

        <div class='text-center '>
            <button type="button" class='btn btn-success mb-3 enterBtn'>Войти</button>
        </div>




        <?php
    mysql_close($link);
    ?>
    </div>
</body>

<script>
    $('.uchList').change(function() {

        $.ajax({
            type: 'post',
            url: '../admin/php/get/getPrepod.php',
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

    });

    $('.enterBtn').click(function() {
        $.ajax({
            type: 'post',
            url: "../php/enter.php",
            data: {
                id: $('.prepodList option:selected').attr('value'),
                pass: $('.passInput').val()
            },
            success: function(data) {
                if (data == 1) {
                    document.location = 'http://kaivedomosti.ru/site/navigation.php';
                } else {
                    $('.alert-danger').show();
                }
            }
        });
    });

    $('.passInput').on('input', function() {
        $('.alert-danger').hide();
    });

</script>

</html>
