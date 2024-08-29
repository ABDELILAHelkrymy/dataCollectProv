<?php

namespace core;

use PDO;
use PDOException;

class Connection
{
    public static function connect($config)
    {
        try {
            $conn = new PDO(
                $config['connection'] . ';dbname=' . $config['dbname'],
                $config['user'],
                $config['password'],
                $config['options']
            );
            return $conn;
        } catch (PDOException $e) {
            die("erreur de la connexion:" . $e->getMessage());
        }
    }
}