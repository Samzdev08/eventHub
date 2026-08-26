<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\EventModel;
use App\Models\RegistrationModel;

class RegistrationController
{
    public function __construct() {}

    public function registerForEvent(Request $request, Response $response): Response
    {
        $idUser = $_SESSION['user']['id'] ?? null;
        $id = $request->getParsedBody()['event_id'] ?? null;

        if ($idUser === null) {
            $_SESSION['flash']['error'] = 'Vous devez être connecté pour vous inscrire à un événement.';
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        if ($id === null) {
            $_SESSION['flash']['error'] = 'ID de l\'événement manquant.';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        $event = EventModel::getEventById($id);

        if (!$event) {
            $_SESSION['flash']['error'] = 'Événement introuvable.';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        $success = RegistrationModel::createRegistration($idUser, $id);

        if ($success) {
            $_SESSION['flash']['success'] = 'Inscription réussie à l\'événement.';
        } else {
            $_SESSION['flash']['error'] = 'Vous êtes déjà inscrit à cet événement.';
        }

        return $response->withHeader('Location', '/events')->withStatus(302);
    }
}