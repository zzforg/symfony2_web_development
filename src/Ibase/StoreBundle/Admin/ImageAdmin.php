<?php

namespace Ibase\StoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Validator\ErrorElement;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ImageAdmin
 *
 * @author jw
 */
class ImageAdmin extends Admin {
    
     protected $parentAssociationMapping = 'product';
    
     protected function configureFormFields(FormMapper $formMapper)
    {
         
//        // get the current Image instance
//        $image = $this->getSubject();
//
//        // use $fileFieldOptions so we can add other options to the field
//        $fileFieldOptions = array('required' => false);
//        if ($image && ($webPath = $image->getWebPath())) {
//            // get the container so the full path to the image can be set
//            $container = $this->getConfigurationPool()->getContainer();
//            $fullPath = $container->get('request')->getBasePath().'/'.$webPath;
//
//            // add a 'help' option containing the preview's img tag
//            $fileFieldOptions['help'] = '<img src="'.$fullPath.'" class="admin-preview" />';
//        }
        
        $formMapper
            ->add('file', 'file', array('required' => false))
            ->add('name')
              //The 1st Product is used when uploading image 
              //associate with a product(system choose)
//            ->add('Product','hidden',array('attr'=>array("hidden" => true)));
              //The 2nd is used when choose a from list of product
              //when upload image
//            ->add('Product', 'sonata_type_model', array('attr'=>array("hidden" => true)), array()); 
            ;
     }
       
    public function prePersist($image) {
        $this->manageFileUpload($image);
    }

    public function preUpdate($image) {
        $this->manageFileUpload($image);
    }

    private function manageFileUpload($image) {
        if ($image->getFile()) {
            $image->refreshUpdated();
        }
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
            ->add('images')
            ->add('name');
//            ->add('ord');
    }
        
    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('id')
            ->add('images','images', array('required'=>false, 
                'template' => 'IbaseStoreBundle:Admin:list_images.html.twig'))
            ->add('name')
            ->add('product')
//            ->add('ord');
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
            
            if(!is_file($object->getFile())){
                $errorElement
                    ->with('images')
                        ->addViolation('You need to choose a file!')
                    ->end();
            }
        }
    }
}
