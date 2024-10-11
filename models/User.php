<?php

namespace models;

use core\Core;

class User
{
    private static string $table = 'user';
    private static int $admin = 14;

    public static function addUser(string $username, string $password): void
    {
        \core\Core::getInstance()->db->insert(self::$table, [
            'username' => mb_strtolower($username),
            'password' => $password
        ]);
    }

    public static function checkUsername(string $username): bool
    {
        $res = \core\Core::getInstance()->db->select('user', ['username'], ['username' => $username]);
        return empty($res);
    }

    public static function getUser(string $username, string $password): array|null
    {
        $res = \core\Core::getInstance()->db->select('user', ['*'], [
            'username' => mb_strtolower($username),
            'password' => $password
        ]);
        if (isset($res[0]))
            return $res[0];
        else
            return null;
    }

    public static function loginUser(array $user): void
    {
        $_SESSION['user'] = $user;
    }

    public static function logoutUser(): void
    {
        unset($_SESSION['user']);
    }

    public static function isLogUser(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function getCurrentUser(): array
    {
        $_SESSION['user'] = self::getUserById($_SESSION['user']['user_id']);
        return $_SESSION['user'];
    }

    public static function getUserByUsername($username): array|null
    {
        $res = Core::getInstance()->db->select(self::$table, ['*'], [
            'username' => mb_strtolower($username)
        ]);
        if ($res)
            return $res[0];
        else
            return null;
    }

    public static function getUserById($id): array|null
    {
        $res = Core::getInstance()->db->select(self::$table, ['*'], [
            'user_id' => $id
        ]);
        if ($res)
            return $res[0];
        else
            return null;
    }

    public static function getAllUsers(): array
    {
        return Core::getInstance()->db->select(self::$table, ['*']);
    }

    public static function changeUser($user_id, $params): array|null
    {
        $resp = [];
        $user = self::getCurrentUser();
        if (isset($params['ava'])) {
            $res = self::ava_validate($params['ava']);
            if (!empty($res)) {
                $resp['ava'] = $res;
            }
        }
        if (isset($params['ban'])) {
            $res = self::ban_validate($params['ban']);
            if (!empty($res)) {
                $resp['ban'] = $res;
            }
        }
        return $resp;
    }

    public static function change_about($text, $user_id)
    {
        Core::getInstance()->db->update(self::$table, ['about' => $text], 'user_id', $user_id);
    }

    private static function ava_validate($ava): array|null
    {
        if ($ava['size'] > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
            return [
                'header' => 'Too large',
                'text' => 'Your avatar must be less than 3 MB'
            ];
        }

        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg'
        ];

        if (!in_array($ava['type'], array_keys($allowedTypes))) {
            return [
                'header' => 'File not allowed',
                'text' => 'Your avatar must be type "jpg" or "png"'
            ];
        }

        $user = User::getCurrentUser();
        if ($user['ava'] != 'base_ava.jpg') {
            unlink('files/ava/' . $user['ava']);
        }

        do {
            $file_name =  uniqid() . '.' . $allowedTypes[$ava['type']];
            $new_path = 'files/ava/' . $file_name;
        } while (file_exists($new_path));

        move_uploaded_file($ava['tmp_name'], $new_path);

        Core::getInstance()->db->update(self::$table, ['ava' => $file_name], 'user_id', $user['user_id']);
        return null;
    }

    private static function ban_validate($ban): array|null
    {
        if ($ban['size'] > 3145728) { // 3 MB (1 byte * 1024 * 1024 * 3 (for 3 MB))
            return [
                'header' => 'Too large',
                'text' => 'Your banner must be less than 3 MB'
            ];
        }

        $allowedTypes = [
            'image/png' => 'png',
            'image/jpeg' => 'jpg'
        ];

        if (!in_array($ban['type'], array_keys($allowedTypes))) {
            return [
                'header' => 'File not allowed',
                'text' => 'Your banner must be type "jpg" or "png"'
            ];
        }

        $user = User::getCurrentUser();
        if ($user['banner'] != 'base_banner.jpg') {
            unlink('files/ban/' . $user['banner']);
        }

        do {
            $file_name =  uniqid() . '.' . $allowedTypes[$ban['type']];
            $new_path = 'files/ban/' . $file_name;
        } while (file_exists($new_path));

        move_uploaded_file($ban['tmp_name'], $new_path);

        Core::getInstance()->db->update(self::$table, ['banner' => $file_name], 'user_id', $user['user_id']);
        return null;
    }

    public static function isAdmin($user_id): bool
    {
        return intval($user_id) == self::$admin;
    }
}