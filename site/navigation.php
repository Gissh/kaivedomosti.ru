<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная</title>

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


        <h1>Список</h1>

        <ul>

            <li><a href='selectNagr.php'>Выбор ведомости</a></li>
            <li><a href='selectNagr.php'>Выбор ведомости</a></li>

        </ul>


        <?php
    mysql_close($link);
    ?>
    </div>
</body>

<script>
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
                console.log(data);
            }
        });
    });

</script>

</html>
