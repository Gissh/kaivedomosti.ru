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
    <title>Управление меню</title>

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


        <h2 class='pt-5 pb-5'>Редактирование пунктов меню</h2>

        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active menuTabBtn" id="menuTable-tab" data-toggle="tab" href="#menuTable" role="tab" aria-controls="menuTable" aria-selected="true">Меню</a>
            </li>
            <li class="nav-item">
                <a class="nav-link adminMenuTabBtn" id="menuAdminTable-tab" data-toggle="tab" href="#menuAdminTable" role="tab" aria-controls="menuAdminTable" aria-selected="false">Админ-меню</a>
            </li>
        </ul>

        <table class="table shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Название</th>
                    <th scope="col">Ссылка</th>
                    <th scope="col">admin</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody class='tbodyMenuTable'>

                <tr>
                    <td></td>
                    <td><input type="text" class="form-control addMenuItemName"></td>
                    <td><input type="text" class="form-control addMenuItemLink"></td>
                    <td><input type="text" class='form-control addMenuItemAdmin' min="0" max="1"></td>
                    <td><button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button></td>
                    <td></td>
                </tr>

                <?php
                        $query=mysql_query('SELECT * FROM `menu`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td>'.$row['name'].'</td>
                    <td>'.$row['link'].'</td>
                    <td class="ifAdmin">'.$row['admin'].'</td>
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
    $('.ifAdmin').each(function() {
        if ($(this).text() == '1') {
            $(this).parent().hide();
        }
    });

    $('.menuTabBtn').click(function() {
        $('.ifAdmin').each(function() {
            if ($(this).text() == '1') {
                $(this).parent().hide();
            } else {
                $(this).parent().show();
            }
        });
    });

    $('.adminMenuTabBtn').click(function() {
        $('.ifAdmin').each(function() {
            if ($(this).text() == '0') {
                $(this).parent().hide();
            } else {
                $(this).parent().show();
            }
        });
    });

    $('.btnAddMenuItem').click(function() {
        $.ajax({
            type: 'post',
            url: 'php/menuAction.php',
            data: {
                name: $('.addMenuItemName').val(),
                link: $('.addMenuItemLink').val(),
                admin: $('.addMenuItemAdmin').val(),
                method: 'add'
            },
            success: function(data) {
                if ($('.addMenuItemAdmin').prop("checked")) {
                    $('.tbodyAdminTable').append('<tr><th scope="row">' + data + '</th><td>' + $('.addMenuItemName').val() + '</td><td>' + $('.addMenuItemLink').val() + '</td><td><button type = "button" class = "btn btn-success editMenuLi">Редактировать</button></td><td ><button type = "button" class = "btn btn-danger deleteMenuItem" data-id =' + data + '>Удалить</button></td> </tr>');
                } else {
                    $('.tbodyMenuTable').append('<tr><th scope="row">' + data + '</th><td>' + $('.addMenuItemName').val() + '</td><td>' + $('.addMenuItemLink').val() + '</td><td><button type = "button" class = "btn btn-success editMenuLi">Редактировать</button></td ><td><button type = "button" class = "btn btn-danger deleteMenuItem" data-id = ' + data + '>Удалить</button></td ></tr>');
                }
            }
        });
    });

    $('.deleteMenuItem').click(function() {
        $(this).parent().parent().remove();

        $.ajax({
            type: 'post',
            url: 'php/menuAction.php',
            data: {
                id: $(this).attr('data-id'),
                method: 'delete'
            },
            success: function(data) {
                $(this).parent().parent().remove();
            }
        });
    });

    $('.editMenuLi').click(function() {

        if ($('body').has('.editTr').length == 0) {
            var inputCopy = $('tbody>tr:first').clone();
            var thisParent = $(this).parent().parent();
            inputCopy.addClass('editTr');
            inputCopy.find('td:first').html(thisParent.find('th:first').text());
            inputCopy.find('td:last').html('<button type="button" class="btn btn-danger cancelBtn">Отмена</button>');
            inputCopy.find('td:eq(-2)').html('<button type="button" class="btn btn-warning applyBtn">Применить</button>');

            thisParent.css('display', 'none');
            thisParent.after(inputCopy);

            inputCopy.find('td').each(function(i, e) {
                i -= 1;
                if ($(this).children().is('input')) {
                    $(this).children('input').val(thisParent.find('td:eq(' + i + ')').text());
                } else if ($(this).children().is('select')) {
                    $(this).children('select').find('option').each(function() {
                        if ($(this).text() == thisParent.find('td:eq(' + i + ')').text()) {
                            $(this).attr('selected', '1');
                        }
                    });

                }
            });
        } else {
            $('.editTr').css('border', '2px solid red');
        }
    });

    $('body').on('click', '.cancelBtn', function() {
        $('.editTr').remove();
        $('tbody>tr').show();
    });

    $('body').on('click', '.applyBtn', function() {
        $.ajax({
            type: 'post',
            url: 'php/menuAction.php',
            data: {
                id: $('.editTr>td:first').text(),
                name: $('.editTr .addMenuItemName').val(),
                link: $('.editTr .addMenuItemLink').val(),
                admin: $('.editTr .addMenuItemAdmin').val(),
                method: 'edit'
            },
            success: function(data) {
                if (data != 'err') {
                    modalShow('Запись успешно обновлена!');
                } else {
                    modalShow('Произошла ошибка, запись не была обновлена!');
                }
            }
        });

        $('.editTr').remove();
        $('tbody>tr').show();


    });

</script>

</html>
