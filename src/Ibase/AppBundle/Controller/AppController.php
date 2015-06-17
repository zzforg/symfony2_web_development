<?php

namespace Ibase\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ibase\AppBundle\Form\Type\ContactType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Ibase\StoreBundle\Entity\Category;
//use Symfony\Component\HttpFoundation\File\UploadedFile;

class AppController extends Controller
{
    /**
     * @Route("/")
     * @Template("index.html.twig")
     */
    public function indexAction()
    {
        return $this->render('IbaseAppBundle:App:index.html.twig');
    }
    
    /**
     * @Route("/aboutus")
     * @Template("about.html.twig")
     */
    public function aboutAction()
    {
        $log = $this->get('logger');
        $log->info('info log for testing');
        $log->error('error log for testing');
        return $this->render('IbaseAppBundle:App:about.html.twig');
    }
    
    /**
     * @Route("/contact")
     * @Template("contact.html.twig")
     */
    public function contactAction()
    {
        return $this->render('IbaseAppBundle:App:contact.html.twig');
    }
//    public function contactAction(Request $request)
//    {
//        $form = $this->createForm(new ContactType());
//
//        if ($request->isMethod('POST')) {
//            $form->handleRequest($request);
//
//            if ($form->isValid()) {
//                $message = \Swift_Message::newInstance()
//                    ->setSubject($form->get('subject')->getData())
//                    ->setFrom($form->get('email')->getData())
//                    ->setTo('zzforg@gmail.com')
//                    ->setBody(
//                        $this->renderView(
//                            'IbaseAppBundle:Mail:contactMail.html.twig',
//                            array(
//                                'ip' => $request->getClientIp(),
//                                'name' => $form->get('name')->getData(),
//                                'email' => $form->get('email')->getData(),
//                                'subject' => $form->get('subject')->getData(),
//                                'message' => $form->get('message')->getData(),
//                            )
//                        ),
//                        'text/html'
//                    );
//
//                $this->get('mailer')->send($message);
//
//                $request->getSession()->getFlashBag()->add('success', 'Your email has been sent! Thanks!');
//
//                return $this->redirect($this->generateUrl('ibase_contact_us'));
//            }
//        }
//
//        return $this->render('IbaseAppBundle:App:contact.html.twig', 
//                array(
//                    'form' => $form->createView()
//                ));
//    }
    
    /**
     * @Route("/renderContact")
     * @Template("renderContact.html.twig")
     */
    public function renderContactAction(Request $request)
    {
        $form = $this->createForm(new ContactType());
        $adminEmail = $this->container->getParameter('mailer_user');

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);

            if ($form->isValid()) {
                $message = \Swift_Message::newInstance()
                    ->setSubject($form->get('subject')->getData())
                    ->setFrom($form->get('email')->getData())
                    ->setTo($adminEmail)
                    ->setBody(
                        $this->renderView(
                            'IbaseAppBundle:Mail:contactMail.html.twig',
                            array(
                                'ip' => $request->getClientIp(),
                                'name' => $form->get('name')->getData(),
                                'email' => $form->get('email')->getData(),
                                'oderNum' => $form->get('oderNumber')->getData(),
                                'itemNum' => $form->get('itemNumber')->getData(),
                                'subject' => $form->get('subject')->getData(),
                                'message' => $form->get('message')->getData(),
                            )
                        ),
                        'text/html'
                    );
                
                $this->get('mailer')->send($message);
                    
                $request->getSession()->getFlashBag()->add('success', 
                        'Your request has been sent! Thanks! '
                        . 'We will get back to you ASAP');
//                return $this->redirect($this->generateUrl('ibase_contact_us'));
            }
        }

        return $this->render('IbaseAppBundle:App:renderContact.html.twig', 
                array(
                    'form' => $form->createView()
                ));
    }
    
    /**
     * @Route("/renderMenu")
     * @Template("renderMenu.html.twig")
     */
    public function renderMenuAction() {
        //get all category datas
        try{
            $em = $this->getDoctrine()->getManager();
            $category = $em->getRepository('IbaseStoreBundle:Category')
                                ->findAll();
            if(isset($category)){
                return $this->render('IbaseAppBundle:App:renderMenu.html.twig',
                    array(
                        'categories' => $category
                    ));
            } else {
                return $this->render('IbaseAppBundle:App:renderMenu.html.twig',
                    array(
                        'categories' => false
                    ));
            }
            
        } catch (Exception $ex) {
            $this->get('logger')->error('Menu is not getting categories'.$ex);
        } 
    }
    
    /**
     * @Route("/renderHot")
     * @Template("renderHot.html.twig")
     */
    public function renderHotAction(){
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('IbaseStoreBundle:Product')
                                ->findAll();
        //Need to be finished by JUE
//        $products = $em->getRepository('IbaseStoreBundle:Product')
//                                ->findTopSaleProducts();
        try{
            return $this->render('IbaseAppBundle:App:renderHot.html.twig',
                    array(
                        'products' => $products
                    ));
        } catch (Exception $ex) {
            $this->get('logger')->error('Can not render products'.$ex);
        }
    }
    
    public function renderBannerAction(){
        //form of upload image
        //get path
        //render view
        return;
    }
    
    public function renderLinkAction(){
        //same as above
        return;
    }
    
    public function uploadImage(){
        return;
    }
}
