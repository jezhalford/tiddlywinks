<?php
namespace Tiddly\Entity;

/**
 * @Entity
 * @Table(name="recipe_ingredient")
 */
class RecipeIngredient
{

    /**
     * @Id
     * @Column(type="integer", name="id")
     * @GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="Drink", inversedBy="recipe")
     * @JoinColumn(name="recipe_id")
     **/
    protected $drink;

    /**
     * @ManyToOne(targetEntity="Ingredient", inversedBy="recipeIngredients")
     * @JoinColumn(name="ingredient_id")
     **/
    protected $ingredient;

    /**
     * @Column(type="integer", name="amount")
     */
    protected $amount;

    public function getId()
    {
        return $this->id;
    }

    public function getDrink()
    {
        return $this->drink;
    }

    public function getIngredient()
    {
        return $this->ingredient;
    }

    public function getAmount()
    {
        return $this->amount;
    }

}
