<?php
use App\router\Router;

require __DIR__ . '/vendor/autoload.php';

session_start();

try {
    $router = new Router;
    $router->getController();
} catch (Exception $e) {
    echo "error: " . $e->getMessage();
    die;
}