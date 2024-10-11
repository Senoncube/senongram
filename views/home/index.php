<?php
/** @var array $user */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i">
    <title>Senongram | Home</title>
    <link rel="icon" href="/files/static/favicon.ico">
    <style>
        <?php include "views/user/css/view_style.css"?>
        <?php include 'themes/dark/menu_style.css'?>
        <?php include 'index_style.css'?>
        <?php include 'themes/dark/bg/squares_style.css'?>
        <?php include 'views/user/posts/posts_styles.css' ?>
    </style>
</head>
<body>

<?php
include 'themes/dark/menu.php';
include 'themes/dark/bg/squares_bg.php';
?>

<div class="hide" id="user-id" data-userid=""></div>

<div class="main-wrapper">
    <main>
        <div class="main card blur" id="posts">
            <h1>Last posts of your follows</h1>
<!--            --><?php //include "views/user/posts/posts.php"?>
        </div>
    </main>
</div>

<script>
    <?php include 'views/user/posts/async_posts.js'?>
    <?php include 'views/user/posts/likes.js'?>
</script>

</body>
</html>