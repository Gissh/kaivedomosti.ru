<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление преподавателями</title>

    <link rel="stylesheet" href='../css/bootstrap.min.css'>

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../sprite/iconwc.js"></script>
    <link rel='stylesheet' href="../css/main.css">


</head>

<body>
    <?php
    require_once('../php/connect.php');
    require_once('../php/base.php');
    ?>



    <div class="container shadow-sm">


        <h1 class='text-center p-3'>Управление преподавателями</h1>

        <table class="table shadow-sm mt-5">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">фамилия</th>
                    <th scope="col">имя</th>
                    <th scope="col">отчество</th>
                    <th scope="col">логин</th>
                    <th scope="col">Пароль</th>
                    <th scope="col">телефон</th>
                    <th scope="col">почта</th>
                    <th scope="col">учебное заведение</th>
                    <th scope="col">Права 0-препод 1-админ 2-куратор</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody class='tbodySpecTable'>
                <tr>
                    <td scope="row"></td>
                    <td scope="row"><input type="text" class="form-control famItem"></td>
                    <td scope="row"><input type="text" class="form-control nameItem"></td>
                    <td scope="row"><input type="text" class="form-control otchItem"></td>
                    <td scope="row"><input type="text" class="form-control loginItem"></td>
                    <td scope="row"><input type="text" class="form-control passItem"></td>
                    <td scope="row"><input type="tel" class="form-control telItem"></td>
                    <td scope="row"><input type="text" class="form-control mailItem"></td>
                    <td scope="row"><select class='custom-select uchList'>
                            <?php
                        $query=mysql_query('SELECT * FROM `uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
                        </select></td>

                    <td scope="row"><select class='custom-select kuratorList'>
                            <option value="0">0</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select></td>
                    <td scope="row"><button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button></td>
                    <td scope="row"></td>

                </tr>
                <?php
                        $query=mysql_query('SELECT `prepod`.`fam`,`prepod`.`id`,`prepod`.`name`,`prepod`.`otch`,`prepod`.`login`,`prepod`.`passw`,`prepod`.`tel`,`prepod`.`mail`,`prepod`.`kurator`,`uch`.`nazv` FROM `prepod`,`uch` WHERE `uch`.`id`=`prepod`.`uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td scope="row">'.$row['fam'].'</td>
                    <td scope="row">'.$row['name'].'</td>
                    <td scope="row">'.$row['otch'].'</td>
                    <td scope="row">'.$row['login'].'</td>
                    <td scope="row">'.$row['passw'].'</td>
                    <td scope="row">'.$row['tel'].'</td>
                    <td scope="row">'.$row['mail'].'</td>
                    <td scope="row">'.$row['nazv'].'</td>
                    <td scope="row">'.$row['kurator'].'</td>
                    
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
            url: 'php/prepodAction.php',
            data: {
                fam: $('.famItem').val(),
                name: $('.nameItem').val(),
                otch: $('.otchItem').val(),
                login: $('.loginItem').val(),
                passw: $('.passItem').val(),
                tel: $('.telItem').val(),
                mail: $('.mailItem').val(),
                uch: $('.uchList option:selected').attr('value'),
                kurator: $('.kuratorList option:selected').text(),
                method: 'add'
            },
            success: function(data) {

                if (data != 'err') {
                    $('.tbodySpecTable').append('<tr><th scope="row">' + data + '</th><td>' + $('.addSpecItemName').val() + '</td><td>' + $('.uchList option:selected').text() + '</td><td>' + $('.addNumberSpec').val() + '</td><td>' +
                        $('.addGodSpec').val() + '</td><td><button type = "button" class = "btn btn-success editMenuLi">Редактировать</button></td><td ><button type = "button" class = "btn btn-danger deleteMenuItem" data-id =' + data + '>Удалить</button></td> </tr>');
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
            url: 'php/prepodAction.php',
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
            url: 'php/prepodAction.php',
            data: {
                id: $('.editTr>td:first').text(),
                fam: $('.editTr .famItem').val(),
                name: $('.editTr .nameItem').val(),
                otch: $('.editTr .otchItem').val(),
                login: $('.editTr .loginItem').val(),
                passw: $('.editTr .passItem').val(),
                tel: $('.editTr .telItem').val(),
                mail: $('.editTr .mailItem').val(),
                uch: $('.editTr .uchList option:selected').attr('value'),
                kurator: $('.editTr .kuratorList option:selected').text(),
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
