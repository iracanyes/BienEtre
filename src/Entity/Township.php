<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 09.10.17
 * Time: 20:00
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
// Contrainte d'unicité
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class Township
 * @package App\Entity
 *
 * @ORM\Table(name="be_township")
 * @ORM\Entity(repositoryClass="App\Repository\TownshipRepository")
 * @UniqueEntity(fields={"township"}, message="Cette commune existe déjà!")
 */
class Township
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     * @ORM\Column(name="township", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     */
    private $township;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="User", mappedBy="township")
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
     * @return string|null
     */
    public function getTownship()
    {
        return $this->township;
    }

    /**
     * @param string $township
     */
    public function setTownship($township)
    {
        $this->township = $township;
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