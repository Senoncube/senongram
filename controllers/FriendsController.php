<?php

namespace controllers;

use core\Core;
use models\Friends;
use models\Like;
use models\Notification;
use models\Post;
use models\User;

class FriendsController extends \core\Controller
{
    public function viewAction($params) {
        $this->checkUser();

        if (empty($params) || empty($params[0])) {
            $type = 'all';
            $temp_user = User::getCurrentUser()['username'];
        } else {
            $temp_user = $params[0];
            $type = $params[1];
        }

        return $this->render(params: [
            'user' => User::getCurrentUser(),
            'temp_user' => User::getUserByUsername($temp_user)['user_id'],
            'type' => $type
        ]);
    }

    public function view_jsonAction($params) {
        $this->checkUser();

        $type = $_GET['type'];

        if ($type == 'all')
            $friends = Friends::getAllUsers();
        elseif ($type == 'followers')
            $friends = Friends::getSubscribers($_GET['user_id']);
        else
            $friends = Friends::getFollows($_GET['user_id']);

        if (boolval($_GET['only_friends'])) {
            $user = User::getCurrentUser()['user_id'];
            $user_subs = Friends::getSubscribers($user);
            $user_follows = Friends::getFollows($user);

            $res = [];
            foreach ($friends as $friend) {
                if (in_array($friend, $user_subs) && in_array($friend, $user_follows))
                    $res[] = $friend;
            }

            $friends = $res;
        }

        if ($_GET['find'])
        {
            $temp = [];
            for ($i = 0; $i < count($friends); $i++)
                if (str_contains($friends[$i]['username'], $_GET['find']))
                    $temp[] = $friends[$i];
            $friends = $temp;
        }
        echo json_encode($friends);
    }

    public function subscribeAction($params)
    {
        $user1 = User::getCurrentUser();
        $user2_id = intval($params[0]);
        if (!User::isLogUser() || Friends::isSubscribed(User::getCurrentUser()['user_id'], $user2_id) || $user2_id == $user1['user_id'])
            die;

        Friends::subscribe($user1['user_id'], $user2_id);
        Notification::add('1', [
            'header' => "{$user1['username']} started following you."
        ], intval($user1['user_id']), intval($user2_id));
    }

    public function unsubscribeAction($params)
    {
        if (!User::isLogUser())
            die;
        Friends::unsubscribe(User::getCurrentUser()['user_id'], intval($params[0]));
    }
}