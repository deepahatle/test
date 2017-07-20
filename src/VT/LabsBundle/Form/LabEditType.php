<?php

namespace VT\LabsBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LabEditType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter your name',
                    'class' => 'form-control'
                )
            ))
            ->add('email', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter your email',
                    'class' => 'form-control'
                )
            ))
            ->add('mobile', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter mobile number',
                    'class' => 'form-control'
                )
            ))
            ->add('address', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter Address',
                    'class' => 'form-control'
                )
            ))
            ->add('city', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter City',
                    'class' => 'form-control'
                )
            ))
            ->add('pincode', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter Pincode',
                    'class' => 'form-control'
                )
            ))
            ->add('doctor', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter Doctor\'s Name',
                    'class' => 'form-control'
                )
            ))
            ->add('signature', HiddenType::class)
            ->add('logo', HiddenType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\LabsBundle\Entity\Lab'
        ));
    }
}
