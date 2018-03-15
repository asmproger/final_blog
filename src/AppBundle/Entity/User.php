<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 3/14/18
 * Time: 4:22 PM
 */

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as FOSUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends FOSUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}