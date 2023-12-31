<?php

namespace App\Model;

class Comment
{
    private int $id;
    private string $content;
    private string $statusComment;
    private int $idPost;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Comment
    {
        $this->id = $id;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): Comment
    {
        $this->content = $content;
        return $this;
    }

    public function getStatusComment(): string
    {
        return $this->statusComment;
    }

    public function setStatusComment(string $statusComment): Comment
    {
        $this->statusComment = $statusComment;
        return $this;
    }

    public function getIdPost(): string
    {
        return $this->idPost;
    }

    public function setIdPost(int $idPost): Comment
    {
        $this->idPost = $idPost;
        return $this;
    }
}