<?php
namespace App\Controller;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controllers
{
    private $loader;
    protected $twig;

    public function __construct()
    {
        //Dossier contenant les fichier Twig
        $this->loader = new FilesystemLoader(__DIR__ . '/templates');

        //Environnement Twig
        $this->twig = new Environment($this->loader);
    }

    
}