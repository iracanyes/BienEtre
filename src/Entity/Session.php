<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 25.01.18
 * Time: 05:36
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class Session
 * @package App\Entity
 * @ORM\Table(name="be_session")
 * @ORM\Entity()
 */
class Session
{
    /**
     * @var int
     * @ORM\Column(name="sess_id", type="string", length=128)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $sess_id;

    /**
     * @ORM\Column(name="sess_data", type="string", length=255)
     */
    protected $sess_data;

    /**
     * @var \DateTime
     * @ORM\Column(name="sess_time", type="datetime")
     */
    protected $sess_time;

    /**
     * @var int
     * @ORM\Column(name="sess_lifetime", type="integer")
     */
    protected $sess_lifetime;
}