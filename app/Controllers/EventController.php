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

        $idUser = $_SESSION['user']['id'] ?? null;

       
        if($idUser == null) {
            $_SESSION['flash']['error'] = 'Vous devez être connecté pour voir les détails d\'un événement.';
            return $response->withHeader('Location', '/login')->withStatus(302);
        }


        $nbRegistrations = EventModel::countRegistrationsByEventId($id);
        $event = EventModel::getEventById($id);
        $isRegistred = RegistrationModel::getRegistrationsByUserId($idUser);

        
        foreach ($isRegistred as $registration) {
            if ($registration['event_id'] == $id) {
                $isRegistred = true;
                break;
            } else {
                $isRegistred = false;
            }
        }



        if (!$event) {
            $_SESSION['flash']['error'] = 'Événement introuvable.';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Evénements - EventHub',
                'event' => $event,
                'isRegistred' => $isRegistred,
                'nbRegistrations' => $nbRegistrations
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

    public function showCreate(Request $request, Response $response)
    {
        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Créer un événement - EventHub',
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'events/form.php');
    }
    public function showEdit(Request $request, Response $response, array $args)
    {
        $id = $args['id'];
        $idUser = $_SESSION['user']['id'] ?? null;

        if ($id == null || !is_numeric($id)) {
            $_SESSION['flash']['error'] = 'ID invalide';
            return $response->withHeader('Location', '/my-events')->withStatus(302);
        }

        if ($idUser == null) {
            $_SESSION['flash']['error'] = 'Vous devez être connecté pour modifier un événement.';
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        if($_SESSION['user']['role'] !== 'admin' && !EventModel::getEventByIdAndUserId($id, $idUser)){
            $_SESSION['flash']['error'] = 'Vous n\'avez pas la permission de modifier cet événement.';
            return $response->withHeader('Location', '/my-events')->withStatus(302);
        }


        $event = EventModel::getEventById($id);

        if (!$event) {
            $_SESSION['flash']['error'] = 'Événement introuvable.';
            return $response->withHeader('Location', '/my-events')->withStatus(302);
        }

        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Modifier un événement - EventHub',
                'id' => $id,
                'event' => $event
                
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'events/form.php');
    }

    public function create(Request $request, Response $response, array $args){

        $data = $request->getParsedBody();

        $data['owner_id'] = $_SESSION['user']['id'];

        if($data['title'] == null || $data['description'] == null || $data['event_date'] == null || $data['capacity'] == null){
            $_SESSION['flash']['error'] = 'Tous les champs sont requis.';
            return $response->withHeader('Location', '/events/create')->withStatus(302);
        }

        if(!is_numeric($data['capacity']) || $data['capacity'] <= 0){
            $_SESSION['flash']['error'] = 'La capacité doit être un nombre positif.';
            return $response->withHeader('Location', '/events/create')->withStatus(302);
        }

        if(strtotime($data['event_date']) < time()){
            $_SESSION['flash']['error'] = 'La date de l\'événement doit être dans le futur.';
            return $response->withHeader('Location', '/events/create')->withStatus(302);
        }

        if(strlen($data['title']) > 255){
            $_SESSION['flash']['error'] = 'Le titre ne doit pas dépasser 255 caractères.';
            return $response->withHeader('Location', '/events/create')->withStatus(302);
        }

       if (preg_match('/[^\p{L}\p{N}\s]/u', $data['title'])) {
            $_SESSION['flash']['error'] = 'Le titre ne doit pas contenir de caractères spéciaux.';
            return $response->withHeader('Location', '/events/create')->withStatus(302);
        }


        $success = EventModel::createEvent($data);

        if(!$success){
            $_SESSION['flash']['error'] = 'Une erreur est survenue lors de la création de l\'événement. Veuillez réessayer.';
            return $response->withHeader('Location', '/events/create')->withStatus(302);
        }

        $_SESSION['flash']['success'] = 'Événement créé avec succès.';
        return $response->withHeader('Location', '/events/' . $success)->withStatus(302);
    }

    public function update(Request $request, Response $response, array $args){

        $id = $args['id'];
        if ($id == null || !is_numeric($id)) {
            $_SESSION['flash']['error'] = 'ID invalide';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        $data = $request->getParsedBody();

        if($data['title'] == null || $data['description'] == null || $data['event_date'] == null || $data['capacity'] == null){
            $_SESSION['flash']['error'] = 'Tous les champs sont requis.';
            return $response->withHeader('Location', '/events/' . $id . '/edit')->withStatus(302);
        }

        if(!is_numeric($data['capacity']) || $data['capacity'] <= 0){
            $_SESSION['flash']['error'] = 'La capacité doit être un nombre positif.';
            return $response->withHeader('Location', '/events/' . $id . '/edit')->withStatus(302);
        }

        if(strtotime($data['event_date']) < time()){
            $_SESSION['flash']['error'] = 'La date de l\'événement doit être dans le futur.';
            return $response->withHeader('Location', '/events/' . $id . '/edit')->withStatus(302);
        }

        if(strlen($data['title']) > 255){
            $_SESSION['flash']['error'] = 'Le titre ne doit pas dépasser 255 caractères.';
            return $response->withHeader('Location', '/events/' . $id . '/edit')->withStatus(302);
        }

        if (preg_match('/[^\p{L}\p{N}\s]/u', $data['title'])) {
            $_SESSION['flash']['error'] = 'Le titre ne doit pas contenir de caractères spéciaux.';
            return $response->withHeader('Location', '/events/' . $id . '/edit')->withStatus(302);
        }

        $success = EventModel::updateEvent($id, $data);

        if(!$success){
            $_SESSION['flash']['error'] = 'Une erreur est survenue lors de la modification de l\'événement. Veuillez réessayer.';
            return $response->withHeader('Location', '/events/' . $id . '/edit')->withStatus(302);
        }

        $_SESSION['flash']['success'] = 'Événement modifié avec succès.';
        return $response->withHeader('Location', '/events/' . $id)->withStatus(302);
    }

    public function delete(Request $request, Response $response, array $args){

        $id = $args['id'];
        $idUser = $_SESSION['user']['id'] ?? null;

        if ($id == null || !is_numeric($id)) {
            $_SESSION['flash']['error'] = 'ID invalide';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        if ($idUser == null) {
            $_SESSION['flash']['error'] = 'Vous devez être connecté pour supprimer un événement.';
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

       if($_SESSION['user']['role'] !== 'admin' && !EventModel::getEventByIdAndUserId($id, $idUser)){
            $_SESSION['flash']['error'] = 'Vous n\'avez pas la permission de supprimer cet événement.';
            return $response->withHeader('Location', '/my-events')->withStatus(302);
        }

        $success = EventModel::deleteEvent($id);

        if(!$success){
            $_SESSION['flash']['error'] = 'Une erreur est survenue lors de la suppression de l\'événement. Veuillez réessayer.';
            return $response->withHeader('Location', '/events')->withStatus(302);
        }

        $_SESSION['flash']['success'] = 'Événement supprimé avec succès.';
        return $response->withHeader('Location', '/my-events')->withStatus(302);
    }
}
