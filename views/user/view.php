<?php
/** @var array $view_user */
/** @var array $user */
/** @var array $posts */
/** @var bool $isSubs */
/** @var bool $isFollow */
/** @var bool $isChat */
/** @var bool $isAdmin */

$isMain = $user == $view_user;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i">
    <title>Senongram | <?=$user['username'] ?></title>
    <link rel="icon" href="/files/static/favicon.ico">
    <style>
        <?php include "css/view_style.css"?>
        <?php include 'themes/dark/menu_style.css'?>
        <?php include 'themes/dark/bg/squares_style.css'?>
        <?php include 'views/user/posts/posts_styles.css'?>
        <?php include 'views/messages/context_menu.css'?>
    </style>
</head>
<body>

<?php
include 'themes/dark/menu.php';
include "themes/dark/bg/squares_bg.php";
?>

<div class="hide" id="user-id" data-userid="<?=$view_user['user_id']?>"></div>

<div class="main-wrapper">
    <main>
        <div class="card main blur">
            <div class="head">
                <img class="banner" src="/files/ban/<?=$view_user['banner']?>">
                <h1 class="text-3d"><?=$view_user['username']?></h1>


            </div>
            <div class="info gradient-border" id="info">
                <section>
                    <img class="ava" src="/files/ava/<?=$view_user['ava']?>">

                        <?php if ($isMain): ?>
                            <div class="follow edit">
                                <button onclick="document.location.href = '/user/edit/'" class="edit-btn">
                                    <p id="btnText">Edit</p>
                                    <div class="checked">
                                        <i class="fa-solid fa-pen fa-xl"></i>
                                    </div>
                                </button>
                            </div>
                        <?php else: ?>
                            <div class="follow">
                                <button onclick="subscribe(<?=$view_user['user_id'] ?>)" id="btn" <?= $isSubs? 'class="active"': '' ?>>
                                    <p id="btnText"><?= $isSubs? 'Subscribed': 'Follow' ?></p>
                                    <div class="checked">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                                            <path fill="transparent" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path>
                                        </svg>
                                    </div>
                                </button>
                            </div>
                        <?php endif; ?>


                    <div class="decr">
                        <strong>About: </strong>
                        <?= $view_user['about'] ?>
                    </div>
                    <div class="info-grid">
                        <strong>Followers:</strong>
                        <a id="followers" href="http://senongram/friends/view/<?=$view_user['username']?>/followers"><?=$view_user['followers']?></a>
                        <strong>Following:</strong>
                        <a href="http://senongram/friends/view/<?=$view_user['username']?>/following"><?=$view_user['following']?></a>
                        <strong>Likes:</strong>
                        <span id="likes"><?=$view_user['likes']?></span>
                    </div>
                </section>


            </div>

            <div class="posts" id="posts">
                <?php if ($isAdmin && !$isMain): ?>
                    <a href="/user/admin/<?=$view_user['username']?>" id="messanger-link" class="plus red">
                        <i class="fa-solid fa-screwdriver-wrench"></i>
                    </a>
                <?php elseif ($isChat): ?>
                    <a href="/messages/view/<?=$view_user['username']?>" id="messanger-link" class="plus blue">
                        <i class="fa-solid fa-comments"></i>
                    </a>
                <?php endif; ?>
                <h1 style="text-align: center">Posts</h1>
                <?php if ($isMain): ?>
                    <form class="new-post" method="post" action="/post/new">
                        <textarea minlength="1" onkeydown="post_enter(event)" id="text" oninput="auto_grow(this)" class="neon" maxlength="255" name="text"></textarea>

                        <div class="upload" onclick="form_submit()">
                            <a type="submit">
                                <i class="fa-solid fa-arrow-up-from-bracket fa-2xl"></i>
                            </a>
                        </div>
                    </form>
                <?php endif; ?>


<!--                //= include "posts/posts.php"-->
            </div>
        </div>


    </main>
</div>
    <script>
        document.querySelectorAll('.s-header a').forEach(function (a) {
            a.onclick = function () {
                document.querySelectorAll('.s-header nav a').forEach(function (t) {
                    if (t !== a)
                        t.classList.remove('checked');
                })
                a.classList.toggle('checked');
            }
        })

        <?php if (!$isMain) : ?>

        let btn = document.getElementById("btn");
        let btnText = document.getElementById("btnText");
        let followers = document.getElementById('followers');

        btn.addEventListener('click', function() {

            btnText.innerHTML = btnText.innerHTML === 'Follow'? "Subscribed" : btnText.innerHTML !== "edit" ? "Follow" : "Edit";
            btn.classList.toggle("active");

            if (btnText.innerHTML === "Subscribed")
                followers.innerHTML = parseInt(followers.innerHTML) + 1;
            else
                followers.innerHTML = parseInt(followers.innerHTML) - 1;
        })
        <?php endif; ?>



        function subscribe(user_id) {

            if (document.getElementById('btn').classList.contains('active')) {
                fetch('http://senongram/friends/unsubscribe/' + user_id);
            } else {
                fetch('http://senongram/friends/subscribe/' + user_id).then(function (res) {
                    return res.text();
                }).then(function (data) {
                    console.log(data);
                });
            }
        }

        function auto_grow(element) {
            if (element.scrollHeight > 70) {
                element.style.height = "10px";
                element.style.height = (element.scrollHeight)+"px";
            } else {
                element.style.height = "70px";
            }

        }

        function form_submit() {
            document.querySelector('form').submit();
        }

        function post_enter(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                form_submit();
            }

        }

        <?php
            if ($isMain)
                include 'posts/posts_edit.js';
        ?>
    </script>

<?php if ($isMain): ?>
    <script>
        <?php include 'views/messages/context_menu_class.js' ?>
        const contMenu = new ContextMenu({
            target: '.post-main',
            menuItems: [
                {
                    content: `${copyIcon}Copy`,
                    events: {
                        click() {
                            document.querySelector('textarea').value = contMenu.currentTarget.querySelector('.post-text').innerHTML.trim();
                            document.querySelector('.main-wrapper').scrollTop = 100;
                        }
                    }
                },
                {
                    content: `${editIcon}Edit`,
                    events: {
                        click() {
                            edit_post(contMenu.currentTarget);
                        }
                    }
                },
                {
                    content: `${deleteIcon}Delete`,
                    divider: 'top',
                    events: {
                        click() {
                            post = contMenu.currentTarget.closest('.post');
                            del();
                        }
                    }
                }
            ]
        });
        contMenu.init();
    </script>
<?php endif; ?>

<script>
    <?php include 'posts/async_posts.js'?>
    <?php include 'posts/likes.js' ?>
</script>
</body>
</html>