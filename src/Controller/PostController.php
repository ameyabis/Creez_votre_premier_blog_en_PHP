<?php
namespace App\Controller;

use App\Model\Post;
use Twig\Environment;
use App\router\Router;
use Twig\Loader\FilesystemLoader;
use App\Repository\PostRepository;


class PostController
{
    public Environment $twig;

    public function __construct(FilesystemLoader $loader)
    {
        $this->twig = new Environment($loader);
    }
    public function showPostPage(int $id): void
    {
        $postRepository = new PostRepository();
        $onePost = $postRepository->getOnePost($id);
        // var_dump($onePost);die;

        $this->twig->display('pages/post.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "root_image" => Router::ROOT_IMAGE,
            "post" => $onePost
        ]);
    }
    public function showPostsPage()
    {
        $postRepository = new PostRepository();
        $postArray = $postRepository->getAllPosts();

        $this->twig->display('pages/posts.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "root_image" => Router::ROOT_IMAGE,
            "posts" => $postArray
        ]);
    }

    public function showFormCreate()
    {
        if (count($_POST) !== 0) {
            $post = new Post();

            $post->setTitle($_POST["title"]);
            $post->setChapo($_POST["chapo"]);
            $post->setDescription($_POST["description"]);

            $isSavedImage = $this->isSavedImage($_FILES);
            $post->setImage($isSavedImage);

            $postRepository = new PostRepository();
            $postRepository->createPost($post);

            header("Location:" . Router::ROOT_DIRECTORY . '?page=posts');
        } else {
            $this->twig->display('pages/createPost.html.twig', [
                "root_directory" => Router::ROOT_DIRECTORY,
            ]);
        }
    }

    public function showFormModify(int $id): void
    {
        $postRepository = new PostRepository();
        $showData = $postRepository->getOnePost($id);
        if (count($_POST) !== 0) {
            $showData->setTitle($_POST["title"]);
            $showData->setDescription($_POST["description"]);
            $showData->setImage($_POST["image"]);
            $showData->setChapo($_POST["chapo"]);

            $updateRepository = new PostRepository();
            $updateRepository->updatePost($showData, $id);

            header("Location:" . Router::ROOT_DIRECTORY . '?page=posts');
        } else {
            $this->twig->display('pages/modifyPost.html.twig', [
                "root_directory" => Router::ROOT_DIRECTORY,
                "post" => $showData,
            ]);
        }
    }

    public function deletePost(int $id): void
    {
        $deleteRepository = new PostRepository;
        $deleteRepository->deletePost($id);

        header("Location:" . Router::ROOT_DIRECTORY . '?page=posts');
    }

    public function isSavedImage($image): string
    {
        $nameImage = $image["image"]["name"];
        move_uploaded_file($image["image"]["tmp_name"], __DIR__ . '/../image/upload/' . $nameImage);

        return $nameImage;
    }
}