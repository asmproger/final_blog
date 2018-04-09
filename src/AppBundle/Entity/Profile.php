<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
{

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * One profile has one user
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", mappedBy="profile")
     */
    protected $user;

    /**
     * many profiles can have one profession
     * @ORM\ManyToOne(targetEntity="Profession", inversedBy="profiles", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $profession;

    /**
     * many profiles can have one sex
     * @ORM\ManyToOne(targetEntity="Sex", inversedBy="profiles")
     * @ORM\JoinColumn(name="sex_id", referencedColumnName="id")
     */
    protected $sex;

    /**
     * @ORM\ManyToMany(targetEntity="Image", inversedBy="profiles")
     * @ORM\JoinTable(name="profiles_images")
     */
    protected $images;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getProfession()
    {
        return $this->profession;
    }

    /**
     * @param mixed $profession
     */
    public function setProfession($profession)
    {
        $this->profession = $profession;
    }

    /**
     * @return mixed
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * @param mixed $sex
     */
    public function setSex($sex)
    {
        $this->sex = $sex;
    }

    /**
     * @return mixed
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * @param mixed $images
     */
    public function setImages($images)
    {
        $this->images = $images;
    }
}
