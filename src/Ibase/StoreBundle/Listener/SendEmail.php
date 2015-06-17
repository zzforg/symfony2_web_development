<?php

namespace Ibase\StoreBundle\Listener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Ibase\StoreBundle\Entity\Purchase;

 class SendEmail{
     
     protected $mailer;
     
     public function __construct ($ibaseMailController) {
         
         $this->mailer = $ibaseMailController;
         
     }


     /**
     * @ORM\PostUpdate
     */
    public function postUpdate(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        if ($entity instanceof Purchase) {  
            $email = $entity->getCustomer()->getEmail();
            if ($entity->getStatus()=="paid") {
                //send confirm email
                $this->mailer->sendMail($email, 2, $entity);
            }else if ($entity->getStatus()=="shipped") {
                //send delivered email
                $this->mailer->sendMail($email, 3, $entity);
            } else if($entity->getStatus()=="waiting"){
                $this->mailer->sendMail($email, 1, $entity);
            }
            
        } 
    }
     
     
     
 }

