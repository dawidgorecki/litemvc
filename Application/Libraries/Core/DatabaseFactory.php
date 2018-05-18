<?php

namespace Libraries\Core;

use PDO;
use PDOException;

class DatabaseFactory
{

    private static $factory;
    private $database;

    /**
     * @return DatabaseFactory
     */
    public static function getFactory(): DatabaseFactory
    {
        if (!self::$factory) {
            self::$factory = new DatabaseFactory();
        }

        return self::$factory;
    }

    /**
     * Connect to the database and returns PDO instance
     * @param bool $persistent
     * @return PDO
     */
    public function getConnection(bool $persistent = false): PDO
    {
        if (!$this->database) {

            try {
                // Set connection options
                $options = [
                    PDO::ATTR_PERSISTENT => $persistent,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ];

                // Create new PDO instance
                $this->database = new PDO(
                  Config::get('DB_TYPE') . ':host=' . Config::get('DB_HOST') . ';dbname=' . Config::get('DB_NAME') . ';port=' . Config::get('DB_PORT'), 
                  Config::get('DB_USER'), 
                  Config::get('DB_PASS'), 
                  $options
                );

                // Set encoding
                switch (Config::get('DB_TYPE')) {
                    case 'mysql':
                        $this->database->exec("SET NAMES " . Config::get('DB_CHARSET'));
                        break;

                    case 'pgsql':
                        $this->database->exec("SET client_encoding='" . Config::get('DB_CHARSET') . "';");
                        $this->database->exec("SET datestyle='DMY';");
                        break;
                }
            } catch (PDOException $e) {
                // No connection, reached limit connections etc.
                
                $error = new \Controllers\ErrorController();
                $error->connectionError('Error');
                
                die();
            }
        }

        return $this->database;
    }

}
