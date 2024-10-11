<?php

namespace models;

use core\Core;

class Message
{
    public static string $chatTable = 'chat';
    public static string $messageTable = 'messages';
    public static int $page_offset = 25;
    public static string $iv = 'dnePqNA0vFqbn0EB';
    public static string $key = "FZqOXmPmSBgGYBKi";

    public static function getChats($user_id): array
    {
        $chats = Core::getInstance()->db->select(self::$chatTable, ['*'], [
            'user1_id' => $user_id,
            'user2_id' => $user_id
        ], true);

        return $chats;
    }

    public static function getMessage($message_id): array|null
    {
       $res = Core::getInstance()->db->select(self::$messageTable, ['*'], [
            'message_id' => $message_id
        ]);

       if (!empty($res))
           return self::decrypt_messages($res)[0];
       else
           return null;
    }

    public static function getChatMessages($chat_id, $page): array
    {
        $res = Core::getInstance()->db->select(self::$messageTable, ['*'], [
            'chat_id' => $chat_id
        ], false, $page, self::$page_offset, 'message_id');
        if (!empty($res))
            return self::decrypt_messages($res);
        else
            return [];
    }

    public static function isChatExists($user1_id, $user2_id, $recursion = true): string|int|null
    {
        $res = Core::getInstance()->db->select(self::$chatTable, ['*'], [
            'user1_id' => $user1_id,
            'user2_id' => $user2_id
        ]);
        if ($res)
            return $res[0]['chat_id'];
        else {
            if ($recursion)
                return self::isChatExists($user2_id, $user1_id, false);
            else
                return false;
        }

    }

    public static function newMessage($user_id, $chat_id, $text)
    {
        Core::getInstance()->db->insert(self::$messageTable, [
            'user_id' => $user_id,
            'chat_id' => $chat_id,
            'text' => self::encrypt($text)
        ]);

//        return Core::getInstance()->db->select(self::$messageTable, ['*'], [
//            'user_id' => $user_id,
//            'chat_id' => $chat_id,
//            'text' => $text
//        ],desc: 'message_id')[0];
    }

    public static function newMessages($last_message_id, $chat_id)
    {
        $last_message = Core::getInstance()->db->select(self::$messageTable, ['message_id'], [
            'chat_id' => $chat_id
        ], page_i: 0, page_offset: 1, desc: 'message_id');

        $arr = self::getChatMessages($chat_id, 0);
        $res = [];
        foreach ($arr as $t)
            if ($t['message_id'] == $last_message_id)
                return $res;
            else
                $res[] = $t;

        return $res;
    }

    public static function delete($message_id)
    {
        Core::getInstance()->db->delete(self::$messageTable, 'message_id', $message_id);
    }

    public static function edit($message_id, $text)
    {
        Core::getInstance()->db->update(self::$messageTable, [
            'text' => self::encrypt($text),
            'edited' => 1
        ],'message_id', $message_id);
    }

    public static function readMessages($chat_id)
    {
        Core::getInstance()->db->update(self::$chatTable, [
            'unread_messages' => 0
        ], 'chat_id', $chat_id);
    }

    public static function encrypt($text): string
    {
        return openssl_encrypt($text, "AES-128-CTR", self::$key, 0, self::$iv);
    }

    public static function decrypt($text): string
    {
        return openssl_decrypt($text, "AES-128-CTR", self::$key, 0, self::$iv);
    }

    public static function decrypt_messages($arr)
    {
        for ($i = 0; $i < count($arr); $i++)
            $arr[$i]['text'] = self::decrypt($arr[$i]['text']);
        return $arr;
    }

    public static function encrypt_all_messages(): void
    {
        $arr = Core::getInstance()->db->select(self::$messageTable, ['*']);
        foreach ($arr as $item) {
            self::edit($item['message_id'], $item['text']);
        }
    }

    public static function newChat($user1_id, $user2_id) {
        Core::getInstance()->db->insert(self::$chatTable, [
            'user1_id' => $user1_id,
            'user2_id' => $user2_id
        ]);
    }
}