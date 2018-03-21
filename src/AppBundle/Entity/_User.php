<?php
/**
 * Created by PhpStorm.
 * User: sovkutsan
 * Date: 3/14/18
 * Time: 4:22 PM
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sonata\UserBundle\Entity\BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\OneToMany;

///**
// * @ORM\Entity
// * @ORM\Table(name="fos_user_user")
// */
class _User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * One User has Many Posts.
     * @OneToMany(targetEntity="Post", mappedBy="user")
     */
    private $posts;

    public function __construct()
    {
        $this->posts = new ArrayCollection();
        parent::__construct();
    }
}