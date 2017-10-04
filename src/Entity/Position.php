<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

use App\Entity\Internaute;
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
     * @ORM\Column(name="ordre", type="integer")
     */
    private $ordre;

    /**
     * @var Internaute
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Internaute", cascade={"persist","remove"}, inversedBy="positions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $internaute;

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
     * Set ordre
     *
     * @param integer $ordre
     *
     * @return Position
     */
    public function setOrdre($ordre)
    {
        $this->ordre = $ordre;

        return $this;
    }

    /**
     * Get ordre
     *
     * @return int
     */
    public function getOrdre()
    {
        return $this->ordre;
    }

    /**
     * @return Internaute
     */
    public function getInternaute()
    {
        return $this->internaute;
    }

    /**
     * @param Internaute $internaute
     */
    public function setInternaute(Internaute $internaute)
    {
        $this->internaute = $internaute;
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

