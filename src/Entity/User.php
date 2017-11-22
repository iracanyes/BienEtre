<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 09.10.17
 * Time: 19:13
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Client;
use App\Entity\Provider;
use App\Entity\PostalCode;
use App\Entity\Locality;
use App\Entity\Township;

/**
 * Class User
 * @package App\Entity
 *
 * Attention: Ici, on doit choisir entre 2 méthodes d'héritage.
 * Une seule table contiendra toutes les informations sur tous types d'utilisateurs
 *      ORM\InheritanceType("SINGLE_TABLE")
 *          => plus performantes car moins de jointures entre tables
 * Une table parent dont les tables enfants hériteront des attributs
 *      ORM\InheritanceType("JOINED")
 *
 * @ORM\Table(name="be_user")
 * @ORM\Entity(repositoryClass="App\Entity\UserRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 *
 * Attention: DiscriminatorColumn permet de définir la colonne sur laquelle sera effectué la discrimination.
 * La colonne "user_type" sera généré et géré automatiquement par Doctrine pour faire la discrimination entre les différents types d'entités!
 *
 * @ORM\DiscriminatorColumn(name="user_type", type="string", length=255)
 * @ORM\DiscriminatorMap({"user" = "User", "client" = "Client", "provider" = "Provider"})
 */
class User
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     */
    protected $password;

    /**
     * @ORM\Column(name="registry_date", type="datetime")
     */
    protected $registryDate;

    /**
     * @ORM\Column(name="nb_error_connection", type="integer")
     */
    protected $nbErrorConnection;

    /**
     * @ORM\Column(name="banned", type="boolean")
     */
    protected $banned;

    /**
     * @ORM\Column(name="registry_confirmed", type="boolean")
     */
    protected $registryConfirmed;

    /**
     * @ORM\ManyToOne(targetEntity="PostalCode", cascade={"persist"}, inversedBy="users")
     * @ORM\JoinColumn(name="postal_code")
     */
    protected $postalCode;

    /**
     * @ORM\ManyToOne(targetEntity="Locality", cascade={"persist"},inversedBy="users")
     * @ORM\JoinColumn(name="locality")
     */
    protected $locality;

    /**
     * @ORM\ManyToOne(targetEntity="Township", cascade={"persist"}, inversedBy="users")
     * @ORM\JoinColumn(name="township")
     */
    protected $township;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
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
    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    /**
     * @return \DateTime
     */
    public function getRegistryDate(): \DateTime
    {
        return $this->registryDate;
    }

    /**
     * @param \DateTime  $registryDate
     */
    public function setRegistryDate(\DateTime  $registryDate)
    {
        $this->registryDate = $registryDate;
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
    public function setUserType(string $userType)
    {
        $this->userType = $userType;
    }

    /**
     * @return int
     */
    public function getNbErrorConnection(): int
    {
        return $this->nbErrorConnection;
    }

    /**
     * @param int $nbErrorConnection
     */
    public function setNbErrorConnection(int $nbErrorConnection)
    {
        $this->nbErrorConnection = $nbErrorConnection;
    }

    /**
     * @return bool
     */
    public function getBanned(): bool
    {
        return $this->banned;
    }

    /**
     * @param boolean $banned
     */
    public function setBanned(bool $banned)
    {
        $this->banned = $banned;
    }

    /**
     * @return boolean
     */
    public function getRegistryConfirmed(): bool
    {
        return $this->registryConfirmed;
    }

    /**
     * @param boolean $registryConfirmed
     */
    public function setRegistryConfirmed(bool $registryConfirmed)
    {
        $this->registryConfirmed = $registryConfirmed;
    }

    /**
     * @return \App\Entity\PostalCode
     */
    public function getPostalCode(): PostalCode
    {
        return $this->postalCode;
    }

    /**
     * @param \App\Entity\PostalCode $postalCode
     */
    public function setPostalCode(PostalCode $postalCode)
    {
        $this->postalCode = $postalCode;

        /*
         * Ajout à la liste des prestataires par code postal
         */
        $postalCode->addUser($this);
    }

    /**
     * Get locality
     *
     * @return \App\Entity\Locality
     */
    public function getLocality(): Locality
    {
        return $this->locality;
    }

    /**
     * Set locality
     *
     * @param \App\Entity\Locality $locality
     */
    public function setLocality(Locality $locality)
    {
        $this->locality = $locality;

        /*
         * Ajout à la liste des prestataires de la ville
         */
        $locality->addUser($this);
    }

    /**
     * @return \App\Entity\Township
     */
    public function getTownship(): Township
    {
        return $this->township;
    }

    /**
     * @param \App\Entity\Township $township
     */
    public function setTownship(Township $township)
    {
        $this->township = $township;

        /*
         * Ajout à liste des prestataires de la commune
         */
        $township->addUser($this);
    }





}