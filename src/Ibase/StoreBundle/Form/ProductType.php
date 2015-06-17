<?php

namespace Ibase\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProductType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('model')
            ->add('brand')
            ->add('color')
            ->add('material')
            ->add('price')
            ->add('category')
            ->add('specifications','collection', 
                    array('type' => new SpecificationType(),
                           'allow_add'    => true,
                           'allow_delete' => true,
                           'prototype' => true,
                           'by_reference' => false,))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ibase\StoreBundle\Entity\Product'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ibase_storebundle_product';
    }
}
