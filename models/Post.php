<?php

namespace models;

use core\Core;
use core\Utils;


class Post
{
    public static string $table = 'post';
    public static int $pageOffset = 5;



    public static function getUserPosts($user_id): array
    {
        $core = Core::getInstance();
        $res = $core->db->select(self::$table, ['*'], [
            'user_id' => $user_id
        ]);
        if (empty($res))
            $res = [];

        return $res;
    }

    public static function getAllPosts($user_id):array
    {
        $res = Core::getInstance()->db->call('getPostsForUser', [$user_id]);
        if (empty($res))
            $res = [];
        return $res;
    }

    public static function getPost($post_id): array
    {
        $post = Core::getInstance()->db->select(self::$table, ['*'], [
            'post_id' => $post_id
        ]);

        return $post[0];
    }

    public static function preparePosts($posts): array
    {
        usort($posts, "\\core\\Utils::timecomp");

        $curuser = User::getCurrentUser();
        for ($i = 0; $i < count($posts); $i++)
        {
            $posts[$i]['short_time'] = Utils::toShortTime($posts[$i]['date']);

            if (isset($posts[$i]['edited']) && $posts[$i]['edited'])
                $posts[$i]['date'] .= ' (edited)';

            $temp_user = User::getUserById($posts[$i]['user_id']);

            $posts[$i]['user'] = [
                'username' => $temp_user['username'],
                'ava' => $temp_user['ava']
            ];

            $posts[$i]['liked'] = Like::isPostLiked($curuser['user_id'], $posts[$i]['post_id']);
        }

        return $posts;
    }

    public static function newPost($user_id, $text): void
    {
        Core::getInstance()->db->insert(self::$table,[
            'user_id' => $user_id,
            'text' => $text
        ]);
        $user = User::getUserById($user_id);
        $subs = Friends::getSubscribers($user_id);
        foreach ($subs as $sub) {
            Notification::add(3, [
                'header' => "{$user['username']} publicated new post",
                'text' => '"' . $text . '"'
            ], $user_id, $sub['user_id']);
        }
    }

    public static function isUsersPost($user_id, $post_id): bool
    {
        return !empty(Core::getInstance()->db->select(self::$table,[
            'user_id' => $user_id,
            'post_id' => $post_id
        ]));
    }

    public static function updatePost($post_id, $text): void
    {
        Core::getInstance()->db->update(self::$table, [
            'text' => $text,
            'edited' => 1
        ], 'post_id', $post_id);
    }

    public static function deletePost($post_id): void
    {
        Core::getInstance()->db->delete(self::$table, 'post_id', $post_id);
    }

    public static function getAllPostsAsync($user_id, $page):array
    {
        $res = Core::getInstance()->db->call('getPostsForUserAsync', [
            $user_id,
            intval($page) * self::$pageOffset,
            self::$pageOffset
        ]);
        if (empty($res))
            $res = [];

        return $res;
    }

    public static function getUserPostsAsync($user_id, $page): array
    {
        $res = Core::getInstance()->db->select(self::$table, ['*'], [
            'user_id' => $user_id
        ], page_i: intval($page), page_offset: self::$pageOffset, desc: 'date');
        if (empty($res))
            $res = [];

        return $res;
    }
}