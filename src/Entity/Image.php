<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Image
 *
 * @ORM\Table(name="be_image")
 * @ORM\Entity(repositoryClass="App\Repository\ImageRepository")
 */
class Image
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
     * @var int
     *
     * @ORM\Column(name="place", type="integer")
     */
    private $place;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     * @Assert\NotBlank(message="Veuillez ajoutez une image")
     * @Assert\File(mimeTypes={"image/jpg","image/jpeg","image/png"}, mimeTypesMessage="Veuillez utilisez les formats suivants: jpeg, jpg, png")
     */
    protected $url;



    /**
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="Provider", cascade={"persist", "remove"}, inversedBy="logos")
     * @ORM\JoinColumn(nullable=true)
     */
    private $providerLogos;
    /**
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="Provider", cascade={"persist", "remove"}, inversedBy="images")
     * @ORM\JoinColumn(nullable=true)
     */
    private $providerImages;

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
     * Set place
     *
     * @param integer $place
     *
     * @return Image
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get place
     *
     * @return int
     */
    public function getPlace(): string
    {
        return $this->place ?? "";
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return Image
     */
    public function setUrl(string $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url ?? "";
    }


    /**
     * @return Provider
     */
    public function getProviderLogos(): Provider
    {
        return $this->providerLogos;
    }

    /**
     * @param Provider $provider
     */
    public function setProviderLogos(Provider $provider)
    {
        $this->providerLogos = $provider;
    }

    /**
     * @return Provider
     */
    public function getProviderImages(): Provider
    {
        return $this->providerImages;
    }

    /**
     * @param Provider $providerImages
     */
    public function setProviderImages(Provider $providerImages)
    {
        $this->providerImages = $providerImages;
    }


}