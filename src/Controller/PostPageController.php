<?php
namespace App\Controller;

use App\Model\Post;
use Twig\Environment;
use App\router\Router;
use Twig\Loader\FilesystemLoader;
use App\Repository\PostRepository;


class PostPageController
{
    public Environment $twig;
    // private 

    public function __construct(FilesystemLoader $loader)
    {
        $this->twig = new Environment($loader);
    }
    public function showPostPage(int $id): void
    {
        $postRepository = new PostRepository();
        $onePost = $postRepository->getOnePost($id);

        $this->twig->display('pages/post.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "post" => $onePost
        ]);
    }
    public function showPostsPage()
    {
        $postRepository = new PostRepository();
        $postArray = $postRepository->getAllPosts();

        $this->twig->display('pages/posts.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
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
            $post->setImage($_POST["image"]);

            $postRepository = new PostRepository();
            $postRepository->createPost($post);
        } else {
            $this->twig->display('pages/createPost.html.twig', [
                "root_directory" => Router::ROOT_DIRECTORY,
            ]);
        }
    }
}