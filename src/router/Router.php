<?php
namespace App\router;

use Twig\Loader\FilesystemLoader;

require __DIR__ . "/../config/autoload.php";
use App\Controller\HomePageController;
use App\Controller\ArticlePageController;

class Router
{
    const ROOT_DIRECTORY = "/projet5/site";
    public FilesystemLoader $loader;
    public function __construct()
    {
        $this->loader = new FilesystemLoader('templates');
    }

    public function getController(): void
    {
        if (isset($_GET["page"]) && $_GET["page"] !== "") {
            match ($_GET["page"]) {
                'article' => $this->getArticlePageController(),
                'articles' => $this->getArticlesPageController(),
            // default => $this->get404Controller(),
            };
        } else {
            $this->getHomePageController();
        }
    }

    public function getArticlePageController(): void
    {
        $articleController = new ArticlePageController($this->loader);
        $articleController->showArticlePage();
    }

    public function getArticlesPageController(): void
    {
        $articleController = new ArticlePageController($this->loader);
        $articleController->showArticlesPage();
    }

    public function getHomePageController(): void
    {
        $pagesController = new HomePageController($this->loader);
        $pagesController->showHomePage();
    }

    public function goToLogin()
    {

    }
}