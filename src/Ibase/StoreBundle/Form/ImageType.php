<?php

namespace Ibase\StoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ImageType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
 
    $this->widgetSchema['name'] = new sfWidgetFormInput();
    $this->widgetSchema['image'] = new sfWidgetFormInputFileEditable(array(
      'file_src' => sfConfig::get('app_product_pictures_folder') . 'thumbnail/' . $this->getObject()->getImage(),
      'is_image' => true,
      'edit_mode' => !$this->isNew(),
      'template' => '%file% %input%'
    ));
 
    $this->validatorSchema['name'] = new sfValidatorString();
    $this->validatorSchema['image'] = new sfValidatorFile(array(
      'path' => sfConfig::get('sf_web_dir') . sfConfig::get('app_product_pictures_folder'),
      'required' => false,
      'mime_types' => 'web_images'
    ));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Ibase\StoreBundle\Entity\Image'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'ibase_cartbundle_image';
    }
}
