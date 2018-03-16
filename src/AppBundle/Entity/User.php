<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 3/14/18
 * Time: 4:22 PM
 */

namespace AppBundle\Entity;

use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;

///**
// * @ORM\Entity
// * @ORM\Table(name="fos_user_user")
// */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
}