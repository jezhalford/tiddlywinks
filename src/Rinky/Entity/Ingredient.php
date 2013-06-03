<?php
namespace Rinky\Entity;

/**
 * @Entity
 * @Table(name="ingredients")
 */
class Ingredient
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
     * @Column(type="decimal", name="abv")
     */
    protected $abv;

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
