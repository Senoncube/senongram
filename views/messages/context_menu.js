


let menuItems = [
    {
        content: `${copyIcon}Copy`,
        events: {
            click(e) {
                document.querySelector('textarea').value = contMenu.currentTarget.querySelector('.message-content').innerHTML;
            }
        }
    },
    {
        content: `${editIcon}Edit`,
        events: {
            click() {
                let mes = contMenu.currentTarget.parentElement;
                if (mes.classList.contains('left'))
                    return;
                let text = contMenu.currentTarget.querySelector('.message-content').innerHTML;
                document.querySelector('.new-message').innerHTML = `
                        <div class="upload" onclick="back()">
                            <a type="submit">
                                <i class="fa-solid fa-circle-arrow-left fa-2xl"></i>
                            </a>
                        </div>
                        <textarea id="text" data-id="${mes.dataset.id}" data-type="update" maxlength="500" oninput="auto_grow(this)" placeholder="Type your text">${text}</textarea>
                <button class="send-but" onclick="edit_message()">
                    <p class="text">Update</p>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
    <path id="paper-plane-icon" d="M462,54.955L355.371,437.187l-135.92-128.842L353.388,167l-179.53,124.074L50,260.973L462,54.955z
M202.992,332.528v124.517l58.738-67.927L202.992,332.528z"></path>
  </svg>
                </button>
            </div>
                `;
                textarea = document.querySelector('textarea');
                textarea.onkeydown = post_enter;
                textarea.focus();
                textarea.selectionStart = textarea.value.length;
            }
        }
    },
    {
        content: `${deleteIcon}Delete`,
        divider: 'top',
        events: {
            click(e) {
                let data = new FormData();
                data.append('message_id', contMenu.currentTarget.parentElement.dataset.id);
                if (contMenu.currentTarget.parentElement === document.querySelector('#messages').firstElementChild)
                    return;
                fetch('http://senongram/messages/delete/', {
                    method: 'POST',
                    body: data
                }).then(function (res) {
                    if (res.status === 200) {
                        let mes = contMenu.currentTarget;
                        mes.height = mes.clientHeight + 'px';
                        mes.classList.add('message-remove');

                        mes.remove();
                    }


                });

            }
        }
    }
]

const contMenu = new ContextMenu({
    target: ".message-orange, .message-blue",
    menuItems
});

contMenu.init();

function back() {
    document.querySelector('.new-message').innerHTML = `
                        <textarea id="text" maxlength="500"  oninput="auto_grow(this)" placeholder="Type your text"></textarea>
                <button class="send-but" onclick="send_message()">
                    <p class="text">Send</p>
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
    <path id="paper-plane-icon" d="M462,54.955L355.371,437.187l-135.92-128.842L353.388,167l-179.53,124.074L50,260.973L462,54.955z
M202.992,332.528v124.517l58.738-67.927L202.992,332.528z"></path>
  </svg>
                </button>
            </div>
                `;
    textarea = document.querySelector('textarea');
    textarea.onkeydown = post_enter;
}

function edit_message() {
    let text = document.querySelector('textarea').value;
    let message_id = textarea.dataset.id;
    if (text.length === 0)
        return;

    let data = new FormData();
    data.append('text', text);
    data.append('message_id', message_id);

    fetch('http://senongram/messages/edit/', {
        method: 'POST',
        body: data
    }).then(function (res) {
        if (res.status === 200) {
            let mes = document.querySelector(`.right[data-id="${message_id}"]`);
            mes.querySelector('.message-content').innerHTML = text;
            mes.querySelector('.message-timestamp').dataset.edited = 1;
            back();
            update_time(mes);
        }

    })
}