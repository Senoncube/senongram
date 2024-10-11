<?php

namespace core;

class Template
{
    protected string $path;
    protected array $params;

    public function __construct(string $path) {
        $this->path = $path;
        $this->params = [];
    }

    public function setParam(string $name, $value): void
    {
        $this->params[$name] = $value;
    }

    public function setParams(array $params): void
    {
        foreach ($params as $name => $value)
            $this->setParam($name, $value);
    }

    public function getHTML(): string
    {
        ob_start();
        extract($this->params);
        include $this->path;
        $html = ob_get_contents();
        ob_end_clean();
        return $html;
    }
}