let page = 0;
let user_id = document.getElementById('user-id').dataset.userid;
let fl = true;
let work = false;

function getPosts() {
    if (!fl || work)
        return;
    let data = new FormData();
    data.append('user_id', user_id);
    data.append('page', page);
    work = true;
    fetch('http://senongram/post/get/', {
        method: 'POST',
        body: data
    }).then(function (res) {
        return res.json();
    }).then(function (data) {
        // console.log(data);
        // work = false;
        // return;
        if (data.length === 0) {
            fl = false;
        }
        for (let post of data) {
            document.querySelector('#posts').innerHTML += `
            <div class="line"></div>
            <div class="post" data-id="${post.post_id}">
                <div class="post-wrapper">
                    <button onclick="setLike(${post.post_id})" id="id${post.post_id}" class="like ${post.liked? 'active' : ''}">
                        <div class="icon">
                            <svg class="prime" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                      d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z">
                                </path>
                            </svg>
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                      d="M462.3 62.6C407.5 15.9 326 24.3 275.7 76.2L256 96.5l-19.7-20.3C186.1 24.3 104.5 15.9 49.7 62.6c-62.8 53.6-66.1 149.8-9.9 207.9l193.5 199.8c12.5 12.9 32.8 12.9 45.3 0l193.5-199.8c56.3-58.1 53-154.3-9.8-207.9z">
                                </path>
                            </svg>
                        </div>
                        <div class="counter">${post.likes}</div>
                    </button>
                    <div class="post-main not-blur">
                        <div class="post-text">
                            ${post.text}
                        </div>
                        <div class="post-time" data-time="${post.date}" data-edited="${post.edited}">
                            ${post.short_time}
                        </div>
                    </div>
                    <a class="post-author" href="/user/view/${post.user.username}">
                        <img src="/files/ava/${post.user.ava}" alt="ava">
                    </a>
                </div>
            </div>`

        }
        page += 1;
        if (typeof contMenu !== typeof undefined)
            contMenu.update();
        work = false;
        update_all_times();
    })
}

getPosts();

let main = document.querySelector('.main-wrapper');
main.onscroll = function () {
    if (main.scrollTop + main.clientHeight > main.scrollHeight - 100) {
        getPosts();
    }
};

function update_time(mes) {
    let time = new Date() - new Date(mes.dataset.time) + 1000 * 60 * 60;
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
    if (mes.dataset.edited === '1')
        text = '(edited) ' + text;
    mes.innerHTML = text;

}

function update_all_times() {
    document.querySelectorAll('.post-time').forEach(update_time);
}

