<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Package
 */
class Package
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $model;

    /**
     * @var string
     */
    private $name;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ProductPerPackage;
    
            
    

    private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ProductPerPackage = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set model
     *
     * @param string $model
     * @return Package
     */
    public function setModel($model)
    {
        $this->model = $model;
    
        return $this;
    }

    /**
     * Get model
     *
     * @return string 
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Package
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Add ProductPerPackage
     *
     * @param \Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage
     * @return Package
     */
    public function addProductPerPackage(\Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage)
    {
        $this->ProductPerPackage[] = $productPerPackage;
    
        return $this;
    }

    /**
     * Remove ProductPerPackage
     *
     * @param \Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage
     */
    public function removeProductPerPackage(\Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage)
    {
        $this->ProductPerPackage->removeElement($productPerPackage);
    }

    /**
     * Get ProductPerPackage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductPerPackage()
    {
        return $this->ProductPerPackage;
    }
    



    /**
     * Set product
     *
     * @param \Ibase\StoreBundle\Entity\Product $product
     * @return Package
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
    
     public function __toString()
    {
        return $this->getName() ? $this->getName() : "";
    }
    /**
     * @var \Ibase\StoreBundle\Entity\Product
     */

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $productPerPackage;


}