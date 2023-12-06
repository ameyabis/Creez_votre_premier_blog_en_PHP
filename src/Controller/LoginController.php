<?php

namespace App\Controller;

use App\Model\User;
use Twig\Environment;
use App\router\Router;
use App\Repository\UserRepository;
use App\Controller\HomePageController;

class LoginController
{
    public function __construct(
        public Environment $twig
    ) {
        $this->twig->addGlobal('session', $_SESSION);
    }

    public function getFormLogin(): void
    {
        $this->twig->display('pages/connection/login.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
        ]);
    }

    public function getFormRegister(): void
    {
        $this->twig->display('pages/connection/register.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
        ]);
    }

    public function register(
        string $username,
        string $password,
        string $email,
        string $firstname,
        string $lastname
    ): void {
        $userRepository = new UserRepository();
        $userExiste = $userRepository->findByEmail($email);

        if ($userExiste === false) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword(password_hash($password, PASSWORD_BCRYPT));
            $user->setEmail($email);
            $user->setFirstname($firstname);
            $user->setLastname($lastname);
            // $user->setIsAdmin(false);

            $userRepository->createUser($user);

            // $this->login($user->getUserName(), $user->getPassword());
        }
    }

    public function login(string $username, string $password): void
    {
        $userRepository = new UserRepository();
        $user = $userRepository->findByUsername($username);

        if (
            isset($user)
            && $user->getUserName() === $username
            && password_verify($password, $user->getPassword())
        ) {
            $_SESSION["username"] = $username;
            $_SESSION["firstname"] = $user->getFirstName();
            $_SESSION["lastname"] = $user->getLastName();
            $_SESSION["email"] = $user->getEmail();
            $_SESSION["isAdmin"] = $user->getIsAdmin();

            $homePage = new HomePageController($this->twig);
            $homePage->showHomePage();
        } else {
            $message = "Erreur dans le mot de passe ou dans le nom d'utilisateur";

            $this->twig->display('pages/connection/login.html.twig', [
                "root_directory" => Router::ROOT_DIRECTORY,
                "message" => $message,
            ]);
        }
    }

    public function logout()
    {
        session_destroy();

        $homePage = new HomePageController($this->twig);
        $homePage->showHomePage();
    }
}