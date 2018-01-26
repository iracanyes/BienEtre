<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
// Ajout de slug
use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Entity\Service;
use App\Entity\ServiceCategory;
use App\Entity\Promotion;
use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Client;

/**
 * Provider
 *
 * @ORM\Entity(repositoryClass="App\Repository\ProviderRepository")
 * @ORM\Table(name="be_provider")
 * @ORM\HasLifecycleCallbacks()
 */
class Provider extends User
{

    /**
     * @var string
     *
     * @ORM\Column(name="brand_name", type="string", length=255, unique=true)
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
     * @ORM\Column(name="email_contact", type="string", length=255)
     *
     */
    private $emailContact;

    /**
     * @var string
     *
     * @ORM\Column(name="phone_number", type="string", length=30)
     */
    private $phoneNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="tva_number", type="string", length=20, unique=true)
     */
    private $tvaNumber;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="string", length=255)
     */
    private $street;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image", cascade={"persist"}, mappedBy="providerLogos")
     *
     */
    private $logos;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Image", cascade={"persist"}, mappedBy="providerImages")
     *
     */
    private $images;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Service", mappedBy="provider")
     */
    private $services;

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
     * @ORM\ManyToMany(targetEntity="Client", cascade={"persist"}, mappedBy="favorites")
     */
    private $fans;

    /**
     * @var int totalFans
     *
     * @ORM\Column(name="total_fan", type="integer")
     */
    private $totalFans = 0;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="\App\Entity\Comment", mappedBy="provider")
     */
    private $opinions;

    /**
     * @var int
     *
     * @ORM\Column(name="rating", type="integer")
     */
    private $rating = 0;

    /**
     * @var string
     * @Gedmo\Slug(fields={"brandName"})
     * @ORM\Column(name="slug", type="string", length=64, unique=true)
     */
    private $slug;



    /**
     * Provider constructor.
     */
    public function __construct()
    {
        $this->logos = new ArrayCollection();
        $this->images = new ArrayCollection();
        $this->services = new ArrayCollection();
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
    public function setBrandName(string $brandName): Provider
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
        return $this->brandName ?? "";
    }

    /**
     * Set webSite
     *
     * @param string $webSite
     *
     * @return Provider
     */
    public function setWebSite(string $webSite): Provider
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
        return $this->webSite ?? "";
    }

    /**
     * Set emailContact
     *
     * @param string $emailContact
     *
     * @return Provider
     */
    public function setEmailContact(string $emailContact): Provider
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
        return $this->emailContact ?? "";
    }

    /**
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return Provider
     */
    public function setPhoneNumber(string $phoneNumber): Provider
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
        return $this->phoneNumber ?? "";
    }

    /**
     * Set tvaNumber
     *
     * @param string $tvaNumber
     *
     * @return Provider
     */
    public function setTvaNumber(string $tvaNumber): Provider
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
        return $this->tvaNumber ?? "";
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Provider
     */
    public function setSlug(string $slug): Provider
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street ?? "";

    }

    /**
     * @param string $street
     * @return Provider
     */
    public function setStreet(string $street): Provider
    {
        $this->street = $street;

        return $this;
    }

    /**
     * Get logo
     *
     * @return \App\Entity\Image
     */
    public function getLogos(): Collection
    {
        return $this->logos;
    }

    /**
     * Add Logo
     * @param \App\Entity\Image $logo
     * @return Provider
     */
    public function addLogo(Image $logo): Provider
    {
            $this->logos[] = $logo;

            $logo->setProviderLogos($this);

            return $this;
    }

    /**
     * Remove Logo
     *
     * @param Image $logo
     * @return void
     */
    public function removeLogo(Image $logo): void
    {
        $this->logos->removeElement($logo);
    }

    /**
     * Get images
     *
     * @return ArrayCollection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * Add image
     *
     * @param Image $image
     * @return Provider
     */
    public function addImage(Image $image): Provider
    {

        $this->images[] = $image;

        // Association avec de l'image avec le provider
        $image->setProviderImages($this);

        return $this;

    }

    /**
     * Remove image
     *
     * @param Image $image
     */
    public function removeImage(Image $image): void
    {

        $this->images->removeElement($image);

    }

    /**
     * Get services
     *
     * @return ArrayCollection
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    /**
     * Add service
     *
     * @param Service $service
     * @return Provider
     */
    public function addService(Service $service): Provider
    {

        $this->services[] = $service;

        /*
         * Association du prestataire au service créée
         */
        $service->setProvider($this);

        return $this;

    }

    /**
     * Remove service
     *
     * @param Service $service
     */
    public function removeService(Service $service): void
    {

        $this->services->removeElement($service);

    }

    /**
     * Get serviceCategories
     *
     * @return Collection
     */
    public function getServiceCategories(): Collection
    {
        return $this->serviceCategories;
    }

    /**
     * Add serviceCategory
     *
     * @param ServiceCategory $serviceCategory
     * @return Provider
     */
    public function addServiceCategory(ServiceCategory $serviceCategory): Provider
    {

        $this->serviceCategories[] = $serviceCategory;

        /*
         * Ajout du prestataire à la liste de la catégorie de service
         */
        $serviceCategory->addProvider($this);

        return $this;

    }

    /**
     * Remove serviceCategory
     *
     * @param ServiceCategory $serviceCategory
     */
    public function removeServiceCategory(ServiceCategory $serviceCategory): void
    {

        $this->serviceCategories->removeElement($serviceCategory);

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
     * @return Provider
     */
    public function addPromotion(Promotion $promotion): Provider
    {

        $this->promotions[] = $promotion;

        /*
         * Association entre le prestataire et la promotion créée
         */
        $promotion->setProvider($this);

        return $this;
    }

    /**
     * Remove promotion
     *
     * @param Promotion $promotion
     */
    public function removePromotion(Promotion $promotion): void
    {

        $this->promotions->removeElement($promotion);

    }

    /**
     * Get fans
     *
     * @return Collection
     */
    public function getFans(): ArrayCollection
    {
        return $this->fans;
    }

    /**
     * Add fan
     *
     * @param Client $client
     */
    public function addFan(Client $client): Provider
    {
        $this->fans[] = $client;

        $this->totalFans++;

        return $this;
    }

    /**
     * Remove fans
     *
     * @param Client $client
     */
    public function removeFan(Client $client): void
    {
        $this->fans->removeElement($client);

        $this->totalFans--;
    }

    /**
     * @return int
     */
    public function getTotalFans(): int
    {
        return $this->totalFans;
    }

    /**
     * Attention : Ralentit les processus car doit effectuer une boucle sur les entités
     * pour connaître le nombre exact.
     *
     *
     *
    public function setTotalFans(): void
    {
        $this->totalFans = count($this->fans);
    }
     */
    /**
     * Les événements ORM-PrePersist permettent d'apporter des modifications à l'entité qui seront ensuite
     * enregistrés en DB par la méthode $this->flush().
     * Les événements ORM-PostPersist permettent de modifier l'entité après enregistrement de ces données en DB.
     *
     * @ ORM PrePersist
     * @ ORM PrePersist()
     * @ return void

    public function updateTotalFans(): void
    {
        $this->setTotalFans();
    }
     */


    /**
     * Get opinions
     *
     * @return Collection
     */
    public function getOpinions(): Collection
    {
        return $this->opinions;
    }

    /**
     * Add comment
     *
     * @param \App\Entity\Comment $comment
     * @return Provider
     */
    public function addComment(Comment $comment): Provider
    {
        $this->opinions[] = $comment;

        return $this;
    }

    /**
     * Remove comment
     *
     * @param \App\Entity\Comment $comment
     */
    public function removeComment(Comment $comment): void
    {
        $this->opinions->removeElement($comment);
    }

    /**
     * @return int
     */
    public function getRating(): int
    {
        return $this->rating;
    }

    /**
     * @param int $rating
     */
    public function setRating(int $rating): void
    {
        $this->rating = $rating;
    }

    /**
     * @ORM\PrePersist
     */
    public function calcRating(): void
    {

        $n = $this->opinions->count();
        $totalVotes = 0;
        if($n > 0){
            foreach ($this->opinions as $comment){

                $totalVotes += (int) $comment->getVote();
            }
            $rate = $totalVotes / $n * 2;
            $this->rating = round($rate, 1, PHP_ROUND_HALF_DOWN);
        }else{
            $this->rating = $n;
        }


    }

    /**
     * Get Address
     *
     * @return string
     */
    public function getAddress(): string
    {
        return "".ucwords($this->getStreet())."</br>"
            .parent::getPostalCode()->getPostalCode()." "
            .parent::getTownship()->getTownship()."</br>"
            .parent::getLocality()->getLocality();
    }
}

