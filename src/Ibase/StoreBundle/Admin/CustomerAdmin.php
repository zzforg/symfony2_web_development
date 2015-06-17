<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomerAdmin
 *
 * @author jw
 */


namespace Ibase\StoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

class CustomerAdmin extends Admin {
        // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('email')
            ->add('first_time')
            ->add('first_name')
            ->add('last_name')
            ->add('street')
            ->add('town')
            ->add('state', 'choice', array(
                              'choices'   => array(
                              'qld' => 'Queensland',
                              'nsw' =>'New South Wales',
                              'vic' => 'Victoria',
                              'act' => 'Australian Capital Territory',
                              'nt' => 'Northern Territory',
                              'sa'  => 'South Australia',
                              'wa'  => 'Western Australia',
                              'tas' => 'Tasmania',
                              )))
            ->add('country', 'text', array(
              'data' => 'Australia', 'read_only' => TRUE))
            ->add('postcode', null, array('required' => false))
            ->add('contact', 'text', array(
                'required' => false,
                'attr' => array('placeholder' => '10 digits mobile/phone')))
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
            ->add('email')
            ->add('first_time')
            ->add('first_name')
            ->add('last_name')
            ->add('street')
            ->add('town')
            ->add('state')
            ->add('country', 'text', array(
              'data' => 'Australia', 'read_only' => TRUE))
            ->add('postcode')
            ->add('contact', 'text', array('attr' => array('placeholder' => '10 digits mobile/phone')))
        ;
    }
    
    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('email')
            ->add('first_name')
            ->add('last_name');
    }
    
    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->add('email')
            ->add('first_time')
            ->add('first_name')
            ->add('last_name')
            ->add('street')
            ->add('town')
            ->add('state')
            ->add('country', 'text', array(
              'data' => 'Australia', 'read_only' => TRUE))
            ->add('postcode')
            ->add('contact', 'text', array('attr' => array('placeholder' => '10 digits mobile/phone')))
                
            // add custom action links
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }
    
    
}
