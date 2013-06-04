<?php
namespace Tiddly\Entity;

use Doctrine\Common\Collections\ArrayCollection;


/**
 * @Entity
 * @Table(name="recipes")
 */
class Drink
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
     * @JoinTable(name="recipe_ingredient",
     *      joinColumns={@JoinColumn(name="recipe_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *      )
     **/
    protected $ingredients;

    /**
     * @ManyToMany(targetEntity="RecipeIngredient")
     * @JoinTable(name="recipe_ingredient",
     *      joinColumns={@JoinColumn(name="recipe_id", referencedColumnName="id")},
     *      inverseJoinColumns={@JoinColumn(name="ingredient_id", referencedColumnName="id")}
     *      )
     */
    protected $recipeIngredients;

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

    public function getRecipeIngredients()
    {
        return $this->recipeIngredients;
    }

    protected function alcoholCalculations() {
        $totalVolume = 0;

        $alcoholValue = 0;

        foreach($this->getRecipeIngredients() as $recipeIngredient) {
            $totalVolume += $recipeIngredient->getAmount();
            $alcoholValue += $recipeIngredient->getAmount() * ($recipeIngredient->getIngredient()->getAbv() / 100);
        }

        return array('alc_vol' => $alcoholValue, 'total_vol' => $totalVolume);
    }

    public function getAbv()
    {
        $numbers = $this->alcoholCalculations();

        return ($numbers['alc_vol'] / $numbers['total_vol']) * 100;
    }

    public function getAlcoholVolume()
    {
        $numbers = $this->alcoholCalculations();

        return $numbers['alc_vol'];
    }

    public function getTotalVolume()
    {
        $numbers = $this->alcoholCalculations();

        return $numbers['total_vol'];
    }
}
