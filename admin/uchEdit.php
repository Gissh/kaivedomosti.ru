<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление учебными заведениями</title>

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

        <h2 class='pt-5'>Редактирование учебных заведений</h2>




        <table class="table shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Название</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody class='tbodyUchTable'>

                <tr>
                    <td></td>
                    <td><input type="text" class="form-control addUchItemName"></td>
                    <td><button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button></td>
                    <td></td>
                </tr>

                <?php
                        $query=mysql_query('SELECT * FROM `uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td>'.$row['nazv'].'</td>
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
            url: 'php/uchAction.php',
            data: {
                name: $('.addUchItemName').val(),
                method: 'add'
            },
            success: function(data) {
                $('.tbodyUchTable').append('<tr><th scope="row">' + data + '</th><td>' + $('.addUchItemName').val() + '</td><td><button type = "button" class = "btn btn-success editMenuLi">Редактировать</button></td><td ><button type = "button" class = "btn btn-danger deleteMenuItem" data-id =' + data + '>Удалить</button></td> </tr>');
            }
        });
    });

    $('.deleteMenuItem').click(function() {
        $(this).parent().parent().remove();

        $.ajax({
            type: 'post',
            url: 'php/uchAction.php',
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
            url: 'php/uchAction.php',
            data: {
                id: $('.editTr>td:first').text(),
                name: $('.editTr .addUchItemName').val(),
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
