<?php
/**
 *
 * User: isk
 * Date: 09.10.17
 * Time: 20:08
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
// Contrainte d'unicité
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * Class Locality
 * @package App\Entity
 *
 * @ORM\Table(name="be_locality")
 * @ORM\Entity(repositoryClass="App\Repository\LocalityRepository")
 * @UniqueEntity(fields={"locality"}, message="Cette localité existe déjà")
 */
class Locality
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
     * @ORM\Column(name="locality", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $locality;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="locality")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLocality(): string
    {
        return $this->locality;
    }

    /**
     * @param string $locality
     */
    public function setLocality(string $locality)
    {
        $this->locality = $locality;
    }

    /**
     * Get users
     *
     * @return ArrayCollection
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