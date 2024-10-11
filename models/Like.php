<?php

namespace models;

use core\Core;

class Like
{
    public static string $table = 'likes';

    public static function isPostLiked($user_id, $post_id): bool
    {
        return !empty(Core::getInstance()->db->select(self::$table, ['*'], [
            'user_id' => $user_id,
            'post_id' => $post_id
        ]));
    }

    public static function setLike($user_id, $post_id): void
    {
        Core::getInstance()->db->insert(self::$table, [
            'user_id' => $user_id,
            'post_id' => $post_id
        ]);
    }

    public static function unsetLike($user_id, $post_id): void
    {
        $like = Core::getInstance()->db->select(self::$table, ["*"], [
            'user_id' => $user_id,
            'post_id' => $post_id
        ]);
        if (!empty($like))
            Core::getInstance()->db->delete(self::$table, 'like_id', $like[0]['like_id']);
    }
}