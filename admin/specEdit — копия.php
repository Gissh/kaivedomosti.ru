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


        <h2 class='p-3'>Добавление новой специальности</h2>
        <div class="form-group  mb-2">
            <label>Название</label>
            <input type="text" class="form-control addSpecItemName">
        </div>

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
            <label>Номер специальности</label>
            <input type="text" class="form-control addNumberSpec">
        </div>

        <div class="form-group  mb-2">
            <label>Год начала (1990-2019)</label>
            <input type="number" class="form-control addGodSpec" min='1990' max='2019'>
        </div>

        <button type="button" class='btn btn-success btnAddMenuItem'>Добавить</button>


        <h2 class='mt-5'>Редактирование специальностей</h2>




        <table class="table shadow-sm">
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
    </div>
</body>

<script>
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
                $('.tbodySpecTable').append('<tr><th scope="row">' + data + '</th><td>' + $('.addSpecItemName').val() + '</td><td>' + $('.uchList option:selected').text() + '</td><td>' + $('.addNumberSpec').val() + '</td><td>' +
                    $('.addGodSpec').val() + '</td><td><button type = "button" class = "btn btn-success editMenuLi">Редактировать</button></td><td ><button type = "button" class = "btn btn-danger deleteMenuItem" data-id =' + data + '>Удалить</button></td> </tr>');
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
            }
        });
    });

</script>

</html>
