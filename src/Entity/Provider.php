<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\User;
use Doctrine\ORM\PersistentCollection;

/**
 * Provider
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProviderRepository")
 */
class Provider extends User
{

    /**
     * @var string
     *
     * @ORM\Column(name="brand_name", type="string", length=255, unique=true, nullable=true)
     */
    private $brandName;

    /**
     * @var string
     *
     * @ORM\Column(name="website", type="string", length=255, nullable=true)
     */
    private $webSite;

    /**
     * @var string
     *
     * @ORM\Column(name="email_contact", type="string", length=255, nullable=true)
     */
    private $emailContact;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=30, nullable=true)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="tva_number", type="string", length=20, unique=true, nullable=true)
     */
    private $tvaNumber;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $logo;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Image", cascade={"persist","remove"})
     * @ORM\JoinTable(name="be_provider_image")
     */
    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Stage", mappedBy="provider")
     */
    private $stages;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="ServiceCategory", cascade={"persist"}, inversedBy="providers")
     *
     * @ORM\JoinTable(name="be_provider_service_category")
     */
    private $serviceCategories;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Promotion", mappedBy="provider")
     */
    private $promotions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Client", mappedBy="favorites")
     */
    private $fans;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Comment", mappedBy="provider")
     */
    private $opinions;

    /**
     * Provider constructor.
     */
    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->stages = new ArrayCollection();
        $this->serviceCategories = new ArrayCollection();
        $this->promotions = new ArrayCollection();
        $this->fans = new ArrayCollection();
        $this->opinions = new ArrayCollection();
    }

    /**
     * Set brandName
     *
     * @param string $brandName
     *
     * @return Provider
     */
    public function setBrandName(string $brandName)
    {
        $this->brandName = $brandName;

        return $this;
    }

    /**
     * Get brandName
     *
     * @return string
     */
    public function getBrandName(): string
    {
        return $this->brandName;
    }

    /**
     * Set webSite
     *
     * @param string $webSite
     *
     * @return Provider
     */
    public function setWebSite(string $webSite)
    {
        $this->webSite = $webSite;

        return $this;
    }

    /**
     * Get webSite
     *
     * @return string
     */
    public function getWebSite(): string
    {
        return $this->webSite;
    }

    /**
     * Set emailContact
     *
     * @param string $emailContact
     *
     * @return Provider
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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Provider
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * Set tvaNumber
     *
     * @param string $tvaNumber
     *
     * @return Provider
     */
    public function setTvaNumber(string $tvaNumber)
    {
        $this->tvaNumber = $tvaNumber;

        return $this;
    }

    /**
     * Get tvaNumber
     *
     * @return string
     */
    public function getTvaNumber(): string
    {
        return $this->tvaNumber;
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
     * @return Array
     */
    public function getImages(): Array
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
    public function getStages(): Array
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

        /*
         * Association du prestataire au service créée
         */
        $stage->setProvider($this);

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
     * Get serviceCategories
     *
     * @return ArrayCollection
     */
    public function getServiceCategories()
    {
        return $this->serviceCategories;
    }

    /**
     * Add serviceCategory
     *
     * @param ServiceCategory $serviceCategory
     */
    public function addServiceCategory(ServiceCategory $serviceCategory)
    {

        $this->serviceCategories[] = $serviceCategory;

        /*
         * Ajout du prestataire à la liste de la catégorie de service
         */
        $serviceCategory->addProvider($this);

    }

    /**
     * Remove serviceCategory
     *
     * @param ServiceCategory $serviceCategory
     */
    public function removeServiceCategory(ServiceCategory $serviceCategory)
    {

        $this->serviceCategories->removeElement($serviceCategory);

    }

    /**
     * Get promotions
     *
     * @return ArrayCollection
     */
    public function getPromotions()
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

        /*
         * Association entre le prestataire et la promotion créée
         */
        $promotion->setProvider($this);
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
     * Get fans
     *
     * @return ArrayCollection
     */
    public function getFans()
    {
        return $this->fans;
    }

    /**
     * Add fan
     *
     * @param Client $client
     */
    public function addFan(Client $client)
    {
        $this->fans[] = $client;
    }

    /**
     * Remove fans
     *
     * @param Client $client
     */
    public function removeFan(Client $client)
    {
        $this->fans->removeElement($client);
    }

    /**
     * Get opinions
     *
     * @return ArrayCollection
     */
    public function getOpinions()
    {
        return $this->opinions;
    }

    /**
     * Add remark
     *
     * @param \App\Entity\Comment $comment
     */
    public function addComment(Comment $comment)
    {
        $this->opinions[] = $comment;
    }

    /**
     * Remove remark
     *
     * @param \App\Entity\Comment $comment
     */
    public function removeComment(Comment $comment)
    {
        $this->opinions->removeElement($comment);
    }
}

