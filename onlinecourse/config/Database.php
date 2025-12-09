<?php

// Database configuration settings
class Database
{
    private static $instance = null;

    public static function getInstance()
    {
        if (self::$instance === null) {
            $host     = '127.0.0.1';
            $dbname   = 'CNWeb_BTTH02';
            $username = 'root';
            $password = '';
            $charset  = 'utf8mb4';

            try {
                $dsn     = "mysql:host=$host;dbname=$dbname;charset=$charset";
                $options = [
                    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES   => false,
                ];

                self::$instance = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                die('Kết nối thất bại: ' . $e->getMessage());
            }
            return self::$instance;
        }
    }
}
