<?php

namespace controllers;

use models\Post;
use models\User;

class PostController extends \core\Controller
{
    public function newAction()
    {
        $this->checkUser();
        $text = $_POST['text'];
        if (!$text)
            $this->redirect('/user/view/');

        if (strlen($text) > 255)
            $text = substr($text, 0, 255);
        Post::newPost(User::getCurrentUser()['user_id'], $text);
        $this->redirect('/user/view/');
    }

    public function changeAction()
    {
        $this->checkUser();
        $text = $_POST['text'];
        $post_id = $_POST['post_id'];
        if (!Post::isUsersPost(User::getCurrentUser()['user_id'], $post_id) || strlen($text) > 255 || strlen($text) < 1)
            die;
        Post::updatePost($post_id, $text);
    }

    public function deleteAction($params)
    {
        $this->checkUser();
        if (!Post::isUsersPost(User::getCurrentUser()['user_id'], $params[0]))
            die;
        Post::deletePost($params[0]);
    }

    public function getAction()
    {

        $page = $_POST['page'];
        if (empty($_POST['user_id'])) {
            $user = User::getCurrentUser();
            $posts = Post::getAllPostsAsync($user['user_id'], $page);
        } else {
            $user = User::getUserById($_POST['user_id']);
            if (empty($user))
                die(http_response_code(404));
            $posts = Post::getUserPostsAsync($user['user_id'], $page);
        }

        $posts = Post::preparePosts($posts);

        echo json_encode($posts);
    }
}