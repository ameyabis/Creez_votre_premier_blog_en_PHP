<?php
namespace App\Controller;

use Twig\Environment;
use App\router\Router;
use App\Config\connectBDD;
use Twig\Loader\FilesystemLoader;


class ArticlePageController
{
    public Environment $twig;
    private connectBDD $db;

    public function __construct(FilesystemLoader $loader)
    {
        $this->twig = new Environment($loader);
        $this->db = new connectBDD();
    }
    public function showArticlePage()
    {
        $this->twig->display('pages/article.html.twig', ["root_directory" => Router::ROOT_DIRECTORY]);
    }
    public function showArticlesPage()
    {
        $this->twig->display('pages/articles.html.twig', ["root_directory" => Router::ROOT_DIRECTORY]);
    }
    public function getAllArticles()
    {
        $getData = $this->db->getConnection()->prepare('SELECT * FROM Post');
        $getData->execute();
        $data = $getData->fetchAll();
    }

    public function getOneArticle()
    {

    }
}