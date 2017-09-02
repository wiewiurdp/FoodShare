<?php

namespace FoodBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Post
 *
 * @ORM\Table(name="post")
 * @ORM\Entity(repositoryClass="FoodBundle\Repository\PostRepository")
 */
class Post
{
    /**
     * @ORM\ManyToMany(targetEntity="FoodBundle\Entity\Ingredient", inversedBy="posts")
     * @ORM\JoinTable(name="posts_ingredients")
     */
    private $ingredients;

    /**
     * @return ArrayCollection
     */
    public function getIngredients()
    {
        return $this->ingredients;
    }

    /**
     * @param ArrayCollection $ingredients
     * @return Post
     */
    public function setIngredients($ingredients)
    {
        $this->ingredients = $ingredients;
    }

    public function __construct()
    {
        $this->ingredients = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="subCategory", type="string", length=255)
     */
    private $subCategory;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=120)
     */
    private $title;


    /**
     * @var int
     *
     * @ORM\Column(name="hotness", type="integer")
     */
    private $hotness;

    /**
     * @var string
     *
     * @ORM\Column(name="vegan", type="string", length=255)
     */
    private $vegan;

    /**
     * @var string
     *
     * @ORM\Column(name="gluten", type="string", length=255)
     */
    private $gluten;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiration", type="datetime")
     */
    private $expiration;

    /**
     * @ORM\Column(name="photo", type="string", nullable=true)
     *
     * @Assert\File()
     * @Assert\Image()
     */
    private $photo;

    /**
     * @ORM\Column(name="creation_date", type="datetime", nullable=true)
     *
     */
    private $creationDate;

    /**
     * @ORM\Column(name="description",  type="string", length=255)
     *
     */
    private $description;

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * @param mixed $creationDate
     */
    public function setCreationDate()
    {
        $this->creationDate = new \DateTime("now");
    }
    /**
     * @return string
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * @param string $subCategory
     */
    public function setSubCategory($subCategory)
    {
        $this->subCategory = $subCategory;
    }
    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
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
     * Set category
     *
     * @param string $category
     * @return Post
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set hotness
     *
     * @param integer $hotness
     * @return Post
     */
    public function setHotness($hotness)
    {
        $this->hotness = $hotness;

        return $this;
    }

    /**
     * Get hotness
     *
     * @return integer
     */
    public function getHotness()
    {
        return $this->hotness;
    }

    /**
     * Set vegan
     *
     * @param string $vegan
     * @return Post
     */
    public function setVegan($vegan)
    {
        $this->vegan = $vegan;

        return $this;
    }

    /**
     * Get vegan
     *
     * @return string
     */
    public function getVegan()
    {
        return $this->vegan;
    }

    /**
     * Set gluten
     *
     * @param string $gluten
     * @return Post
     */
    public function setGluten($gluten)
    {
        $this->gluten = $gluten;

        return $this;
    }

    /**
     * Get gluten
     *
     * @return string
     */
    public function getGluten()
    {
        return $this->gluten;
    }

    /**
     * Set expiration
     *
     * @param \DateTime $expiration
     * @return Post
     */
    public function setExpiration($expiration)
    {
        $this->expiration = $expiration;

        return $this;
    }

    /**
     * Get expiration
     *
     * @return \DateTime
     */
    public function getExpiration()
    {
        return $this->expiration;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
}
