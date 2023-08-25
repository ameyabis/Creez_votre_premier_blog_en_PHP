<?php
namespace App\Controller;

use App\Model\User;
use App\router\Router;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class HomePageController
{
    public Environment $twig;

    public function __construct(FilesystemLoader $loader)
    {
        $this->twig = new Environment($loader);
    }
    public function showHomePage()
    {
        $this->twig->display('pages/homepage.html.twig', ["root_directory" => Router::ROOT_DIRECTORY]);
        // $user = new User();
        // $user->firstName = "Jeremy";
        // $user->lastName = "Test";
        // $user2 = new User();
        // $user2->firstName = "test2";
        // $user2->lastName = "jeremy2";
        // var_dump($this->twig);
        // die;
    }
}