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
use App\Entity\Commentaire;
use App\Entity\Prestataire;
use App\Entity\Position;

/**
 * Class Internaute
 *
 * @ORM\Table(name="be_internaute")
 * @ORM\Entity(repositoryClass="App\Repository\InternauteRepository")
 */
class Internaute
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
     * @ORM\Column(name="nom", type="string", length=255    )
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255    )
     */
    private $prenom;

    /**
     * @var bool
     *
     * @ORM\Column(name="newsletter", type="boolean")
     */
    private $newsletter;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Position", mappedBy="internaute")
     */
    private $positions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Prestataire", cascade={"persist","remove"}, inversedBy="favoris")
     * @ORM\JoinTable(name="be_favoris")
     */
    private $favoris;

    /**
     * Internaute constructor.
     */
    public function __construct()
    {
        $this->positions = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }        

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
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return string
     */
    public function getPrenom(): string
    {
        return $this->prenom;
    }

    /**
     * @param string $prenom
     */
    public function setPrenom(string $prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return bool
     */
    public function getNewsletter()
    {
        return $this->newsletter;
    }

    /**
     * @param bool $newsletter
     */
    public function setNewsletter($newsletter)
    {
        $this->newsletter = $newsletter;
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
     * Get favoris
     *
     * @return ArrayCollection
     */
    public function getFavoris(): ArrayCollection
    {
        return $this->favoris;
    }

    /**
     * Add favori
     *
     * @param Prestataire $prestataire
     */
    public function addFavori(Prestataire $prestataire)
    {
        $this->favoris[] = $prestataire;

        $prestataire->addFavori($this);
    }

    /**
     * Remove favori
     *
     * @param Prestataire $prestataire
     */
    public function removeFavori(Prestataire $prestataire)
    {
        $this->favoris->removeElement($prestataire);
    }
}