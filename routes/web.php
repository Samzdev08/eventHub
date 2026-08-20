<?php


/** @var \Slim\App $app */

use App\Controllers\HomeController;
use App\Controllers\EventController;

$app->get('/', HomeController::class);
$app->get('/events', EventController::class);
$app->get('/events/{id}', [EventController::class, 'details']);