<?php
namespace App\Repository;

use App\Model\User;
use App\Config\connectBDD;

class UserRepository
{
    private connectBDD $db;
    public User $user;
    public function __construct()
    {
        $this->db = new connectBDD;
    }
    public function findByUsername(string $username): ?User
    {
        $getData = $this->db->getConnection()->prepare('SELECT * FROM User WHERE username = :username');
        $getData->execute([':username' => $username]);
        $userData = $getData->fetch();

        if ($userData !== false) {
            $user = new User();
            $user->setId($userData['id']);
            $user->setUserName($userData['userName']);
            $user->setEmail($userData['email']);
            $user->setFirstName($userData['firstName']);
            $user->setLastName($userData['lastName']);
            $user->setPassword($userData['password']);
            $user->setIsAdmin($userData['isAdmin']);

            return $user;
        }

        return null;
    }

    public function findByEmail(string $email): bool
    {
        $getData = $this->db->getConnection()->prepare('SELECT * FROM User WHERE email = :email');
        $getData->execute([':email' => $email]);
        $userData = $getData->fetch();

        if ($userData !== false) {
            return true;
        } else {
            return false;
        }
    }

    public function createUser(User $user): string
    {
        $stmt = $this->db->getConnection()->prepare(
            'INSERT INTO User (firstname, lastname, username, password, email, isAdmin) 
            VALUES (:firstname, :lastname, :username, :password, :email, :isAdmin)'
        );
        $stmt->bindValue(':firstname', $user->getFirstName());
        $stmt->bindValue(':lastname', $user->getLastName());
        $stmt->bindValue(':username', $user->getUserName());
        $stmt->bindValue(':password', $user->getPassword());
        $stmt->bindValue(':email', $user->getEmail());
        $stmt->bindValue(':isAdmin', 0);
        
        if ($stmt->execute()) {
            $message = 'Insertion réussie !';

            return $message;
        } else {
            $message = 'Erreur lors de l\'insertion';

            return $message;
        }
    }
}
