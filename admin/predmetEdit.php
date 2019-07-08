<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Управление предметами</title>

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



    <div class="container shadow-sm mt-5">

        <h1 class='text-center p-3'>Управление предметами</h1>

        <table class="table shadow-sm">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">id</th>
                    <th scope="col">Название</th>
                    <th scope="col">Учебное заведение</th>
                    <th scope="col">Год начала</th>
                    <th scope="col">Редактировать</th>
                    <th scope="col">Удалить</th>
                </tr>
            </thead>
            <tbody class='tbodyPredmetTable'>
                <tr>
                    <td scope="row"></td>
                    <td scope="row"><input type="text" class="form-control addPredmetItemName"></td>
                    <td scope="row"><select class='custom-select uchList'>
                            <?php
                        $query=mysql_query('SELECT * FROM `uch`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<option value='.$row['id'].'>'.$row['nazv'].'</option>';
                        }
                        ?>
                        </select></td>
                    <td scope="row"><input type="number" class="form-control addGodSpec" min='1990' max='2019'></td>
                    <td scope="row"><button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button></td>

                </tr>
                <?php
                        $query=mysql_query('SELECT `predmet`.`id`, `uch`.`nazv` as "uch", `predmet`.`nazv`, `predmet`.`god` FROM `predmet`,`uch` WHERE `predmet`.`uch`=`uch`.`id`');
                        while($row=mysql_fetch_assoc($query)){
                            echo '<tr>
                    <th scope="row">'.$row['id'].'</th>
                    <td scope="row">'.$row['nazv'].'</td>
                    <td scope="row">'.$row['uch'].'</td>
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
    </div>
</body>

<script>
    $('.btnAddMenuItem').click(function() {
        $.ajax({
            type: 'post',
            url: 'php/predmetAction.php',
            data: {
                name: $('.addPredmetItemName').val(),
                uch: $('.uchList option:selected').attr('value'),
                god: $('.addGodSpec').val(),
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
            url: 'php/predmetAction.php',
            data: {
                id: $(this).attr('data-id'),
                method: 'delete'
            },
            success: function(data) {
                $(this).parent().parent().remove();
            }
        });
    });

</script>

</html>
