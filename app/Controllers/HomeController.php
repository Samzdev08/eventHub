<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;

class HomeController
{
    public function __construct() {}

    public function __invoke(Request $request, Response $response): Response
    {
        $view = new PhpRenderer(__DIR__ . '/../Views/layouts', ['title' => 'Accueil - EventHub']);

        $view->setLayout('layout.php');
        return $view->render($response, 'home.php');
    }
}
