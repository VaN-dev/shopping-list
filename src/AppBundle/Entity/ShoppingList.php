<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ShoppingList
 *
 * @ORM\Table(name="shoppinglists")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShoppingListRepository")
 */
class ShoppingList
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
     * @var integer
     *
     * @ORM\Column(name="scope", type="smallint")
     */
    private $scope;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=true)
     */
    protected $user;

    /**
     * @var ShoppingListRecipe[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\ShoppingListRecipe", mappedBy="shoppingList", cascade={"persist"})
     */
    private $recipes;

    /**
     * @var RecipeIngredient[]
     */
    private $groupedIngredients = [];


    /**
     * CUSTOM METHODS
     */

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->recipes = new ArrayCollection();
        $this->scope = 0;
    }

    /**
     * Add groupedIngredient
     *
     * @param RecipeIngredient $recipeIngredient
     * @return ShoppingList
     */
    public function addGroupedIngredient(RecipeIngredient $recipeIngredient)
    {
        $this->groupedIngredients[] = $recipeIngredient;

        return $this;
    }

    /**
     * Remove groupedIngredient
     *
     * @param RecipeIngredient $recipeIngredient
     */
    public function removeGroupedIngredient(RecipeIngredient $recipeIngredient)
    {
        $this->groupedIngredients->removeElement($recipeIngredient);
    }

    /**
     * Get groupedIngredients
     *
     * @return recipeIngredient[]
     */
    public function getGroupedIngredients()
    {
        return $this->groupedIngredients;
    }

    /**
     * GETTERS & SETTERS
     */

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
     * @return ShoppingList
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
     * Set scope
     *
     * @param integer $scope
     * @return ShoppingList
     */
    public function setScope($scope)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return integer
     */
    public function getScope()
    {
        return $this->scope;
    }

    /**
     * Set user
     *
     * @param User $user
     * @return ShoppingList
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add recipe
     *
     * @param ShoppingListRecipe $recipe
     * @return ShoppingList
     */
    public function addRecipe(ShoppingListRecipe $recipe)
    {
        if (null === $recipe->getShoppingList()) {
            $recipe->setShoppingList($this);
        }
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param ShoppingListRecipe $recipe
     */
    public function removeRecipe(ShoppingListRecipe $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    /**
     * Get recipes
     *
     * @return ShoppingListRecipe[]
     */
    public function getRecipes()
    {
        return $this->recipes;
    }
}
