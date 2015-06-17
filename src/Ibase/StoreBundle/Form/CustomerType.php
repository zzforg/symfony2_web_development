<?php

namespace Ibase\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class CustomerType extends AbstractType
{
     /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('first_name')
            ->add('last_name')
            ->add('street')
            ->add('town')
            ->add('state', 'choice', array(
                'choices' => array(
                    'ACT' => 'ACT',
                    'NSW' => 'NSW',
                    'VIC' => 'VIC', 
                    'QLD' => 'QLD', 
                    'SA' => 'SA',
                    'WA' => 'WA',
                    'TAS' => 'TAS',
                    'NT' => 'NT',
            )))
            ->add('country', 'text', array(
              'data' => 'Australia', 'read_only' => TRUE))
            ->add('postcode')
            ->add('contact', 'integer', array(
                'attr' => array(
                    'placeholder' => '10 digits mobile/phone, e.g: 0456789000',
                    )))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ibase\StoreBundle\Entity\Customer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ibase_storebundle_customer';
    }
}
