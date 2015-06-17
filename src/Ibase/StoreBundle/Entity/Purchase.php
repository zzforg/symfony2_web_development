<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ibase\bundle\MailBundle;

/**
 * Purchase
 */
class Purchase
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $delivery_fee;

    /**
     * @var string
     */
    private $total_amount;

    /**
     * @var string
     */
    private $status;
    
    /**
     * @var string
     */
    private $tracking_number;
    
    /**
     * @var string
     */
    private $carrier;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $purchasePerItem;

    /**
     * @var \Ibase\StoreBundle\Entity\Customer
     */
    private $customer;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchasePerItem = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set delivery_fee
     *
     * @param string $deliveryFee
     * @return Purchase
     */
    public function setDeliveryFee($deliveryFee)
    {
        $this->delivery_fee = $deliveryFee;
    
        return $this;
    }

    /**
     * Get delivery_fee
     *
     * @return string 
     */
    public function getDeliveryFee()
    {
        return $this->delivery_fee;
    }

    /**
     * Set total_amount
     *
     * @param string $totalAmount
     * @return Purchase
     */
    public function setTotalAmount($totalAmount)
    {
        $this->total_amount = $totalAmount;
    
        return $this;
    }

    /**
     * Get total_amount
     *
     * @return string 
     */
    public function getTotalAmount()
    {
        return $this->total_amount;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return Purchase
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set tracking number
     *
     * @param string $status
     * @return Purchase
     */
    public function setTrackingNumber($trackingNumber)
    {
        $this->tracking_number = $trackingNumber;
    
        return $this;
    }

    /**
     * Get tracking number
     *
     * @return string 
     */
    public function getTrackingNumber()
    {
        return $this->tracking_number;
    }
    
        /**
     * Set status
     *
     * @param string $status
     * @return Purchase
     */
    public function setCarrier($carrier)
    {
        $this->carrier = $carrier;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return string 
     */
    public function getCarrier()
    {
        return $this->carrier;
    }
    
    /**
     * Add purchasePerItem
     *
     * @param \Ibase\StoreBundle\Entity\PurchasePerItem $purchasePerItem
     * @return Purchase
     */
    public function addPurchasePerItem(\Ibase\StoreBundle\Entity\PurchasePerItem $purchasePerItem)
    {
        $this->purchasePerItem[] = $purchasePerItem;
    
        return $this;
    }

    /**
     * Remove purchasePerItem
     *
     * @param \Ibase\StoreBundle\Entity\PurchasePerItem $purchasePerItem
     */
    public function removePurchasePerItem(\Ibase\StoreBundle\Entity\PurchasePerItem $purchasePerItem)
    {
        $this->purchasePerItem->removeElement($purchasePerItem);
    }

    /**
     * Get purchasePerItem
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPurchasePerItem()
    {
        return $this->purchasePerItem;
    }
    /**
     * Get purchasePerItem
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPurchasePerItemAsString()
    {
        return implode("\r\n",$this->purchasePerItem->toArray());
    }

    /**
     * Set customer
     *
     * @param \Ibase\StoreBundle\Entity\Customer $customer
     * @return Purchase
     */
    public function setCustomer(\Ibase\StoreBundle\Entity\Customer $customer = null)
    {
        $this->customer = $customer;
    
        return $this;
    }

    /**
     * Get customer
     *
     * @return \Ibase\StoreBundle\Entity\Customer 
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
       if(!$this->getCreatedAt()) {
            $this->createdAt = new \DateTime();
        }
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedAtValue()
    {
        $this->updatedAt = new \DateTime();
    }

    
        public function __toString()
    {
        return $this->getCustomer() ? $this->getCustomer()->getEmail() : " Thanks for your purchase";
    }


 

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Purchase
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    
        return $this;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Purchase
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    
        return $this;
    }
}