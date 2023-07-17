<?php
require __DIR__ . '/src/router/Router.php';
use App\router\Router;

require __DIR__ . '/vendor/autoload.php';

// echo $template->render('base.html.twig', []);

try {
    $router = new Router;
    $router->getController();
} catch (Exception $e) {
    echo "error: " . $e->getMessage();
    die;
}