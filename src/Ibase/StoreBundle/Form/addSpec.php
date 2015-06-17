<?php

namespace Ibase\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class addSpecType extends AbstractType
{
    
    public function buildForm (FormBuilderInterface $builder, array $options) 
    {
        
        
        
        
        
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

