<?php
namespace App\Repository;

use App\Model\Post;
use App\Model\Comment;
use App\Config\connectBDD;

class CommentRepository
{
    private connectBDD $db;
    public Comment $comment;
    public int $idPost;
    public function __construct()
    {
        $this->db = new connectBDD;
    }

    public function createComment(Comment $comment, int $id): string
    {
        $sql = "INSERT INTO Comment (content, idPost, status) VALUES (:content, :idPost, 'NoValidate')";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':content', $comment->getContent());
        $stmt->bindValue(':idPost', $id);
        
        if ($stmt->execute()) {
            $message = 'Insertion réussie !';

            return $message;
        } else {
            $message = 'Erreur lors de l\'insertion';

            return $message;
        }
    }
    
    public function getValidatedCommentByPostId(int $id): array
    {
        $getLimitComment = $this->db->getConnection()->prepare('SELECT * FROM Comment WHERE idPost = :id AND status = "validate"');
        $getLimitComment->execute([':id' => $id]);
        $commentDatas = $getLimitComment->fetchAll();
        $comments = [];

        foreach ($commentDatas as $commentData) {
            $comment = new Comment();

            $comment->setId($commentData["id"]);
            $comment->setContent($commentData["content"]);

            $comments[] = $comment;
        }

        return $comments;
    }

    public function getCommentNotValidated(): array
    {
        $getLimitComment = $this->db->getConnection()->prepare('SELECT * FROM Comment WHERE status = "NoValidate"');
        $getLimitComment->execute();
        $commentDatas = $getLimitComment->fetchAll();

        $comments = [];

        foreach ($commentDatas as $commentData) {
            $comment = new Comment();
            $post = new Post();

            $comment->setId($commentData["id"]);
            $comment->setContent($commentData["content"]);
            $comment->setStatusComment($commentData["status"]);
            $comment->setIdPost($commentData["idPost"]);

            $comments[] = $comment;
        }

        return $comments;
    }

    public function deleteComment(int $id): string
    {
        $sql = "DELETE FROM Comment
                WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);

        if ($stmt->execute()) {
            $message = 'Suppression terminé';

            return $message;
        } else {
            $message = 'Erreur lors de la suppression';

            return $message;
        }
    }

    public function validateComment(int $id): string
    {
        $sql = "UPDATE Comment 
                SET status = 'validate'
                WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(':id', $id);
        
        if ($stmt->execute()) {
            $status = 'Success';

            return $status;
        } else {
            $status = 'Error';

            return $status;
        }
    }

}