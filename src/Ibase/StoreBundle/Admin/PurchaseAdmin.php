<?php
// src/Ibase/StroreBundle/Admin/PurchaseAdmin.php
// Model code --- to be corrected.

namespace Ibase\StoreBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\PropertyAccess\PropertyAccess;

Use Ibase\StoreBundle\Entity\Purchase;

class PurchaseAdmin extends Admin
{
    
    // setup the defaut sort column and order
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'createdAt'
    );
    // Fields to be shown on create/edit forms
    protected function configureFormFields(FormMapper $formMapper)
    {
//        $this->mlog->info('Start to configure form fields');
        $formMapper
            ->add('delivery_fee', null, 
                    array(
                        'required' => false,
                        'help'=>'After changed shipping, status need to be '
                        . 'changed to "WAITING PAYMENT" to notice customer'
                        )
                  )
            ->add('total_amount', null, array('required' => false))
            ->add('status', 'choice', array(
                'required' => false,
                 'choices' => array(
                     'pickup' => 'pickup',
                     'freight' => 'freight',
                     'waiting' => 'waiting payment', 
                     'paid' => 'paid', 
                     'shipped'=> 'shipped',),
                     'preferred_choices' => array('waiting'),
                 'help'=>'PICKUP - Change to complete when customer picked up already <br />'
                        . 'FREIGHT - Customer order have product need to add freight<br />'
                        . 'WAITING - Order placed, cutomer need to pay<br />'
                        . 'PAID - Customer paid, need to be shipped<br />'
                        . 'SHIPPED - Order has been shipped<br />'
                  ))
            ->add('tracking_number', null, array('required' => false))
            ->add('carrier', 'choice', 
                    array(
                        'required' => false,
                        'choices' => array(
                            'Australia Post' => 'Australia Post', 
                            'Australia Express' => 'Express Post - Australia Post',
                            'CouriersPlease'=>'CouriersPlease',
                            'Toll IPEC'=>'Toll IPEC',
                            'TNT'=>'TNT', 
                            'Star Track Express'=>'Star Track Express'),
                        'empty_value' => 'Please choose one',
                    )
                 )
//            ->add('customer', null, array('required' => false));
                ;
    }
    
        /**
     * @param \Sonata\AdminBundle\Show\ShowMapper $showMapper
     *
     * @return void
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
//    $id = $this->getIdParameter();
//    $id = $id+10000;
//        $id = $object->getId();
//        $orderNum = 100000;
        $showMapper
            ->add('id')
            ->add('status')
            ->add('delivery_fee')
            ->add('total_amount')
            ->add('tracking_number')
            ->add('carrier')
            ->add('createdAt')
            ->add('purchasePerItem')

        ;
    }

    // Fields to be shown on filter forms
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {   
        $datagridMapper
            ->add('status', 'doctrine_orm_choice', array(), 'choice', 
                    array('choices' => array(
                        'pickup' => 'pickup',
                        'freight' => 'freight',
                        'waiting' => 'waiting payment', 
                        'paid' => 'paid', 
                        'shipped'=> 'shipped',),))
            ->add('customer')
            ->add('customer.first_name')
            ->add('customer.last_name')
            ->add('tracking_number')
            ->add('purchasePerItem')
            ->add('createdAt', 'doctrine_orm_date_range',
                    array('label' => 'Period',), 
                    'sonata_type_date_range', 
                    array(
                        'widget' => 'single_text', 
                        'required' => false,
                        'format' => 'M/d/y',
                        'attr' => array('class' => 'datepicker'))) ;
    }

    // Fields to be shown on lists
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('Id')
            ->add('status')
            ->addIdentifier('customer', null, array('route'=>array('name'=>'show')))
            ->add('R', 'checkbox', array('required'=>false, 
                'template' => 'IbaseStoreBundle:Admin:list_flag.html.twig'))
            ->add('customer.first_name',null, array('label'=>'First Name',))
            ->add('customer.last_name',null, array('label'=>'Last Name',))
            ->add('tracking_number')
            ->add('carrier')
            ->add('purchasePerItem', 'purchasePerItem', array('label'=>'Products',
                'template' => 'IbaseStoreBundle:Admin:purchase_list_products.html.twig'))  
           ->add('purchasePerItemAsString',null, array('label'=>'Products Shortlist',))
            // add custom action links
            ->add('_action', 'actions', array(
                'actions' => array(
                    'show' => array(),
                    'edit' => array(),
                )
            ))
        ;
    }

    // Create Batch Action for change status of selected orders.

    public function getBatchActions()
    {
        // retrieve the default (currently only the delete action) actions
        if ($this->isGranted('LIST')) {
            $actions = parent::getBatchActions();
        }
//        $actions = parent::getBatchActions();

        // check user permissions
        if($this->hasRoute('edit') && $this->isGranted('EDIT') && $this->hasRoute('delete') && $this->isGranted('DELETE')) {
            $actions['toPaid'] = array(
                'label'            => 'change status to paid',
                'ask_confirmation' => true // If true, a confirmation will be asked before performing the action
            );
            $actions['toShipped'] = array(
                'label'            => 'change status to shipped',
                'ask_confirmation' => true // If true, a confirmation will be asked before performing the action
            );

        }

        return $actions;
    }
    
    public function getExportFields() {
        $exportItems = array(
            $this->getTranslator()->trans('Order Number') => 'id', 
            $this->getTranslator()->trans('Full Name') => 'customer.full_name', 
            $this->getTranslator()->trans('Contact') => 'customer.contact',
            $this->getTranslator()->trans('Email') => 'customer.email',
            $this->getTranslator()->trans('Street') => 'customer.street',
            $this->getTranslator()->trans('Town') => 'customer.town',
            $this->getTranslator()->trans('State') => 'customer.state',
            $this->getTranslator()->trans('Postcode') => 'customer.postcode',
            $this->getTranslator()->trans('Items') => 'purchasePerItemAsString',
            $this->getTranslator()->trans('Total($)') => 'total_amount',
            $this->getTranslator()->trans('Shipping') => 'delivery_fee',
            $this->getTranslator()->trans('Order time') => 'createdAt',
            $this->getTranslator()->trans('Last Update') => 'updatedAt',  
            ); 
        return $exportItems;
    }

//        public function mlog() 
//    {
//        $logger = $this->get('logger');
//        return $logger;
//    }
    

}
