<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

define('APP_DIR', dirname(__DIR__));

require_once APP_DIR . "/autoload.php";

use App\Router;
use App\Controllers\PagesController;
use App\Application;

$router = new Router();

$router->get('/', [PagesController::class, 'home']);
$router->get('/error', [PagesController::class, 'error']);

$application = new Application($router);
$response = $application->run($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

$response->send();
