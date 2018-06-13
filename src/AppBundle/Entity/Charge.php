<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Charge
 *
 * @ORM\Table(name="charge")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ChargeRepository")
 */
class Charge
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
     * @ORM\Column(name="charge_id", type="string", length=255)
     */
    private $chargeId;

    /**
     * @var integer
     *
     * @ORM\Column(name="product_id", type="integer")
     */
    private $productId;

    /**
     * @var integer
     *
     * @ORM\Column(name="amount", type="integer")
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="datetime")
     */
    private $dateCreation;
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
     * Set chargeId.
     *
     * @param string $chargeId
     *
     * @return Charge
     */
    public function setChargeId($chargeId)
    {
        $this->chargeId = $chargeId;

        return $this;
    }

    /**
     * Get chargeId.
     *
     * @return string
     */
    public function getChargeId()
    {
        return $this->chargeId;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
}
