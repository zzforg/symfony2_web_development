<?php

// src/Ibase/StroreBundle/Admin/ProductAdmin.php
// Model code --- to be corrected.

namespace Ibase\StoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Ibase\StoreBundle\Form\SpecificationType;
use Ibase\StoreBundle\Form\ImageType;
use Doctrine\ORM\EntityRepository;


/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProductAdmin
 *
 * @author jw
 */
class ProductAdmin extends Admin {
    
     protected function configureFormFields(FormMapper $formMapper)
    {
         $formMapper
            ->add('name')
            ->add('category','entity', array(
                   'class' => 'IbaseStoreBundle:Category',
                   'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                              ->where('u.topCategory is not null')
                              ->OrderBy('u.name','ASC')
                              ;},
                  ))
            ->add('model')
            ->add('brand', null, array('required' => false))
//            ->add('color', null, array('required' => false))
//            ->add('material', null, array('required' => false))
            ->add('price') 
            ->add('freight', 'choice', array(
                'choices'   => array(
                    0   => 'Free',
                    null => 'Freight',
                ),
                'required'  => false,
            ))
            ->with('Specifications')
//                ->add('specifications','sonata_type_model',
//                      array('expanded' => true, 'multiple' => true))
                 ->add('specifications', 'sonata_type_collection', 
                         array(
                             'required' => false,
                            'by_reference' => false,
                            'type_options' => array('delete' => false)
                    ), 
                         array(
                            'edit' => 'inline',
                            'inline' => 'table',
                            'sortable' => 'id',
                    ))
            ->end()
            ->with('Images')                     
              ->add('images','sonata_type_model',
                    array(
                        'required' => false,
                        'expanded' => false, 
                        'multiple' => true,
                        
                        ))
                //This part is used when images and product persist at the same
                //time, not stable, only success when all image forms not null
//                ->add('images', 'sonata_type_collection', 
//                        array(
//                            'required' => false,
//                            'by_reference' => false,
//                            'type_options' => array('delete' => true),
//                    ), 
//                        array(
//                            'edit' => 'inline',
//                            'inline' => 'table',
//                            'sortable' => 'id',
//                    ))
            ->end()
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
            ->add('id')
            ->add('name')
            ->add('model')
            ->add('brand')
//            ->add('color')
//            ->add('material')
            ->add('price')
            ->add('freight')
            ->add('specifications')
            ->with("images")
            ->add('images', 'images', 
                    array(
                        'required'=>false, 
                        'template' => 'IbaseStoreBundle:Admin:list_product_images.html.twig'))
            ->end();

    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('id')
            ->add('name')
            ->add('model')
            ->add('brand');

    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('Id')
            ->add('model')
            ->add('images', 'images', array('required'=>false, 
                'template' => 'IbaseStoreBundle:Admin:product_list_image.html.twig'))
            ->add('name')
            ->add('brand')
            ->add('price')
            ->add('freight')    
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
    public function validate(ErrorElement $errorElement, $object)
    {
        // conditional validation, see the related section for more information
        if ($object) {
            // abstract cannot be empty when the post is enabled
            $errorElement
                ->with('name')
                    ->assertNotBlank()
                    ->assertNotNull()
                ->end()
            ;
        }
    }
    
    public function prePersist($object) {
        $images = $object->getImages();
        foreach($images as $img){
            if(isset($img)){
                $img->setProduct($object);
            }  
        }
    }
    
    public function preUpdate($object) {
        $images = $object->getImages();
        if(isset($images)){
            foreach($images as $img){
                $img->setProduct($object);
            }
        }
    }

}