<?php

namespace controllers;

use Core\Application;
use Core\Controller;
use Core\Request;
use Core\Response;
use Exception;

class SiteController extends Controller
{
    /**
     * @throws Exception
     */
    public function index(Request $request, Response $response)
    {
        $view = [];
        $this->view->render('welcome', $view);
    }
}