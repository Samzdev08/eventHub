<?php


/** @var \Slim\App $app */

use App\Controllers\HomeController;
use App\Controllers\EventController;
use App\Controllers\AuthController;

$app->get('/', HomeController::class);
$app->get('/events', EventController::class);
$app->get('/events/{id}', [EventController::class, 'details']);

$app->get('/register', [AuthController::class, 'register']);
$app->post('/register', [AuthController::class, 'handleRegister']);

$app->get('/login', [AuthController::class, 'login']);
$app->post('/login', [AuthController::class, 'handleLogin']);

$app->post('/logout', [AuthController::class, 'logout']);

$app->get('/my-events', [EventController::class, 'myEvents']);
$app->get('/events/create', [EventController::class, 'showCreate']);
$app->post('/events/create', [EventController::class, 'create']);

$app->get('/events/{id}/edit', [EventController::class, 'showEdit']);
$app->post('/events/{id}/edit', [EventController::class, 'update']);
$app->post('/events/{id}/delete', [EventController::class, 'delete']);