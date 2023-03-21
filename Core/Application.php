<?php

namespace Core;

use Core\Database\Database;
use Exception;

class Application
{
    public Session $session;
    public Request $request;
    public Response $response;
    public Database $database;

    protected static Container $container;
    public Router $router;
    private static Application $instance;
    public static Application $app;

    /**
     * @throws Exception
     */
    public function __construct($migrate = false)
    {
        self::$app = $this;
        $this->session = new Session();
        $this->request = new Request();
        $this->response = new Response();
        self::$container = new Container();

        $this->configs();
        $this->definitions_calls();

        if(! $migrate) {
            $router = new \Core\Router();

            require base_path('routes/route.php');

            $router->route($router->request->getPath(), $router->request->method());
        }
    }

    /**
     * @throws Exception
     */
    private function definitions_calls(): void
    {
        self::$container->bind('Core\Database\Database', function () {
            $config = require base_path('configs/config.php');

            return new Database($config['database']);
        });

        $this->database = static::resolve(Database::class);
    }

    private function configs(): void
    {
        ini_set('default_charset', 'UTF-8');

        $minPhpVersion = '7.4';
        if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
            $message = sprintf(
                'Your PHP version must be %s or higher to run Laragon Framework. Current version: %s',
                $minPhpVersion,
                PHP_VERSION
            );

            exit($message);
        }
        $this->checkExtensions();
    }

    private function checkExtensions(): void
    {
        $required_extensions = [
            'gd',
            'mysqli',
            'pdo_mysql',
            'pdo_sqlite',
            'curl',
            'fileinfo',
            'intl',
            'exif',
            'mbstring',
        ];

        $not_loaded = [];

        foreach ($required_extensions as $ext) {

            if (!extension_loaded($ext)) {
                $not_loaded[] = $ext;
            }
        }

        if (!empty($not_loaded)) {
            echo "Please load the following extensions in your php.ini file: <br>" . implode("<br>", $not_loaded);
            die;
        }
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