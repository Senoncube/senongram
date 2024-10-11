<?php

namespace controllers;

use core\Controller;
use core\Core;
use core\Template;
use core\Utils;
use models\Friends;
use models\Like;
use models\Message;
use models\Post;
use models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function registerAction(): string
    {
        if (User::isLogUser())
            $this->redirect('/user/index');
        if (Core::getInstance()->requestMethod == 'POST')
        {
            $errors = [];
            if (!preg_match('/^[a-zA-Z0-9._-]+$/', $_POST['username']))
                $errors['username'] = 'Usernames can only contain a-z, a-z, 0~9, "_" and "-" characters';
            if (!\models\User::checkUsername($_POST['username']))
                $errors['username'] = 'This username is already in use';
            if ($_POST['password'] != $_POST['password2'])
                $errors['password2'] = 'Both passwords must be the same';
            if ($errors)
                return $this->render(params: [
                    'errors' => $errors,
                    'model' => $_POST
                ]);
            else {
                \models\User::addUser($_POST['username'], md5($_POST['password']));
                header('Location: /user/view/');
                die;
            }
        } else
            return $this->render();
    }

    public function loginAction(): string
    {
        if (User::isLogUser())
            $this->redirect('/user/index');
        if (Core::getInstance()->requestMethod == 'POST')
        {
            $user = User::getUser($_POST['username'], md5($_POST['password']));
            if (empty($user))
                return $this->render(params: [
                    'errors' => [
                        'username' => 'Username or password incorrect'
                    ],
                    'model' => $_POST
                ]);
            else
            {
                User::loginUser($user);
                header('Location: /user/view/');
                die;
            }
        }
        return $this->render();
    }

    public function viewAction(array $params): string
    {

        $this->checkUser();
        if (!empty($params[0]))
            $username = $params[0];
        else
            $username = User::getCurrentUser()['username'];

        $user = User::getUserByUsername($username);
        if (empty($user))
            $this->redirect('/main/error/404');


        $posts = Post::getUserPosts($user['user_id']);

        $posts = Post::preparePosts($posts);

        $curuser = User::getCurrentUser();
        return $this->render(params: [
            'user' => $curuser,
            'view_user' => $user,
            'posts' => $posts,
            'isSubs' => Friends::isSubscribed($curuser['user_id'], $user['user_id']),
            'isFollow' => Friends::isSubscribed($user['user_id'], $curuser['user_id']),
            'isChat' => Message::isChatExists($user['user_id'], $curuser['user_id']),
            'isAdmin' => User::isAdmin($curuser['user_id'])
        ]);
    }

    public function logoutAction(): void
    {
        if (User::isLogUser())
            User::logoutUser();
        header('Location: /user/login');
    }

    public function editAction()
    {
        $this->checkUser();
        $errors = [];

        if (Core::getInstance()->requestMethod == 'POST') {
            $params = [];
            if (strlen($_POST['about']) > 100) {
                $errors['about'] = [
                    'header' => 'Too loooong!',
                    'text' => 'The length of the "about" section must not exceed 100 characters'
                ];
            } else {
                $_POST['about'] = str_replace('\n', '', $_POST['about']);
                User::change_about($_POST['about'], User::getCurrentUser()['user_id']);
            }

            if ($_FILES['ava']['size'] > 0) {
                $params['ava'] = $_FILES['ava'];
            }

            if ($_FILES['ban']['size'] > 0) {
                $params['ban'] = $_FILES['ban'];
            }

            $params['about'] = $_POST['about'];
            if (empty($errors)) {
                $resp = User::changeUser(User::getCurrentUser()['user_id'], $params);
                if (empty($resp))
                    $this->redirect('/user/view/');
                else {
                    if (isset($resp['ava']))
                        $errors['ava'] = $resp['ava'];
                    if (isset($resp['ban']))
                        $errors['ban'] = $resp['ban'];
                }
            }
        }

        return $this->render(params: [
            'user' => User::getCurrentUser(),
            'errors' => $errors
        ]);
    }

    public function adminAction($params)
    {
        $this->checkUser();
        $user = User::getCurrentUser();
        if (User::isAdmin($user['user_id'])) {
            $user_in = User::getUserByUsername($params[0]);
            if (!empty($user_in)) {
                User::loginUser($user_in);
                $this->redirect('/user/view/');
            }
            $this->redirect('/main/error/404');
        }
        $this->redirect('/main/error/403');
    }



//    public function postAction($params)
//    {
//        $this->checkUser();
//        //echo 'aboba';
//        if ($params[0] == 'new')
//        {
//            self::newPost();
//            header('Location: http://senongram/user/view/');
//            die;
//        }
//
//        elseif ($params[0] == 'change')
//            self::changePost();
//        elseif ($params[0] == 'delete')
//            self::deletePost($params[1]);
//
//        die;
//    }


}