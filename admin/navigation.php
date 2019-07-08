<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';

if($_SESSION['admin']!=1){
    header('Location: http://kaivedomosti.ru/admin/navigation.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> Навигация </title>

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
        <h2 class='p-3'>Список добавления</h2>

        <ul class='p-5'>
            <li><a href='../admin/menuEdit.php'>Добавить пункт меню</a></li>
            <li><a href='../admin/uchEdit.php'>Добавить учебное заведение</a></li>
            <li><a href='../admin/prepodEdit.php'>Добавить преподавателя</a></li>
            <li><a href='../admin/predmetEdit.php'>Добавить предмет</a></li>
            <li><a href='../admin/specEdit.php'>Добавить специальность</a></li>
            <li><a href='../admin/nagrEdit.php'>Добавить nagr</a></li>
            <li><a href='../admin/uspevEdit.php'>Добавить uspev</a></li>
            <li><a href='../admin/sved_stud.php'>Сведения студентов</a></li>
            <li><a href='../admin/objasnEdit.php'>Объяснительная</a></li>
        </ul>


    </div>



</body>

</html>
