<?php

namespace core;

use controllers\MainController;

class Core
{
    private static Core $instance;
    public array $arr;
    public array $pageParams;
    public DB $db;
    public string $requestMethod;

    private function __construct() {
        global $pageParams;
        $this->arr = [];
        $this->pageParams = $pageParams;
    }

    public static function getInstance(): Core
    {
        if (empty(self::$instance))
            self::$instance = new self();
        return self::$instance;
    }

    public function Initialize(): void
    {
        session_start();
        $this->db = new DB(DATABASE_HOST, DATABASE_LOGIN, DATABASE_PASSWORD, DATABASE_NAME);
        $this->requestMethod = $_SERVER['REQUEST_METHOD'];
    }

    public function Run(): void
    {
        if (empty($_GET['route']))
            $route = [];
        else
            $route = explode('/', $_GET['route']);
        if (empty($route[0]))
            $route[0] = "main";
        if (empty($route[1]))
            $route[1] = 'index';
        $this->arr['moduleName'] = $route[0];
        $this->arr['actionName'] = $route[1];
        $controllerName = 'controllers\\' . ucfirst(array_shift($route)) . 'Controller';
        $controllerAction = array_shift($route) . 'Action';

        $statusCode = 200;
        if (class_exists($controllerName)) {
            $controller = new $controllerName();
            if (class_exists($controllerName) && method_exists($controller, $controllerAction)) {
                $html = $controller->$controllerAction($route);
                $this->arr['content'] = $html;
            }
            else
                $statusCode = 404;
        } else $statusCode = 404;

        if ($statusCode >= 400)
            $this->arr['content'] = (new MainController())->errorAction($statusCode);
    }
    public function Done(): void
    {
        $tpl = new Template('themes/dark/layout.php');
        $tpl->setParam('content', $this->arr['content']);
        $tpl->setParams($this->pageParams);
        echo $tpl->getHTML();
    }
}