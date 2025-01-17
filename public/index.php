<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', true);

define('APP_DIR', dirname(__DIR__));

require_once APP_DIR . "/autoload.php";

use App\Router;
use App\Controllers\PagesController;
use App\Controllers\AuthController;
use App\Application;

$router = new Router();

$router->get('/', [PagesController::class, 'home']);
$router->get('/create', [PagesController::class, 'create']);
$router->post('/create', [PagesController::class, 'store']);
$router->post('/delete/*', [PagesController::class, 'delete']);

$router->post('/delete-ajax', [PagesController::class, 'destroy']);

$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'store']);
$router->post('/logout', [AuthController::class, 'destroy']);

$application = new Application($router);
$response = $application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$response->send();
