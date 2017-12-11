<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 11.12.17
 * Time: 09:45
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Newsletter
 * @package App\Entity
 * @ORM\Table(name="be_newsletter")
 * @ORM\Entity(repositoryClass="App\Entity\NewsletterRepository")
 */
class Newsletter
{
    /**
     * @var int
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var \Datetime
     * @ORM\Column(name="release_date", type="datetime")
     */
    private $releaseDate;

    /**
     * @var string
     *
     * @ORM\Column(name="pdf", type="string", length=255)
     */
    private $pdf;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return \Datetime
     */
    public function getReleaseDate(): \Datetime
    {
        return $this->releaseDate;
    }

    /**
     * @param \Datetime $releaseDate
     */
    public function setReleaseDate(\Datetime $releaseDate)
    {
        $this->releaseDate = $releaseDate;
    }

    /**
     * @return string
     */
    public function getPdf()
    {
        return $this->pdf;
    }

    /**
     * @param string $pdf
     */
    public function setPdf($pdf)
    {
        $this->pdf = $pdf;
    }


}