<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Provider;
use App\Entity\ServiceCategory;

/**
 * Promotion
 *
 * @ORM\Table(name="be_promotion")
 * @ORM\Entity(repositoryClass="App\Repository\PromotionRepository")
 */
class Promotion
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="pdf", type="string", length=255, nullable=true)
     * @ Assert\NotBlank(message="Veuillez ajoutez un PDF")
     * @ Assert\File(mimeTypes={"application/pdf"}, mimeTypesMessage="Veuillez utilisez les formats suivants: .pdf")
     */
    private $pdf;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     * @Assert\DateTime()
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     * @Assert\DateTime()
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="datetime")
     * @Assert\DateTime()
     */
    private $releaseDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="datetime")
     * @Assert\DateTime()
     */
    private $expiryDate;

    /**
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="Provider", cascade={"persist","remove"}, inversedBy="promotions")
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Provider")
     * @Assert\Valid()
     */
    private $provider;

    /**
     * @var ServiceCategory
     *
     * @ORM\ManyToOne(targetEntity="ServiceCategory", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\ServiceCategory")
     * @Assert\Valid()
     */
    private $serviceCategory;



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
     * Set name
     *
     * @param string $name
     *
     * @return Promotion
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Promotion
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set pdf
     *
     * @param string $pdf
     *
     * @return Promotion
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;

        return $this;
    }

    /**
     * Get pdf
     *
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Promotion
     */
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Promotion
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Promotion
     */
    public function setReleaseDate($releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * Set expiryDate
     *
     * @param \DateTime $expiryDate
     *
     * @return Promotion
     */
    public function setExpiryDate($expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return \DateTime
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * Set provider
     *
     * @ param Provider $provider
     *
     * @ return Promotion
     */

    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;

        return $this;
    }

    /**
     * Get provider
     *
     * @return Provider
     */

    public function getProvider()
    {
        return $this->provider;
    }

    /**
     * Set serviceCategory
     *
     * @param ServiceCategory $serviceCategory
     *
     * @return Promotion
     */
    public function setServiceCategory(ServiceCategory $serviceCategory)
    {
        $this->serviceCategory = $serviceCategory;

        return $this;
    }

    /**
     * Get serviceCategory
     *
     * @return ServiceCategory
     */
    public function getServiceCategory()
    {
        return $this->serviceCategory;
    }
}

