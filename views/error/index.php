<?php
/** @var TYPE_NAME $error */
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i">
    <link rel="icon" href="/files/static/favicon.ico">

    <title>Senongram | Error <?= $error?></title>
    <style>
        <?php include 'index_style.css'?>
        <?php include 'themes/dark/menu_style.css'?>
    </style>
</head>

<body>

<?php include 'themes/dark/menu.php'?>

<div class="wrapper">
    <h1 class="hero-title" id="backfont"> <?= $error?></h1>

    <img src="/files/static/st_small_507x507-pad_600x600_f8f8f8__9_-removebg-preview.png">
</div>



</body>

<script>
    setTimeout(function () {
        document.getElementById('backfont').style.animation = "colorrr 10s infinite";
    }, 1100);
</script>

</html>