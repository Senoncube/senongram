let json_chats = "{}";

function check_chats() {
    fetch('http://senongram/messages/getchats').then(function (res) {
        return res.json();
    }).then(function (data) {
        if (JSON.stringify(data) !== json_chats) {
            let temp = JSON.parse(json_chats);
            let chats_time = document.querySelectorAll('.chat-time');

            for (let i = 0; i < temp.length; i++) {
                if (temp[i].last_message_id !== null && data[i].last_message_id !== null) {
                    temp[i].last_message.shortTime = data[i].last_message.shortTime;
                    chats_time[i].innerHTML = data[i].last_message.shortTime;
                }
            }

            if (JSON.stringify(data) === JSON.stringify(temp)) {
                json_chats = JSON.stringify(data);
                return;
            }

            json_chats = JSON.stringify(data);
            let chats_el = document.querySelector('.chats');
            chats_el.innerHTML = '';
            for (let chat of data) {
                let html = '';
                html += `
                <a href="/messages/view/${chat.user.username}" class="chat${chat.unread_messages > 0? ' unread' : ''}">
                    <img src="/files/ava/${chat.user.ava}">
                    <div class="user">
                        <h2>${chat.user.username}</h2>`
                if (chat.last_message_id !== null) {
                    html += `
                    <p>${chat.last_message.sender}: ${chat.last_message.text}</p>
                            <div class="chat-time">${chat.last_message.shortTime}</div>
                    `
                    if (+chat.unread_messages !== 0)
                        html += `<div class="unread-messages">${chat.unread_messages}</div>`
                } else {
                    html += '<p>No messages yet</p>'
                }

                html += `</div></a>`
                chats_el.innerHTML += html;
            }
        }

    })
}

check_chats();