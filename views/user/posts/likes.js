let likes_counter = document.querySelector('#likes');

function likeAnim(b){
    if (b.classList.contains('active')) {
        b.classList.remove('active');
        b.classList.add('dislike');
        let likes = b.querySelector('.counter').innerHTML;
        b.querySelector('.counter').innerHTML = (parseInt(likes) - 1).toString();
        likes_counter.innerHTML = parseInt(likes_counter.innerHTML) - 1;
    } else {
        b.classList.add('active');
        b.classList.remove('dislike');
        let likes = b.querySelector('.counter').innerHTML;
        b.querySelector('.counter').innerHTML = (parseInt(likes) + 1).toString();
        likes_counter.innerHTML = parseInt(likes_counter.innerHTML) + 1;
    }
}

function setLike(post_id) {
    let b = document.querySelector('#id' + post_id);
    if (b.classList.contains('active')) {
        fetch('http://senongram/like/unset/' + post_id);
    } else {
        fetch('http://senongram/like/set/' + post_id);
    }
    likeAnim(b);
}