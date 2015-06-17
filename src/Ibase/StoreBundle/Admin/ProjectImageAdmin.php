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

class ProjectImageAdmin extends Admin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('images', 'sonata_type_model_list', array(), array(
                'link_parameters' => array('context' => 'default')
            ))
            ;
    }
    
    protected function configureListFields(ListMapper $list)
    {
        $list
            ->add('product')
            ->add('images')
        ;
    }
}

