<?php

class Game
{
    protected $id;
    protected $title;
    protected $releaseDate;
    protected $link;
    protected $developerId;
    protected $platformId;

    public function __construct(
        ?int $id = null,
        string $title = '',
        ?DateTime $releaseDate = null,
        string $link = '',
        ?int $developerId = null,
        ?int $platformId = null
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->releaseDate = $releaseDate;
        $this->developerId = $developerId;
        $this->platformId = $platformId;
        $this->setLink($link);
    }

    /**
     * Fetch all games from database as Gamr objects
     */
    public static function fetchAll() {
        global $databaseHandler;
    
        $statement = $databaseHandler->query('SELECT * FROM `game`');
        return $statement->fetchAll(PDO::FETCH_FUNC, 'Game::create');
    }

    /**
     * Fetch single game by id
     */
    public static function fetchById(int $id) {
        global $databaseHandler;

        $statement = $databaseHandler->prepare('SELECT * FROM `game` WHERE `id` = :id');
        $statement->execute([ ':id' => $id ]);
        $result = $statement->fetchAll(PDO::FETCH_FUNC, 'Game::create');
        
        if (empty($result)) {
            return null;
        }

        return $result[0];
    }

    /**
     * Convert `game` record from database to Game object
     */
    public static function create($id, $name, $link) {
        return new Game($id, $name, $link);
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of title
     */ 
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @return  self
     */ 
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of releaseDate
     */ 
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set the value of releaseDate
     *
     * @return  self
     */ 
    public function setReleaseDate(DateTime $releaseDate)
    {
        $this->releaseDate = $releaseDate;

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
        if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
            throw new Exception('Game::link property must be a valid URL.');
        }

        $this->link = $link;

        return $this;
    }

    /**
     * Get developer as Developer object
     */
    public function getDeveloper(): ?Developer
    {
        return Developer::fetchById($this->developerId);
    }

    /**
     * Set developer
     */
    public function setDeveloper(Developer $developer): self
    {
        $this->developerId = $developer->getId();

        return $this;
    }

    /**
     * Get platform as Platform object
     */
    public function getPlatform(): ?Platform
    {
        return Platform::fetchById($this->platformId);
    }

    /**
     * Set Platform
     */
    public function setPlatform(Platform $platform): self
    {
        $this->platformId = $platform->getId();

        return $this;
    }
}
