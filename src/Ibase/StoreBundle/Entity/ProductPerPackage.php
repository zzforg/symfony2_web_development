<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductPerPackage
 */
class ProductPerPackage
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
     * @var \Ibase\StoreBundle\Entity\Product
     */
    private $product;

    /**
     * @var \Ibase\StoreBundle\Entity\Package
     */
    private $package;


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
     * @return ProductPerPackage
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
     * Set product
     *
     * @param \Ibase\StoreBundle\Entity\Product $product
     * @return ProductPerPackage
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

    /**
     * Set package
     *
     * @param \Ibase\StoreBundle\Entity\Package $package
     * @return ProductPerPackage
     */
    public function setPackage(\Ibase\StoreBundle\Entity\Package $package = null)
    {
        $this->package = $package;
    
        return $this;
    }

    /**
     * Get package
     *
     * @return \Ibase\StoreBundle\Entity\Package 
     */
    public function getPackage()
    {
        return $this->package;
    }
    
       public function __toString()
    {
        return $this->getProduct() ? $this->getProduct()->getName() : "";
    }
}