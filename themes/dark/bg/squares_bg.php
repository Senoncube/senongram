<div class="area" >
    <ul class="circles">
    </ul>
</div >

<script>
    let ul = document.querySelector('.area ul');

    function new_circle(li, delay) {
        li.remove();
        li = document.createElement('li');
        li.style.left = Math.floor(Math.random() * 100) + '%';
        let temp = Math.floor(Math.random() * 150) + 20;
        li.style.width = temp + 'px';
        li.style.height = temp + 'px';
        let duration = Math.floor(Math.random() * 10) + 10;
        li.style.animationDuration = duration + 's';
        li.style.animationDelay = delay + 's';
        li.style.background = '#' + Math.floor(Math.random()*16777215).toString(16);
        // setTimeout(function () {
        //     new_circle(li, 0);
        // }, (delay + duration) * 1000);
        ul.appendChild(li);
    }
    for (let i = 0; i < 20; i++)
    {
        let li = document.createElement('li');

        new_circle(li, Math.floor(Math.random() * 10));
    }
</script>