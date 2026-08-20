<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\EventModel;

class EventController
{
    public function __construct() {}

    public function __invoke(Request $request, Response $response): Response
    {
        $events = EventModel::getAllUser();

        $view = new PhpRenderer(__DIR__ . '/../Views/layouts', 
        ['title' => 'Evénements - EventHub',
         'events' => $events
        ]);

        $view->setLayout('layout.php');
        return $view->render($response, 'events/index.php');
    }
}
