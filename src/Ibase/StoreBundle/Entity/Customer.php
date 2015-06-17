<?php

namespace Ibase\StoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Customer
 */
class Customer
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $first_name;

    /**
     * @var string
     */
    private $last_name;

    /**
     * @var string
     */
    private $street;

    /**
     * @var string
     */
    private $town;

    /**
     * @var string
     */
    private $state;

    /**
     * @var string
     */
    private $country;

    /**
     * @var string
     */
    private $postcode;

    /**
     * @var string
     */
    private $contact;
    
    /**
     * @var boolean
     */
    private $first_time;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $purchase;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->purchase = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set email
     *
     * @param string $email
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;
    
        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set first_name
     *
     * @param string $firstName
     * @return Customer
     */
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    
        return $this;
    }

    /**
     * Get first_name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Set last_name
     *
     * @param string $lastName
     * @return Customer
     */
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    
        return $this;
    }

    /**
     * Get last_name
     *
     * @return string 
     */
    public function getLastName()
    {
        return $this->last_name;
    }
    
    /**
     * Get full_name
     *
     * @return string 
     */
    public function getFullName()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Set street
     *
     * @param string $street
     * @return Customer
     */
    public function setStreet($street)
    {
        $this->street = $street;
    
        return $this;
    }

    /**
     * Get street
     *
     * @return string 
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * Set town
     *
     * @param string $town
     * @return Customer
     */
    public function setTown($town)
    {
        $this->town = $town;
    
        return $this;
    }

    /**
     * Get town
     *
     * @return string 
     */
    public function getTown()
    {
        return $this->town;
    }

    /**
     * Set state
     *
     * @param string $state
     * @return Customer
     */
    public function setState($state)
    {
        $this->state = $state;
    
        return $this;
    }

    /**
     * Get state
     *
     * @return string 
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return Customer
     */
    public function setCountry($country)
    {
        $this->country = $country;
    
        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set postcode
     *
     * @param string $postcode
     * @return Customer
     */
    public function setPostcode($postcode)
    {
        $this->postcode = $postcode;
    
        return $this;
    }

    /**
     * Get postcode
     *
     * @return string 
     */
    public function getPostcode()
    {
        return $this->postcode;
    }

    /**
     * Set contact
     *
     * @param string $contact
     * @return Customer
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    
        return $this;
    }

    /**
     * Get contact
     *
     * @return string 
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Add purchase
     *
     * @param \Ibase\StoreBundle\Entity\Purchase $purchase
     * @return Customer
     */
    public function addPurchase(\Ibase\StoreBundle\Entity\Purchase $purchase)
    {
        $this->purchase[] = $purchase;
    
        return $this;
    }

    /**
     * Remove purchase
     *
     * @param \Ibase\StoreBundle\Entity\Purchase $purchase
     */
    public function removePurchase(\Ibase\StoreBundle\Entity\Purchase $purchase)
    {
        $this->purchase->removeElement($purchase);
    }

    /**
     * Get purchase
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPurchase()
    {
        return $this->purchase;
    }
    
        
    public function __toString()
   {
         return $this->getEmail() ? $this->getEmail() : "";
   }

    /**
     * Set first_time
     *
     * @param boolean $firstTime
     * @return Customer
     */
    public function setFirstTime($firstTime)
    {
        $this->first_time = $firstTime;
    
        return $this;
    }

    /**
     * Get first_time
     *
     * @return boolean 
     */
    public function getFirstTime()
    {
        return $this->first_time;
    }
}