<?php

namespace Core\Support;

use Core\Application;
use Core\Response;
use Exception;

class Csrf
{
    /**
     * @throws Exception
     */
    private function random_token(): string
    {
        return bin2hex(random_bytes(12));
    }

    /**
     * @throws Exception
     */
    public function create_csrf(): string
    {
        $token = $this->random_token();
        Application::$app->session->set('_csrf_token', $token);
        return $token;
    }

    /**
     * @throws Exception
     */
    public function check_csrf()
    {
        $check = Application::$app->request->post('_csrf_token');
        if(Application::$app->session->exists('_csrf_token') && Application::$app->session->get('_csrf_token') == $check)
        {
            return true;
        }
        abort(Response::FORBIDDEN);
    }
}