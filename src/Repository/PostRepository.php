<?php
namespace App\Repository;

use App\Model\Post;
use App\Config\connectBDD;

class PostRepository
{
    private connectBDD $db;
    public Post $posts;
    public function __construct()
    {
        $this->db = new connectBDD;
    }

    /**
     * @return Post
     */
    public function getOnePost(int $id): Post
    {
        $getData = $this->db->getConnection()->prepare('SELECT * FROM Post WHERE id = :id');
        $getData->execute([':id' => $id]);
        $postData = $getData->fetch();
        // var_dump($postData);die;

        $post = new Post();
        $post->setId($id);
        $post->setTitle($postData["title"]);
        $post->setDescription($postData["description"]);
        $post->setImage($postData["image"]);
        // $post->setDateTime($postData["dateTime"]);
        $post->setChapo($postData["chapo"]);
        // $post->setLastUpdate($postData["lastUpdate"]);

        return $post;
    }

    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {
        $getData = $this->db->getConnection()->prepare('SELECT * FROM Post');
        $getData->execute();
        $postDatas = $getData->fetchAll();
        $posts = [];

        foreach ($postDatas as $postData) {
            $post = new Post();

            $post->setId($postData["id"]);
            $post->setTitle($postData["title"]);
            $post->setDescription($postData["description"]);
            $post->setImage($postData["image"]);
            // $post->setDateTime($postData["dateTime"]);
            $post->setChapo($postData["chapo"]);
            // $post->setLastUpdate($postData["lastUpdate"]);

            $posts[] = $post;
        }

        return $posts;
    }

    public function getLastPost(): array
    {
        $getLimitPost = $this->db->getConnection()->prepare('SELECT * FROM Post ORDER BY id DESC LIMIT 3');
        $getLimitPost->execute();
        $postDatas = $getLimitPost->fetchAll();
        $posts = [];

        foreach ($postDatas as $postData) {
            $post = new Post();

            $post->setId($postData["id"]);
            $post->setTitle($postData["title"]);
            $post->setDescription($postData["description"]);
            $post->setImage($postData["image"]);
            $post->setChapo($postData["chapo"]);

            $posts[] = $post;
        }

        return $posts;
    }

    public function createPost()
    {
        // $form = $_POST
        $title = "New post";
        $chapo = "Ceci est un test de création de Post";
        $description = "Lorem Ipsum";

        $post = new Post();
        $post->setTitle($title);
        $post->setChapo($chapo);
        $post->setDescription($description);

        $insertData = $this->db->getConnection()->prepare('');
    }
}