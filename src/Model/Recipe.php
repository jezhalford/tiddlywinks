<?php
namespace Rinky\Model;

class Recipe
{

    private $id;

    private $name;

    private $instructions;

    private $description;

    public function __construct($id, $name, $instructions, $description)
    {

        $this->id = $id;
        $this->name = $name;
        $this->instructions = $instructions;
        $this->description = $description
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getInstructions()
    {
        return $this->instructions;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
