<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\Common\Collections\ArrayCollection;

use App\Entity\Image;
use App\Entity\Provider;
use App\Entity\Promotion;

/**
 * ServiceCategory
 *
 * @ORM\Table(name="be_service_category")
 * @ORM\Entity(repositoryClass="App\Repository\ServiceCategoryRepository")
 */
class ServiceCategory
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var bool
     *
     * @ORM\Column(name="in_front_page", type="boolean")
     */
    private $inFrontPage;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_valid", type="boolean", nullable=true)
     */
    private $isValid;

    /**
     * @var Image
     *
     * @ORM\OneToOne(targetEntity="Image", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=true)
     *
     * @Assert\Type(type="App\Entity\Image")
     * @Assert\Valid()
     */
    private $image;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Provider", mappedBy="serviceCategories")
     */
    private $providers;

    /**
     * @var string $slug
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * ServiceCategory constructor.
     */
    public function __construct()
    {
        $this->providers = new ArrayCollection();
    }


    /**
     * Get id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nv
     *
     * @return ServiceCategory
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return ServiceCategory
     */
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set inFrontPage
     *
     * @param boolean $inFrontPage
     *
     * @return $this
     */
    public function setInFrontPage(bool $inFrontPage)
    {
        $this->inFrontPage = $inFrontPage;

        return $this;
    }

    /**
     * Get inFrontPage
     *
     * @return bool
     */
    public function getInFrontPage(): bool
    {
        return $this->inFrontPage;
    }

    /**
     * Set isValid
     *
     * @param boolean $isValid
     *
     * @return $this
     */
    public function setIsValid($isValid)
    {
        $this->isValid = $isValid;

        return $this;
    }

    /**
     * Get isValid
     *
     * @return bool
     */
    public function getIsValid()
    {
        return $this->isValid;
    }

    /**
     * Get Image
     *
     * @return Image
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set Image
     * @param Image $image
     */
    public function setImage(Image $image)
    {
        $this->image = $image;
    }

    /**
     * Get providers
     *
     * @ return ArrayCollection
     */

    public function getProviders()
    {
        return $this->providers;
    }

    /**
     * Add provider
     *
     * @ param Provider $provider
     */

    public function addProvider(Provider $provider)
    {

        $this->providers[] = $provider;

    }

    /**
     * Remove provider
     *
     * @param Provider $provider
     */

    public function removeProvider(Provider $provider)
    {
        $this->providers->removeElement($provider);
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
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
    }



}

