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
        $events = EventModel::getAllEvent();

        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Evénements - EventHub',
                'events' => $events
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'events/index.php');
    }

    public function details(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        if($id == null || !is_numeric($id)) {

            $_SESSION['flash']['error'] = 'ID invalide';
            return $response->withHeader('Location', '/events')->withStatus(302);

        }

       /* $idUser = $_SESSION['user_id'] ?? null;
       
        if($idUser == null) {
            $_SESSION['flash']['error'] = 'Vous devez être connecté pour voir les détails d\'un événement.';
            return $response->withHeader('Location', '/')->withStatus(302);
        }*/

        $event = EventModel::getEventById($id);

        if (!$event) {
            $_SESSION['flash']['error'] = 'Événement introuvable.';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

          $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Evénements - EventHub',
                'event' => $event
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'events/show.php');

        

    }
}
