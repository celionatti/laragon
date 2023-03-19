<?php

namespace Core\Support;

use Core\Application;

class FlashMessage
{
    public static function bootstrap_alert(): string
    {
        if(Application::$app->session->getFlash('success')) {
            return self::bootstrap_success(Application::$app->session->getFlash('success'));
        } elseif (Application::$app->session->getFlash('error')) {
            return self::bootstrap_error(Application::$app->session->getFlash('error'));
        } else {
            return false;
//            return self::bootstrap_info(Application::$app->session->getFlash('info'));
        }
    }

    private static function bootstrap_success($msg): string
    {
        return "
            <div class='alert alert-success alert-dismissible fade show mt-3 mx-2 shadow-lg fixed-top text-uppercase text-center' role='alert' style='z-index: 5000;'>
                <div>{$msg}</div>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }

    private static function bootstrap_error($msg): string
    {
        return "
            <div class='alert alert-error alert-dismissible fade show mt-3 mx-2 shadow-lg fixed-top text-uppercase text-center' role='alert' style='z-index: 5000;'>
                <div>{$msg}</div>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }

    private static function bootstrap_info($msg): string
    {
        return "
            <div class='alert alert-error alert-dismissible fade show mt-3 mx-2 shadow-lg fixed-top text-uppercase text-center' role='alert' style='z-index: 5000;'>
                <div>{$msg}</div>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        ";
    }
}