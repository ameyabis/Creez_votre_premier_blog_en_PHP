<?php
namespace App\Config;

use PDO;
use Exception;

class connectBDD
{
    public function __construct()
    {

    }

    public function getConnection()
    {
        try {
            $db = new PDO('mysql:host=localhost;dbname=portfolio;charset=utf8', 'root', 'root');
        } catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        
        return $db;
    }
}