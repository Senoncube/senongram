<?php

namespace models;

use core\Core;

class Notification
{
    public static string $table = 'notification';

    public static function add($type, $params, $from_user_id, $user_id): void
    {
        $note = [
            'type' => $type,
            'user_id' => $user_id,
            'from_user_id' => $from_user_id,
            'header' => $params['header']
        ];
        if ($type != '1')
        {
            $note['text'] = $params['text'];
            if (strlen($note['text']) > 80) {
                $note['text'] = substr($note['text'], 0, 77) . '...';
                if ($type == '2')
                    $note['text'] .= '"';
            }


        }

        Core::getInstance()->db->insert(self::$table, $note);
    }

    public static function delete($not_id): void
    {
        Core::getInstance()->db->delete(self::$table, 'notification_id', $not_id);
    }

    public static function get($user_id): array
    {
        $nots = Core::getInstance()->db->select(self::$table, ['*'], [
            'user_id' => $user_id
        ]);

        if (!$nots)
            return [];
        else
            return $nots;
    }

    public static function checkUserNot($user_id, $not_id)
    {
        return !empty(Core::getInstance()->db->select(self::$table, ['*'], [
                'user_id' => $user_id,
                'notification_id' => $not_id
            ]));
    }
}