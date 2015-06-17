<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Category
 */
class Category
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->product = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Category
     */
    public function setName($name)
    {
        if ($this->slug == null) {
            $this->slug = $name;
        }
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
     * Set description
     *
     * @param string $description
     * @return Category
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
     * Add product
     *
     * @param \Ibase\StoreBundle\Entity\Product $product
     * @return Category
     */
    public function addProduct(\Ibase\StoreBundle\Entity\Product $product)
    {
        $this->product[] = $product;
    
        return $this;
    }

    /**
     * Remove product
     *
     * @param \Ibase\StoreBundle\Entity\Product $product
     */
    public function removeProduct(\Ibase\StoreBundle\Entity\Product $product)
    {
        $this->product->removeElement($product);
    }

    /**
     * Get product
     *
     * @return \Doctrine\Common\Collections\Collection 
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
     * @var string
     */
    private $slug;


    /**
     * Set slug
     *
     * @param string $slug
     * @return Category
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $subCategory;


    /**
     * Add subCategory
     *
     * @param \Ibase\StoreBundle\Entity\category $subCategory
     * @return Category
     */
    public function addSubCategory(\Ibase\StoreBundle\Entity\category $subCategory)
    {
        $this->subCategory[] = $subCategory;
    
        return $this;
    }

    /**
     * Remove subCategory
     *
     * @param \Ibase\StoreBundle\Entity\category $subCategory
     */
    public function removeSubCategory(\Ibase\StoreBundle\Entity\category $subCategory)
    {
        $this->subCategory->removeElement($subCategory);
    }

    /**
     * Get subCategory
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }
    /**
     * @var \Ibase\StoreBundle\Entity\Category
     */
    private $topCategory;


    /**
     * Set topCategory
     *
     * @param \Ibase\StoreBundle\Entity\Category $topCategory
     * @return Category
     */
    public function setTopCategory(\Ibase\StoreBundle\Entity\Category $topCategory = null)
    {
        $this->topCategory = $topCategory;
    
        return $this;
    }

    /**
     * Get topCategory
     *
     * @return \Ibase\StoreBundle\Entity\Category 
     */
    public function getTopCategory()
    {
        return $this->topCategory;
    }
}