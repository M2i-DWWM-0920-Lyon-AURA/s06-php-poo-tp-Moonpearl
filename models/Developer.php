<?php

class Developer
{
    protected $id;
    protected $name;
    protected $link;

    /**
     * Create new Developer object
     * 
     * @param int $id Database ID
     * @param string $name Developer name
     * @param string $link Link to developer's website
     */
    public function __construct(int $id = null, string $name = '', string $link = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->setLink($link);
    }

    /**
     * Fetch all developers from database as Developer objects
     */
    public static function fetchAll() {
        global $databaseHandler;
    
        $statement = $databaseHandler->query('SELECT * FROM `developer`');
        return $statement->fetchAll(PDO::FETCH_FUNC, 'Developer::create');
    }

    /**
     * Convert `developer` record from database to Developer object
     */
    public static function create($id, $name, $link) {
        return new Developer($id, $name, $link);
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of link
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     *
     * @return  self
     */ 
    public function setLink($link)
    {
        // Vérifie que la nouvelle valeur reçue est bien une URL
        if (!filter_var($link, FILTER_VALIDATE_URL)) {
            throw new Exception('Developer::link property must be a valid URL.');
        }

        $this->link = $link;

        return $this;
    }
}
