<?php

namespace controllers;

use core\Controller;
use models\User;

class MainController extends Controller
{
    public function indexAction(): void
    {
        $this->redirect('/home/');
    }
    public function errorAction(int|array $code): string
    {
        if (is_array($code))
            $code = $code[0];
        return $this->render('views/error/index.php', [
            'error' => $code,
            'user' => User::getCurrentUser()
        ]);
    }
}