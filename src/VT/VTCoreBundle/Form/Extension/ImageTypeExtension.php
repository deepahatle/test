<?php

/**
 * Created by PhpStorm.
 * User: Avinash Lad
 * Date: 28/6/16
 * Time: 5:53 PM
 */

// src/VT/VTCoreBundle/Form/Extension/ImageTypeExtension.php
namespace VT\VTCoreBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageTypeExtension extends AbstractTypeExtension
{
    /**
     * Returns the name of the type being extended.
     *
     * @return string The name of the type being extended
     */
    public function getExtendedType()
    {
        return FileType::class;
    }

    /**
     * Add the image_path option
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(array('image_path'));
    }

    /**
     * Pass the image URL to the view
     *
     * @param FormView $view
     * @param FormInterface $form
     * @param array $options
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['image_path'])) {
            $parentData = $form->getParent()->getData();

            $imageUrl = null;
            if (null !== $parentData) {
                $accessor = PropertyAccess::createPropertyAccessor();
//                $imageUrl = $accessor->getValue($parentData, $options['image_path']);
                if( is_array($parentData) && isset($parentData[$options['image_path']]) && !empty($parentData[$options['image_path']]) ){
                    $imageUrl = $parentData[$options['image_path']];
                }elseif(is_object($parentData)) {
                    $imageUrl = $accessor->getValue($parentData, $options['image_path']);
                }
            }

            // set an "image_url" variable that will be available when rendering this field
            $view->vars['image_url'] = $imageUrl;
        }
    }
}