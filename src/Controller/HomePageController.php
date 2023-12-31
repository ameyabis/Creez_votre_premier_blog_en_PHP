<?php
namespace App\Controller;

use App\Repository\PostRepository;
use App\router\Router;
use Twig\Environment;

class HomePageController
{
    public function __construct(
        public Environment $twig
    ) {}
    public function showHomePage()
    {
        $postRepository = new PostRepository();
        $postArray = $postRepository->getLastPost();

        $this->twig->display('pages/homepage.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "root_image" => Router::ROOT_IMAGE,
            "posts" => $postArray,
            "isAdmin" => $_SESSION["isAdmin"] ?? false,
            "session" => $_SESSION,
        ]);
    }
}