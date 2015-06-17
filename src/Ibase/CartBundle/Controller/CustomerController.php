<?php

namespace Ibase\CartBundle\Controller;

use Ibase\StoreBundle\Controller\CustomerController as BaseController;
use Ibase\StoreBundle\Entity\Customer;
use Ibase\StoreBundle\Form\CustomerType;
use Symfony\Component\Validator\Constraints\NotBlank;

class CustomerController extends BaseController
{    
//    public function newAction()
//    {
//        $session = $this->getRequest()->getSession();
//        if(!$session->has('cart')){
//            return $this->redirect($this->generateUrl('ibase_home')); 
//        }
//        $response = parent::newAction();
//        return $response;
//    }

    public function createAction(\Symfony\Component\HttpFoundation\Request $request) 
    {
        $session = $this->getRequest()->getSession();
        $em = $this->getDoctrine()->getManager();
        if(!$session->has('cart')){
            return $this->redirect($this->generateUrl('ibase_home')); 
        } elseif($session->has('cart') && $session->has('customer')){
            return $this->redirect($this->generateUrl('ibase_payment')); 
        }
        $log = $this->get('logger');
        try{
            
            $entity = new Customer();
            $form = $this->createForm(new CustomerType(), $entity, array(
                'method' => 'POST',
            ));
            $form->add('submit', 'submit', array('label' => 'Continue'));
//            $form->add('previousStep', 'submit', array(
//                'validation_groups' => false,
//                ));
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em->persist($entity);
                //check if customer exists
                $email = $entity->getEmail();
                $ExistingCustomers = $em->getRepository('IbaseStoreBundle:Customer')
                              ->findBy(
                                        array('email' => $email)
                                      );

                if(isset($ExistingCustomers)){
                    if(in_array($email, $ExistingCustomers)){
                        $entity->setFirstTime(false);
                        foreach($ExistingCustomers as $cus) {
                            $cus->setFirstTime(false);
                            $em->persist($cus);
                        }
                    } else {
                        $entity->setFirstTime(true);
                    }
                } 
                $em->flush();
                $session = $this->getRequest()->getSession();
                $session->set('customer', $entity->getId());
                //if create success -> payment method page
                $redirctUrl = $this->redirect($this->generateUrl('ibase_payment'));
                return $redirctUrl;
            }
            return $this->render('IbaseCartBundle:Customer:new.html.twig', array(
                'form' => $form->createView(),
            ));
        } catch (Exception $ex) {
            $log->error('Fail to create new customer by: '.$ex);
        }
        
    }
    

}
