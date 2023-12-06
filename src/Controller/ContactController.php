<?php
namespace App\Controller;

use Twig\Environment;
use App\router\Router;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;


class ContactController
{
    public function __construct(
        public Environment $twig
    ) {}

    public function showFormContact()
    {
        $this->twig->display('pages/contact.html.twig', [
            "root_directory" => Router::ROOT_DIRECTORY,
            "root_image" => Router::ROOT_IMAGE,
            "session" => $_SESSION,
        ]);
    }

    public function sendEmail()
    {
        $sujet = $_POST['title'];
        $contenu = $_POST['message'];

        $username = $_SESSION['username'];
        $email = $_SESSION['email'];

        $mail = new PHPMailer();
        $mail->SMTPDebug = 0;
        $mail->isSMTP();
        $mail->Host = 'a-w-c.eu';
        $mail->SMTPAuth = true;
        $mail->Username = "jg@a-w-c.eu";
        $mail->Password = "~8=^q1XeIb0E";
        $mail->SMTPSecure = "ssl";
        $mail->Port = 465;
        $mail->From = "jg@a-w-c.eu";
        $mail->FromName = "Contact de " . $username;

        $mail->addAddress("jeremy.ghesquiere98@gmail.com");
        $mail->isHTML(true);
        $mail->Subject = "Contact de " . $username;
        $mail->Body = "vous a contacter a se sujet " . $sujet . ".<br>
        sont addresse mail est la suivante: " . $email . "<br>" . $contenu;

        try {
            $mail->send();
            $message =  "Message has been sent successfully";

            $this->twig->display('pages/homepage.html.twig', [
                "root_directory" => Router::ROOT_DIRECTORY,
                "root_image" => Router::ROOT_IMAGE,
                "message" => $message,
            ]);
        } catch (Exception $e) {
            $message =  "Mailer Error: " . $mail->ErrorInfo;

            return $message;
        }
    }
}