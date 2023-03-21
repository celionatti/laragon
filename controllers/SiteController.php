<?php

namespace controllers;

use Core\Application;
use Core\Controller;
use Core\Request;
use Core\Response;
use Exception;
use models\Users;

class SiteController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $view = [
            'users' => Users::find(),
        ];
        $this->view->render('welcome', $view);
    }
}