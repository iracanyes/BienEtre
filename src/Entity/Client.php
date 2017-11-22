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
     * @var ArrayCollection $positions
     *
     * @ORM\OneToMany(targetEntity="Position", mappedBy="client")
     */
    private $positions;

    /**
     * @var ArrayCollection $favorites
     *
     * @ORM\ManyToMany(targetEntity="Provider", cascade={"persist","remove"}, inversedBy="fans")
     * @ORM\JoinTable(name="be_favorite")
     */
    private $favorites;

    /**
     * @var ArrayCollection $comments
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="client")
     */
    private $comments;

    /**
     * @var ArrayCollection $abuses
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Abuse", mappedBy="client")
     */
    private $abuses;

    /**
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    protected $avatar;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $this->positions = new ArrayCollection();
        $this->favorites = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->abuses = new ArrayCollection();
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
     * @return Client
     */
    public function setLastname(string $lastname): Client
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
     * @return Client
     */
    public function setFirstname(string $firstname): Client
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get newsletter
     *
     * @return bool
     */
    public function getNewsletter(): bool
    {
        return $this->newsletter;
    }

    /**
     * Set newsletter
     *
     * @param bool $newsletter
     * @return Client
     */
    public function setNewsletter($newsletter): Client
    {
        $this->newsletter = $newsletter;

        return $this;
    }

    /**
     * Get positions
     *
     * @return ArrayCollection
     */
    public function getPositions(): ArrayCollection
    {
        return $this->positions;
    }

    /**
     * Add position
     *
     * @param Position $position
     * @return Client
     */
    public function addPosition(Position $position): Client
    {
        $this->positions[] = $position;

        $position->setClient($this);

        return $this;
    }

    /**
     * Remove position
     *
     * @param Position $position
     */
    public function removePosition(Position $position): void
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
     * Add favorite
     *
     * @param Provider $provider
     * @return Client
     */
    public function addFavorite(Provider $provider): Client
    {
        $this->favorites[] = $provider;

        $provider->addFan($this);

        return $this;
    }

    /**
     * Remove favorite
     *
     * @param Provider $provider
     */
    public function removeFavorite(Provider $provider): void
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
     * @return Client
     */
    public function addComment(Comment $comment): Client
    {
        $this->comments[] = $comment;

        /*
         * Association du commentaire au client qui l'a crée
         */
        $comment->setClient($this);

        /*
         * Ajout du commentaire dans les opinions du prestataire
         */
        $comment->getProvider()->addComment($comment);

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \App\Entity\Comment $comment
     */
    public function removeComment(Comment $comment): void
    {
        $this->comments->removeElement($comment);
    }

    /**
     * Get Abuses
     *
     * @return ArrayCollection
     */
      public function getAbuses(): string
      {
          return $this->abuses;
      }

      /**
       * Add Abuse
       *
       * @param \App\Entity\Abuse $abuse
       * @return Client
       */
      public function addAbuse(Abuse $abuse): Client
      {
          $this->abuses = $abuse;

          $abuse->setClient($this);
      }

      /**
       * Remove Abuse
       *
       * @param \App\Entity\Abuse $abuse
       */
      public function removeAbuse(Abuse $abuse): void
      {
          $this->abuses->removeElement($abuse);
      }

      /**
      * @return \App\entity\Image
      */
    public function getAvatar(): Image
    {
        return $this->avatar;
    }

      /**
     * @param \App\entity\Image $avatar
     */
      public function setAvatar(Image $avatar)
    {
        $this->avatar = $avatar;
    }
}