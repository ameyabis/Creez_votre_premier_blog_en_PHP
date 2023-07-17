<?php
namespace App\router;

require_once __DIR__ . '/../controllers/TwigController.php';
use App\Controllers\TwigController;
use Twig\Loader\FilesystemLoader;

class Router
{
    public FilesystemLoader $loader;
    public function __construct()
    {
        $this->loader = new FilesystemLoader('templates');
    }

    public function getController(): void
    {
        $twigController = new TwigController($this->loader);
        $twigController->showHomePage();
    }
}