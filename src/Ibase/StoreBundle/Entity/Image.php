<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Image
 */
class Image
{
    /**
     * @var integer
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var integer
     */
    public $ord;
    
    /**
     * @var \Ibase\StoreBundle\Entity\Product
     */
    private $Product;
    
    /**
     * @var integer
     */
    public $path;
    
    /**
     * Set id
     *
     * @param integer $id
     * @return Image
     */
    public function setId($id)
    {
        $this->id = $id;
    
        return $this;
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
     * @return Image
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
     * Set ord
     *
     * @param integer $ord
     * @return Image
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    
        return $this;
    }

    /**
     * Get ord
     *
     * @return integer 
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * Set Product
     *
     * @param \Ibase\StoreBundle\Entity\Product $product
     * @return Image
     */
    public function setProduct(\Ibase\StoreBundle\Entity\Product $product = null)
    {
        $this->Product = $product;
    
        return $this;
    }

    /**
     * Get Product
     *
     * @return \Ibase\StoreBundle\Entity\Product 
     */
    public function getProduct()
    {
        return $this->Product;
    }

    //const SERVER_PATH_TO_IMAGE_FOLDER ='';

    /**
     * Unmapped property to handle file uploads
     */
    private $file;

    /**
     * Sets file.
     *
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Manages the copying of the file to the relevant place on the server
     */
    public function upload()
    {
        // the file property can be empty if the field is not required
        if (null === $this->getFile()) {
            return;
        }

        // we use the original file name here but you should
        // sanitize it at least to avoid any security issues

        // move takes the target directory and target filename as params
        $this->getFile()->move(
            $this->getUploadRootDir(),
            $this->getFile()->getClientOriginalName()
        );

        // set the path property to the filename where you've saved the file
        $this->path = $this->getFile()->getClientOriginalName();

        // clean up the file property as you won't need it anymore
        $this->setFile(null);
    }
        
    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        return __DIR__.'/../../../../web/'.$this->getUploadDir();
    }
    
    protected function getUploadDir()
    {
        // get rid of the __DIR__ so it doesn’t screw up
        // when displaying uploaded doc/image in the view.
        $directory = '/uploads';
//        if(!is_writable($directory)) {
//            mkdir("/uploads", 0777);
//        }
        return $directory;
    }
    
    public function getAbsolutePath()
    {
        return null === $this->path
            ? null
            : $this->getUploadRootDir().'/'.$this->path;
    }

    public function getWebPath()
    {
        //get rid of '/web' when using in local
        return null === $this->path
            ? 'null'
            : '/web'.$this->getUploadDir().'/'.$this->path;
    }

    /**
     * @ORM\PrePersist
     * Lifecycle callback to upload the file to the server
     */
    public function lifecycleFileUpload() {
        $this->upload();
    }

    /**
     * Updates the hash value to force the preUpdate and postUpdate events to fire
     */
    public function refreshUpdated() {
        $this->setUpdated(new \DateTime("now"));
    }
    
    /**
     * @var \DateTime
     */
    private $updated;

    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @return Image
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;
    
        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime 
     */
    public function getUpdated()
    {
        return $this->updated;
    }
    
    public function __toString()
    {
        return $this->getName() ? $this->getName() : "";
    }
}