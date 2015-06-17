<?php

namespace Ibase\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ibase\StoreBundle\Entity\Specification;
use Ibase\StoreBundle\Form\SpecificationType;

/**
 * Specification controller.
 *
 */
class SpecificationController extends Controller
{

    /**
     * Lists all Specification entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IbaseStoreBundle:Specification')->findAll();

        return $this->render('IbaseStoreBundle:Specification:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Specification entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Specification();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('specification_show', array('id' => $entity->getId())));
        }

        return $this->render('IbaseStoreBundle:Specification:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Specification entity.
    *
    * @param Specification $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Specification $entity)
    {
        $form = $this->createForm(new SpecificationType(), $entity, array(
            'action' => $this->generateUrl('specification_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Specification entity.
     *
     */
    public function newAction()
    {
        $entity = new Specification();
        $form   = $this->createCreateForm($entity);

        return $this->render('IbaseStoreBundle:Specification:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Specification entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Specification')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Specification entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:Specification:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Specification entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Specification')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Specification entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:Specification:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Specification entity.
    *
    * @param Specification $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Specification $entity)
    {
        $form = $this->createForm(new SpecificationType(), $entity, array(
            'action' => $this->generateUrl('specification_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Specification entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:Specification')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Specification entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('specification_edit', array('id' => $id)));
        }

        return $this->render('IbaseStoreBundle:Specification:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Specification entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbaseStoreBundle:Specification')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Specification entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('specification'));
    }

    /**
     * Creates a form to delete a Specification entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('specification_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
    
    public function showInProductAction ($product_id) 
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IbaseStoreBundle:Specification')
                ->getWithProduct($product_id);

        return $this->render('IbaseStoreBundle:Specification:index.html.twig', array(
            'entities' => $entities,
        ));
        
    }
}
