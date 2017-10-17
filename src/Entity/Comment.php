<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 10.10.17
 * Time: 19:52
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Provider;
use App\Entity\Client;

/**
 * Class Comment
 * @package App\Entity
 *
 * @ORM\Table(name="be_comment")
 * @ORM\Entity(repositoryClass="App\Repository\CommentRepository")
 */
class Comment
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
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @ORM\Column(name="vote", type="integer", length=1)
     */
    private $vote;

    /**
     * @var \DateTime
     * @ORM\Column(name="entry_date", type="datetime")
     */
    private $entryDate;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client", cascade={"persist","remove"}, inversedBy="comments")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @var Provider
     *
     * @ORM\ManyToOne(targetEntity="Provider", cascade={"persist","remove"}, inversedBy="remarks")
     * @ORM\JoinColumn(nullable=false)
     */
    private $provider;

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
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * @return int
     */
    public function getVote()
    {
        return $this->vote;
    }

    /**
     * @param int $vote
     */
    public function setVote(int $vote)
    {
        $this->vote = $vote;
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
     * @return \App\Entity\Client
     */
    public function getClient(): \App\Entity\Client
    {
        return $this->client;
    }

    /**
     * @param \App\Entity\Client $client
     */
    public function setClient(\App\Entity\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return \App\Entity\Provider
     */
    public function getProvider() : \App\Entity\Provider
    {
        return $this->provider;
    }

    /**
     * @param \App\Entity\Provider $provider
     */
    public function setProvider(Provider $provider)
    {
        $this->provider = $provider;
    }


}