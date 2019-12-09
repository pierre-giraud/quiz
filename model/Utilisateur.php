<?php


class Utilisateur
{
    private $id;
    private $nom;
    private $type;

    public function __construct($id, $nom, $type) {
        $this -> id   = $id;
        $this -> nom  = $nom;
        $this -> type = $type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    public function __toString()
    {
        return "Utilisateur n°" . $this->id . " - '" . $this->nom . "' de type " . $this->type;
    }
}