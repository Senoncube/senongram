<?php
$module = \core\Core::getInstance()->arr['moduleName'];
/** @var array $user */
?>

<header class="s-header">
    <a href="/home/" class="checked">
        <span class="gradient-text">Senongram</span>
    </a>
    <nav>
        <a href="/notifications/" <?= $module == 'notifications'? 'class="checked"' : '' ?>>
                <span class="notification"
                    <?php if ($user['notifications'] != '0') :?>
                        data-count="<?=intval($user['notifications']) - 1?>"
                    <?php endif; ?>
                ></span>
        </a>

        <a href="/home/" <?= $module == 'home'? 'class="checked"' : '' ?>>
                <span>
                    <i class="fa-solid fa-house"></i>
                </span>
        </a>
        <a href="/friends/view/" <?= $module == 'friends'? 'class="checked"' : '' ?>>
                <span>
                    <i class="fa-solid fa-user-group"></i>
                </span>
        </a>
        <a href="/messages/view/" <?= $module == 'messages'? 'class="checked"' : '' ?>>
                <span>
                    <i class="fa-solid fa-message"></i>
                </span>
        </a>
        <a href="/user/view/" <?= $module == 'user'? 'class="checked"' : '' ?>>
                <span>
                    <i class="fa-solid fa-user"></i>
                </span>
        </a>
    </nav>
</header>

<script>
    let el = document.querySelector('.notification');

    function notification() {
        let count = Number(el.getAttribute('data-count')) || 0;
        el.setAttribute('data-count', count + 1);
        el.classList.remove('notify');
        el.offsetWidth = el.offsetWidth;
        el.classList.add('notify');
        el.classList.add('show-count');
    }

    if (el.getAttribute('data-count') !== null) {
        notification();
    }

    function check_notifications() {
        fetch('http://senongram/notifications/get').then(function (res) {
            if (res.status === 200)
                return res.text();
        }).then(function (data) {
            if (el.dataset.count !== data) {
                if (data === '0') {
                    el.dataset.count = 0;
                    el.classList.remove('show-count');
                } else {
                    el.dataset.count = +data - 1;
                    notification();
                }

            }

        });
    }

    setInterval(check_notifications, 100);

</script>

<script src="https://kit.fontawesome.com/46d9990b5b.js" crossorigin="anonymous"></script>