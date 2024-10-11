<?php

namespace models;

use core\Core;
use core\Utils;
use models\User;

class Friends
{
    public static string $table = 'subscribes';
    public static function getAllUsers(): array
    {
        $arr = User::getAllUsers();
        return Utils::deleteParams($arr, ['password', 'notifications']);
    }

    public static function getSubscribers($user_id)
    {
        $subscribers = Core::getInstance()->db->select(self::$table, ['user1_id'], [
            'user2_id' => $user_id
        ]);

        $res = [];
        foreach ($subscribers as $subscriber) {
            $res[] = User::getUserById($subscriber['user1_id']);
        }

        return Utils::deleteParams($res, ['password', 'notifications']);
    }

    public static function getFollows($user_id): array
    {
        $subscribers = Core::getInstance()->db->select(self::$table, ['user2_id'], [
            'user1_id' => $user_id
        ]);

        $res = [];
        foreach ($subscribers as $subscriber) {
            $res[] = User::getUserById($subscriber['user2_id']);
        }

        return Utils::deleteParams($res, ['password', 'notifications']);
    }

    public static function isSubscribed($user1_id, $user2_id): bool
    {
        return !empty(Core::getInstance()->db->select(self::$table,['*'], [
            'user1_id' => $user1_id,
            'user2_id' => $user2_id
        ]));
    }

    public static function subscribe($user1_id, $user2_id): void
    {
        Core::getInstance()->db->insert(self::$table, [
            'user1_id' => intval($user1_id),
            'user2_id' => intval($user2_id)
        ]);


        if (!Message::isChatExists($user1_id, $user2_id)) {
            Message::newChat($user1_id, $user2_id);
        }
    }

    public static function unsubscribe($user1_id, $user2_id): void
    {
        $sub = Core::getInstance()->db->select(self::$table, ["*"], [
            'user1_id' => intval($user1_id),
            'user2_id' => intval($user2_id)
        ]);
        if (!empty($sub))
            Core::getInstance()->db->delete(self::$table, 'subscribe_id', $sub[0]['subscribe_id']);
    }
}