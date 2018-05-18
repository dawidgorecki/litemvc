<?php

namespace Models;

use Libraries\Core\Model;

class Page extends Model
{

    /**
     * Example of using database
     */
    public function getPageTitleById(int $id)
    {
        $db = $this->getDB();

        // Prepare a statement for execution 
        $db->prepare("SELECT title FROM pages WHERE id = :id LIMIT 1");
        
        // Bind a value to a parameter
        $db->bind("id", $id);

        // Execute a prepared statement and return result set
        return $db->executeAndFetch();
    }

}
