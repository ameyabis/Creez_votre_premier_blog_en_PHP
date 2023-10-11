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
        $post->setDateTime(\DateTime::createFromFormat('Y-m-j H:i:s', $postData["dateTime"]));
        // $post->setDateTime($postData["dateTime"]);
        $post->setChapo($postData["chapo"]);
        $post->setLastUpdate(\DateTime::createFromFormat('Y-m-j H:i:s', $postData["lastUpdate"]));
        // $post->setLastUpdate($postData["lastUpdate"]);

        return $post;
    }

    /**
     * @return Post[]
     */
    public function getAllPosts(): array
    {
        $getData = $this->db->getConnection()->prepare('SELECT * FROM Post ORDER BY id DESC');
        $getData->execute();
        $postDatas = $getData->fetchAll();
        $posts = [];

        foreach ($postDatas as $postData) {
            $post = new Post();

            $post->setId($postData["id"]);
            $post->setTitle($postData["title"]);
            $post->setDescription($postData["description"]);
            $post->setImage($postData["image"]);
            $post->setDateTime(\DateTime::createFromFormat('Y-m-j H:i:s', $postData["dateTime"]));
            $post->setChapo($postData["chapo"]);
            $post->setLastUpdate(\DateTime::createFromFormat('Y-m-j H:i:s', $postData["dateTime"]));

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
            $post->setDateTime(\DateTime::createFromFormat('Y-m-j H:i:s', $postData["dateTime"]));
            $post->setImage($postData["image"]);
            $post->setChapo($postData["chapo"]);
            $post->setLastUpdate(\DateTime::createFromFormat('Y-m-j H:i:s', $postData["dateTime"]));

            $posts[] = $post;
        }

        return $posts;
    }

    public function createPost(Post $post): void
    {
        $sql = "INSERT INTO Post (title, description, image, chapo, dateTime, lastUpdate) 
                VALUES (:title, :description, :image, :chapo, NOW(), NOW())";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':description', $post->getDescription());
        $stmt->bindValue(':image', $post->getImage());
        $stmt->bindValue(':chapo', $post->getChapo());

        if ($stmt->execute()) {
            echo 'Insertion réussie !';
        } else {
            echo 'Erreur lors de l\'insertion';
        }
    }

    public function updatePost(Post $post, int $id): void
    {
        $sql = "UPDATE Post 
                SET title = :title, description = :description, image = :image, chapo = :chapo, lastUpdate = NOW()
                WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $post->getId());
        $stmt->bindValue(':title', $post->getTitle());
        $stmt->bindValue(':description', $post->getDescription());
        $stmt->bindValue(':image', $post->getImage());
        $stmt->bindValue(':chapo', $post->getChapo());

        if ($stmt->execute()) {
            echo 'Modification réussie !';
        } else {
            echo 'Erreur lors de l\'insertion';
        }
    }

    public function deletePost(int $id): void
    {
        $sql = "DELETE FROM Post
                WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            echo 'Suppression terminé';
        } else {
            echo 'Erreur lors de la suppression';
        }
    }
}