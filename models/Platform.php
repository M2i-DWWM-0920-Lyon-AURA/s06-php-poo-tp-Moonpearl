<?php

require_once './models/AbstractBrand.php';

class Platform extends AbstractBrand
{
    /**
     * Fetch all platforms from database as Platform objects
     */
    public static function fetchAll() {
        global $databaseHandler;
    
        $statement = $databaseHandler->query('SELECT * FROM `platform`');
        return $statement->fetchAll(PDO::FETCH_FUNC, 'Platform::create');
    }

    /**
     * Fetch single platform by id
     */
    public static function fetchById(int $id) {
        global $databaseHandler;

        $statement = $databaseHandler->prepare('SELECT * FROM `platfofrm` WHERE `id` = :id');
        $statement->execute([ ':id' => $id ]);
        $result = $statement->fetchAll(PDO::FETCH_FUNC, 'Platform::create');
        
        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    /**
     * Convert `platform` record from database to Platform object
     */
    public static function create($id, $name, $link) {
        return new Platform($id, $name, $link);
    }
}
