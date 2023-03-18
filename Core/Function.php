<?php


use JetBrains\PhpStorm\NoReturn;

function dd($value): void
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die;
}

function urlIs($value): bool
{
    return $_SERVER['REQUEST_URI'] === $value;
}

function authorize($conditions, $status = \Core\Response::FORBIDDEN): void
{
    if(! $conditions) {
        abort($status);
    }
}

function base_path($path): string
{
    return dirname(__DIR__) . DIRECTORY_SEPARATOR . $path;
}

function assets_path($path): string
{
    return \Core\Config::get('domain') . 'assets' . DIRECTORY_SEPARATOR . $path;
}

#[NoReturn] function redirect($uri): void
{
    http_response_code(\Core\Response::FOUND);
    if (! headers_sent()) {
        header("Location: $uri");
    } else {
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $uri . '"';
        echo '</script>';
        echo '<script>';
        echo '<meta http-equiv="refresh" content="0;url=' . $uri . '" />';
        echo '</script>';
    }
    exit();
}

function last_uri(): void
{
    if (! headers_sent()) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die();
    }
}

/**
 * @throws Exception
 */
function view($path, $attributes = [], $layout = 'default'): void
{
    $view = new \Core\View();
    $view->setLayout($layout);
    $view->render($path, $attributes);
}

/**
 * @throws Exception
 */
#[NoReturn] function abort($code = \Core\Response::NOT_FOUND): void
{
    http_response_code($code);

    view("errors/{$code}", []);
    die();
}