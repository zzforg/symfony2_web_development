<?php

namespace Ibase\MailBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Swift_Image;

class MailController extends Controller
{
    
    protected $service;
    
    public function __construct($service) {
          $this->service = $service;
    }

    public function sendMail($to, $type, $order)
    {
        $log = $this->get('logger');
        $message = \Swift_Message::newInstance()
                ->setSubject('Ibase Mail Center')
                ->setFrom('zzforg@gmail.com')
                ->setTo($to);

        $logo=$message->embed(Swift_Image::fromPath('images/ibase_logo.jpg'));
        $fName = $order->getCustomer()->getFirstName();
        
        $orderNumber = $order->getId() + 100000;
        $reorderURL = $this->get('router')->generate('ibase_reorder', 
                array(
                    'orderNum' => $orderNumber
                    ));
        switch ($type)
        {
        case 1:
          $message->setBody(
                  $this->renderView(
                          'IbaseMailBundle:Mail:email_waiting.html.twig', 
                          array(
                              'order' => $order,
                              'logo' => $logo,
                              'url' => $reorderURL,
                          )
                    ),'text/html');
          break;  
        case 2:
          $message->setBody(
                  $this->renderView(
                          'IbaseMailBundle:Mail:email_paid.html.twig', 
                          array(
                              'order' => $order,
                              'logo' => $logo,
                          )
                    ),'text/html');
          break;
        case 3:
            $message->setBody(
                  $this->renderView(
                          'IbaseMailBundle:Mail:email_shipped.html.twig', 
                          array(
                              'order' => $order,
                              'logo' => $logo,
                          )
                    ),'text/html');
            break;
        case 4:     
        $map=$message->embed(Swift_Image::fromPath('images/ibase_map.jpg'));
            $message->setBody(
                  $this->renderView(
                          'IbaseMailBundle:Mail:email_pickup.html.twig', 
                          array(
                              'order' => $order,
                              'logo' => $logo,
                              'map' => $map,
                          )
                    ),'text/html');
            break;
        case 5:
            $message->setBody(
                  $this->renderView(
                          'IbaseMailBundle:Mail:freight.html.twig', 
                          array(
                              'order' => $order,
                          )
                    ),'text/html');
            break;
        case 6:
            $message->setBody(
                  $this->renderView(
                          'IbaseMailBundle:Mail:new_order.html.twig', 
                          array(
                              'order' => $order,
                          )
                    ),'text/html');
            break;
        default:
            $message->setBody(
                  $this->renderView(
                          'IbaseMailBundle:Mail:email_error.html.twig', 
                          array(
                              'fName' => $fName,
                              'orderNum' => $order,
                              'logo' => $logo,
                          )
                    ),'text/html');
        }
        try{
            $this->get('mailer')->send($message);
        } catch (Exception $ex) {
            $log->error('the email can not be sent');
        }
        return $this->render('IbaseMailBundle:Mail:email.html.twig');
    }
}
