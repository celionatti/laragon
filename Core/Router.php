<?php

namespace Core;

use Core\Middleware\Middleware;
use Exception;
use JetBrains\PhpStorm\NoReturn;

class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];
    public function __construct()
    {
        $this->request = new Request();
        $this->response = new Response();
    }

    public function add($method, $uri, $controller): static
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    public function get($uri, $controller): static
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller): static
    {
        return $this->add('POST', $uri, $controller);
    }

    public function put($uri, $controller): static
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function patch($uri, $controller): static
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function delete($uri, $controller): static
    {
        return $this->add('DELETE', $uri, $controller);
    }

    /**
     * @throws Exception
     */
    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                if($route['middleware']) {
                    Middleware::resolve($route['middleware']);
                }

                $callback = $route['controller'] ?? false;

                if(is_string($callback)) {
                    http_response_code(Response::OK);
                    return require base_path($route['controller']);
                }

                if(is_array($callback)) {
                    $controller = new $callback[0]();
                    $controller->action = $callback[1];
                    $callback[0] = $controller;
                }
                http_response_code(Response::OK);
                return  call_user_func($callback, $this->request, $this->response);
            }
        }
        $this->abort();
    }

    public function getCallback($value)
    {
        // Trim slashes
        $url = trim($value['uri'], '/');

        // Get all routes for current request method
        $routes = $value['method'];

        $routeParams = false;

        // Start iterating registered routes
        foreach ($routes as $route => $callback) {
            // Trim slashes
            $route = trim($route, '/');
            $routeNames = [];

            if (!$route) {
                continue;
            }

            // Find all route names from route and save in $routeNames
            if (preg_match_all('/\{(\w+)(:[^}]+)?}/', $route, $matches)) {
                $routeNames = $matches[1];
            }

            // Convert route name into regex pattern
            $routeRegex = "@^" . preg_replace_callback('/\{\w+(:([^}]+))?}/', fn($m) => isset($m[2]) ? "({$m[2]})" : '(\w+)', $route) . "$@";

            // Test and match current route against $routeRegex
            if (preg_match_all($routeRegex, $url, $valueMatches)) {
                $values = [];
                for ($i = 1; $i < count($valueMatches); $i++) {
                    $values[] = $valueMatches[$i][0];
                }
                $routeParams = array_combine($routeNames, $values);

                $this->request->setRouteParams($routeParams);
                return $callback;
            }
        }

        return false;
    }

    /**
     * @param int $code
     * @return void
     * @throws Exception
     */
    #[NoReturn] protected function abort(int $code = Response::NOT_FOUND): void
    {
        http_response_code($code);

        view("errors/{$code}", []);

        die();
    }

}