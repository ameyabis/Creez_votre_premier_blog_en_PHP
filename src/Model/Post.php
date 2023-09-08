<?php

namespace App\Model;

class Post
{
    private int $id;
    private string $title;
    private string $description;
    private string $image;
    private \DateTime $dateTime;
    private string $chapo;
    private \DateTime $lastUpdate;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): Post
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): Post
    {
        $this->title = $title;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): Post
    {
        $this->description = $description;
        return $this;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function setImage(string $image): Post
    {
        $this->image = $image;
        return $this;
    }

    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    public function setDateTime(\DateTime $dateTime): Post
    {
        $this->dateTime = $dateTime;
        return $this;
    }

    public function getChapo(): string
    {
        return $this->chapo;
    }

    public function setChapo(string $chapo): Post
    {
        $this->chapo = $chapo;
        return $this;
    }

    public function getLastUpdate(): \DateTime
    {
        return $this->lastUpdate;
    }

    public function setLastUpdate(\DateTime $lastUpdate): Post
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }
}