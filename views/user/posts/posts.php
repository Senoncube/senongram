<?php
/** @var TYPE_NAME $posts */

//echo '<pre>';
//var_dump($posts);
//die;

foreach ($posts as $post): ?>
    <div class="line"></div>
    <div class="post" data-id="<?=$post['post_id']?>">
        <div class="post-wrapper">
            <button onclick="setLike(<?=$post['post_id']?>)" id="id<?=$post['post_id']?>" class="like <?= $post['liked']? 'active' : '' ?>">
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
                <div class="counter"><?=$post['likes']?></div>
            </button>
            <div class="post-main not-blur">
                <div class="post-text">
                    <?=$post['text']?>
                </div>
                <div class="post-time">
                    <?=$post['date']?>
                </div>
            </div>
            <a class="post-author" href="/user/view/<?=$post['user']['username']?>">
                <img src="/files/ava/<?=$post['user']['ava']?>" alt="ava">
            </a>
        </div>
    </div>
<?php endforeach;?>
