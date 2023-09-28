<?php

namespace App\Model;

class User
{
    private int $id;
    private string $firstName;
    private string $lastName;
    private string $userName;
    private string $email;
    private string $picture;
    private int $roles;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): User
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): User
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getUserName(): string
    {
        return $this->userName;
    }

    public  function setUserName(string $userName): User
    {
        $this->userName = $userName;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): User
    {
        $this->picture = $picture;
        return $this;
    }

    
}