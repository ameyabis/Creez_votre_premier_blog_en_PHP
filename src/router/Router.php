<?php
namespace App\router;

use App\Config\connectBDD;

require __DIR__ . "/../config/autoload.php";
use Twig\Loader\FilesystemLoader;
use App\Controller\HomePageController;
use App\Controller\PostController;

class Router
{
    const ROOT_DIRECTORY = "/projet5/site";
    const ROOT_IMAGE = "/projet5/site/src/image/upload/";
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
                'post' => $this->getPostController(),
                'posts' => $this->getPostsPageController(),
                'create' => $this->getCreatePostPage(),
                'modify' => $this->getModifyPostPage(),
                'delete' => $this->getDeletePost(),
            // default => $this->get404Controller(),
            };
        } else {
            $this->getHomePageController();
        }
    }

    public function getPostController(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        if ($id === null || $id === 0) {
            $this->getHomePageController();
        }
        $postController = new PostController($this->loader);
        $postController->showPostPage($id);
    }

    public function getPostsPageController(): void
    {
        $PostController = new PostController($this->loader);
        $PostController->showPostsPage();
    }

    public function getHomePageController(): void
    {
        $pagesController = new HomePageController($this->loader);
        $pagesController->showHomePage();
    }

    public function getCreatePostPage(): void
    {
        $createController = new PostController($this->loader);
        $createController->showFormCreate();
    }

    public function getModifyPostPage(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        // if ($id === null || $id === 0) {
        //     $this->getHomePageController();
        // }

        $modifyController = new PostController($this->loader);
        $modifyController->showFormModify($id);
    }

    public function getDeletePost(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        
        $deletePost = new PostController($this->loader);
        $deletePost->deletePost($id);
    }
}