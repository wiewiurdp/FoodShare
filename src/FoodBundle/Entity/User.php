<?php

namespace FoodBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getTransactions()
    {
        return $this->transactions;
    }

    /**
     * @param mixed $transactions
     */
    public function setTransactions($transactions)
    {
        $this->transactions = $transactions;
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        $this->posts = new ArrayCollection();
        $this->transactions = new ArrayCollection();
    }

    /**
     * One User has many Transactions.
     * @ORM\OneToMany(targetEntity="FoodBundle\Entity\Transaction", mappedBy="user")
     */
    private $transactions;


    /**
     * One User has Many Posts.
     * @ORM\OneToMany(targetEntity="FoodBundle\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @return mixed
     */
    public function getRatingAmount()
    {
        return $this->ratingAmount;
    }

    /**
     * @param mixed $ratingAmount
     */
    public function setRatingAmount($ratingAmount)
    {
        $this->ratingAmount = $ratingAmount;
    }

    /**
     * @return float
     */
    public function getRating()
    {
        return $this->rating;
    }

    /**
     * @param float $rating
     */
    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    /**
     * @return float
     */
    public function getRatingSum()
    {
        return $this->ratingSum;
    }

    /**
     * @param float $ratingSum
     */
    public function setRatingSum($ratingSum)
    {
        $this->ratingSum = $ratingSum;
    }

    /**
     * @var float
     *
     * @ORM\Column(name="ratingAmount", type="decimal", scale=2, nullable=TRUE)
     */
    private $ratingAmount;

    /**
     * @var float
     *
     * @ORM\Column(name="rating", type="decimal", scale=2, nullable=TRUE)
     */
    private $rating;

    /**
     * @var float
     *
     * @ORM\Column(name="ratingSum", type="decimal", scale=2, nullable=TRUE)
     */
    private $ratingSum;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="phoneNumber", type="string", length=255)
     */
    private $phoneNumber;

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
    }


    /**
     * @return mixed
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * @param mixed $posts
     */
    public function setPosts($posts)
    {
        $this->posts = $posts;
    }
    // ...


}