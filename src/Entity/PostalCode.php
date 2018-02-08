<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 09.10.17
 * Time: 20:18
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/** Composant de validation des propriétés **/
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use App\Entity\User;

/**
 * Class PostalCode
 * @package App\Entity
 *
 * @ORM\Table(name="be_postal_code")
 * @ORM\Entity(repositoryClass="App\Repository\PostalCodeRepository")
 * @UniqueEntity(fields={"postalCode"}, message="Ce code postal existe déjà!")
 */
class PostalCode
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="postal_code", type="integer", unique=true)
     * @Assert\NotBlank()
     */
    private $postalCode;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="User", cascade={"persist"}, mappedBy="postalCode")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set postalCode
     * @param int $postalCode
     */
    public function setPostalCode(int $postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * Get users
     *
     * @return ArrayCollection     *
     */
    public function getUsers(): ArrayCollection
    {
        return $this->users;
    }

    /**
     * Add user
     *
     * @param \App\Entity\User $user
     */
    public function addUser(User $user)
    {
        $this->users[] = $user;
    }

    /**
     * Remove user
     *
     * @param \App\Entity\User $user
     */
    public function removeUser(User $user)
    {
        $this->users->removeElement($user);
    }
}