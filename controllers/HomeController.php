<?php

namespace controllers;

use models\Post;
use models\User;

class HomeController extends \core\Controller
{
    public function indexAction()
    {
        $this->checkUser();
        $user = User::getCurrentUser();

        $posts = Post::getAllPosts($user['user_id']);
        $posts = Post::preparePosts($posts);

        return $this->render(params: [
            'user' => $user,
            'posts' => $posts
        ]);
    }
}