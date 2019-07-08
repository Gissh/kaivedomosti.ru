<?php 

require_once('../php/connect.php');

$query=mysql_query('SELECT `student`.`fam`,`student`.`name`,`student`.`otch` FROM `objasn`,`student` WHERE `objasn`.`student_id`=`student`.`id` AND `objasn`.`link`='.$_GET['link']);

if(mysql_num_rows($query)!=1){
    header("Location: login.php");
}else{
    $rowName=mysql_fetch_assoc($query);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Объяснительная</title>

    <link rel="stylesheet" href='../css/bootstrap.min.css'>

    <script src="../js/jquery-3.3.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <link rel='stylesheet' href="../css/main.css">


</head>

<body>
    <?php require_once('../php/base.php'); ?>
    <div class="container shadow-sm">


        <h3 class='pt-3'>
            <?php echo 'Студент: '.$rowName['fam'].' '.$rowName['name'].' '.$rowName['otch']; ?>
        </h3>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Текст объяснительной</label>
            <textarea class="form-control objasnText" rows="3"></textarea>
        </div>


        <button type="button" class='btn btn-success saveObj mb-2' data-objasn='<?php echo $_GET["link"] ?>'>Отправить</button>

        <div class="alert alert-danger" role="alert">
            После отправки объяснительной, данная ссылка будет больше не доступна!
        </div>
        <br>
        <?php
    mysql_close($link);
    ?>
    </div>
</body>

<script>
    $('.saveObj').click(function() {

        var link = $(this).attr('data-objasn');

        $.ajax({
            type: "post",
            url: "../php/enterObjasn.php",
            data: {
                link: link,
                text: $('.objasnText').val()
            },
            success: function(data) {
                console.log(data);
            }
        });
    });

</script>

</html>
