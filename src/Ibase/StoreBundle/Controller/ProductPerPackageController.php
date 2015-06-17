<?php

namespace Ibase\StoreBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Ibase\StoreBundle\Entity\ProductPerPackage;
use Ibase\StoreBundle\Form\ProductPerPackageType;

/**
 * ProductPerPackage controller.
 *
 */
class ProductPerPackageController extends Controller
{

    /**
     * Lists all ProductPerPackage entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('IbaseStoreBundle:ProductPerPackage')->findAll();

        return $this->render('IbaseStoreBundle:ProductPerPackage:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new ProductPerPackage entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new ProductPerPackage();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('package_include_show', array('id' => $entity->getId())));
        }

        return $this->render('IbaseStoreBundle:ProductPerPackage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a ProductPerPackage entity.
    *
    * @param ProductPerPackage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(ProductPerPackage $entity)
    {
        $form = $this->createForm(new ProductPerPackageType(), $entity, array(
            'action' => $this->generateUrl('package_include_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new ProductPerPackage entity.
     *
     */
    public function newAction()
    {
        $entity = new ProductPerPackage();
        $form   = $this->createCreateForm($entity);

        return $this->render('IbaseStoreBundle:ProductPerPackage:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a ProductPerPackage entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:ProductPerPackage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductPerPackage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:ProductPerPackage:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing ProductPerPackage entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:ProductPerPackage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductPerPackage entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IbaseStoreBundle:ProductPerPackage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a ProductPerPackage entity.
    *
    * @param ProductPerPackage $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(ProductPerPackage $entity)
    {
        $form = $this->createForm(new ProductPerPackageType(), $entity, array(
            'action' => $this->generateUrl('package_include_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing ProductPerPackage entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('IbaseStoreBundle:ProductPerPackage')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find ProductPerPackage entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('package_include_edit', array('id' => $id)));
        }

        return $this->render('IbaseStoreBundle:ProductPerPackage:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a ProductPerPackage entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IbaseStoreBundle:ProductPerPackage')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find ProductPerPackage entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('package_include'));
    }

    /**
     * Creates a form to delete a ProductPerPackage entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('package_include_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
