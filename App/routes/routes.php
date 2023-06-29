<?php

require_once 'App/Controllers/VoteController.php';
require_once 'App/Controllers/CommuneController.php';
require_once 'Router.php';

require_once "App/config/connection.php";
Database::getInstance();

$router = new Router();

/*
    Rutas web
*/
$router->get('/', function () {
    $voteController = new VoteController();
    $voteController->index();
});
$router->post('/vote', function () {
    $voteController = new VoteController();
    $voteController->create();
});

/*
    /APIS
*/

$router->get('/api/communes/region', function () {
    header('Content-Type: application/json');
    echo json_encode(CommuneController::getCommunesByIdRegion($_GET['idRegion']));
});


// Obtiene el método de solicitud y la ruta actual de la URL
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ejecuta el enrutador para manejar la solicitud
$router->handleRequest($requestMethod, $requestPath);
