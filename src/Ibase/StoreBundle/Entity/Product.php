<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
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
    private $model;

    /**
     * @var string
     */
    private $brand;

    /**
     * @var string
     */
    private $color;

    /**
     * @var string
     */
    private $material;

    /**
     * @var string
     */
    private $price;

    /**
     * @var string
     */
    private $freight;
    
    /**
     * @var \Ibase\StoreBundle\Entity\PurchasePerItem
     */
    private $purchasePerItem;


    /**
     * @var \Ibase\StoreBundle\Entity\Category
     */
    private $category;
    
    /**
     * @var \Ibase\StoreBundle\Entity\Specification
     */
    
    private $specifications;
   /**
     * @var \Ibase\StoreBundle\Entity\Image
     */
    private $images;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->specifications = new \Doctrine\Common\Collections\ArrayCollection();
        $this->images = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Product
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
     * Set model
     *
     * @param string $model
     * @return Product
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
     * Set brand
     *
     * @param string $brand
     * @return Product
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;
    
        return $this;
    }

    /**
     * Get brand
     *
     * @return string 
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set color
     *
     * @param string $color
     * @return Product
     */
    public function setColor($color)
    {
        $this->color = $color;
    
        return $this;
    }

    /**
     * Get color
     *
     * @return string 
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set material
     *
     * @param string $material
     * @return Product
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    
        return $this;
    }

    /**
     * Get material
     *
     * @return string 
     */
    public function getMaterial()
    {
        return $this->material;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;
    
        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set category
     *
     * @param \Ibase\StoreBundle\Entity\Category $category
     * @return Product
     */
    public function setCategory(\Ibase\StoreBundle\Entity\Category $category = null)
    {
        $this->category = $category;
    
        return $this;
    }

    /**
     * Get category
     *
     * @return \Ibase\StoreBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @var \Ibase\StoreBundle\Entity\Package
     */
    private $package;


    /**
     * Set package
     *
     * @param \Ibase\StoreBundle\Entity\Package $package
     * @return Product
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
        return $this->getName() ? $this->getName() : "";
    }
    
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $productPerPackage;


    /**
     * Add productPerPackage
     *
     * @param \Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage
     * @return Product
     */
    public function addProductPerPackage(\Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage)
    {
        $this->productPerPackage[] = $productPerPackage;
    
        return $this;
    }

    /**
     * Remove productPerPackage
     *
     * @param \Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage
     */
    public function removeProductPerPackage(\Ibase\StoreBundle\Entity\ProductPerPackage $productPerPackage)
    {
        $this->productPerPackage->removeElement($productPerPackage);
    }

    /**
     * Get productPerPackage
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getProductPerPackage()
    {
        return $this->productPerPackage;
    }

    /**
     * Set purchasePerItem
     *
     * @param \Ibase\StoreBundle\Entity\purchasePerItem $purchasePerItem
     * @return Product
     */
    public function setPurchasePerItem(\Ibase\StoreBundle\Entity\purchasePerItem $purchasePerItem = null)
    {
        $this->purchasePerItem = $purchasePerItem;
    
        return $this;
    }

    /**
     * Get purchasePerItem
     *
     * @return \Ibase\StoreBundle\Entity\purchasePerItem 
     */
    public function getPurchasePerItem()
    {
        return $this->purchasePerItem;
    }

    /**
     * Add purchasePerItem
     *
     * @param \Ibase\StoreBundle\Entity\PurchasePerItem $purchasePerItem
     * @return Product
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
     * Get specification
     *
     * @return \Ibase\StoreBundle\Entity\Specification 
     */
    public function getSpecifications()
    {
        return $this->specifications;
    }

    /**
     * Add specification
     *
     * @param \Ibase\StoreBundle\Entity\Specification $specification
     * @return Product
     */
    public function addSpecification(\Ibase\StoreBundle\Entity\Specification $specification)
    {
        $specification->setProduct($this);
        $this->specifications->add($specification);
    
        return $this;
    }

    /**
     * Remove specification
     *
     * @param \Ibase\StoreBundle\Entity\Specification $specification
     */
    public function removeSpecification(\Ibase\StoreBundle\Entity\Specification $specification)
    {
        $this->specifications->removeElement($specification);
        $specification->setProduct(null);
    }
    

    /**
     * Get images
     *
     * @return \Ibase\StoreBundle\Entity\Image 
     */
    public function getImages()
    {
        return $this->images;
    }

    /**
     * Add image
     *
     * @param \Ibase\StoreBundle\Entity\Images $image
     * @return Product
     */
    public function addImages(\Ibase\StoreBundle\Entity\image $image)
    {
        $image->setProduct($this);
        $this->images->add($image);
    
        return $this;
    }

    /**
     * Remove image
     *
     * @param \Ibase\StoreBundle\Entity\Image $image
     */
    public function removeImages(\Ibase\StoreBundle\Entity\Specification $image)
    {
        $this->images->removeElement($image);
        $image->setProduct(null);
    }

    /**
     * Add images
     *
     * @param \Ibase\StoreBundle\Entity\Image $images
     * @return Product
     */
    public function addImage(\Ibase\StoreBundle\Entity\Image $images)
    {
        $this->images[] = $images;
    
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Ibase\StoreBundle\Entity\Image $images
     */
    public function removeImage(\Ibase\StoreBundle\Entity\Image $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Set freight
     *
     * @param string $freight
     * @return Product
     */
    public function setFreight($freight)
    {
        $this->freight = $freight;
    
        return $this;
    }

    /**
     * Get freight
     *
     * @return string 
     */
    public function getFreight()
    {
        return $this->freight;
    }
}