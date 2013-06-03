<?php
namespace Rinky\Entity;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 * @Table(name="recipes")
 */
class Recipe
{
    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @Column(type="string", length=255, name="name")
     */
    protected $name;


    /**
     * @Column(type="text", name="instructions")
     */
    protected $instructions;

    /**
     * @Column(type="text", name="description")
     */
    protected $description;

    /**
     * @ManyToMany(targetEntity="Ingredient")
     **/
    protected $ingredients;

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
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

    public function getIngredients()
    {
        return $this->ingredients;
    }
}
