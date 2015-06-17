<?php

namespace Ibase\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ibase\StoreBundle\Entity\Product;
use Ibase\StoreBundle\Form\ProductType;

/**
 * Product controller.
 *
 */
class ProductController extends Controller
{

    /**
     * Lists all Product entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IbaseStoreBundle:Product')->findAll();

        return $this->render('IbaseStoreBundle:Product:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Product entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Product();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_show', array('id' => $entity->getId())));
        }

        return $this->render('IbaseStoreBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Product entity.
    *
    * @param Product $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Product $entity)
    {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('product_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Product entity.
     *
     */
    public function newAction()
    {
        $entity = new Product();
        $form   = $this->createCreateForm($entity);

        return $this->render('IbaseStoreBundle:Product:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Product entity.
     *
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }
        $data = array();
        $cartForm = $this->createFormBuilder($data)
                ->add('quantity', 'integer' , array(
                 'attr' => 
                    array('min' => 1, 
                          'max' => 100,
                          'empty_value' => 1,
                          'empty_data' => 1,
                          'data' => 1,)
                    ))
                ->add('submit','submit', array(
                    'label' =>'Add to shopping cart',
                ))
                ->getForm();
        if($request->isMethod('POST')) {
            $cartForm->handleRequest($request);
            $data = $cartForm->getData();
        }
        if ($cartForm->isValid()) {
        return $this->redirect(
                $this->generateUrl('ibase_add_cart', array(
                    'id' => $id,
                    'num'=>$data["quantity"]
                )));
        
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:Product:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(), 
            'cart_form' => $cartForm->createView()
                ));
    }

    /**
     * Displays a form to edit an existing Product entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }

      $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:Product:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Product entity.
    *
    * @param Product $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Product $entity)
    {
        $form = $this->createForm(new ProductType(), $entity, array(
            'action' => $this->generateUrl('product_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Product entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Product')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Product entity.');
        }
        
        $originalSpecs = new \Doctrine\Common\Collections\ArrayCollection();

        // Create an ArrayCollection of the current Spec objects in the database
        foreach ($entity->getSpecifications() as $specification) {
        $originalSpecs->add($specification);
            }
        
        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            foreach ($originalSpecs as $specification) {
                if (false === $entity->getSpecifications()->contains($specification)) {
                    // remove the Spec
                    $entity->removeSpecification($specification);
                    $em->remove($specification);
                }
            }
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('product_edit', array('id' => $id)));
        }

        return $this->render('IbaseStoreBundle:Product:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Product entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbaseStoreBundle:Product')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Product entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('product'));
    }

    /**
     * Creates a form to delete a Product entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('product_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function listAction() 
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IbaseStoreBundle:Product')->findAll();

        return $this->render('IbaseStoreBundle:Product:list.html.twig', array(
            'entities' => $entities,
        ));
        
    }
    
    public function listByCategoryAction($slug) 
    {
        try{
           $em = $this->getDoctrine()->getManager();
           $entity = $em->getRepository('IbaseStoreBundle:Category')->findOneBy(
                    array('slug'=>$slug));
           $products = $entity->getProduct();
//            $entities = $em->getRepository('IbaseStoreBundle:Product')->findByCategory($category_id);
            return $this->render('IbaseStoreBundle:Product:index.html.twig', array(
                'entities' => $products,
            )); 
        } catch (Exception $ex) {
            $this->get('logger')
                    ->error('Could not retrieve products from database'.$ex);
        }
        
        
    }
    
}
