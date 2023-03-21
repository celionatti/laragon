<?php

namespace Core\Forms;

use Core\Support\Csrf;
use Exception;

class Form
{
    /**
     * @throws Exception
     */
    public static function csrfField(): string
    {
        $csrf = new Csrf();
        $token = $csrf->create_csrf();
        return "<input type='hidden' value='{$token}' name='_csrf_token' />";
    }

    public static function method($method): string
    {
        return "<input type='hidden' value='{$method}' name='_method' />";
    }

    public static function processAttrs($attrs): string
    {
        $html = "";
        foreach ($attrs as $key => $value) {
            $html .= " {$key}='{$value}'";
        }
        return $html;
    }
}