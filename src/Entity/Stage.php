<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Provider;

/**
 * Stage
 *
 * @ORM\Table(name="be_stage")
 * @ORM\Entity(repositoryClass="App\Repository\StageRepository")
 */
class Stage
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
     * @ORM\Column(name="pricing", type="string", length=255)
     */
    private $pricing;

    /**
     * @var string
     *
     * @ORM\Column(name="additional_information", type="text", nullable=true)
     */
    private $additionalInformation;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="start_date", type="datetime")
     */
    private $startDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="end_date", type="datetime")
     */
    private $endDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="release_date", type="datetime")
     */
    private $releaseDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expiry_date", type="datetime")
     */
    private $expiryDate;

    /**
     * @ var Provider
     *
     * @ ORM\ManyToOne(targetEntity="App\Entity\Provider", cascade={"persist","remove"}, inversedBy="stages")
     * @ ORM\JoinColumn(nullable=false)
     */
    //private $provider;


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
     * @return Stage
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
     * @return Stage
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
     * Set pricing
     *
     * @param string $pricing
     *
     * @return Stage
     */
    public function setPricing($pricing)
    {
        $this->pricing = $pricing;

        return $this;
    }

    /**
     * Get pricing
     *
     * @return string
     */
    public function getPricing()
    {
        return $this->pricing;
    }

    /**
     * Set additionalInformation
     *
     * @param string $additionalInformation
     *
     * @return Stage
     */
    public function setAdditionalInformation($additionalInformation)
    {
        $this->additionalInformation = $additionalInformation;

        return $this;
    }

    /**
     * Get additionalInformation
     *
     * @return string
     */
    public function getAdditionalInformation()
    {
        return $this->additionalInformation;
    }

    /**
     * Set startDate
     *
     * @param \DateTime $startDate
     *
     * @return Stage
     */
    public function setStartDate(\DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get startDate
     *
     * @return \DateTime
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return Stage
     */
    public function setEndDate(\DateTime $endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * Set releaseDate
     *
     * @param \DateTime $releaseDate
     *
     * @return Stage
     */
    public function setReleaseDate(\DateTime $releaseDate)
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    /**
     * Get releaseDate
     *
     * @return \DateTime
     */
    public function getReleaseDate(): \DateTime
    {
        return $this->releaseDate;
    }

    /**
     * Set expiryDate
     *
     * @param \DateTime $expiryDate
     *
     * @return Stage
     */
    public function setExpiryDate(\DateTime $expiryDate)
    {
        $this->expiryDate = $expiryDate;

        return $this;
    }

    /**
     * Get expiryDate
     *
     * @return \DateTime
     */
    public function getExpiryDate(): \DateTime
    {
        return $this->expiryDate;
    }

    /**
     * Set provider
     *
     * @param Provider $provider
     *
     * @return Stage
     */
    public function setProvider($provider)
    {
        $this->provider = $provider;
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

}

