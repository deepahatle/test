<?php

namespace VT\UsersBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DoctorCreateType extends AbstractType
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
                    'placeholder' => 'Enter Name',
                    'class' => 'form-control'
                )
            ))
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter Email',
                    'class' => 'form-control'
                )
            ))
            ->add('mobile', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter Mobile',
                    'class' => 'form-control'
                )
            ))
            ->add('address', TextareaType::class, array(
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
            ->add('percentage', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Enter Percentage',
                    'class' => 'form-control'
                )
            ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'VT\UsersBundle\Entity\Doctor'
        ));
    }
}
