<?php
/** @var array $nots */
//echo '<pre>';
//var_dump($nots);
//die;
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i">
    <title>Senongram | Notifications</title>
    <link rel="icon" href="/files/static/favicon.ico">
    <style>
        <?php include "views/user/css/view_style.css"?>
        <?php include 'themes/dark/menu_style.css'?>
        <?php include 'index_style.css'?>
        <?php include 'themes/dark/bg/squares_style.css'?>
    </style>
</head>
<body>

<?php
include 'themes/dark/menu.php';
include 'themes/dark/bg/squares_bg.php';
?>

<div class="main-wrapper">
    <main>
        <div class="main card blur">
            <h1>Notifications</h1>

            <?php foreach ($nots as $not) : ?>
            <?php
                $class = 'message';
                if ($not['type'] == '2')
                    $class = 'like-not';
                elseif ($not['type'] == '3')
                    $class = 'subscribe';
            ?>
                <div class="Message <?=$class ?>" id="js-timer">
                    <div class="Message-icon">
                        <a href="/user/view/<?=$not['from_user']['username'] ?>">
                            <img src="/files/ava/<?=$not['from_user']['ava'] ?>">
                        </a>

                    </div>
                    <div class="Message-body">
                        <p class="header"><?=$not['header'] ?></p>
                        <?php if ($not['type'] != '1'):?>
                            <p class="u-italic"><?= $not['text'] ?></p>
                        <?php endif; ?>
                        <div class="not-time">
                            <?= $not['date'] ?>
                        </div>
                    </div>

                    <button onclick="fetch('http://senongram/notifications/delete/' + '<?=$not['notification_id'] ?>')" class="Message-close js-messageClose"><i class="fa fa-times"></i></button>

                </div>
            <?php endforeach; ?>
    </main>
</div>

<script>
    let not = document.querySelector('.notification');

    document.querySelectorAll('.js-messageClose').forEach(function (b) {

        b.addEventListener('click', function () {
            b.closest('.Message').classList.add('is-hidden');
            setTimeout(function () {
                b.parentElement.remove();
            }, 1500)

            let count = parseInt(not.getAttribute('data-count'));
            not.setAttribute('data-count', count - 1);

            if (count === 1)
                not.classList.remove('show-count');
        })
    })

    // document.querySelectorAll('.Message').forEach(function (not) {
    //     not.style.height = not.getBoundingClientRect().height + 'px';
    // })

</script>

</body>
</html>