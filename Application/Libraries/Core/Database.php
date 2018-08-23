<?php

namespace Libraries\Core;

use PDO;
use PDOException;

class Database
{

    /**
     * @var PDO
     */
    protected $pdo;

    /**
     * @var \PDOStatement
     */
    protected $stmt;

    /**
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Return a PDO instance representing a connection to a database
     * @return PDO
     */
    public function getPDO(): PDO
    {
        return $this->pdo;
    }

    /**
     * Initiates a transaction
     * @return bool
     */
    public function beginTransaction(): bool
    {
        try {
            return $this->pdo->beginTransaction();
        } catch (PDOException $e) {
            /**
             * Driver does not support transactions
             */
            die($e->getMessage());
        }
    }

    /**
     * Commits a transaction
     * @return bool
     */
    public function commit(): bool
    {
        try {
            return $this->pdo->commit();
        } catch (PDOException $e) {
            /**
             * There is no active transaction
             */
            die($e->getMessage());
        }
    }

    /**
     * Rolls back a transaction
     * @return bool
     */
    public function rollback(): bool
    {
        try {
            return $this->pdo->rollBack();
        } catch (PDOException $e) {
            /**
             * There is no active transaction
             */
            die($e->getMessage());
        }
    }

    /**
     * Prepares a statement for execution and returns a statement object
     * @param string $statement
     */
    public function prepare(string $statement)
    {
        try {
            $this->stmt = $this->pdo->prepare($statement);
        } catch (PDOException $e) {
            /**
             * Database server cannot prepare the statement
             */
            die($e->getMessage());
        }
    }

    /**
     * Bind a value to a parameter
     * @param string $param
     * @param mixed $value
     * @param mixed $type
     * @return bool
     */
    public function bind(string $param, $value, $type = null): bool
    {
        if (is_null($type)) {
            /**
             * Check data type of value
             */
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        return $this->stmt->bindValue($param, $value, $type);
    }

    /**
     * Execute a prepared statement
     * @return bool
     */
    public function execute(): bool
    {
        if ($this->stmt) {
            return $this->stmt->execute();
        }

        return false;
    }

    /**
     * Execute a prepared statement and return result set
     * @return mixed
     */
    public function executeAndFetchAll()
    {
        if ($this->execute()) {
            return $this->fetchAll();
        }

        return false;
    }

    /**
     * Execute an SQL statement and return the number of affected rows
     * @param string $statement
     * @return int
     */
    public function exec(string $statement): int
    {
        $count = $this->pdo->exec($statement);
        return ($count === false) ? -1 : $count;
    }

    /**
     * Execute an SQL statement
     * @param string $statement
     */
    public function query(string $statement)
    {
        $this->stmt = $this->pdo->query($statement);
    }

    /**
     * Execute an SQL statement and return result set
     * @param string $statement
     * @return mixed
     */
    public function queryAndFetchAll(string $statement)
    {
        $this->query($statement);
        return $this->fetchAll();
    }

    /**
     * Return result set
     * An empty array is returned if there are zero results to fetch, or FALSE on failure
     */
    public function fetchAll()
    {
        if ($this->stmt) {
            return $this->stmt->fetchAll();
        }

        return false;
    }

    /**
     * Fetch the next row from a result set
     */
    public function fetchSingle(int $fetchStyle = PDO::FETCH_ASSOC)
    {
        if ($this->stmt) {
            return $this->stmt->fetch($fetchStyle);
        }

        return false;
    }

    /**
     * Returns the number of rows affected by the last SQL statement
     * @return integer
     */
    public function affectedRows(): int
    {
        if ($this->stmt) {
            return $this->stmt->rowCount();
        }

        return 0;
    }

    /**
     * Return ID of the last inserted row
     * @return string
     */
    public function lastId(): string
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * Closes the cursor, enabling the statement to be executed again
     * @return bool
     */
    public function closeCursor(): bool
    {
        if ($this->stmt) {
            return $this->stmt->closeCursor();
        }

        return false;
    }

}
