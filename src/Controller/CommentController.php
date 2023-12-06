<?php
namespace App\Controller;

use Twig\Environment;
use App\router\Router;
use App\Repository\PostRepository;
use App\Repository\CommentRepository;
use App\Controller\ErrorPageController;


class CommentController
{
    public function __construct(
        public Environment $twig
    ) {}

    public function showNoValidateComment(): void
    {
        $commentRepository = new CommentRepository();
        $commentArray = $commentRepository->getCommentNotValidated();

        $this->twig->display('pages/commentPost.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "comments" => $commentArray,
            "isAdmin" => $_SESSION["isAdmin"] ?? false,
            "session" => $_SESSION,
        ]);
    }

    public function deleteComment(int $id): void
    {
        $commentRepository = new CommentRepository();
        $commentRepository->deleteComment($id);
    }

    public function validateComment(int $id, int $idPost): void
    {
        $commentRepository = new CommentRepository();
        $dataRepository = $commentRepository->validateComment($id);

        if ($dataRepository === "Success") {
            $message = 'Modification réussie !';

            $postRepository = new PostRepository();
            $dataPost = $postRepository->getOnePost($idPost);
        } else {
            $message = 'Erreur lors de la validation';

            $error = new ErrorPageController($this->twig);
            $error->show404Page();
        }

        header("Location:" . Router::ROOT_DIRECTORY . '?page=comment');
    }
}