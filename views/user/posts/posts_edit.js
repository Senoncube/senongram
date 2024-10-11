let post = null;
let prev_post = null;

function edit_post(temp_post) {
        if (post !== null)
            back();
        post = temp_post.closest('.post');

        let text = post.querySelector('.post-text').innerHTML.trim();

        prev_post = post.innerHTML;

        post.id = 'edit';
        post.innerHTML = `
<div onclick="back()" class="upload small back">
    <a>
        <i class="fa-solid fa-reply"></i>
    </a>
</div>
<textarea onkeydown="edit_enter" minlength="1" id="text" oninput="auto_grow(this)" class="neon" maxlength="255" name="text">${text}</textarea>
<div class="button-wrapper">
    <div onclick="del()" class="upload small delete" onclick="form_submit()">
        <a>
            <i class="fa-solid fa-trash"></i>
        </a>
    </div>
    <div onclick="save()" class="upload small" onclick="form_submit()">
        <a>
            <i class="fa-solid fa-floppy-disk"></i>
        </a>
    </div>
</div>

`;
        post.classList.add('new-post');

        document.getElementById('edit').querySelector('textarea').onkeydown = function edit_enter(e) {
            if (e.shiftKey || e.ctrlKey)
                return;
            if (e.key === 'Enter') {
                e.preventDefault();
                save();
            }

        }


    }

function back() {
    console.log('aboba');
    post.innerHTML = prev_post;
    post = null;
    contMenu.update();
    update_all_times();
}

function save() {
    let text = post.querySelector('textarea').value;
    if (!text)
        return back();

    let post_id = post.dataset.id;
    post.innerHTML = prev_post;
    post.querySelector('.post-text').innerHTML = text;
    post.querySelector('.post-time').dataset.edited = 1;
    contMenu.update();

    let formData = new FormData();
    formData.append('text', text);
    formData.append('post_id', post_id);


    fetch('http://senongram/post/change/', {
        method: 'POST',
        body: formData
    });

    post = null;
    update_all_times();
}

function del() {
    post.previousElementSibling.remove();
    post.remove();

    fetch('http://senongram/post/delete/' + post.dataset.id);

    post = null;
}

document.addEventListener('click', function (e) {
    // if (post ) {
    //     if (!post.contains(e.target))
    //         back();
    //     console.log(e.target);
    //     console.log(post);
    // }

})

