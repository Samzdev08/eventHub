<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as Handler;




class AuthMiddleware {

    public function __invoke( Request $request, Handler $handler)
    {
        if (!isset($_SESSION['user'])) {
            // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
            header('Location: /login');
            exit();
        }

        return $handler->handle($request);
    }

    public function alreadyLoggedIn(Request $request, Handler $handler)
    {
        if (isset($_SESSION['user'])) {
            $_SESSION['flash']['success'] = 'Vous êtes déjà connecté.';
            header('Location: /my-events');
            exit();
        }

        return $handler->handle($request);
    }
}