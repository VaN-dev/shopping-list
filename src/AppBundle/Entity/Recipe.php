<?php

namespace AppBundle\Entity;

use JMS\Serializer\Annotation\VirtualProperty;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Recipe
 *
 * @ORM\Table(name="recipes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeRepository")
 */
class Recipe
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="people", type="smallint")
     */
    private $people;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user", nullable=true)
     */
    protected $user;

    /**
     * @var Ingredient[]
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Ingredient", cascade={"persist"})
     * @ORM\JoinTable(name="recipe_ingredients")
     */
    private $ingredients;

    /**
     * @var string
     *
     * @ORM\Column(name="image")
     */
    private $image;

    /**
     * @var Scope
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Scope")
     */
    private $scope;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
        return __DIR__.'/../../../web/'.$this->getUploadDir();
    }

    public function getUploadDir()
    {
        return 'uploads/recipes';
    }

    public function getAbsolutePath()
    {
        return null === $this->image ? null : $this->getUploadRootDir().'/'.$this->image;
    }

    /**
     * @return null|string
     * @VirtualProperty
     */
    public function getWebPath()
    {
        return null === $this->image ? null : '/'.$this->getUploadDir().'/'.$this->image;
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
     * Set name
     *
     * @param string $name
     * @return Recipe
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set people
     *
     * @param integer $people
     * @return Recipe
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

    /**
     * Set user
     *
     * @param User $user
     * @return Recipe
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
     * Add ingredients
     *
     * @param Ingredient $ingredients
     * @return Recipe
     */
    public function addIngredient(Ingredient $ingredients)
    {
        $this->ingredients[] = $ingredients;

        return $this;
    }

    /**
     * Remove ingredients
     *
     * @param Ingredient $ingredients
     */
    public function removeIngredient(Ingredient $ingredients)
    {
        $this->ingredients->removeElement($ingredients);
    }

    /**
     * Get ingredients
     *
     * @return Ingredient[]
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * set image
     *
     * @param $image
     * @return Recipe
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Set scope
     *
     * @param \AppBundle\Entity\Scope $scope
     *
     * @return Recipe
     */
    public function setScope(\AppBundle\Entity\Scope $scope = null)
    {
        $this->scope = $scope;

        return $this;
    }

    /**
     * Get scope
     *
     * @return \AppBundle\Entity\Scope
     */
    public function getScope()
    {
        return $this->scope;
    }
}
