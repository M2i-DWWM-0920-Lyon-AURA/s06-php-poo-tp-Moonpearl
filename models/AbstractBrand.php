<?php

abstract class AbstractBrand
{
    protected $id;
    protected $name;
    protected $link;

    /**
     * Create new AbstractBrand object
     * 
     * @param int $id Database ID
     * @param string $name AbstractBrand name
     * @param string $link Link to brand's website
     */
    public function __construct(int $id = null, string $name = '', string $link = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->setLink($link);
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
        if (!empty($link) && !filter_var($link, FILTER_VALIDATE_URL)) {
            throw new Exception('AbstractBrand::link property must be a valid URL.');
        }

        $this->link = $link;

        return $this;
    }
}
