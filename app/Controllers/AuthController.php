<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use App\Models\UserModel;

class AuthController
{
    public function __construct() {}

    public function register(Request $request, Response $response): Response
    {


        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Inscription - EventHub',
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'auth/register.php');
    }

    public function login(Request $request, Response $response): Response
    {
        $view = new PhpRenderer(
            __DIR__ . '/../Views',
            [
                'title' => 'Connexion - EventHub',
            ]
        );

        $view->setLayout('layouts/layout.php');
        return $view->render($response, 'auth/login.php');
    }

    public function logout(Request $request, Response $response): Response
    {

        session_destroy();


        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function handleRegister(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();


        if (empty($data['username']) || empty($data['password_hash']) || empty($data['role'])) {
            $_SESSION['flash']['error'] = 'Tous les champs sont requis.';
            return $response->withHeader('Location', '/register')->withStatus(302);
        }

        if (preg_match('/[^a-zA-Z0-9_]/', $data['username'])) {
            $_SESSION['flash']['error'] = 'Le nom d\'utilisateur ne peut contenir que des lettres, des chiffres et des underscores.';
            return $response->withHeader('Location', '/register')->withStatus(302);
        }


        if (UserModel::userExists($data['username'])) {
            $_SESSION['flash']['error'] = 'Le nom d\'utilisateur existe déjà.';
            return $response->withHeader('Location', '/register')->withStatus(302);
        }



        $hashedPassword = password_hash($data['password_hash'], PASSWORD_BCRYPT);

        $data['password'] = $hashedPassword;

        $success = UserModel::createUser($data);

        if (!$success) {
            $_SESSION['flash']['error'] = 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.';
            return $response->withHeader('Location', '/register')->withStatus(302);
        }

        $_SESSION['flash']['success'] = 'Inscription réussie. Vous pouvez maintenant vous connecter.';
        return $response->withHeader('Location', '/login')->withStatus(302);
    }

    public function handleLogin(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();


        if (empty($data['username']) || empty($data['password'])) {
            $_SESSION['flash']['error'] = 'Tous les champs sont requis.';
            return $response->withHeader('Location', '/login')->withStatus(302);
        }


        $success = UserModel::login($data);

        if (!$success) {
            $_SESSION['flash']['error'] = 'Nom d\'utilisateur ou mot de passe incorrect.';
            return $response->withHeader('Location', '/login')->withStatus(302);
        }

        $_SESSION['flash']['success'] = 'Connexion réussie.';
        return $response->withHeader('Location', '/')->withStatus(302);
    }
}
