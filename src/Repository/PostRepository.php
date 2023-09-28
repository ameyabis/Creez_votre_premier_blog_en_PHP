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

    /**
     * @return Post[]
     */
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

    public function createPost($post): void
    {
        $title = $post->getTitle();
        $chapo = $post->getChapo();
        $description = $post->getDescription();
        $image = $post->getImage();

        var_dump($title, $chapo, $description, $image);

        $sql = "INSERT INTO Post (title, description, image, chapo) VALUES (:title, :description, :image, :chapo)";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':title', $title);
        $stmt->bindValue(':description', $description);
        $stmt->bindValue(':image', $image);
        $stmt->bindValue(':chapo', $chapo);

        if ($stmt->execute())
        {
            echo 'Insertion réussie !';
        } else {
            echo 'Erreur lors de l\'insertion';
        }
        // $insertData = $this
        //     ->db->getConnection()
        //     ->prepare('INSERT INTO Post (title, description, image, chapo) 
        //                 VALUES (:title, :description, :image, :chapo) ');
    }
}