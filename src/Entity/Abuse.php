<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 10.10.17
 * Time: 20:04
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Entity\Comment;
use App\Entity\Client;


/**
 * Class Abuse
 *
 * @package App\Entity
 *
 * @ORM\Table(name="be_abuse")
 * @ORM\Entity(repositoryClass="App\Entity\AbuseRepository")
 */
class Abuse
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
     * @ORM\Column(name="description", type="text")
     * @Assert\NotBlank()
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="entry_date", type="datetime")
     * @Assert\DateTime()
     */
    private $entryDate;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Client", cascade={"persist","remove"}, inversedBy="abuses")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\Type(type="App\Entity\Client")
     * @Assert\Valid()
     */
    private $client;

    /**
     * @var Comment
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Comment", cascade={"persist","remove"})
     * @Assert\Type(type="App\Entity\Comment")
     * @Assert\Valid()
     */
    private $comment;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return \DateTime
     */
    public function getEntryDate(): \DateTime
    {
        return $this->entryDate;
    }

    /**
     * @param \DateTime $entryDate
     */
    public function setEntryDate(\DateTime $entryDate)
    {
        $this->entryDate = $entryDate;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Comment
     */
    public function getComment(): Comment
    {
        return $this->comment;
    }

    /**
     * @param Comment $comment
     */
    public function setComment(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @ORM\PrePersist()
     * @return void
     */
    public function registryDate(){
        $this->setEntryDate(new \Datetime());
    }


}