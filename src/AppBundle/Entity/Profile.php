<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Profile
 *
 * @ORM\Table(name="profile")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProfileRepository")
 */
class Profile
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
     * One profile has one user
     * @ORM\OneToOne(targetEntity="Application\Sonata\UserBundle\Entity\User", mappedBy="profile")
     */
    protected $user;

    /**
     * many profiles can have one profession
     * @ORM\ManyToOne(targetEntity="Profession", inversedBy="profiles")
     * @ORM\JoinColumn(name="profession_id", referencedColumnName="id")
     */
    protected $profession;

    /**
     * many profiles can have one sex
     * @ORM\ManyToOne(targetEntity="Sex", inversedBy="profiles")
     * @ORM\JoinColumn(name="sex_id", referencedColumnName="id")
     */
    protected $sex;

    /**
     *
     */

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

}
