<?php

if (isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] === 'production') {
    // production environment
    define('DB_NAME', $_SERVER['RDS_DB_NAME']);
    define('DB_USER', $_SERVER['RDS_USERNAME']);
    define('DB_PASSWORD', $_SERVER['RDS_PASSWORD']);
    define('DB_HOST', $_SERVER['RDS_HOSTNAME']);
} else {
    // local environment
    define('DB_NAME', 'cloud_festivals_db');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');
}

class Connection
{

    private static $database = DB_NAME;
    private static $username = DB_USER;
    private static $password = DB_PASSWORD;
    private static $host = DB_HOST;

    public static function getInstance()
    {
        $dsn = 'mysql:host=' . Connection::$host . ';dbname=' . Connection::$database;

        $connection = new PDO($dsn, Connection::$username, Connection::$password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $connection;
    }

}
