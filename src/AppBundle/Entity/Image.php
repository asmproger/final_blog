<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Post
 *
 * @ORM\Table(name="image")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ImageRepository")
 */
class Image
{

    public function __construct()
    {
        $this->profiles = new ArrayCollection();
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="path", type="text")
     */
    private $path;


    /**
     * @var ArrayCollection
     * @ORM\ManyToMany(targetEntity="Profile", mappedBy="images")
     */
    protected $profiles;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param null|string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * @return ArrayCollection
     */
    public function getProfiles()
    {
        return $this->profiles;
    }

    /**
     * @param ArrayCollection $profiles
     */
    public function setProfiles($profiles)
    {
        $this->profiles = $profiles;
    }
}