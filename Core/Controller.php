<?php

namespace Core;

use JetBrains\PhpStorm\NoReturn;

class Controller
{
    public View $view;
    public string $action = "";

    public function __construct()
    {
        $this->view = new View();
        $this->view->setLayout(Config::get('default_layout'));
        $this->onConstruct();
    }

    #[NoReturn] public function json_response($resp): void
    {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        http_response_code(Response::OK);
        echo json_encode($resp);
        exit;
    }

    public function onConstruct(): void
    {}
}