<?php
namespace App\Controller;

use Twig\Environment;
use App\router\Router;

class ErrorPageController
{
    public function __construct(
        public Environment $twig
    ) {}
    public function show404Page()
    {
        $this->twig->display('pages/404page.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "root_image" => Router::ROOT_IMAGE,
            "isAdmin" => $_SESSION["isAdmin"] ?? false,
            "session" => $_SESSION,
            // "message" => $message
        ]);
    }
}