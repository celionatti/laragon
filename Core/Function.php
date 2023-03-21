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

/**
 * @throws Exception
 */
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

function console_logger($message): void
{
    echo "[" . date("Y-m-d H:i:s") . "] - " . $message . PHP_EOL;
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
#[NoReturn] function abort($code = \Core\Response::NOT_FOUND, $attributes = []): void
{
    http_response_code($code);

    view("errors/{$code}", $attributes);
    die();
}

function get_pagination_vars(): array
{
    $page_number = $_GET['page'] ?? 1;
    $page_number = empty($page_number) ? 1 : (int) $page_number;
    $page_number = max($page_number, 1);

    $current_link = $_GET['url'] ?? 'home';
    $current_link = "/" . $current_link;
    $query_string = "";
    foreach ($_GET as $key => $value) {
        if ($key != 'url') {
            $query_string .= "&" . $key . "=" . $value;
        }
    }

    if (!str_contains($query_string, "page=")) {
        $query_string .= "&page=" . $page_number;
    }

    $query_string = trim($query_string, "&");
    $current_link .= "?" . $query_string;

    $current_link = preg_replace("/page=.*/", "page=" . $page_number, $current_link);
    $next_link = preg_replace("/page=.*/", "page=" . ($page_number + 1), $current_link);
    $first_link = preg_replace("/page=.*/", "page=1", $current_link);
    $prev_page_number = $page_number < 2 ? 1 : $page_number - 1;
    $prev_link = preg_replace("/page=.*/", "page=" . $prev_page_number, $current_link);
    return [
        'current_link' => $current_link,
        'next_link' => $next_link,
        'prev_link' => $prev_link,
        'first_link' => $first_link,
        'page_number' => $page_number,
    ];
}