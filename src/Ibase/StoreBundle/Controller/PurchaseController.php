<?php

namespace Ibase\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ibase\StoreBundle\Entity\Purchase;
use Ibase\StoreBundle\Form\PurchaseType;

/**
 * Purchase controller.
 *
 */
class PurchaseController extends Controller
{

    /**
     * Lists all Purchase entities.
     *
     */
    public function indexAction($status = null)
    {
        $em = $this->getDoctrine()->getManager();
        
        if($status) {
           $entities = $em->getRepository('IbaseStoreBundle:Purchase')
                   ->findByStatus($status);
        }else {

        $entities = $em->getRepository('IbaseStoreBundle:Purchase')->findAll(); }

        return $this->render('IbaseStoreBundle:Purchase:index.html.twig', array(
            'entities' => $entities,
        ));
    }
 
    /**
     * Creates a new Purchase entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Purchase();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('Purchase_show', array('id' => $entity->getId())));
        }

        return $this->render('IbaseStoreBundle:Purchase:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Purchase entity.
    *
    * @param Purchase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Purchase $entity)
    {
        $form = $this->createForm(new PurchaseType(), $entity, array(
            'action' => $this->generateUrl('Purchase_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Purchase entity.
     *
     */
    public function newAction()
    {
        $entity = new Purchase();
        $form   = $this->createCreateForm($entity);

        return $this->render('IbaseStoreBundle:Purchase:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Purchase entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:Purchase:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Purchase entity.
     *
     */
    public function editAction($id, $tracking = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);
        if ($tracking) {
            return $this->render('IbaseStoreBundle:Purchase:trackingEdit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'tracking'    => $tracking,
                ));
        }
        
        return $this->render('IbaseStoreBundle:Purchase:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Purchase entity.
    *
    * @param Purchase $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Purchase $entity)
    {
        $form = $this->createForm(new PurchaseType(), $entity, array(
            'action' => $this->generateUrl('Purchase_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Purchase entity.
     *
     */
    public function updateAction(Request $request, $id, $tracking = null)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Purchase')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Purchase entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);
        
        if ($editForm->isValid()) {
            $em->flush();
            if($tracking) {
              return  $this->redirect($this->generateUrl('Purchase'));
            }

            return $this->redirect($this->generateUrl('Purchase_show', array('id' => $id)));
        }


        return $this->render('IbaseStoreBundle:Purchase:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Purchase entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbaseStoreBundle:Purchase')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Purchase entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('Purchase'));
    }

    /**
     * Creates a form to delete a Purchase entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Purchase_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    private function sendEmail($type) {
        $em = $this->getDoctrine()->getManager();
        $mailer = $this->get('ibase.mail.controller');
        if ($this->getStatus()=="confirmed") {
            //send confirm email
            
            $mailer->sendMail($this->getCustomer()->getEmail(), 1);
                
        }else if ($this->getStatus()=="delivered") {
            //send delivered email
            $mailer->sendMail($this->getCustomer()->getEmail(), 2);
        }
        
    }
    
    public function listByTimeAction($period) {
        $em = $this->getDoctrine()->getManager();
        
        if($period) {
           $entities = $em->getRepository('IbaseStoreBundle:Purchase')
                   ->getPurchaseWithDate($period);
        }else {

        throw $this->createNotFoundException('Unable to find purchase.');}

        return $this->render('IbaseStoreBundle:Purchase:index.html.twig', array(
            'entities' => $entities,
        ));
        
    }
    
    public function listByFullName($first, $last) {
        $em = $this->getDoctrine() ->getManager();
        if($first && $last) {
            $entities = $em->getRepository('IbaseStoreBundle:Purchase')
                    ->findByCustomerName($first, $last);
        } else {
            throw $this->createNotFoundException('Unable to find it.');
        }
         return $this->render('IbaseStoreBundle:Purchase:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    
    public function searchAction(Request $request) {
        $em = $this->getDoctrine()->getEntityManager();
        $data = array();
        $searchForm = $this->createFormBuilder($data)
                 ->add('type', 'choice', array(
                  'choices'   => array(
                    'Customer Email'   => 'email',
                    'Product Name' => 'product',
                    'Order Number'   => 'order',
                    )
                     ))
                 ->add('keyword', 'text')
                 ->add('search', 'submit')
                 ->getForm();
        $subRequest = $this->container->get('request');
        print($subRequest);
        if($subRequest->isMethod('GET')) {
            print($subRequest);
            $searchForm->handleRequest($subRequest);
        }
        if($searchForm->isSubmitted()) {
            print("SS////");
            $data = $searchForm->getData();
            $keyword = $data['keyword'];
            $type = $data['type'];
            $query = $em->createQueryBuilder()
                 ->select('p')
                 ->from('IbaseStoreBundle:Purchase',  'p')
                 ->where("p.Customer = :keyword")
                 ->setParameter('keyword', $keyword )
                 ->addOrderBy('p.id', 'DESC')
                 ->getQuery();
             $entities = $query->getResult();
        return $this->render('IbaseStoreBundle:Purchase:index.html.twig', array(
            'entities' => $entities)
                );
        }
        return $this->render('IbaseStoreBundle:Purchase:search.html.twig', array(
            'search_form' => $searchForm->createView()
                ));        

    }
    
    public function isRepeated($customer) {
        $flag = false;
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('IbaseStoreBundle:Purchase')
                ->countByCustomer($customer);
        if($entities) {
            $flag = true;
        }
    }
}
