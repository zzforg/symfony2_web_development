<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CategoryAdmin
 *
 * @author jw
 */


namespace Ibase\StoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CategoryAdmin extends Admin {
    // Define the fields to create/edit a category.
         protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name')
            ->add('description')
            ->add('topCategory')
//            ->add('subCategory', 'entity', 
//                    array(
//                        'class' => 'IbaseStoreBundle:Category',
//                        'expanded' => true, 
//                        'multiple' => true
//                        ), 
//                    array()
//            )
        ;
     }
         
     /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
         $showMapper
            ->add('name')
            ->add('description')
            ->add('topCategory')
//            ->add('subCategory', null,
//                    array( 
//                        'template' => 'IbaseStoreBundle:Admin:category_show.html.twig'
//                        )
//                )
         ;

    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('name')
            ->add('description')
            ->add('topCategory')
//            ->add('subCategory')
                // add custom action links
            ->add('_action', 'actions', 
                    array(
                        'actions' => array(
                        'show' => array(),
                        'edit' => array(),
                )
            ))
        ;
    }
    
    public function preRemove($object) {
        $top = $object->getTopCategory();
        $sub = $object->getSubCategory();
        if(isset($top)){
            $object->getTopCategory(null);
        } elseif(isset($sub)){
            foreach($sub as $s){
                $s->setTopCategory(null);   
            }
        }
    }
    
//    public function prePersist($object)
//    {
//        $this->preUpdate($object);
//    }
//    
//    public function preUpdate($object)
//    {
//        foreach ($object->getSubCategory() as $sub) {
//            $sub->setTopCategory($object);
//        }
//    }
}
