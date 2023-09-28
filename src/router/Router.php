<?php
namespace App\router;

use App\Config\connectBDD;

require __DIR__ . "/../config/autoload.php";
use Twig\Loader\FilesystemLoader;
use App\Controller\HomePageController;
use App\Controller\PostPageController;

class Router
{
    const ROOT_DIRECTORY = "/projet5/site";
    public FilesystemLoader $loader;
    public connectBDD $db;
    public function __construct()
    {
        $this->loader = new FilesystemLoader('templates');
    }

    public function getController(): void
    {
        if (isset($_GET["page"]) && $_GET["page"] !== "") {
            match ($_GET["page"]) {
                'post' => $this->getPostPageController(),
                'posts' => $this->getPostsPageController(),
                'create' => $this->getCreatePostPage(),
            // default => $this->get404Controller(),
            };
        } else {
            $this->getHomePageController();
        }
    }

    public function getPostPageController(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        if ($id === null || $id === 0) {
            $this->getHomePageController();
        }
        $postController = new PostPageController($this->loader);
        $postController->showPostPage($id);
    }

    public function getPostsPageController(): void
    {
        $PostController = new PostPageController($this->loader);
        $PostController->showPostsPage();
    }

    public function getHomePageController(): void
    {
        $pagesController = new HomePageController($this->loader);
        $pagesController->showHomePage();
    }

    public function createPostAdmin(): void
    {

    }

    public function getCreatePostPage(): void
    {
        $createController = new PostPageController($this->loader);
        $createController->showFormCreate();
    }
}