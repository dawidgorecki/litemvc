<?php

namespace Libraries\Core;

class Model
{
    protected $database;
    
    /**
     * Create database connection
     */
    public function __construct()
    {
        $connection = DatabaseFactory::getFactory()->getConnection();
        $this->database = new Database($connection);
    }
    
    /**
     * Get database instance
     * @return \Libraries\Core\Database
     */
    public function getDB(): Database
    {
        return $this->database;
    }
}
