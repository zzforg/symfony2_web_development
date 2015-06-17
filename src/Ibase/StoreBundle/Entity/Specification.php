<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Specification
 */
class Specification
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $fieldName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Ibase\StoreBundle\Entity\Product
     */
    private $product;


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
     * Set fieldName
     *
     * @param string $fieldName
     * @return Specification
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
    
        return $this;
    }

    /**
     * Get fieldName
     *
     * @return string 
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Specification
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set product
     *
     * @param \Ibase\StoreBundle\Entity\Product $product
     * @return Specification
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
        return $this->getFieldName() ? $this->getFieldName() : "";
    }
    
}