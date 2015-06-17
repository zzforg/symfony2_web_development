<?php

namespace Ibase\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ibase\StoreBundle\Entity\PurchasePerItem;
use Ibase\StoreBundle\Form\PurchasePerItemType;

/**
 * PurchasePerItem controller.
 *
 */
class PurchasePerItemController extends Controller
{

    /**
     * Lists all PurchasePerItem entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IbaseStoreBundle:PurchasePerItem')->findAll();

        return $this->render('IbaseStoreBundle:PurchasePerItem:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new PurchasePerItem entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new PurchasePerItem();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('choose_a_item_show', array('id' => $entity->getId())));
        }

        return $this->render('IbaseStoreBundle:PurchasePerItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a PurchasePerItem entity.
    *
    * @param PurchasePerItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(PurchasePerItem $entity)
    {
        $form = $this->createForm(new PurchasePerItemType(), $entity, array(
            'action' => $this->generateUrl('choose_a_item_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new PurchasePerItem entity.
     *
     */
    public function newAction()
    {
        $entity = new PurchasePerItem();
        $form   = $this->createCreateForm($entity);

        return $this->render('IbaseStoreBundle:PurchasePerItem:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a PurchasePerItem entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:PurchasePerItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PurchasePerItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:PurchasePerItem:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing PurchasePerItem entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:PurchasePerItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PurchasePerItem entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:PurchasePerItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a PurchasePerItem entity.
    *
    * @param PurchasePerItem $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(PurchasePerItem $entity)
    {
        $form = $this->createForm(new PurchasePerItemType(), $entity, array(
            'action' => $this->generateUrl('choose_a_item_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing PurchasePerItem entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:PurchasePerItem')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find PurchasePerItem entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('choose_a_item_edit', array('id' => $id)));
        }

        return $this->render('IbaseStoreBundle:PurchasePerItem:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a PurchasePerItem entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbaseStoreBundle:PurchasePerItem')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find PurchasePerItem entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('choose_a_item'));
    }

    /**
     * Creates a form to delete a PurchasePerItem entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('choose_a_item_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
