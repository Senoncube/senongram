<?php

namespace controllers;

use models\Like;
use models\Notification;
use models\Post;
use models\User;

class LikeController extends \core\Controller
{
    public function setAction($params)
    {
        $post_id = intval($params[0]);
        if (!User::isLogUser() || Like::isPostLiked(User::getCurrentUser()['user_id'], $post_id))
            die;
        $user = User::getCurrentUser();
        $post = Post::getPost($params[0]);

        Like::setLike($user['user_id'], $post_id);
        if ($user['user_id'] != $post['user_id'])
            Notification::add('2', [
                'header' => "{$user['username']} liked your post",
                'text' => "\"{$post['text']}\""
            ], $user['user_id'], $post['user_id']);
    }

    public function unsetAction($params)
    {
        if (!User::isLogUser())
            die;
        Like::unsetLike(User::getCurrentUser()['user_id'], intval($params[0]));
    }
}