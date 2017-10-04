<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Prestataire
 *
 * @ORM\Table(name="be_prestataire")
 * @ORM\Entity(repositoryClass="App\Repository\PrestataireRepository")
 */
class Prestataire
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, unique=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="siteWeb", type="string", length=255, nullable=true)
     */
    private $siteWeb;

    /**
     * @var string
     *
     * @ORM\Column(name="emailContact", type="string", length=255)
     */
    private $emailContact;

    /**
     * @var string
     *
     * @ORM\Column(name="numTelephone", type="string", length=30)
     */
    private $numTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="numTva", type="string", length=20, unique=true)
     */
    private $numTva;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist","remove"})
     * 
     */
    private $logo;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Image", cascade={"persist","remove"})
     * @ORM\JoinTable(name="be_prestataire_image")
     */
    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="prestataire")
     */
    private $stages;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="CategorieService", cascade={"persist"}, inversedBy="prestataires")
     *
     * @ORM\JoinTable(name="be_prestataire_categorie_service")
     */
    private $categorieServices;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Promotion", mappedBy="prestataire")
     */
    private $promotions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Internaute", mappedBy="favoris")
     */
    private $favoris;

    /**
     * Prestataire constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->stages = new ArrayCollection();
        $this->categorieServices = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->favoris = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Prestataire
     */
    public function setNom(string $nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * Set siteWeb
     *
     * @param string $siteWeb
     *
     * @return Prestataire
     */
    public function setSiteWeb(string $siteWeb)
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    /**
     * Get siteWeb
     *
     * @return string
     */
    public function getSiteWeb(): string
    {
        return $this->siteWeb;
    }

    /**
     * Set emailContact
     *
     * @param string $emailContact
     *
     * @return Prestataire
     */
    public function setEmailContact(string $emailContact)
    {
        $this->emailContact = $emailContact;

        return $this;
    }

    /**
     * Get emailContact
     *
     * @return string
     */
    public function getEmailContact(): string
    {
        return $this->emailContact;
    }

    /**
     * Set numTelephone
     *
     * @param string $numTelephone
     *
     * @return Prestataire
     */
    public function setNumTelephone(string $numTelephone)
    {
        $this->numTelephone = $numTelephone;

        return $this;
    }

    /**
     * Get numTelephone
     *
     * @return string
     */
    public function getNumTelephone(): string
    {
        return $this->numTelephone;
    }

    /**
     * Set numTva
     *
     * @param string $numTva
     *
     * @return Prestataire
     */
    public function setNumTva(string $numTva)
    {
        $this->numTva = $numTva;

        return $this;
    }

    /**
     * Get numTva
     *
     * @return string
     */
    public function getNumTva(): string
    {
        return $this->numTva;
    }

    /**
     * Get logo
     *
     * @return \App\Entity\Image
     */
    public function getLogo(): Image
    {
        return $this->logo;
    }

    /**
     * @param \App\Entity\Image $logo
     */
    public function setLogo(Image $logo)
    {
            $this->logo = $logo;
    }

    /**
     * Get images
     *
     * @return ArrayCollection
     */
    public function getImages(): ArrayCollection
    {
        return $this->images;
    }

    /**
     * Add image
     *
     * @param Image $image
     */
    public function addImage(Image $image)
    {

        $this->images[] = $image;



    }

    /**
     * Remove image
     *
     * @param Image $image
     */
    public function removeImage(Image $image)
    {

        $this->images->removeElement($image);

    }

    /**
     * Get stages
     *
     * @return ArrayCollection
     */
    public function getStages(): ArrayCollection
    {
        return $this->stages;
    }

    /**
     * Add stage
     *
     * @param Stage $stage
     */
    public function addStage(Stage $stage)
    {

        $this->stages[] = $stage;

    }

    /**
     * Remove stage
     *
     * @param Stage $stage
     */
    public function removeStage(Stage $stage)
    {

        $this->stages->removeElement($stage);

    }

    /**
     * Get categorieServices
     *
     * @return ArrayCollection
     */
    public function getCategorieServices(): ArrayCollection
    {
        return $this->categorieServices;
    }

    /**
     * Add categorieService
     *
     * @param CategorieService $categorieService
     */
    public function addCategorieService(CategorieService $categorieService)
    {

        $this->categorieServices[] = $categorieService;

        $categorieService->addPrestataire($this);

    }

    /**
     * Remove categorieService
     *
     * @param CategorieService $categorieService
     */
    public function removeCategorieService(CategorieService $categorieService)
    {

        $this->categorieServices->removeElement($categorieService);

    }

    /**
     * Get promotions
     *
     * @return ArrayCollection
     */
    public function getPromotions(): ArrayCollection
    {
        return $this->promotions;
    }

    /**
     * Add promotion
     *
     * @param Promotion $promotion
     *
     */
    public function addPromotion(Promotion $promotion)
    {

        $this->promotions[] = $promotion;

    }

    /**
     * Remove promotion
     *
     * @param Promotion $promotion
     */
    public function removePromotion(Promotion $promotion)
    {

        $this->promotions->removeElement($promotion);

    }

    /**
     * Get favoris
     *
     * @return ArrayCollection
     */
    public function getFavoris()
    {
        return $this->favoris;
    }

    /**
     * Add favori
     *
     * @param Internaute $internaute
     */
    public function addFavori(Internaute $internaute)
    {
        $this->favoris[] = $internaute;
    }

    /**
     * Remove favoris
     *
     * @param Internaute $internaute
     */
    public function removeFavori(Internaute $internaute)
    {
        $this->favoris->removeElement($internaute);
    }
}

