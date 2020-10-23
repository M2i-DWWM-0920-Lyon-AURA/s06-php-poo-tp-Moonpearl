<?php

require_once './models/AbstractBrand.php';

class Developer extends AbstractBrand
{
    /**
     * Fetch all developers from database as Developer objects
     */
    public static function fetchAll() {
        global $databaseHandler;
    
        $statement = $databaseHandler->query('SELECT * FROM `developer`');
        return $statement->fetchAll(PDO::FETCH_FUNC, 'Developer::create');
    }

    /**
     * Fetch single developer by id
     */
    public static function fetchById(int $id) {
        global $databaseHandler;

        $statement = $databaseHandler->prepare('SELECT * FROM `developer` WHERE `id` = :id');
        $statement->execute([ ':id' => $id ]);
        $result = $statement->fetchAll(PDO::FETCH_FUNC, 'Developer::create');
        
        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    /**
     * Convert `developer` record from database to Developer object
     */
    public static function create($id, $name, $link) {
        return new Developer($id, $name, $link);
    }
}
