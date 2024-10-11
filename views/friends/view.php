<?php
/** @var array $user */
/** @var string $temp_user */
/** @var string $type */

$temp_username = \models\User::getUserById($temp_user)['username'];

if ($temp_username == $user['username'])
    $title = "Your ";
else
    $title = $temp_username . ' ';

if ($type == 'all')
    $title .= 'friends';
else
    $title .= $type;

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i">
    <title>Senongram | <?= $title ?></title>
    <link rel="icon" href="/files/static/favicon.ico">
    <style>
        <?php include "views/user/css/view_style.css"?>
        <?php include 'themes/dark/menu_style.css'?>
        <?php include 'view_style.css'?>
        <?php include 'themes/dark/bg/squares_style.css'?>
    </style>
</head>
<body>

<?php
include 'themes/dark/menu.php';
include 'themes/dark/bg/squares_bg.php'
?>

<div class="main-wrapper">
    <main>
        <div class="main card blur">
            <h1><?=$title ?></h1>
            <div class="inputs">
                <div class="form__group field">
                    <input autocomplete="off" type="input" class="form__field" placeholder="Name" name="find" id='find' required />
                    <label for="name" class="form__label">Username</label>
                </div>
                <div class="only-fans">
                    <div class="switch">
                        <input type="checkbox" id="switch" class="toggle" <?= $type == 'all'? 'checked' : '' ?> /><label for="switch">Toggle</label>

                    </div>
                    <span>
                        Only Friends
                    </span>

                </div>

                <button type="submit" class="searchButton">
                    <i class="fa fa-search fa-2xl"></i>
                </button>
            </div>
            <div class="friends">


            </div>
    </main>
</div>

<script>
    let settings = {
        user : '<?=$temp_user ?>',
        only_friends : <?= $type == 'all'? 'true' : 'false' ?>,
        find: '',
        type: '<?=$type ?>'
    }

    let friends = document.querySelector('.friends');

    get_users();

    function get_users() {
        //console.log(`http://senongram/friends/view_json/?type=${settings.type}&user_id=${settings.user}&find=${settings.find}&only_friends=${+settings.only_friends}`)
        fetch(`http://senongram/friends/view_json/?type=${settings.type}&user_id=${settings.user}&find=${settings.find}&only_friends=${+settings.only_friends}`)
            .then((response) => {
               return response.json();
            }).then(function (data) {
                friends.innerHTML = '';
                data.forEach(function (friend) {
                    let fr = document.createElement('div');
                    fr.classList.add('friend');
                    fr.innerHTML = `
                        <div class="ava">
                            <img src="/files/ava/${friend.ava}">
                        </div>
                        <div class="info2">
                            <h2>${friend.username}</h2>
                            <div class="stats">
                                <span><strong>Followers: </strong> ${friend.followers}</span>
                                <span><strong>Following: </strong> ${friend.following}</span>
                                <span><strong>Likes: </strong> ${friend.likes}</span>
                            </div>
                        </div>
                        <div class="cool-btn">
                            <div>
                                <a href="/user/view/${friend.username}">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                    <span class="arrow">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </span>
                                </a>

                            </div>
                        </div>`;
                    friends.appendChild(fr);
                });
        })
    }

    document.querySelector('.searchButton').onclick = function () {
        settings.find = document.querySelector('#find').value;
        settings.only_friends = document.querySelector('#switch').checked;
        get_users();
    }
</script>

</body>
</html>