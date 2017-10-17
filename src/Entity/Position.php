<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Client;
use App\Entity\Bloc;

/**
 * Position
 *
 * @ORM\Table(name="be_position")
 * @ORM\Entity(repositoryClass="App\Repository\PositionRepository")
 */
class Position
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
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", cascade={"persist","remove"}, inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @var Bloc
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Bloc", cascade={"persist","remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $bloc;


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
     * @return Position
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
    public function getPlace(): int
    {
        return $this->place;
    }

    /**
     * @return Client
     */
    public function getClient()
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
     * @return Bloc
     */
    public function getBloc()
    {
        return $this->bloc;
    }

    /**
     * @param Bloc $bloc
     */
    public function setBloc(Bloc $bloc)
    {
        $this->bloc = $bloc;
    }


}

