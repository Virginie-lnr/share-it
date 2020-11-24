<?php

/**
 * This file is the Front Controller
 * HTTP traffic must be redirected to this file
 *
 * @var App $app
 */

use App\Controller\HomeController;
use Slim\App;

// App configuration
require_once __DIR__ . '/../config/bootstrap.php';
// $app->setBasePath("/slim-app/public");
// Application routes
$app
    ->get('/', [HomeController::class, 'homepage'])
    ->setName('homepage');

// on peut indiquer des paramètres dans les routes entre { accolades }
// on peut indiquer leur format avec des regex 
// \d+ : constitué d'un ou plusieurs chiffres 
// les paramètres seront envoyés en arguments de la méthode du controller
$app
    ->get('/download/{id:\d+}', [HomeController::class, 'download'])
    ->setName('download');
// $app
//     ->map(['GET', 'POST'], '/test', [HomeController::class, 'test'])
//     ->setName('test');

// $app
//     ->get('/a-propos', [HomeController::class, 'about'])
//     ->setName('about');
// Start the application
$app->run();
