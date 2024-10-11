<?php
/** @var array $user */
/** @var array $chats */
/** @var array $selected_chat */

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i">
    <link rel="icon" href="/files/static/favicon.ico">
    <title>Senongram | Messanger</title>
    <link rel="icon" href="/files/static/favicon.ico">
    <style>
        <?php include "themes/dark/menu_style.css"?>
        <?php include "view_style.css"?>
        <?php include "themes/dark/bg/squares_style.css"?>
        <?php include "context_menu.css" ?>
    </style>
</head>
<body>


<?php
include 'themes/dark/menu.php';
include 'themes/dark/bg/squares_bg.php';
?>

<main>
    <div class="chats not-blur">


    </div>
    <div class="messenger blur">
        <?php if ($selected_chat): ?>
        <div class="messages">
            <div class="overflow-container">
                <div class="container" id="messages">

                    <?php foreach ($selected_chat['messages'] as $message): ?>
                        <?php if ($message['user_id'] == $user['user_id']) : ?>
                            <div class="right" data-id="<?=$message['message_id'] ?>">
                                <div class="message-orange">
                                    <p class="message-content"><?=$message['text'] ?></p>
                                    <div class="message-timestamp" data-edited="<?=$message['edited']?>" data-time="<?=$message['date'] ?>"><?=$message['short_date'] ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="left" data-id="<?=$message['message_id'] ?>">
                                <div class="message-blue">
                                    <p class="message-content"><?=$message['text'] ?></p>
                                    <div class="message-timestamp" data-edited="<?=$message['edited']?>" data-time="<?=$message['date'] ?>"><?=$message['short_date'] ?></div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <div style="display: none; visibility: hidden" data-id="0"></div>

                </div>
            </div>

            <div class="new-message">
                <textarea id="text" maxlength="500" oninput="auto_grow(this)" placeholder="Type your text"></textarea>
                <button class="send-but" onclick="send_message()">
                    <p class="text">Send</p>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
    <path id="paper-plane-icon" d="M462,54.955L355.371,437.187l-135.92-128.842L353.388,167l-179.53,124.074L50,260.973L462,54.955z
M202.992,332.528v124.517l58.738-67.927L202.992,332.528z"></path>
  </svg>
                </button>
            </div>
        </div>

            <div class="user" id="user" data-userid="<?=$selected_chat['user']['user_id'] ?>">
                <div class="info gradient-border" id="info">

                    <section>
                        <h1><?=$selected_chat['user']['username'] ?></h1>
                        <img class="ava" src="/files/ava/<?=$selected_chat['user']['ava'] ?>">
                        <div class="user-link">
                            <a href="/user/view/<?=$selected_chat['user']['username']?>">Profile</a>
                            <div class="icon">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 268.832 268.832">
                                    <path d="M265.17 125.577l-80-80c-4.88-4.88-12.796-4.88-17.677 0-4.882 4.882-4.882 12.796 0 17.678l58.66 58.66H12.5c-6.903 0-12.5 5.598-12.5 12.5 0 6.903 5.597 12.5 12.5 12.5h213.654l-58.66 58.662c-4.88 4.882-4.88 12.796 0 17.678 2.44 2.44 5.64 3.66 8.84 3.66s6.398-1.22 8.84-3.66l79.997-80c4.883-4.882 4.883-12.796 0-17.678z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="decr">
                            <strong>About: </strong>
                            <?=$selected_chat['user']['about'] ?>
                        </div>
                        <div class="info-grid">
                            <strong>Followers:</strong>
                            <a id="followers" href="http://senongram/friends/view/<?=$selected_chat['user']['username']?>/followers"><?=$selected_chat['user']['followers']?></a>
                            <strong>Following:</strong>
                            <a href="http://senongram/friends/view/<?=$selected_chat['user']['username']?>/following"><?=$selected_chat['user']['following']?></a>
                            <strong>Likes:</strong>
                            <span id="likes"><?=$selected_chat['user']['likes']?></span>
                        </div>
                    </section>


                </div>
            </div>
        <?php else: ?>
            <div class="select-chat">
                <span>
                    Select chat...
                </span>
            </div>
        <?php endif; ?>
        </div>
</main>

<script>

    let but = document.querySelector('.send-but');
    let textarea = document.querySelector('textarea');
    <?php if ($selected_chat): ?>
        let user2_id = document.getElementById('user').dataset.userid;
    <?php endif; ?>


    function send_message() {
        let text = textarea.value;

        if (text.length == 0)
            return;

        but.classList.add('clicked');
        but.querySelector('.text').innerText = 'Sent!';

        setTimeout(function () {
            but.classList.remove('clicked');
            but.querySelector('.text').innerText = 'Send';
        }, 5000);


        textarea.value = '';

        let data = new FormData();
        data.append('text', text);
        data.append('user2_id', document.querySelector('#user').dataset.userid);

        //testFetch('http://senongram/messages/send', data);
        fetch('http://senongram/messages/send', {
            method: 'POST',
            body: data
        });
    }

    function testFetch(link, data) {
        fetch(link, {
            method: 'POST',
            body: data
        }).then(function (res) {
            return res.text();
        }).then(function (data) {
            console.log(data);
        });
    }

    let chats = document.querySelector('.chats');
    let messenger = document.querySelector('.messenger');

    ['mouseenter', 'mouseleave'].forEach(function (event) {
        chats.addEventListener(event, function () {
            messenger.classList.toggle('skewed');
        });
    })

    function auto_grow(element) {
        if (element.scrollHeight > 70) {
            if (element.scrollHeight > 250) {
                element.style.height = "250px";
                return;
            }
            element.style.height = "10px";
            element.style.height = (element.scrollHeight)+"px";
            if (element.scrollHeight < 70)
                auto_grow(element);
        } else {
            element.style.height = "70px";
        }
        element.parentElement.style.height = (element.scrollHeight + 20)+"px";
    }

    function post_enter(e) {
        if (but.classList.contains('clicked')) {
            but.classList.remove('clicked');
            but.querySelector('.text').innerText = 'Send';
        }
        if (e.key === 'Enter') {
            e.preventDefault();
            if (textarea.value.trim() !== '') {
                if (textarea.dataset.type === 'update')
                    edit_message();
                else
                    send_message();
            }

        }

    }
    textarea.onkeydown = post_enter;
    let messages_container = document.querySelector('.messages');

    let page = 1;

    messages_container.onscroll = function paging() {
        if (-messages_container.scrollTop + messages_container.clientHeight > messages_container.scrollHeight - 200) {
            let data = new FormData();
            data.append('page', page);
            data.append('user2_id', user2_id);
            messages_container.onscroll = function () {
            }
            let save_scroll_top = messages_container.scrollTop;
            fetch('http://senongram/messages/get/', {
                method: 'POST',
                body: data
            }).then(function (res) {
                return res.json();
            }).then(function (data) {
                if (data.length !== 0) {
                    messages_container.onscroll = paging;
                }
                for (let mes of data) {
                    let clas = {
                        wrapper: 'right',
                        color: 'orange'
                    };
                    if (+mes.user_id === +user2_id)
                        clas = {
                            wrapper: 'left',
                            color: 'blue'
                        }
                    document.querySelector('#messages').innerHTML += `
                    <div class="${clas.wrapper}" data-id="${mes.message_id}">
                            <div class="message-${clas.color}">
                                <p class="message-content">${mes.text}</p>
                                <div class="message-timestamp" data-edited="${mes.updated}" data-time="${mes.date}"></div>
                            </div>
                        </div>`
                    messages_container.scrollTop = save_scroll_top;
                }
                update_all_times();
                contMenu.update();
                page++;
            })
        }

    }

    function check_messages() {
        let last = document.getElementById('messages').firstElementChild.dataset.id;
        let data = new FormData();
        data.append('user2_id', user2_id);
        data.append('message_id', last);

        fetch('http://senongram/messages/getnew/', {
            method: 'POST',
            body: data
        }).then(function (res) {
            return res.json();
        }).then(function (data) {
            if (document.getElementById('messages').firstElementChild.dataset.id !== last)
                return;
            for (let mes  of data) {
                console.log(mes);
                let clas = {
                    wrapper: 'right',
                    color: 'orange'
                };
                if (+mes.user_id === +user2_id)
                    clas = {
                        wrapper: 'left',
                        color: 'blue'
                    }
                document.querySelector('#messages').innerHTML = `
                    <div class="${clas.wrapper}" data-id="${mes.message_id}">
                            <div class="message-${clas.color}">
                                <p class="message-content">${mes.text}</p>
                                <div class="message-timestamp" data-edited="${mes.edited}" data-time="${mes.date}">${mes.short_date}</div>
                            </div>
                        </div>` + document.querySelector('#messages').innerHTML;

            }
            if (data.length !== 0) {
                update_all_times();
                contMenu.update();
            }
        })
    }

    setInterval(check_messages, 100);

    function update_time(mes) {
        let time = new Date() - new Date(mes.querySelector('.message-timestamp').dataset.time) + 1000 * 60 * 60;
        time /= 1000;
        let text = '';
        if (time >= 60 * 60 * 24 * 365)
            text = Math.floor(time / (60 * 60 * 24 * 365)) + ' year';
        else if (time >= 60 * 60 * 24)
            text = Math.floor(time / (60 * 60 * 24)) + ' day';
        else if (time >= 60 * 60) {
            text = Math.floor(time / (60 * 60)) + ' hour';
            setTimeout(() => {update_time(mes)}, 1000 * 60 * 60);
        }
        else if (time >= 60) {
            text = Math.floor(time / 60) + ' minute';
            setTimeout(() => {update_time(mes)}, 1000 * 60);
        }
        else {
            text = Math.floor(time) + ' second';
            setTimeout(() => {update_time(mes)}, 1000);
        }


        if (text[0] !== '1' || (time[1] >= '0' && time[1] <= '9'))
            text += 's';

        text += ' ago';
        if (mes.querySelector('.message-timestamp').dataset.edited === '1')
            text = '(edited) ' + text;
        mes.querySelector('.message-timestamp').innerHTML = text;

    }

    function update_all_times() {
        document.querySelectorAll('.left').forEach(update_time);
        document.querySelectorAll('.right').forEach(update_time);
    }

    update_all_times();


</script>

<script>
    <?php include "context_menu_class.js" ?>
    <?php include "context_menu.js"; ?>
    <?php include "chats.js" ?>
    setInterval(check_chats, 100);
</script>

</body>
</html>