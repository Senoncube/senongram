<?php

namespace core;

use models\User;

class Controller
{
    public string $path;
    protected Core $core;
    public function __construct() {
        $this->core = \core\Core::getInstance();
        $this->path = "views/{$this->core->arr['moduleName']}/{$this->core->arr['actionName']}.php";
    }
    public function render(string $path = null, array $params = []): string
    {
        if (!empty($path))
            $this->path = $path;
        $tpl = new Template($this->path);
        $tpl->setParams($params);
        return $tpl->getHTML();
    }

    public function renderView(string $viewName, array $params = []): string
    {
        $path = "views/{$this->core->arr['moduleName']}/$viewName.php";
        return $this->render($path, $params);
    }

    public function redirect($url)
    {
        header("Location: $url");
        die;
    }

    public function checkUser()
    {
        if (!User::isLogUser())
            $this->redirect('/user/login');
    }


}