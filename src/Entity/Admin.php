<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 25.01.18
 * Time: 04:09
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

/**
 * Class Admin
 * @package App\Entity
 * @ORM\Table(name="be_admin")
 * @ORM\Entity(repositoryClass="App\Repository\AdminRepository")
 *
 */
class Admin extends User
{

}