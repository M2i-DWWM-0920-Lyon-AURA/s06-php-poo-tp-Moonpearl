<?php

require_once './models/AbstractBrand.php';

class Platform extends AbstractBrand
{
    /**
     * Fetch all developers from database as Developer objects
     */
    public static function fetchAll() {
        global $databaseHandler;
    
        $statement = $databaseHandler->query('SELECT * FROM `platform`');
        return $statement->fetchAll(PDO::FETCH_FUNC, 'Platform::create');
    }

    /**
     * Convert `developer` record from database to Developer object
     */
    public static function create($id, $name, $link) {
        return new Platform($id, $name, $link);
    }

}
