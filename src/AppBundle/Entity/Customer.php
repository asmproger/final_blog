<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Customer
 *
 * @ORM\Table(name="customer")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CustomerRepository")
 */
class Customer
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
     * @var string
     *
     * @ORM\Column(name="customer_id", type="string", length=255)
     */
    private $customerId;


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
     * Set customerId.
     *
     * @param string $customerId
     *
     * @return Customer
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;

        return $this;
    }

    /**
     * Get customerId.
     *
     * @return string
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }
}
