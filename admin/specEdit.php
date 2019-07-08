<?php 
include $_SERVER['DOCUMENT_ROOT'].'/php/checkEnter.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление специальностями</title>

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


        <h1 class='text-center p-3'>Управление специальностями</h1>

        <table class="table shadow-sm mt-5">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Название</th>
                    <th scope="col">Учебное заведение</th>
                    <th scope="col">Номер</th>
                    <th scope="col">Год начала</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody class='tbodySpecTable'>
                <tr>
                    <td scope="row"></td>
                    <td scope="row"><input type="text" class="form-control addSpecItemName"></td>
                    <td scope="row"><select class='custom-select uchList'>
                            <?php
                        $query=mysql_query('SELECT * FROM `uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
                        </select></td>

                    <td scope="row"><input type="text" class="form-control addNumberSpec"></td>
                    <td scope="row"><input type="number" class="form-control addGodSpec" min='1990' max='2019'></td>
                    <td scope="row"><button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button></td>
                    <td scope="row"></td>

                </tr>
                <?php
                        $query=mysql_query('SELECT `spec`.`id`, `uch`.`nazv` as "uch", `spec`.`nazv`, `spec`.`nomer`, `spec`.`god` FROM `spec`,`uch` WHERE `spec`.`uch`=`uch`.`id`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td scope="row">'.$row['nazv'].'</td>
                    <td scope="row">'.$row['uch'].'</td>
                    <td scope="row">'.$row['nomer'].'</td>
                    <td scope="row">'.$row['god'].'</td>
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
            url: 'php/specAction.php',
            data: {
                name: $('.addSpecItemName').val(),
                uch: $('.uchList option:selected').attr('value'),
                numberSpec: $('.addNumberSpec').val(),
                god: $('.addGodSpec').val(),
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
            url: 'php/specAction.php',
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
            url: 'php/specAction.php',
            data: {
                id: $('.editTr>td:first').text(),
                name: $('.editTr .addSpecItemName').val(),
                uch: $('.editTr .uchList option:selected').attr('value'),
                numberSpec: $('.editTr .addNumberSpec').val(),
                god: $('.editTr .addGodSpec').val(),
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
