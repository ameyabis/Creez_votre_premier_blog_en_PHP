<?php
namespace App\Controller;

use App\Model\User;
use App\Repository\PostRepository;
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
        $postRepository = new PostRepository();
        $postArray = $postRepository->getLastPost();

        $this->twig->display('pages/homepage.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "posts" => $postArray,
        ]);
    }
}