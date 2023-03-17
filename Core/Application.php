<?php

namespace Core;

class Application
{
    public Request $request;
    public Response $response;
    public Router $router;
    private static Application $instance;
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();

        $router = new \Core\Router();

        require base_path('routes/route.php');

        $router->route($router->request->getPath(), $router->request->method());
    }

    public static function init(): static
    {
        if(!isset(self::$instance)) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

}