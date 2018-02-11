<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 09.10.17
 * Time: 19:13
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\User\EquatableInterface;
/** Composant de validation des propriétés **/
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


use App\Entity\Client;
use App\Entity\Provider;
use App\Entity\PostalCode;
use App\Entity\Locality;
use App\Entity\Township;

/**
 * Class User
 * @package App\Entity
 *
 * @ORM\Table(name="be_user")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 *
 * Contient des fonctions de callback du cycle de vie de l'entité
 *
 * @ORM\HasLifecycleCallbacks()
 *
 * Nous devons créer une contrainte d'unicité pour l'ajout des objets de type User dans la base de donnée. Chaque objet doit avoir une propriété "email" unique
 *
 * @UniqueEntity(fields={"email"}, message="Ce compte e-mail existe déjà!")
 *
 * Attention: Ici, on doit choisir entre 2 méthodes d'héritage.
 * Une seule table contiendra toutes les informations sur tous types d'utilisateurs
 *      ORM\InheritanceType("SINGLE_TABLE")
 *          => plus performantes car moins de jointures entre tables
 * Une table parent dont les tables enfants hériteront des attributs
 *      ORM\InheritanceType("JOINED")
 *
 * @ORM\InheritanceType("JOINED")
 *
 * Attention: DiscriminatorColumn permet de définir la colonne sur laquelle sera effectué la discrimination.
 * La colonne "user_type" sera généré et géré automatiquement par Doctrine pour faire la discrimination entre les différents types d'entités!
 *
 * @ORM\DiscriminatorColumn(name="user_type", type="string", length=255)
 * @ORM\DiscriminatorMap({"user" = "User", "client" = "Client", "provider" = "Provider", "admin" = "Admin"})
 */
class User implements AdvancedUserInterface, \Serializable
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * Cette propriété contiendra le mot de passe en clair reçu par le formulaire avant son encodage
     * Cette propriété ne doit pas être persisté en DB.
     *
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    protected $plainPassword;

    /**
     * @ORM\Column(name="password", type="string", length=255)
     * @Assert\NotBlank()
     *
     */
    protected $password;

    /**
     * @var array
     * @ORM\Column(name="roles", type="array", length=255)
     */
    protected $roles;

    /**
     * @ORM\Column(name="registry_date", type="datetime")
     */
    protected $registryDate;

    /**
     * @var \Datetime
     * @ORM\Column(name="update_date", type="datetime", nullable=true)
     */
    protected $updateDate;

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
     * @var boolean $isActive
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    /**
     * @var string
     * @ORM\Column(name="token", type="string", length=255)
     *
     */
    private $token;

    /**
     * Chaque utilisateur utilise cette clé API pour accéder à son compte via l'API
     * @ORM\Column(name="api_key", type="string", nullable=true)
     */
    private $apiKey;


    /**
     * @ORM\ManyToOne(targetEntity="PostalCode", cascade={"persist"}, inversedBy="users")
     * @ORM\JoinColumn(name="postal_code")
     * @Assert\Type(type="App\Entity\PostalCode")
     * @Assert\Valid()
     */
    protected $postalCode;

    /**
     * @ORM\ManyToOne(targetEntity="Locality", cascade={"persist"},inversedBy="users")
     * @ORM\JoinColumn(name="locality")
     *
     * @Assert\Type(type="App\Entity\Locality")
     * @Assert\Valid()
     */
    protected $locality;

    /**
     * @ORM\ManyToOne(targetEntity="Township", cascade={"persist"}, inversedBy="users")
     * @ORM\JoinColumn(name="township")
     *
     * @Assert\Type(type="App\Entity\Township")
     * @Assert\Valid()
     */
    protected $township;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->nbErrorConnection =0;
        $this->banned = false;
        $this->registryConfirmed = true;
        $this->isActive = true;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Méthode obligatoire hérité de l'interface UserInterface
     * @return string|void
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->email;
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
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    /**
     * @param string $plainPassword
     */
    public function setPlainPassword($plainPassword): void
    {
        $this->plainPassword = $plainPassword;
        $this->roles = new ArrayCollection();
    }



    /**
     * @return string
     */
    public function getPassword()
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

    public function getSalt(){
    }

    /**
     * Get Roles
     * @return Collection|string[]
     */
    public function getRoles(){
        return $this->roles;
    }

    /**
     * @param string $role
     */
    public function addRole(string $role)
    {

        $this->roles[]=$role;
    }

    public function removeRole(string $role)
    {
        /* array_search(value, table)
         * Recherche dans la table et retourne la clé de la valeur correspondante
         * array_splice(table, start, length)
         * Extrait une séquence d'éléments d'une table
         *
            if($key = array_search($role, $this->roles)){

                array_splice($this->roles, $key, 1);
            }
         */
        $this->roles->removeElement($role);

    }

    public function eraseCredentials()
    {
    }



    /**
     * @return string
     */
    public function getApiKey()
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     */
    public function setApiKey(string $apiKey): void
    {
        $this->apiKey = $apiKey;
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
     * @return \Datetime
     */
    public function getUpdateDate(): \Datetime
    {
        return $this->updateDate;
    }

    /**
     * @param \Datetime $updateDate
     */
    public function setUpdateDate(\Datetime $updateDate): void
    {
        $this->updateDate = $updateDate;
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
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive): void
    {
        $this->isActive = $isActive;
    }

    /**
     * @return string|null
     */
    public function getToken()
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
     * @return PostalCode|null
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param PostalCode $postalCode
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
     * @return Locality
     */
    public function getLocality()
    {
        return $this->locality;
    }

    /**
     * Set locality
     *
     * @param Locality $locality
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
    public function getTownship()
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

    /**
     * Lorsqu'on se connecte(login), tout l'objet User est serialisé dans une session.
     * À la requête suivante, l'objet User est dé-serialisé.
     * Ensuite, la valeur de la propriété "Id" est ré-utilisé pour demander un autre objet User en DB.
     * Finalement, le second objet est comparé avec l'objet User dé-serialisé pour s'assurer qu'elles représentent le même utilisateur.
     * Si par exemple, une propriété est différent, alors l'utilisateur sera déconnecté pour des raisons de sécurité.
     *
     * @return mixed|string
     */
    public function serialize()
    {
        return $this->serialize(array(
            $this->id,
            $this->email,
            $this->password,
            $this->isActive
        ));
    }

    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->email,
            $this->password,
            $this->isActive
            ) = $this->unserialize($serialized);
    }

    /**************** Méthode EquatableInterface ********************/

    public function isEqualTo(AdvancedUserInterface $user){
        if(!$user instanceof User){
            return false;
        }

        if($this->email !== $user->getEmail()){
            return false;
        }

        if($this->password !== $user->getPassword()){
            return false;
        }

        if($this->getUserType() !== $user->getUserType())

        return true;
    }



    /**************** Méthodes AdvancedUserInterface ***************/
    /**
     * Permettent d'exclure les utilisateurs.
     * Si une de ces méthodes retourne "false", le processus de login se terminera. On peut persister ces infos en DB si nécessaire.
     * Chaque méthode générera un message d'erreur différent.
     */


    /**
     * Vérifie si le compte est expiré
     * @return bool
     */
    public function isAccountNonExpired()
    {
        // TODO: Implement isAccountNonExpired() method.
        return true;
    }

    /**
     * Vérifie si le compte est bloqué
     * @return bool
     */
    public function isAccountNonLocked()
    {
        // TODO: Implement isAccountNonLocked() method.
        return true;
    }

    /**
     * Vérifie si le mot de passe est expiré
     * @return bool
     */
    public function isCredentialsNonExpired()
    {
        // TODO: Implement isCredentialsNonExpired() method.
        return true;
    }

    /**
     * Vérifie si l'utilisateur est actif.
     * @return bool
     */
    public function isEnabled()
    {
        return $this->isActive;
    }

    /****************** Événement Doctrine.  ***********************/
    /**
     * @ORM\PrePersist
     * @return void
     */
    public function registryAt()
    {
        $this->setRegistryDate(new \Datetime());
    }

    /**
     * Mise à jour de la date de mise à jour de l'objet
     *
     * @ORM\PreUpdate()
     * @return void
     */
    public function updateAt()
    {
        $this->setUpdateDate(new \Datetime());
    }


}