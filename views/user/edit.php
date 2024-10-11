<?php
/** @var array $user */
/** @var array $errors */
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i|Roboto">
    <title>Senongram | Edit profile</title>
    <link rel="icon" href="/files/static/favicon.ico">
    <style>
        <?php include "views/user/css/view_style.css"?>
        <?php include 'themes/dark/menu_style.css'?>
        <?php include 'css/edit_style.css'?>
        <?php include 'themes/dark/bg/squares_style.css'?>
        <?php include 'views/user/posts/posts_styles.css' ?>
    </style>
</head>
<body>

<?php
include 'themes/dark/menu.php';
include 'themes/dark/bg/squares_bg.php';
?>

<div class="main-wrapper">
    <main>
        <form class="main card blur" action="" method="post" enctype="multipart/form-data">
            <h1>Edit profile</h1>
            <div class="line"></div>
            <h2>About:</h2>
            <textarea minlength="1" id="text" oninput="auto_grow(this)" class="neon" maxlength="255" name="about"><?=$user['about']?></textarea>
            <?php if (isset($errors['about'])): ?>
                <div class="toast toast--yellow add-margin">
                    <div class="toast__icon">
                        <i class="fa-solid fa-exclamation fa-xl"></i>
                    </div>

                    <div class="toast__content">
                        <p class="toast__type"><?=$errors['about']['header'] ?></p>
                        <p class="toast__message"><?=$errors['about']['text'] ?></p>
                    </div>
                    <div class="toast__close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642"
                             enable-background="new 0 0 15.642 15.642">
                            <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                        </svg>
                    </div>
                </div>
            <?php endif; ?>

            <div class="line"></div>

            <div class="drag-wrapper"
                 ondragover="drag_start(event, this)"
                 ondrop="drop(event, this)"
                 ondragleave="drag_leave(event, this)" >
                <h2>Avatar:</h2>
                <div class="edit-ava">
                    <div class="ava-input-wrapper">
                        <div class="file-upload-wrapper" data-text="Select your file!">
                            <input accept=".png, .jpg" name="ava" id="ava-inp" type="file" class="file-upload-field" value="">

                        </div>
                        <div class="txt">
                            or drop file here
                        </div>

                    </div>

                    <img src="/files/ava/<?=$user['ava'] ?>" id="ava-img">
                </div>
            </div>

            <?php if (isset($errors['ava'])): ?>
                <div class="toast toast--yellow add-margin">
                    <div class="toast__icon">
                        <i class="fa-solid fa-exclamation fa-xl"></i>
                    </div>

                    <div class="toast__content">
                        <p class="toast__type"><?=$errors['ava']['header'] ?></p>
                        <p class="toast__message"><?=$errors['ava']['text'] ?></p>
                    </div>
                    <div class="toast__close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642"
                             enable-background="new 0 0 15.642 15.642">
                            <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
            <div class="line"></div>
            <div class="drag-wrapper"
                 ondragover="drag_start(event, this)"
                 ondrop="drop(event, this)"
                 ondragleave="drag_leave(event, this)" >
            <h2>Banner:</h2>
                <img src="/files/ban/<?=$user['banner'] ?>" class="banner" id="ban-img">
                <div class="ban-inp-wrapper">
                    <div class="file-upload-wrapper" data-text="Select your file!">
                        <input accept=".png, .jpg" id="ban-inp" name="ban" type="file" class="file-upload-field" value="">
                    </div>
                    <div class="txt"> or drop file here</div>
                </div>
            </div>
            <?php if (isset($errors['ban'])): ?>
                <div class="toast toast--yellow add-margin">
                    <div class="toast__icon">
                        <i class="fa-solid fa-exclamation fa-xl"></i>
                    </div>

                    <div class="toast__content">
                        <p class="toast__type"><?=$errors['ban']['header'] ?></p>
                        <p class="toast__message"><?=$errors['ban']['text'] ?></p>
                    </div>
                    <div class="toast__close">
                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 15.642 15.642"
                             enable-background="new 0 0 15.642 15.642">
                            <path fill-rule="evenodd" d="M8.882,7.821l6.541-6.541c0.293-0.293,0.293-0.768,0-1.061  c-0.293-0.293-0.768-0.293-1.061,0L7.821,6.76L1.28,0.22c-0.293-0.293-0.768-0.293-1.061,0c-0.293,0.293-0.293,0.768,0,1.061  l6.541,6.541L0.22,14.362c-0.293,0.293-0.293,0.768,0,1.061c0.147,0.146,0.338,0.22,0.53,0.22s0.384-0.073,0.53-0.22l6.541-6.541  l6.541,6.541c0.147,0.146,0.338,0.22,0.53,0.22c0.192,0,0.384-0.073,0.53-0.22c0.293-0.293,0.293-0.768,0-1.061L8.882,7.821z"></path>
                        </svg>
                    </div>
                </div>
            <?php endif; ?>
            <div class="buts-wrapper">
                <a class="button" href="/user/logout/" >
                    <span>
                        Exit

                    </span>
                    <div class="icon">
                        <i class="fa-solid fa-right-from-bracket fa-xl"></i>
                    </div>
                </a>
                <button class="button green" type="submit" role="button">
                    <span>
                        save

                    </span>
                    <div class="icon">
                        <i class="fa-solid fa-floppy-disk fa-xl"></i>
                    </div>
                </button>
            </div>

        </form>
    </main>
</div>

<script>
    function auto_grow(element) {
        if (element.scrollHeight > 70) {
            element.style.height = "10px";
            element.style.height = (element.scrollHeight)+"px";
        } else {
            element.style.height = "70px";
        }

    }

    function set_img(inp, img) {
        let [ava] = inp.files;
        if (ava) {
            img.src = URL.createObjectURL(ava);
            inp.parentElement.dataset.text = ava.name;
            if (ava.name.length > 15)
                inp.parentElement.dataset.text = ava.name.substr(0, 15) + '...';
        }
    }

    let ava_inp = document.getElementById('ava-inp');
    ava_inp.onchange = function () {
        set_img(ava_inp, document.getElementById('ava-img'))
    }

    let ban_inp = document.getElementById('ban-inp');
    ban_inp.onchange = function () {
        set_img(ban_inp, document.getElementById('ban-img'))
    }

    document.querySelectorAll('.toast__close').forEach(function (b) {
        b.onclick = function () {
            let mes = b.parentElement;
            mes.style.maxHeight = mes.clientHeight + 'px';
            mes.classList.add('close_toast');
            setTimeout(function () {
                mes.remove();
            }, 500)
        }
    })

    function drag_start(e, el) {
        e.preventDefault();
        el.classList.add('drag');
    }

    function drag_leave(e, el) {
        el.classList.remove('drag');
    }

    function drop(ev, el) {
        ev.preventDefault();

        let inp = el.querySelector('input');
        inp.files = ev.dataTransfer.files;
        set_img(inp, el.querySelector('img'));
    }
    
    document.querySelectorAll('.drag-wrapper').forEach(function () {
        
    })

</script>
</body>
</html>