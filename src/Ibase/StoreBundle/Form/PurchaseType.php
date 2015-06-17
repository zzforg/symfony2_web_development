<?php

namespace Ibase\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PurchaseType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('delivery_fee')
            ->add('total_amount')
            ->add('status', 'choice', array(
                 'choices' => array(
                     'waiting' => 'awaiting payment', 
                     'paid' => 'awaiting ship', 
                     'shipped'=> 'shipped',
                     'pickup' => 'pickup'),
                      'preferred_choices' => array('waiting'),
                  ))
            ->add('tracking_number')
            ->add('carrier', 'choice', array(
                  'choices' => array('post' => 'Australia Post', 'express' => 'Express Post - Australia Post',
                      'couriers'=>'CouriersPlease','toll'=>'Toll IPEC',
                      'tnt'=>'TNT', 'ste'=>'Star Track Express'),
                  'preferred_choices' => array('post'),
                  ))
            ->add('customer');
        
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ibase\StoreBundle\Entity\Purchase'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ibase_storebundle_purchase';
    }
}
