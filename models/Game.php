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
    public static function create($id, $title, $releaseDate, $link, $developerId, $platformId) {
        $releaseDate = new DateTime($releaseDate);

        return new Game($id, $title, $releaseDate, $link, $developerId, $platformId);
    }

    /**
     * Save current object state in database
     */
    public function save() 
    {
        if (is_null($this->id)) {
            $this->insert();
        } else {
            $this->update();
        }
    }

    /**
     * Add new database record base on this object's properties
     */
    protected function insert()
    {
        global $databaseHandler;

        // Crée une requête préparée permettant d'insérer un nouvel enregistrement
        // dans la table 'game'
        $statement = $databaseHandler->prepare('
            INSERT INTO `game` (
                `title`,
                `release_date`,
                `link`,
                `developer_id`,
                `platform_id`
            )
            VALUES (
                :title,
                :release_date,
                :link,
                :developer_id,
                :platform_id
            )
        ');
        // Exécute la requête préparée en remplaçant chaque champ précédé de ':' par la propriété
        // correspondnate de l'objet
        $statement->execute([
            ':title' => $this->title,
            ':release_date' => $this->releaseDate->format('Y-m-d'),
            ':link' => $this->link,
            ':developer_id' => $this->developerId,
            ':platform_id' => $this->platformId,            
        ]);

        $this->id = $databaseHandler->lastInsertId();
    }

    /**
     * Update macthing database record
     */
    protected function update()
    {
        global $databaseHandler;

        $statement = $databaseHandler->prepare('
            UPDATE `game`
            SET
                `title` = :title,
                `release_date` = :release_date,
                `link` = :link,
                `developer_id` = :developer_id,
                `platform_id` = :platform_id
            WHERE `id` = :id
        ');
        $statement->execute([
            ':id' => $this->id,
            ':title' => $this->title,
            ':release_date' => $this->releaseDate->format('Y-m-d'),
            ':link' => $this->link,
            ':developer_id' => $this->developerId,
            ':platform_id' => $this->platformId,            
        ]);
    }

    /**
     * Delete matching database record
     */
    public function delete()
    {
        global $databaseHandler;

        $statement = $databaseHandler->prepare('DELETE FROM `game` WHERE `id` = :id');
        $statement->execute([ ':id' => $this->id ]);

        $this->id = null;
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
    public function getReleaseDate(): DateTime
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
            throw new InvalidValueException('Game::link property must be a valid URL.', 5);
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
