<?php

namespace Core;

use Core\Database\Database;
use Exception;

class Application
{
    public Request $request;
    public Response $response;
    protected static Container $container;
    public Database $database;
    public Router $router;
    private static Application $instance;
    public static Application $app;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        self::$container = new Container();

        $router = new \Core\Router();

        require base_path('routes/route.php');

        $router->route($router->request->getPath(), $router->request->method());

        self::$container->bind('Core\Database\Database', function () {
            $config = require base_path('configs/config.php');

            return new Database($config['database']);
        });

        $this->database = static::resolve(Database::class);
    }

    public static function init(): static
    {
        if(!isset(self::$instance)) {
            self::$instance = new Application();
        }
        return self::$instance;
    }

    public static function setContainer($container): void
    {
        static::$container = $container;
    }

    public static function container(): Container
    {
        return static::$container;
    }

    public static function bind(string $key, $resolver): void
    {
        static::container()->bind($key, $resolver);
    }

    /**
     * @throws Exception
     */
    public static function resolve($key)
    {
        return static::container()->resolve($key);
    }

}