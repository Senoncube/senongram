<?php

namespace controllers;

use core\Utils;
use models\Message;
use models\User;

class MessagesController extends \core\Controller
{
    public function viewAction(array $params)
    {
        $this->checkUser();
        $user = User::getCurrentUser();
        $chats = Message::getChats($user['user_id']);
        $selected_chat = null;

        if (isset($params[0]) && !empty($params[0])) {
            $temp_user = User::getUserByUsername($params[0]);
            if (empty($temp_user))
                return (new MainController())->errorAction(404);

            $chat = Message::isChatExists($user['user_id'], $temp_user['user_id']);

            if (!$chat)
                return (new MainController())->errorAction(403);

            $selected_chat = [];
            $selected_chat['user'] = User::getUserByUsername($params[0]);

            $selected_chat['messages'] = Message::getChatMessages($chat, 0);
            if (isset($selected_chat['messages'][0]) &&
                $selected_chat['messages'][0]['user_id'] != $user['user_id']) {
                Message::readMessages($chat);
                $chats = Message::getChats($user['user_id']);
            } else {
                $selected_chat['unread_messages'] = 0;
            }


            for ($i = 0; $i < count($selected_chat['messages']); $i++)
                $selected_chat['messages'][$i]['short_date'] = Utils::toShortTime($selected_chat['messages'][$i]['date']);
        }

        $chats = $this->getchats($chats);

        return $this->render(params: [
            'user' => User::getCurrentUser(),
            'chats' => $chats,
            'selected_chat' => $selected_chat
        ]);
    }

    public function sendAction(): void
    {
        if (!User::isLogUser())
            die('{}');
        $user1_id = User::getCurrentUser()['user_id'];
        $user2_id = $_POST['user2_id'];
        $chat = Message::isChatExists($user1_id, $user2_id);

        if (!$chat)
            die('{}');
        $text = $_POST['text'];
        if (strlen($text) < 1)
            die('{}');
        if (strlen($text) > 500)
            $text = substr($text, 0, 500);

        Message::newMessage($user1_id, $chat, $text);
    }

    public function getAction()
    {
        if (!User::isLogUser())
            die('{}');
        $user1_id = User::getCurrentUser()['user_id'];
        $user2_id = $_POST['user2_id'];
        $chat = Message::isChatExists($user1_id, $user2_id);
        $page = $_POST['page'];

        if (!$chat && !is_int($page))
            die('{}');

        $res = Message::getChatMessages($chat, $page);
//        for ($i = 0; $i < count($res); $i++)
//            $res[$i]['date'] = Utils::toShortTime($res[$i]['date']);

        echo json_encode($res);
    }

    public function getnewAction() {
        $last_message_id = $_POST['message_id'];
        if (!User::isLogUser())
            die('[]');
        $user1_id = User::getCurrentUser()['user_id'];
        $user2_id = $_POST['user2_id'];
        $chat = Message::isChatExists($user1_id, $user2_id);

        if (!$chat)
            die('[]');

        $res = Message::newMessages($last_message_id, $chat);
        for ($i = 0; $i < count($res); $i++)
            $res[$i]['short_date'] = Utils::toShortTime($res[$i]['date']);

        echo json_encode($res);
    }

    public function deleteAction() {
        var_dump($_POST);
        if (!User::isLogUser())
            die(http_response_code(401));
        $message_id = $_POST['message_id'];
        if (Message::getMessage($message_id)['user_id'] != User::getCurrentUser()['user_id'])
            die(http_response_code(403));

        Message::delete($message_id);
        die(http_response_code(200));
    }

    public function editAction() {
        if (!User::isLogUser())
            die(http_response_code(401));
        $message_id = $_POST['message_id'];
        if (Message::getMessage($message_id)['user_id'] != User::getCurrentUser()['user_id'])
            die(http_response_code(403));

        $text = $_POST['text'];
        if (strlen($text) < 1)
            die(http_response_code(403));
        if (strlen($text) > 500)
            $text = substr($text, 0, 500);

        Message::edit($message_id, $text);
        die(http_response_code(200));
    }

    public function getchatsAction()
    {
        if (!User::isLogUser())
            die(http_response_code(401));

        return json_encode($this->getchats(Message::getChats(User::getCurrentUser()['user_id'])));
    }

    private function getchats($chats)
    {
        $user = User::getCurrentUser();

        for ($i = 0; $i < count($chats); $i++) {
            if ($chats[$i]['last_message_id']) {

                $message = Message::getMessage($chats[$i]['last_message_id']);
                if (strlen($message['text']) > 50)
                    $message['text'] = substr($message['text'], 0, 50) . '...';
                $chats[$i]['last_message'] = [
                    'sender' => User::getUserById($message['user_id'])['username'],
                    'text' => $message['text'],
                    'shortTime' => Utils::toShortTime($message['date']),
                    'fullTime' => $message['date']
                ];
                if (User::getUserById($message['user_id'])['user_id'] === $user['user_id'])
                    $chats[$i]['unread_messages'] = 0;
            }

            $temp_user = $chats[$i]['user1_id'];
            if ($temp_user == $user['user_id'])
                $temp_user = $chats[$i]['user2_id'];

            $temp_user = User::getUserById($temp_user);
            $chats[$i]['user'] = [
                'user_id' => $temp_user['user_id'],
                'username' => $temp_user['username'],
                'ava' => $temp_user['ava']
            ];
        }
        usort($chats, 'self::time_comp');

        return $chats;
    }

    private static function time_comp($a, $b)
    {

        if ($a['last_message_id'] && $b['last_message_id'])
            return strtotime($b['last_message']['fullTime']) - strtotime($a['last_message']['fullTime']);
        elseif ($a['last_message_id'])
            return  -1;
        elseif ($b['last_message_id'])
            return 1;
        return 0;
    }
}