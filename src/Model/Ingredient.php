<?php
namespace Rinky\Model;

class Ingredient
{

    private $id;

    private $name;

    private $abv;

    public function __construct($id, $name, $abv)
    {

        $this->id = $id;
        $this->name = $name;
        $this->abv = $abv;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getAbv()
    {
        return $this->abv;
    }
}
