<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingListRecipe
 *
 * @ORM\Table(name="shoppinglist_recipes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShoppingListRecipeRepository")
 */
class ShoppingListRecipe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var ShoppingList
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ShoppingList", inversedBy="recipes")
     * @ORM\JoinColumn(name="shoppinglist_id")
     */
    private $shoppingList;

    /**
     * @var Recipe
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Recipe")
     * @ORM\JoinColumn(name="recipe_id")
     */
    private $recipe;

    /**
     * @var integer
     *
     * @ORM\Column(name="people", type="integer")
     */
    private $people;

    /**
     * ShoppingListRecipe constructor.
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
    }


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ShoppingListRecipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set shoppingList
     *
     * @param ShoppingList $shoppingList
     *
     * @return ShoppingListRecipe
     */
    public function setShoppingList(ShoppingList $shoppingList = null)
    {
        $this->shoppingList = $shoppingList;

        return $this;
    }

    /**
     * Get shoppingList
     *
     * @return ShoppingList
     */
    public function getShoppingList()
    {
        return $this->shoppingList;
    }

    /**
     * Set recipe
     *
     * @param Recipe $recipe
     *
     * @return ShoppingListRecipe
     */
    public function setRecipe(Recipe $recipe = null)
    {
        $this->recipe = $recipe;

        return $this;
    }

    /**
     * Get recipe
     *
     * @return \AppBundle\Entity\Recipe
     */
    public function getRecipe()
    {
        return $this->recipe;
    }

    /**
     * Set people
     *
     * @param integer $people
     *
     * @return ShoppingListRecipe
     */
    public function setPeople($people)
    {
        $this->people = $people;

        return $this;
    }

    /**
     * Get people
     *
     * @return integer
     */
    public function getPeople()
    {
        return $this->people;
    }
}
