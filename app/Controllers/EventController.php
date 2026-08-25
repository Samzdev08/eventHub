<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\EventModel;
use App\Models\RegistrationModel;

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
        if ($id == null || !is_numeric($id)) {

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

    public function myEvents(Request $request, Response $response)
    {
        $role = $_SESSION['user']['role'];
        $data = [];

        if ($role === 'organizer') {
            $data['events'] = EventModel::getEventByUserId($_SESSION['user']['id']) ;
        } elseif ($role === 'user') {
            $data['registrations'] = RegistrationModel::getRegistrationsByUserId($_SESSION['user']['id']);
        }

        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            array_merge(['title' => 'Evénements - EventHub'], $data)
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'events/profil.php');
    }

    public function create(Request $request, Response $response)
    {
        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Créer un événement - EventHub',
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'events/create.php');
    }
    public function edit(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        if ($id == null || !is_numeric($id)) {
            $_SESSION['flash']['error'] = 'ID invalide';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        $event = EventModel::getEventById($id);

        if (!$event) {
            $_SESSION['flash']['error'] = 'Événement introuvable.';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Modifier un événement - EventHub',
                'event' => $event
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'events/edit.php');
    }
}
