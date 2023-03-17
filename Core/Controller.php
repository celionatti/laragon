<?php

namespace Core;

class Controller
{
    public View $view;
//    public string $layout = "default";
    public string $action = "";

    public function __construct()
    {
        $this->view = new View();
        $this->view->setLayout(Config::get('default_layout'));
        $this->onConstruct();
    }

    public function onConstruct(): void
    {}
}