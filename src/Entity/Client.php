<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 01.10.17
 * Time: 03:53
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\Comment;
use App\Entity\Provider;
use App\Entity\Position;
use App\Entity\User;

/**
 * Class Client
 *
 * @ORM\Entity(repositoryClass="App\Entity\ClientRepository")
 */
class Client extends User
{

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=255, nullable=true)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=255, nullable=true)
     */
    private $firstname;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean", nullable=true)
     */
    private $newsletter;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Position", mappedBy="client")
     */
    private $positions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Provider", cascade={"persist","remove"}, inversedBy="fans")
     * @ORM\JoinTable(name="be_favorite")
     */
    private $favorites;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="client")
     */
    private $comments;



    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->positions = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     */
    public function setLastname(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     */
    public function setFirstname(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * Set newsletter
     *
     * @param bool $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get positions
     *
     * @return ArrayCollection
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * Add position
     *
     * @param Position $position
     */
    public function addPosition(Position $position)
    {
        $this->positions[] = $position;
    }

    /**
     * Remove position
     *
     * @param Position $position
     */
    public function removePosition(Position $position)
    {
        $this->positions->removeElement($position);
    }

    /**
     * Get favorites
     *
     * @return ArrayCollection
     */
    public function getFavorites(): ArrayCollection
    {
        return $this->favorites;
    }

    /**
     * Add favori
     *
     * @param Provider $provider
     */
    public function addFavorite(Provider $provider)
    {
        $this->favorites[] = $provider;

        $provider->addFan($this);
    }

    /**
     * Remove favori
     *
     * @param Provider $provider
     */
    public function removeFavorite(Provider $provider)
    {
        $this->favorites->removeElement($provider);
    }

    /**
     * Get comments
     *
     * @return ArrayCollection
     */
    public function getComments() : ArrayCollection
    {
        return $this->comments;
    }

    /**
     * Add comment
     *
     * @param \App\Entity\Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->comments[] = $comment;

        $comment->setClient($this);
    }

    /**
     * Remove comment
     *
     * @param \App\Entity\Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->comments->removeElement($comment);
    }
}