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
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

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
     * @var string
     *
     * @ORM\Column(name="image", nullable=true)
     */
    private $image;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User")
     * @ORM\JoinColumn(name="user", nullable=true)
     */
    private $user;

    /**
     * @var RecipeIngredient[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\RecipeIngredient", mappedBy="recipe", cascade={"persist", "remove"})
     */
    private $ingredients;

    /**
     * @var Scope
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Scope")
     */
    private $scope;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="AppBundle\Entity\Tag", mappedBy="recipes", cascade={"persist"})
     */
    private $tags;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->ingredients = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function getUploadRootDir()
    {
        // absolute path to your directory where images must be saved
//        return __DIR__.'/../../../web/'.$this->getUploadDir();

        $dir = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? str_replace('\\', '/', __DIR__) : __DIR__;

        return $dir.'/../../../web/'.$this->getUploadDir();
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
        return null === $this->image ? 'http://placehold.it/120x90' : $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . '/'.$this->getUploadDir().'/'.$this->image;
    }

    /**
     * @return array
     */
    public function guessSynonyms()
    {
        $synonyms = [];

        if (false !== strpos($this->name, '/')) {
            $synonyms[] = str_replace('/', '', $this->name);
        }

        return $synonyms;
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
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return Recipe
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }


    /**
     * Set name
     *
     * @param string $name
     *
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
     *
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
     * Set image
     *
     * @param string $image
     *
     * @return Recipe
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Recipe
     */
    public function setUser(\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add ingredient
     *
     * @param \AppBundle\Entity\RecipeIngredient $ingredient
     *
     * @return Recipe
     */
    public function addIngredient(\AppBundle\Entity\RecipeIngredient $ingredient)
    {
        if (null === $ingredient->getRecipe()) {
            $ingredient->setRecipe($this);
        }
        $this->ingredients[] = $ingredient;

        return $this;
    }

    /**
     * Remove ingredient
     *
     * @param \AppBundle\Entity\RecipeIngredient $ingredient
     */
    public function removeIngredient(\AppBundle\Entity\RecipeIngredient $ingredient)
    {
        $this->ingredients->removeElement($ingredient);
    }

    /**
     * Get ingredients
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIngredients()
    {
        return $this->ingredients;
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

    /**
     * @return ArrayCollection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param Tag $tag
     */
    public function addTag(Tag $tag)
    {
        $tag->addRecipe($this);

        $this->tags->add($tag);
    }

    public function removeTag(Tag $tag)
    {
        $this->tags->removeElement($tag);
    }
}
