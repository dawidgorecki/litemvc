<?php

namespace Libraries\Core;

use PDO;
use PDOException;

class DatabaseFactory
{

    /**
     * @var DatabaseFactory
     */
    private static $factory;

    /**
     * @var PDO
     */
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
     * Return database configuration
     * @return array
     */
    protected function getConfig(): array
    {
        return [
            'driver' => Config::get('DB_TYPE', 'pgsql'),
            'host' => Config::get('DB_HOST', 'localhost'),
            'port' => Config::get('DB_PORT', '5432'),
            'charset' => Config::get('DB_CHARSET', 'utf8'),
            'db' => Config::get('DB_NAME'),
            'user' => Config::get('DB_USER','postgres'),
            'password' => Config::get('DB_PASS')
        ];
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
                /**
                 * Set connection options
                 */
                $options = [
                    PDO::ATTR_PERSISTENT => $persistent,
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ];

                $config = $this->getConfig();

                /**
                 * Set DSN and create new PDO instance
                 */
                $dsn = $config['driver'] . ':host=' . $config['host'] . ';dbname=' . $config['db'] . ';port=' . $config['port'];
                $this->database = new PDO($dsn, $config['user'], $config['password'], $options);

                /**
                 * Set encoding
                 */
                switch ($config['driver']) {
                    case 'mysql':
                        $this->database->exec("SET NAMES " . $config['charset']);
                        break;

                    case 'pgsql':
                        $this->database->exec("SET client_encoding='" . $config['charset'] . "';");
                        $this->database->exec("SET datestyle='DMY';");
                        break;
                }
            } catch (PDOException $e) {
                System::log("Database connection error", __FILE__);

                /**
                 * No connection, reached limit connections etc.
                 */
                $error = new \Controllers\ErrorController();
                $error->connectionError();

                exit();
            }
        }

        return $this->database;
    }

}
