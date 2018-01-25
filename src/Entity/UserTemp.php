<?php
/**
 * User: isk
 * Date: 09.01.18
 * Time: 20:35
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class UserTemp
 * @package App\Entity
 * @ORM\Table(name="be_temp_user")
 * @ORM\Entity(repositoryClass="App\Entity\UserTemp")
 *
 * Contrainte d'unicité sur la propriété "email"
 * @UniqueEntity(fields={"email"}, message="Cette adresse E-mail existe déjà ! ")
 */
class UserTemp implements UserInterface, \Serializable
{
    /**
     * @var int $id
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string email
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * Pour des raisons de sécurité (convention CVE-2013-5750), on limite à 4096 le nombre de caractères d'un mot de passe
     *
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @var string password
     * @ORM\Column(name="password", type="string", length=255)
     *
     */
    private $password;

    /**
     * @var string $userType
     * @ORM\Column(name="userType", type="string", length=12)
     */
    private $userType;

    /**
     * @var \DateTime $registry_date
     * @ORM\Column(name="registry_date", type="datetime")
     * @Assert\DateTime()
     */
    private $registry_date;

    /**
     * @var string $token
     * @ORM\Column(name="token", type="string", length=255)
     */
    private $token;

    /**
     * @var boolean $isActive
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;

    public function __construct()
    {
        $this->isActive = true;
        $this->registry_date = new \DateTime();
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
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }


    /**
     * @return string|null
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword(string $plainPassword): void
    {
        $this->plainPassword = $plainPassword;
    }



    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return null|string
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return null;
    }

    /**
     * @return string
     */
    public function getUserType(): string
    {
        return $this->userType;
    }

    /**
     * @param string $userType
     */
    public function setUserType(string $userType): void
    {
        $this->userType = $userType;
    }

    /**
     * @return \DateTime
     */
    public function getRegistryDate(): \DateTime
    {
        return $this->registry_date;
    }

    /**
     * @param \DateTime $registry_date
     */
    public function setRegistryDate(\DateTime $registry_date): void
    {
        $this->registry_date = $registry_date;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return array("ROLE_USER");
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
        $this->plainPassword = null;
    }

    /**
     * @see \Serializable::serialize()
     * @return string
     */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->token,
            $this->registry_date,
        ));
    }

    /**
     * @see \Serializable::unserialize()
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->token,
            $this->registry_date,
        ) = unserialize($serialized);
    }

}