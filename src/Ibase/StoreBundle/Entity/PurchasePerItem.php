<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PurchasePerItem
 */
class PurchasePerItem
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $quantity;


    /**
     * @var \Ibase\StoreBundle\Entity\Purchase
     */
    private $purchase;


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
     * Set quantity
     *
     * @param integer $quantity
     * @return PurchasePerItem
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set purchase
     *
     * @param \Ibase\StoreBundle\Entity\Purchase $purchase
     * @return PurchasePerItem
     */
    public function setPurchase(\Ibase\StoreBundle\Entity\Purchase $purchase)
    {
        $this->purchase = $purchase;
    
        return $this;
    }

    /**
     * Get purchase
     *
     * @return \Ibase\StoreBundle\Entity\Purchase 
     */
    public function getPurchase()
    {
        return $this->purchase;
    }
    
        public function __toString()
    {
        if($this->getProduct()) {
            $itemDetail = $this->getProduct()->getModel()
                          .", "
                          .$this->getQuantity()
                          .", $"
                          .$this->getProduct()->getPrice();
         
        } else {
          $itemDetail = "";  
        }
        return $itemDetail;
    }
    /**
     * @var \Ibase\StoreBundle\Entity\Product
     */
    private $product;


    /**
     * Set product
     *
     * @param \Ibase\StoreBundle\Entity\Product $product
     * @return PurchasePerItem
     */
    public function setProduct(\Ibase\StoreBundle\Entity\Product $product = null)
    {
        $this->product = $product;
    
        return $this;
    }

    /**
     * Get product
     *
     * @return \Ibase\StoreBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->product;
    }

}