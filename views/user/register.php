<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway|Poppins:900i">
    <link rel="icon" href="/files/static/favicon.ico">
    <style>
        <?php include "css/login_style.css" ?>
        <?php include "themes/dark/bg/squares_style.css" ?>
        .login .card {
            height: 80% !important;
        }
    </style>
    <title>Senongram | Register</title>
</head>
<body>

<?php
/** @var array $errors */
/** @var array $model */
core\Core::getInstance()->pageParams['title'] = 'Login';
if (!isset($model))
    $model = [
        'username' => ''
    ];


if (!isset($errors))
    $errors = [
        'username' => '',
        'password' => '',
        'password2' => ''
    ];
$arr = ['username', 'password', 'password2'];
foreach ($arr as $t)
    if (!isset($errors[$t]))
        $errors[$t] = '';
?>

<?php
include "themes/dark/bg/squares_bg.php";
?>

<div class="login">
    <div class="card">
        <div class="h1">
            <h1>Sign In to <span class="gradient-text">Senongram</span></h1>
        </div>
        <main>

            <form method="post" action="">
                <section>
                    <h2>Sign In to start</h2>
                </section>
                <section class="big">
                    <div class="inp-wrapper">
                        <div class="cool-input">
                            <input autocomplete="off" class="user" type="text" name="username" id="username" placeholder="Login" value="<?=$model['username']?>">
                            <span></span>
                        </div>

                        <div class="hint" id="username_hint" style="display: none">
                            Username or password is incorrect
                        </div>
                    </div>


                    <div class="inp-wrapper">
                        <div class="cool-input">
                            <input class="password" type="password" name="password" id="password" placeholder="Password">
                            <span></span>
                        </div>
                        <div class="hint" id="password_hint" style="display: none">
                            Username or password is incorrect
                        </div>
                    </div>

                    <div class="inp-wrapper">
                        <div class="cool-input">
                            <input class="password2" type="password" name="password2" id="password2" placeholder="Repeat password">
                            <span></span>
                        </div>
                        <div class="hint" id="password_hint2" style="display: none">
                            Username or password is incorrect
                        </div>
                    </div>

                    <button class="cta bad">
                        <span>NEXT</span>
                        <span>
                              <svg width="66px" height="43px" viewBox="0 0 66 43" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                <g id="arrow" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                  <path class="one" d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                  <path class="two" d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z" fill="#FFFFFF"></path>
                                  <path class="three" d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z" fill="#FFFFFF"></path>
                                </g>
                              </svg>
                            </span>
                    </button>
                    <!--                    <button>-->
                    <!--                        GET STARTED-->
                    <!--                        <span class="skobki">-->
                    <!--                            <span class="first">></span>-->
                    <!--                            <span class="second">></span>-->
                    <!--                            <span class="third">></span>-->
                    <!--                        </span>-->
                    <!---->
                    <!--                    </button>-->
                    <a href="/user/login" class="link">Already have an account?</a>
                </section>
            </form>
            <div class="second-part">
                <img src="/files/static/hayasak_remove_bg.png">
                <!--            <img src="https://wallpapersmug.com/download/3840x2160/6d3c26/dark-minimal-mountains.png">-->

            </div>

        </main>
    </div>

</div>

<script>
    let cta = document.querySelector('.cta');
    let username_hint = document.querySelector('#username_hint');
    let password_hint = document.querySelector('#password_hint');
    let username_inp = document.querySelector('#username');
    let password_inp = document.querySelector('#password');
    let password2_inp = document.querySelector('#password2');
    let password2_hint = document.querySelector('#password_hint2');

    let errors = {
        username : "<?= $errors['username']?>",
        password : '<?= $errors['password']?>',
        password2 : '<?= $errors['password2']?>'
    };

    check_inputs();

    document.querySelectorAll('input').forEach(function (inp) {
        inp.onfocus = function () {
            inp.nextElementSibling.classList.add('focus-gradient');
        };
        inp.oninput = function () {
            if (inp.value) {
                errors[inp.id] = '';
            }
            else {
                errors[inp.id] = 'This field can\'t be empty';
            }

            check_inputs();

        }
        inp.addEventListener('focusout', function () {
            inp.nextElementSibling.classList.remove('focus-gradient');
        });
    });



    cta.addEventListener('click', function (e) {
        if (cta.classList.contains('bad')) {
            e.preventDefault();
            console.log('aboba');
            cta.classList.add('shake');
            cta.addEventListener('animationend', function () {
                cta.classList.remove('shake');
            });
        }
    })

    function check_inputs() {
        let arr = [{input: username_inp, hint: username_hint, error: errors.username},
            {input: password_inp, hint: password_hint, error: errors.password},
            {input: password2_inp, hint: password2_hint, error: errors.password2}];
        let fl = true;
        for (let inp of arr) {
            if (!inp.input.value)
                fl = false;
            if (inp.error) {
                fl = false;
                inp.input.parentElement.classList.add('wrong-input');
                inp.hint.style.display = 'block';
                inp.hint.innerText = inp.error;
            } else {
                inp.input.parentElement.classList.remove('wrong-input');
                inp.hint.style.display = 'none';
            }
        }

        if (fl) {
            cta.classList.remove('bad');
            cta.classList.add('good');
        } else {
            cta.classList.remove('good');
            cta.classList.add('bad');
        }
    }
</script>

</body>
</html>