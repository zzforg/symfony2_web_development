<?php

namespace Ibase\StoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

use Tutorial\BlogBundle\Entity\Specification;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SpecificationAdmin
 *
 * @author jw
 */
class SpecificationAdmin extends Admin {

    protected $parentAssociationMapping = 'product';
    
     protected function configureFormFields(FormMapper $formMapper)
    {
         if(!$this->isChild()) {
            $formMapper->add('product', 'sonata_type_model', array('attr'=>array("hidden" => true)), array());
        }
          $formMapper
            ->add('fieldName')
            ->add('description')
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
            ->add('fieldName')
            ->add('description')
        ;
    }
    
    
    /**
     * @param \Sonata\AdminBundle\Datagrid\ListMapper $listMapper
     * @return void
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('fieldName')
            ->add('description')
        ;
    }
    
}
