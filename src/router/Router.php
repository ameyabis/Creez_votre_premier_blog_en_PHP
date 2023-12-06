<?php
namespace App\router;

use Twig\Environment;

require __DIR__ . "/../config/autoload.php";

use App\Config\connectBDD;
use Twig\Loader\FilesystemLoader;
use App\Controller\PostController;
use App\Controller\LoginController;
use App\Controller\CommentController;
use App\Controller\ContactController;
use App\Controller\HomePageController;
use App\Controller\ErrorPageController;

class Router
{
    const ROOT_DIRECTORY = "/projet5/site";
    const ROOT_IMAGE = "/projet5/site/src/image/upload/";
    const ROOT_PDF = "/projet5/site/src/pdf/";
    public FilesystemLoader $loader;
    public connectBDD $db;
    public Environment $twig;
    public function __construct()
    {
        $this->loader = new FilesystemLoader('templates');
        $this->twig = new Environment($this->loader);
    }

    public function getController(): void
    {
        // if (empty($_SESSION)) {
        if (isset($_GET["page"]) && $_GET["page"] !== "") {
            match ($_GET["page"]) {
                'registerForm' => $this->getRegisterFormAction(),
                'register' => $this->createUserController(),
                'loginForm' => $this->getLoginFormAction(),
                'login' => $this->createConnectionController(),
                'logout' => $this->logoutController(),
                'post' => $this->getPostController(),
                'posts' => $this->getPostsPageController(),
                'create' => $this->getCreatePostPage(),
                'modify' => $this->getModifyPostPage(),
                'delete' => $this->getDeletePost(),
                'comment' => $this->getNoValidateComment(),
                'deleteComment' => $this->getDeleteComment(),
                'validateComment' => $this->getValidateComment(),
                'contact' => $this->getContactFormAction(),
                'sendContact' => $this->getContactController(),
                default => $this->get404page(),
            };
        } else {
            $this->getHomePageController();
        }
        // }
    }

    public function getPostController(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        if ($id === null || $id === 0) {
            $this->getHomePageController();
        }

        $postController = new PostController($this->twig);
        $postController->showPostPage($id);
    }

    public function getPostsPageController(): void
    {
        $PostController = new PostController($this->twig);
        $PostController->showPostsPage();
    }

    public function getHomePageController(): void
    {
        $pagesController = new HomePageController($this->twig);
        $pagesController->showHomePage();
    }

    public function getCreatePostPage(): void
    {
        $createController = new PostController($this->twig);
        $createController->showFormCreate();
    }

    public function getModifyPostPage(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        $modifyController = new PostController($this->twig);
        $modifyController->showFormModify($id);
    }

    public function getDeletePost(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        $deletePost = new PostController($this->twig);
        $deletePost->deletePost($id);
    }

    public function getNoValidateComment(): void
    {
        $createComment = new CommentController($this->twig);
        $createComment->showNoValidateComment();
    }

    public function getDeleteComment(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        $deleteComment = new CommentController($this->twig);
        $deleteComment->deleteComment($id);
    }

    public function getValidateComment(): void
    {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;

        $validateComment = new CommentController($this->twig);
        $validateComment->validateComment($id, $_GET["idPost"]);
    }

    public function createConnectionController(): void
    {
        if (!isset($_POST['username']) || !isset($_POST['password'])) {
            $this->get404page();
        }

        $createConnection = new LoginController($this->twig);
        $createConnection->login($_POST['username'], $_POST['password']);
    }

    public function getLoginFormAction(): void
    {
        $loginForm = new LoginController($this->twig);
        $loginForm->getFormLogin();
    }

    public function getRegisterFormAction(): void
    {
        $registerForm = new LoginController($this->twig);
        $registerForm->getFormRegister();
    }

    public function createUserController(): void
    {
        if (
            !isset($_POST['username'])
            || !isset($_POST['password'])
            || !isset($_POST['email'])
            || !isset($_POST['firstname'])
            || !isset($_POST['lastname'])
        ) {
            $this->get404page();
        }

        $createConnection = new LoginController($this->twig);
        $createConnection->register(
            $_POST['username'],
            $_POST['password'],
            $_POST['email'],
            $_POST['firstname'],
            $_POST['lastname']
        );

        $this->createConnectionController();
    }

    public function logoutController(): void
    {
        $logoutAction = new LoginController($this->twig);
        $logoutAction->logout();
    }

    public function getContactFormAction(): void
    {
        $contactFrom = new ContactController($this->twig);
        $contactFrom->showFormContact();
    }

    public function get404page(): void
    {
        $pageError = new ErrorPageController($this->twig);
        $pageError->show404Page();
    }

    public function getContactController(): void
    {
        $contactController = new ContactController($this->twig);
        $contactController->sendEmail();
    }
}