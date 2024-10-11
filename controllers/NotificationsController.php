<?php

namespace controllers;

use core\Utils;
use models\Like;
use models\Notification;
use models\User;

class NotificationsController extends \core\Controller
{
    public function indexAction()
    {
        $this->checkUser();

        $user = User::getCurrentUser();

        $nots = Notification::get($user['user_id']);

        usort($nots, "\\core\\Utils::timecomp");

        $curuser = User::getCurrentUser();
        for ($i = 0; $i < count($nots); $i++)
        {
            $nots[$i]['date'] = Utils::toShortTime($nots[$i]['date']);

            $temp_user = User::getUserById($nots[$i]['from_user_id']);

            $nots[$i]['from_user'] = [
                'username' => $temp_user['username'],
                'ava' => $temp_user['ava']
            ];
        }

        return $this->render(params: [
            'nots' => $nots,
            'user' => User::getCurrentUser()
        ]);
    }

    public function deleteAction($params)
    {
        if (!User::isLogUser() || !Notification::checkUserNot(User::getCurrentUser()['user_id'], $params[0]))
            die;
        Notification::delete($params[0]);
        die;
    }

    public function getAction()
    {
        if (!User::isLogUser())
            die(http_response_code(401));
        http_response_code(200);
        echo count(Notification::get(User::getCurrentUser()['user_id']));
    }
}