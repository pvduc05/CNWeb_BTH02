<?php

// Database configuration settings
class Database
{
    /** @var PDO $instance */
    private static $connection = null;

    public static function getConnection()
    {
        if (self::$connection === null) {
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

                self::$connection = new PDO($dsn, $username, $password, $options);
            } catch (PDOException $e) {
                throw new PDOException($e->getMessage(), (int) $e->getCode());
            }
        }

        return self::$connection;
    }
}
