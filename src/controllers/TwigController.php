<?php
namespace App\Controllers;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class TwigController
{
    public Environment $twig;

    public function __construct(FilesystemLoader $loader)
    {
        $this->twig = new Environment($loader);
    }
    public function showHomePage()
    {
        $this->twig->display('pages/accueil.html.twig');
    }
}